<?php

namespace Videona\Backend\SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('VideonaBackendSocialBundle:Default:index.html.twig', array('name' => $name));
    }
}
