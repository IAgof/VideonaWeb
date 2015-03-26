<?php

namespace Videona\Frontend\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('VideonaFrontendHomeBundle:Default:index.html.twig', array('name' => $name));
    }
}
