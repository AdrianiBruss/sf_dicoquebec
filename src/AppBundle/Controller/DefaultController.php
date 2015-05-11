<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Term;
use AppBundle\Form\TermType;
use Cocur\Slugify\Slugify;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/term/add", name="addTerm")
     */
    public function addTermAction(Request $request)
    {

        $newTerm = new Term();

        $termForm = $this->createForm(new TermType(), $newTerm);
        $termForm->handleRequest($request);

        if ($termForm->isValid()){

            $slugify = new Slugify();

            $slugified_name = $slugify->slugify($newTerm->getName());

//            check if term already exists
            $term = $this->getDoctrine()->getRepository('AppBundle:Term');
            $checkTerm = $term->findBySlug($slugified_name);

            if (!$checkTerm){

//                term doesn't exist

            $newTerm->setDateCreated(new \DateTime());
            $newTerm->setSlug($slugified_name);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newTerm);
            $em->flush();

                $this->addFlash('success', 'Terme Ajouté ! ');
                return $this->redirectToRoute('homepage');

            }else{
                $this->addFlash('error', 'Terme déjà existant ! ');
            }

        }

        $params = array(
            'termForm'=> $termForm->createView()
        );

        return $this->render('term/addTerm.html.twig', $params);

    }

    /**
     * @Route("/term/update/{slug}", name="updateTerm")
     */
    public function updateTermAction($slug, Request $request)
    {
        $termRepo = $this->getDoctrine()->getRepository('AppBundle:Term');
        $term = $termRepo->findBySlug($slug);

        $params = array(
            'term' => $term
        );

        return $this->render('term/update.html.twig', $params);
    }

    /**
     * @Route("/term/delete/{slug}", name="deleteTerm")
     */
    public function deleteTermAction($slug, Request $request)
    {
        $termRepo = $this->getDoctrine()->getRepository('AppBundle:Term');
        $term = $termRepo->findBySlug($slug);

        $params = array(
            'term' => $term
        );

        return $this->render('default/index.html.twig', $params);
    }
}
