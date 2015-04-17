<?php



namespace AppBundle\Service;


use AppBundle\Entity\Definition;
use AppBundle\Entity\Example;
use AppBundle\Entity\Term;

class ParseCsvService {

    private $doctrine;
    private $validator;
    private $root_dir;
    private $em;
    public function __construct($doctrine,$validator,$root_dir){
        $this->doctrine=$doctrine;
        $this->validator=$validator;
        $this->root_dir=$root_dir;
        $this->em=$this->doctrine->getManager();
    }
    public function saveInfos(){
        $row = 1;
        $handle=fopen($this->root_dir.DIRECTORY_SEPARATOR.'Resources'.DIRECTORY_SEPARATOR.'csv'.DIRECTORY_SEPARATOR.'dico.csv','r');
        while (($csv=fgetcsv($handle, null, ';')) !== FALSE) {
            if($row==1){
                $row++;
                continue;
            }
            $row++;
            $this->hydrateTerm($csv);
        }
        $this->em->flush();
    }

    public function hydrateTerm($array){
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
        if ($array[12] != null){
            var_dump($array[12]);
            die();
        }else{
            $array[12] = new \DateTime();
        }
        $newTerm->setDateCreated(new DateTime(int($array[12])));
        $this->em->persist($newTerm);
        $definitions=[
            'def1'=>$array[1],
            'def2'=>$array[2]
        ];
        $this->hydrateDefinitions($definitions,$newTerm);
        $this->hydrateExamples($array[4],$array[5],$newTerm);

    }
    public function hydrateDefinitions($array,$term){
        foreach($array as $def){
            $newDef=new Definition();
            $newDef->setDescription($def);
            $newDef->setTerm($term);
            $this->em->persist($newDef);
        }
    }
    public function hydrateExamples($ex,$trad,$term){
        $newExample=new Example();
        $newExample->setExample($ex);
        $newExample->setTranslation($trad);
        $newExample->setTerm($term);
        $this->em->persist($newExample);
    }
}