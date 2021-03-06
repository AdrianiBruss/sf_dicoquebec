<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Definition;
use AppBundle\Entity\DefinitionBackup;
use AppBundle\Entity\Example;
use AppBundle\Entity\ExampleBackup;
use AppBundle\Entity\Term;
use AppBundle\Entity\TermBackup;
use AppBundle\Form\TermType;
use AppBundle\Form\TermUpdateType;
use Cocur\Slugify\Slugify;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class DefaultController extends Controller
{
    private $session;

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $termRepo = $this->getDoctrine()->getRepository('AppBundle:Term');
        $terms = $termRepo->findHomeTerms();
        $wotdRepo = $this->getDoctrine()->getRepository('AppBundle:DayWord');
        $wotd = $wotdRepo->findWotd();
        $params = [
            'terms' => $terms,
            'wotd' => $wotd
        ];
        return $this->render('default/index.html.twig', $params);
    }

    /**
     * @Route("/term/add", name="addTerm")
     */
    public function addTermAction(Request $request)
    {

        $newTerm = new Term();


        $this->session = $this->get('session');
        $termForm = $this->createForm(new TermType($this->session), $newTerm);


        $termForm->handleRequest($request);
        if ($termForm->isValid()) {
            $def = new Definition();
            $newTerm->addDefinition($def);

            $example = new Example();
            $newTerm->addExample($example);

            if ($termForm->has('email')) {
                $this->setEmailSession($termForm->get('email')->getData());
            }

            $slugify = new Slugify();
            $slugified_name = $slugify->slugify($newTerm->getName());

//            check if term already exists
            $term = $this->getDoctrine()->getRepository('AppBundle:Term');
            $checkTerm = $term->findBySlug($slugified_name);

            if (!$checkTerm) {

//                term doesn't exist

                $newTerm->setDateCreated(new \DateTime());
                $newTerm->setSlug($slugified_name);


                foreach ($newTerm->getDefinitions() as $desc) {
                    if (!($desc->getDescription())) {
                        $newTerm->removeDefinition($desc);
                    }
                }

                foreach ($newTerm->getExamples() as $ex) {
                    if (!($ex->getExample()) || !($ex->getTranslation())) {
                        $newTerm->removeExample($ex);
                    }
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($newTerm);

                $em->flush();

                $this->addFlash('success', 'Terme Ajouté ! ');

                $this->get('mail_service')->sendMailOnAdd($this->getEmailSession(), $newTerm);
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

            $def = new Definition();
            $term->addDefinition($def);
            $example = new Example();
            $term->addExample($example);

            foreach ($term->getDefinitions() as $desc) {
                if (!($desc->getDescription())) {
                    $term->removeDefinition($desc);
                }
            }

            foreach ($term->getExamples() as $ex) {
                if (!($ex->getExample()) || !($ex->getTranslation())) {
                    $term->removeExample($ex);
                }
            }
            if ($termForm->has('email')) {
                $this->setEmailSession($termForm->get('email')->getData());
            }
            if ($termForm->get('Delete')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($term);
                $em->flush();
                $this->addFlash('success', 'Terme ' . $term->getName() . ' Supprimé ! ');

                $this->get('mail_service')->sendMailOnRemoval($this->getEmailSession(), $term);
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


            foreach ($term->getDefinitions() as $def) {
                $defBackup = new DefinitionBackup();
                $defBackup->setDateModified(new \DateTime());
                $defBackup->setDescription($def->getDescription());
                $updatedTerm->addDefinition($defBackup);
            }

            foreach ($term->getExamples() as $ex) {
                $exampleBackup = new ExampleBackup();
                $exampleBackup->setDateModified(new \DateTime());
                $exampleBackup->setExample($ex->getExample());
                $exampleBackup->setTranslation($ex->getTranslation());
                $updatedTerm->addExample($exampleBackup);
            }
//            $updatedTerm->addExample($exampleBackup);


            $em = $this->getDoctrine()->getManager();
            $em->persist($term);
            $em->persist($updatedTerm);
//            dump($term);
//            dump($updatedTerm);die;
            $em->flush();

            $this->addFlash('success', 'Terme Modifié ! ');

            $this->get('mail_service')->sendMailOnUpdate($this->getEmailSession(), $term);
            return $this->redirectToRoute('homepage');

        }

        $params = array(
            'termForm' => $termForm->createView(),
            'term' => $term
        );

        return $this->render('term/update.html.twig', $params);
    }

    /**
 * @Route("/term/{slug}", name="showTerm")
 */
    public function showTermAction($slug)
    {
        $voted = false;
        $this->session = $this->get('session');

        $termRepo = $this->getDoctrine()->getRepository('AppBundle:Term');
        $term = $termRepo->findOneBySlug($slug);

        $this->session = $this->get('session');
        if ($this->get('session')->get('votes')) {
            if (array_key_exists($slug, $this->get('session')->get('votes'))) {
                $voted = true;
            }
        }


        $params = [
            'term' => $term,
            'voted' => $voted
        ];
        return $this->render('term/single.html.twig', $params);
    }

    /**
     * @Route("/term/backup/{id}", name="showTermBackup")
     */
    public function showTermBackupAction($id)
    {

        $termRepo = $this->getDoctrine()->getRepository('AppBundle:TermBackup');
        $backups = $termRepo->findByTerm($id);

        $params = [
            'backups' => $backups,

        ];

        return $this->render('term/backup.html.twig', $params);
    }

    /**
     * @Route("/vote/term/{slug}", name="voteTerm")
     */
    public function voteTermAction($slug)
    {
        $termRepo = $this->getDoctrine()->getRepository('AppBundle:Term');
        $term = $termRepo->findOneBySlug($slug);

        $this->session = $this->get('session');
        if (!$this->session->get('votes')) {
            $this->session->set('votes', []);
        }
        $sessionVotes = $this->session->get('votes');
        if (!array_key_exists($slug, $sessionVotes)) {
            $voteValue = intval($term->getNbVotes()) + 1;
            $term->setNbVotes($voteValue);
            $em = $this->getDoctrine()->getManager();
            $em->persist($term);
            $em->flush();

            $sessionVotes[$slug] = true;
            $this->session->set('votes', $sessionVotes);
        }
        return new JsonResponse($term->getNbVotes());
    }


    public function setEmailSession($data)
    {
        if (!$this->session->get('email')) {
            $this->session->set('email', $data);
        }
    }

    public function getEmailSession()
    {
        return $this->session->get('email');
    }

    public function renderSideBarAction()
    {
        $termRepo = $this->getDoctrine()->getRepository('AppBundle:Term');
        $terms = $termRepo->findHomeTerms();
        $params = [
            "terms" => $terms
        ];

        return $this->render('partials/sidebar.html.twig', $params);
    }
}
