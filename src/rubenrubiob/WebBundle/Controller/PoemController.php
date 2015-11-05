<?php

namespace rubenrubiob\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PoemController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allAction()
    {
        // Get all elements
        $poems = $this->getDoctrine()->getManager()->getRepository('rubenrubiobPoemBundle:Poem')->findAll();

        // Return HTML response
        return $this->render('rubenrubiobWebBundle:Poem:all.html.twig',array(
            'poems'      => $poems,
        ));
    }
}
