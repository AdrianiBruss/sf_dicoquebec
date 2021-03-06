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
            $num = count($csv);
            if($row==1){
                $row++;
                continue;
            }
            $row++;

            for ($c=0; $c < $num; $c++){
                if (empty($csv[$c]) || $csv[$c] == 'NULL'){
                    var_dump($csv[$c].'is empty');
                    $csv[$c] = null;
                }
            }

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
        $newDate = new \DateTime();
        $newDate->setTimestamp(intval($array[12]));
        $newTerm->setDateCreated($newDate);
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

            if (!empty($def)) {
                $newDef = new Definition();
                $newDef->setDescription($def);
                $newDef->setTerm($term);
                $this->em->persist($newDef);
            }

        };
    }
    public function hydrateExamples($ex,$trad,$term){

        if (!empty($ex)){

            $newExample=new Example();
            $newExample->setExample($ex);
            $newExample->setTranslation($trad);
            $newExample->setTerm($term);
            $this->em->persist($newExample);

        }

    }
}