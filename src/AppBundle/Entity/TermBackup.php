<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TermBackup
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TermBackupRepository")
 */
class TermBackup
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
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Term", inversedBy="termBackups", cascade={"persist"})
     */
    private $term;

    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DefinitionBackup", mappedBy="termBackup", cascade={"persist"})
     */
    private $definitions;

    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ExampleBackup", mappedBy="termBackup", cascade={"persist"})
     */
    private $examples;


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
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return TermBackup
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
     * Set name
     *
     * @param string $name
     * @return TermBackup
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
     * @return TermBackup
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
     * @return TermBackup
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
     * @return TermBackup
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
     * @return TermBackup
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
     * @return TermBackup
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
     * @return TermBackup
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
     * @return TermBackup
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
     * Set term
     *
     * @param \AppBundle\Entity\Term $term
     * @return TermBackup
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
     * Constructor
     */
    public function __construct()
    {
        $this->definitions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->examples = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add definitions
     *
     * @param \AppBundle\Entity\DefinitionBackup $definitions
     * @return TermBackup
     */
    public function addDefinition(\AppBundle\Entity\DefinitionBackup $definitions)
    {
        $this->definitions[] = $definitions;
        $definitions->setTermBackup($this);

        return $this;
    }

    /**
     * Remove definitions
     *
     * @param \AppBundle\Entity\DefinitionBackup $definitions
     */
    public function removeDefinition(\AppBundle\Entity\DefinitionBackup $definitions)
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
     * @param \AppBundle\Entity\ExampleBackup $examples
     * @return TermBackup
     */
    public function addExample(\AppBundle\Entity\ExampleBackup $examples)
    {
        $this->examples[] = $examples;
        $examples->setTermBackup($this);


        return $this;
    }

    /**
     * Remove examples
     *
     * @param \AppBundle\Entity\ExampleBackup $examples
     */
    public function removeExample(\AppBundle\Entity\ExampleBackup $examples)
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
}
