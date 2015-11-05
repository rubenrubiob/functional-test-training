<?php
namespace rubenrubiob\PoemBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use rubenrubiob\PoemBundle\Entity\Poem;
use rubenrubiob\PoemBundle\Entity\Author;

/**
 * Class LoadPoemData
 * @package rubenrubiob\PoemBundle\DataFixtures\ORM
 */
class LoadPoemData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Authors entities
        $authors = array(
            array(
                'name'      => 'Federico García Lorca',
            ),
            array(
                'name'      => 'Pablo Neruda',
            ),
            array(
                'name'      => 'Luis de Góngora',
            ),
            array(
                'name'      => 'Miquel Martí i Pol',
            ),
        );

        $authorsObjects = array();

        foreach ($authors as $authorData) {
            $author = new Author();
            $author->setName($authorData['name']);

            $manager->persist($author);

            $authorsObjects[] = $author;
        }

        // Poems entities
        $poems = array(
            array(
                'title'         => 'Romance Sonámbulo',
                'authorIndex'   => 0,
            ),
            array(
                'title'         => 'Pequeño Poema Infinto',
                'authorIndex'   => 0,
            ),
            array(
                'title'         => 'Tierra y luna',
                'authorIndex'   => 0,
            ),
            array(
                'title'         => 'Todo en ti fue naufragio',
                'authorIndex'   => 1,
            ),
            array(
                'title'         => 'Te recuerdo como eras en el último otoño',
                'authorIndex'   => 1,
            ),
            array(
                'title'         => 'Y ríase la gente',
                'authorIndex'   => 2,
            ),
            array(
                'title'         => 'El temps',
                'authorIndex'   => 3,
            ),
            array(
                'title'         => 'Lletra a Dolors',
                'authorIndex'   => 3,
            ),
        );


        foreach ($poems as $poemData) {
            $poem = new Poem();
            $poem->setTitle($poemData['title']);
            $poem->setAuthor($authorsObjects[$poemData['authorIndex']]);

            $manager->persist($poem);
        }

        $manager->flush();
    }
}