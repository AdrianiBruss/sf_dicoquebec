<?php



namespace AppBundle\Service;


use AppBundle\Entity\DayWord;

class WordOfTheDayService {

    private $doctrine;
    private $em;
    private $termRepo;
    private $dayWordRepo;
    private $terms;
    public function __construct($doctrine){
        $this->doctrine=$doctrine;
        $this->em=$this->doctrine->getManager();
        $this->termRepo=$this->doctrine->getRepository('AppBundle:Term');
        $this->dayWordRepo=$this->doctrine->getRepository('AppBundle:DayWord');
        $this->terms= $this->termRepo->findPopularTerms();
    }

    public function getWotd(){
        $potentialTerm= $this->getRandomTerm($this->terms);
        if($this->checkIfAlreadyDisplayed($potentialTerm)){
            $this->getWotd();
            return false;
        }
        $this->doctrine->getManager();
        $newDayWord = new DayWord();
        $newDayWord->setWordId($potentialTerm->getId());
        $this->em->persist($newDayWord);
        $this->em->flush();
        dump("Word of the day is chosen! date :  ");
        dump(new \DateTime('now'));
    }
    public function checkIfAlreadyDisplayed($term){
        $termId = $term->getId();
        $duplicate = $this->dayWordRepo->findOneById($termId);
        return $duplicate;
    }
    public function getRandomTerm($array){
        $randomKey= array_rand($array,1);
        $potentialTerm = $array[$randomKey];
        return $potentialTerm;
    }

}