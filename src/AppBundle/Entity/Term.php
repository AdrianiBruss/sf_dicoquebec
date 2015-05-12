<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Term
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TermRepository")
 */
class Term
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="variation", type="string", length=255, nullable=true)
     */
    private $variation;

    /**
     * @var string
     *
     * @ORM\Column(name="pronunciation", type="string", length=255, nullable=true)
     */
    private $pronunciation;

    /**
     * @var string
     *
     * @ORM\Column(name="nature", type="string", length=255, nullable=true)
     */
    private $nature;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=255, nullable=true)
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255, nullable=true)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="origin", type="text", nullable=true)
     */
    private $origin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbVotes", type="integer", nullable=true)
     */
    private $nbVotes;


    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Definition", mappedBy="term")
     */
    private $definitions;

    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Example", mappedBy="term")
     */
    private $examples;

    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TermBackup", mappedBy="term", cascade={"remove"})
     */
    private $termBackups;

    /**
     * @var string
     * @ORM\Column(name="slug",type="string",length=255)
     */
    private $slug;




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
     * Set name
     *
     * @param string $name
     * @return Term
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return Term
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set variation
     *
     * @param string $variation
     * @return Term
     */
    public function setVariation($variation)
    {
        $this->variation = $variation;

        return $this;
    }

    /**
     * Get variation
     *
     * @return string 
     */
    public function getVariation()
    {
        return $this->variation;
    }

    /**
     * Set pronunciation
     *
     * @param string $pronunciation
     * @return Term
     */
    public function setPronunciation($pronunciation)
    {
        $this->pronunciation = $pronunciation;

        return $this;
    }

    /**
     * Get pronunciation
     *
     * @return string 
     */
    public function getPronunciation()
    {
        return $this->pronunciation;
    }

    /**
     * Set nature
     *
     * @param string $nature
     * @return Term
     */
    public function setNature($nature)
    {
        $this->nature = $nature;

        return $this;
    }

    /**
     * Get nature
     *
     * @return string 
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * Set genre
     *
     * @param string $genre
     * @return Term
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return Term
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set origin
     *
     * @param string $origin
     * @return Term
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return string 
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Term
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set nbVotes
     *
     * @param integer $nbVotes
     * @return Term
     */
    public function setNbVotes($nbVotes)
    {
        $this->nbVotes = $nbVotes;

        return $this;
    }

    /**
     * Get nbVotes
     *
     * @return integer 
     */
    public function getNbVotes()
    {
        return $this->nbVotes;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->definitions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->examples = new \Doctrine\Common\Collections\ArrayCollection();
        $this->termBackups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add definitions
     *
     * @param \AppBundle\Entity\Definition $definitions
     * @return Term
     */
    public function addDefinition(\AppBundle\Entity\Definition $definitions)
    {
        $this->definitions[] = $definitions;

        return $this;
    }

    /**
     * Remove definitions
     *
     * @param \AppBundle\Entity\Definition $definitions
     */
    public function removeDefinition(\AppBundle\Entity\Definition $definitions)
    {
        $this->definitions->removeElement($definitions);
    }

    /**
     * Get definitions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * Add examples
     *
     * @param \AppBundle\Entity\Example $examples
     * @return Term
     */
    public function addExample(\AppBundle\Entity\Example $examples)
    {
        $this->examples[] = $examples;

        return $this;
    }

    /**
     * Remove examples
     *
     * @param \AppBundle\Entity\Example $examples
     */
    public function removeExample(\AppBundle\Entity\Example $examples)
    {
        $this->examples->removeElement($examples);
    }

    /**
     * Get examples
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExamples()
    {
        return $this->examples;
    }

    /**
     * Add termBackups
     *
     * @param \AppBundle\Entity\TermBackup $termBackups
     * @return Term
     */
    public function addTermBackup(\AppBundle\Entity\TermBackup $termBackups)
    {
        $this->termBackups[] = $termBackups;

        return $this;
    }

    /**
     * Remove termBackups
     *
     * @param \AppBundle\Entity\TermBackup $termBackups
     */
    public function removeTermBackup(\AppBundle\Entity\TermBackup $termBackups)
    {
        $this->termBackups->removeElement($termBackups);
    }

    /**
     * Get termBackups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTermBackups()
    {
        return $this->termBackups;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Term
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
