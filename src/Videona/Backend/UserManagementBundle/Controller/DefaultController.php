<?php

namespace Videona\Backend\UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('VideonaBackendUserManagementBundle:Default:index.html.twig', array('name' => $name));
    }
}
