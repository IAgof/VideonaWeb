<?php

namespace Videona\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('VideonaRestBundle:Default:index.html.twig', array('name' => $name));
    }
}
