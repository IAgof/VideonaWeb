<?php

namespace Videona\DBBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('VideonaDBBundle:Default:index.html.twig', array('name' => $name));
    }
}
