<?php

namespace rubenrubiob\PoemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;

/**
 * Poem
 *
 * @ORM\Table(name="author")
 * @ORM\Entity(repositoryClass="rubenrubiob\PoemBundle\Entity\Author\AuthorRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Author
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Serializer\Expose
     * @Serializer\SerializedName("id")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Serializer\Expose
     * @Serializer\SerializedName("name")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="rubenrubiob\PoemBundle\Entity\Poem", mappedBy="author")
     */
    protected $poems;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->poems = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     *
     * @return Author
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
     * Add poem
     *
     * @param \rubenrubiob\PoemBundle\Entity\Poem $poem
     *
     * @return Author
     */
    public function addPoem(\rubenrubiob\PoemBundle\Entity\Poem $poem)
    {
        $this->poems[] = $poem;

        return $this;
    }

    /**
     * Remove poem
     *
     * @param \rubenrubiob\PoemBundle\Entity\Poem $poem
     */
    public function removePoem(\rubenrubiob\PoemBundle\Entity\Poem $poem)
    {
        $this->poems->removeElement($poem);
    }

    /**
     * Get poems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPoems()
    {
        return $this->poems;
    }
}
