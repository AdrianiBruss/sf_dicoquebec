<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Example
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ExampleRepository")
 */
class ExampleBackup
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateModified", type="datetime")
     */
    private $dateModified;

    /**
     * @var string
     *
     * @ORM\Column(name="example", type="text", nullable=true)
     */
    private $example;

    /**
     * @var string
     *
     * @ORM\Column(name="translation", type="text", nullable=true)
     */
    private $translation;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TermBackup", inversedBy="examples", cascade={"persist"})
     */
    private $termBackup;


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
     * Set example
     *
     * @param string $example
     * @return Example
     */
    public function setExample($example)
    {
        $this->example = $example;

        return $this;
    }

    /**
     * Get example
     *
     * @return string 
     */
    public function getExample()
    {
        return $this->example;
    }

    /**
     * Set translation
     *
     * @param string $translation
     * @return Example
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * Get translation
     *
     * @return string 
     */
    public function getTranslation()
    {
        return $this->translation;
    }



    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return ExampleBackup
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime 
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * Set termBackup
     *
     * @param \AppBundle\Entity\TermBackup $termBackup
     * @return ExampleBackup
     */
    public function setTermBackup(\AppBundle\Entity\TermBackup $termBackup = null)
    {
        $this->termBackup = $termBackup;

        return $this;
    }

    /**
     * Get termBackup
     *
     * @return \AppBundle\Entity\TermBackup 
     */
    public function getTermBackup()
    {
        return $this->termBackup;
    }
}
