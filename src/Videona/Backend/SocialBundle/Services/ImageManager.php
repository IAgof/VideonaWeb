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

/**
 * Manager for image files
 *
 * @author vlf
 */
class ImageManager {

    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('VideonaDBBundle:Image');
    }
    
    /**
     * Save the image
     * 
     * @param User $user
     * @param string $image the images's url
     * 
     * @return 
     */
    public function loadImage(\Videona\DBBundle\Entity\User $user, $image) {
        
        $directory = $GLOBALS['kernel']->getRootDir().'/../web/file/profileicons/temp/';
        ld($directory);

        return $directory;
    }
    
    /**
     * Save the image in a temporal folder
     * 
     * @param string $facebookId
     * 
     * @return 
     */
    public function saveTempImage() {
        
        $directory = $GLOBALS['kernel']->getRootDir().'/../web/file/profileicons/temp/';
        ld($directory);

        return $directory;
    }

    /**
     * Save the image in the images's folder
     * 
     * @param string $facebookId
     * 
     * @return 
     */
    public function saveOriginalImage() {
        $directory = $GLOBALS['kernel']->getRootDir().'/../web/file/profileicons/originals/';
        ld($directory);

        return $directory;
    }

}
