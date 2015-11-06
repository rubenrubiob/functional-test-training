<?php

namespace rubenrubiob\PoemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;

/**
 * Poem
 *
 * @ORM\Table(name="poem")
 * @ORM\Entity(repositoryClass="rubenrubiob\PoemBundle\Entity\Poem\PoemRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Poem
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
     * @Serializer\SerializedName("title")
     */
    protected $title;

    /**
     * @ORM\ManyToOne(targetEntity="Author", inversedBy="poems")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false)
     * @Serializer\Expose
     * @Serializer\SerializedName("author")
     */
    protected $author;

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
     * Set title
     *
     * @param string $title
     *
     * @return Poem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param \rubenrubiob\PoemBundle\Entity\Author $author
     *
     * @return Poem
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \rubenrubiob\PoemBundle\Entity\Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("foobar")
     *
     * @return string
     */
    public function getFoobar()
    {
        return 'foobar';
    }
}
