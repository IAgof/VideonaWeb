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

use Doctrine\ORM\EntityManager;
use Videona\Backend\SocialBundle\Services\ImageManager;

/**
 * Manager for google user data
 *
 * @author vlf
 */
class GoogleManager {

    /**
     * @var ObjectManager
     */
    protected $em;
    
    /**
     * @var ObjectManager
     */
    protected $imageManager;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param EntityManager $em
     * @param ImageManager $imageManager
     */
    public function __construct(EntityManager $em, ImageManager $imageManager) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('VideonaDBBundle:SocialGoogle');
        $this->imageManager = $imageManager;
    }
    
    /**
     * Finds a user by the user's unique id on Google on social_google table
     * 
     * @param string $googleId
     * 
     * @return UserInterface or null if user does not exist
     */
    public function loadUserBySocialId($googleId) {
        $user = $this->repository->findOneBy(array('google_id' => $googleId));

        return $user;
    }

}
