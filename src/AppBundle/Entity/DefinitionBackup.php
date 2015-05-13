<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DefinitionBackup
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DefinitionRepository")
 */
class DefinitionBackup
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TermBackup", inversedBy="definitions", cascade={"persist"})
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
     * Set description
     *
     * @param string $description
     * @return Definition
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set term
     *
     * @param \AppBundle\Entity\Term $term
     * @return Definition
     */
    public function setTerm(\AppBundle\Entity\Term $term = null)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Get term
     *
     * @return \AppBundle\Entity\Term 
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return DefinitionBackup
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
     * @return DefinitionBackup
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
