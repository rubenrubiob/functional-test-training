<?php

namespace rubenrubiob\WebserviceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PoemController extends Controller
{
    /**
     * @return Response
     */
    public function allAction()
    {
        // Get all elements
        $poems = $this->getDoctrine()->getManager()->getRepository('rubenrubiobPoemBundle:Poem')->findAll();

        $response = array(
            'poems'     => $poems,
        );

        // Return serialized response
        return new Response($this->get('serializer')->serialize($response, 'json'));
    }
}
