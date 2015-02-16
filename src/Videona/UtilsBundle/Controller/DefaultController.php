<?php

namespace Videona\UtilsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('VideonaUtilsBundle:Default:index.html.twig', array('name' => $name));
    }
}
