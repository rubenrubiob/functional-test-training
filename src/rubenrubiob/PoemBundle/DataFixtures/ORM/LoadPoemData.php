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
                'year'          => 1924,
                'authorIndex'   => 0,
            ),
            array(
                'title'         => 'Pequeño Poema Infinto',
                'year'          => 1930,
                'authorIndex'   => 0,
            ),
            array(
                'title'         => 'Tierra y luna',
                'year'          => 1935,
                'authorIndex'   => 0,
            ),
            array(
                'title'         => 'Todo en ti fue naufragio',
                'year'          => 1924,
                'authorIndex'   => 1,
            ),
            array(
                'title'         => 'Te recuerdo como eras en el último otoño',
                'year'          => 1924,
                'authorIndex'   => 1,
            ),
            array(
                'title'         => 'Y ríase la gente',
                'year'          => 1581,
                'authorIndex'   => 2,
            ),
            array(
                'title'         => 'El temps',
                'year'          => 1985,
                'authorIndex'   => 3,
            ),
            array(
                'title'         => 'Lletra a Dolors',
                'year'          => 1985,
                'authorIndex'   => 3,
            ),
        );


        foreach ($poems as $poemData) {
            $poem = new Poem();
            $poem->setTitle($poemData['title']);
            $poem->setAuthor($authorsObjects[$poemData['authorIndex']]);
            $poem->setYear($poemData['year']);

            $manager->persist($poem);
        }

        $manager->flush();
    }
}