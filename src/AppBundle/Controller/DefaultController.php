<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Definition;
use AppBundle\Entity\Example;
use AppBundle\Entity\Term;
use AppBundle\Entity\TermBackup;
use AppBundle\Form\TermType;
use AppBundle\Form\TermUpdateType;
use Cocur\Slugify\Slugify;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    private $session;

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $termRepo = $this->getDoctrine()->getRepository('AppBundle:Term');
        $terms= $termRepo->findHomeTerms();
        $wotdRepo = $this->getDoctrine()->getRepository('AppBundle:DayWord');
        $wotd= $wotdRepo->findWotd();
        $params=[
            'terms'=>$terms,
            'wotd'=>$wotd
        ];
        dump($params);
        return $this->render('default/index.html.twig',$params);
    }

    /**
     * @Route("/term/add", name="addTerm")
     */
    public function addTermAction(Request $request)
    {

        $newTerm = new Term();

        $def = new Definition();
        $newTerm->getDefinitions()->add($def);

        $example = new Example();
        $newTerm->getExamples()->add($example);

        $this->session = $this->get('session');
        $termForm = $this->createForm(new TermType($this->session), $newTerm);

        $termForm->handleRequest($request);
        if ($termForm->isValid()) {

            $slugify = new Slugify();
            $slugified_name = $slugify->slugify($newTerm->getName());

//            check if term already exists
            $term = $this->getDoctrine()->getRepository('AppBundle:Term');
            $checkTerm = $term->findBySlug($slugified_name);

            if (!$checkTerm) {

//                term doesn't exist

                $newTerm->setDateCreated(new \DateTime());
                $newTerm->setSlug($slugified_name);



                $em = $this->getDoctrine()->getManager();
                $em->persist($newTerm);

                $em->flush();
                dump($newTerm);
                die();
                $this->addFlash('success', 'Terme Ajouté ! ');
                return $this->redirectToRoute('homepage');

            } else {
                $this->addFlash('error', 'Terme déjà existant ! ');
            }

        }

        $params = array(
            'termForm' => $termForm->createView()
        );

        return $this->render('term/add.html.twig', $params);

    }

    /**
     * @Route("/term/update/{slug}", name="updateTerm")
     */
    public function updateTermAction($slug, Request $request)
    {
        $termRepo = $this->getDoctrine()->getRepository('AppBundle:Term');

        $term = $termRepo->findOneBySlug($slug);

        $this->session = $this->get('session');
        $termForm = $this->createForm(new TermUpdateType($this->session), $term);
        $termForm->handleRequest($request);
        if ($termForm->isValid()) {
            if(!$this->session->get('email')){
                $this->session->set('email',$termForm->get('email')->getData());
            }
            if ($termForm->get('Delete')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($term);
                $em->flush();
                $this->addFlash('success', 'Terme ' . $term->getName() . ' Supprimé ! ');
                return $this->redirectToRoute('homepage');
            }

            $updatedTerm = new TermBackup();
            $updatedTerm->setTerm($term);
            $updatedTerm->setDateModified(new \DateTime());
            $updatedTerm->setName($term->getName());
            $updatedTerm->setCategory($term->getCategory());
            $updatedTerm->setVariation($term->getVariation());
            $updatedTerm->setPronunciation($term->getPronunciation());
            $updatedTerm->setNature($term->getNature());
            $updatedTerm->setNumber($term->getNumber());
            $updatedTerm->setOrigin($term->getOrigin());
            $updatedTerm->setGenre($term->getGenre());


            $em = $this->getDoctrine()->getManager();
            $em->persist($term);
            $em->persist($updatedTerm);
            $em->flush();

            $this->addFlash('success', 'Terme Modifié ! ');
            return $this->redirectToRoute('homepage');

        }

        $params = array(
            'termForm' => $termForm->createView(),
            'term' => $term
        );

        return $this->render('term/update.html.twig', $params);
    }

}
