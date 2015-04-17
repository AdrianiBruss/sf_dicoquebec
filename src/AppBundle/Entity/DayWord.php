<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DayWord
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DayWordRepository")
 */
class DayWord
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="wordId", type="integer")
     */
    private $wordId;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set wordId
     *
     * @param integer $wordId
     * @return DayWord
     */
    public function setWordId($wordId)
    {
        $this->wordId = $wordId;

        return $this;
    }

    /**
     * Get wordId
     *
     * @return integer 
     */
    public function getWordId()
    {
        return $this->wordId;
    }
}
