<?php

/*
 * This file is part of the Videona code project.
 * 
 * Copyright (C) 2015 Videona Socialmedia SL
 * http://www.videona.com
 * info@videona.com
 *
 * All rights reserved
 */

namespace Videona\Backend\UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * LogoutSocialNetworksController is a class that allows users to logout from
 * Videona
 *
 * @author vlf
 */
class LogoutSocialNetworksController extends Controller {

    /**
     * Method to logout a user from Videona.
     * 
     * @param Request $request
     * 
     * @return view
     */
    public function logoutSocialAction(Request $request) {
        // Show logout button
        return $this->render('VideonaBackendUserManagementBundle:LogoutSocialNetworks:logout.html.twig');
    }

}
