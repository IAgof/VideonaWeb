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

namespace Videona\Frontend\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * HomePageController is a class that manages the home page.
 *
 * @author vlf
 */
class HomePageController extends Controller {
    
    /**
     * Method for showing the landing page. It depends if the user is logged or
     * not logged.
     * 
     * @param Request $request
     */
    public function showHomePageAction() {
        
        // Show landing page
        return $this->render('VideonaFrontendHomeBundle:HomePage:home.html.twig');
    }
    
}