<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Example
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ExampleRepository")
 */
class Example
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Term", inversedBy="examples")
     */
    private $term;


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
     * Set term
     *
     * @param \AppBundle\Entity\Term $term
     * @return Example
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
}
