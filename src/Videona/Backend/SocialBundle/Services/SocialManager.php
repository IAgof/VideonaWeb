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

namespace Videona\Backend\SocialBundle\Services;

use Videona\Backend\SocialBundle\Services\FacebookManager;
use Videona\Backend\SocialBundle\Services\GoogleManager;
use Videona\Backend\SocialBundle\Services\TwitterManager;

/**
 * This class manages the available social networks
 *
 * @author vlf
 */
class SocialManager {

    /**
     * @var ObjectManager
     */
    protected $facebookManager;
    
    /**
     * @var ObjectManager
     */
    protected $googleManager;
    
    /**
     * @var ObjectManager
     */
    protected $twitterManager;

    /**
     * Constructor.
     *
     * @param FacebookManager $facebookManager
     * @param GoogleManager $googleManager
     * @param TwitterManager $twitterManager
     */
    public function __construct(FacebookManager $facebookManager, GoogleManager $googleManager, TwitterManager $twitterManager) {
        $this->facebookManager = $facebookManager;
        $this->googleManager = $googleManager;
        $this->twitterManager = $twitterManager;
    }
    
    /**
     * Identify the social network that the user uses for log in and get the 
     * manager of the service.
     * 
     * @param string $serviceName
     * 
     * @return ObjectManager
     */
    public function getServiceManager($serviceName) {
        $socialManager = mb_strtolower($serviceName).'Manager';
        
        return $this->$socialManager;
    }

}
