<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Definition;
use AppBundle\Entity\Example;
use AppBundle\Entity\Term;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Cocur\Slugify\Slugify;

class LoadBook implements FixtureInterface,ContainerAwareInterface{

    private $container;


    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $em)
    {

        $this->saveInfos($em);

    }

    public function saveInfos($em){
        $row = 1;

        // trouver le moyen de recupere la root directory ici
        $handle=fopen($this->container->get('kernel')->getRootDir().DIRECTORY_SEPARATOR.'Resources'.DIRECTORY_SEPARATOR.'csv'.DIRECTORY_SEPARATOR.'dico.csv','r');
        while (($csv=fgetcsv($handle, null, ';')) !== FALSE) {
            $num = count($csv);
            if($row==1){
                $row++;
                continue;
            }
            $row++;

            for ($c=0; $c < $num; $c++){

                // voir si le vardump ca passe

                if (empty($csv[$c]) || $csv[$c] == 'NULL'){
//                    var_dump($csv[$c].'is empty');
                    $csv[$c] = null;
                }
            }

            $this->hydrateTerm($csv, $em);
        }
        dump('terms saved');
        $em->flush();
    }

    public function hydrateTerm($array, $em){
        $slugify=new Slugify();

        $newTerm=new Term();
        $newTerm->setName($array[0]);
        $newTerm->setCategory($array[3]);
        $newTerm->setVariation($array[6]);
        $newTerm->setPronunciation($array[7]);
        $newTerm->setNbVotes($array[14]);
        $newTerm->setOrigin($array[11]);
        $newTerm->setNumber($array[10]);
        $newTerm->setGenre($array[9]);
        $newTerm->setNature($array[8]);
        $newDate = new \DateTime();
        $newDate->setTimestamp(intval($array[12]));
        $newTerm->setDateCreated($newDate);
        $newTerm->setSlug($slugify->slugify($array[0]));
        $em->persist($newTerm);
        $definitions=[
            'def1'=>$array[1],
            'def2'=>$array[2]
        ];
        $this->hydrateDefinitions($definitions,$newTerm, $em);
        $this->hydrateExamples($array[4],$array[5],$newTerm, $em);

    }
    public function hydrateDefinitions($array,$term, $em){

        foreach($array as $def){

            if (!empty($def)) {
                $newDef = new Definition();
                $newDef->setDescription($def);
                $newDef->setTerm($term);
                $em->persist($newDef);
            }

        };
    }
    public function hydrateExamples($ex,$trad,$term, $em){

        if (!empty($ex)){

            $newExample=new Example();
            $newExample->setExample($ex);
            $newExample->setTranslation($trad);
            $newExample->setTerm($term);
            $em->persist($newExample);

        }

    }

}