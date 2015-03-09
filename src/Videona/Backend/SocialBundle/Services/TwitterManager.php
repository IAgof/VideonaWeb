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
 * Manager for twitter user data
 *
 * @author vlf
 */
class TwitterManager {

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
        $this->repository = $this->em->getRepository('VideonaDBBundle:SocialTwitter');
        $this->imageManager = $imageManager;
    }
    
    /**
     * Finds a user by the user's unique id on Twitter on social_twitter table
     * 
     * @param string $twitterId
     * 
     * @return UserInterface or null if user does not exist
     */
    public function loadUserBySocialId($twitterId) {
        $user = $this->repository->findOneBy(array('twitter_id' => $twitterId));

        return $user;
    }

}
