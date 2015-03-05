<?php

namespace Videona\Backend\OAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('VideonaBackendOAuthBundle:Default:index.html.twig', array('name' => $name));
    }
}
