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

namespace Videona\DBBundle\Entity;

use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use FOS\UserBundle\Util\CanonicalizerInterface;
use FOS\UserBundle\Model\UserInterface;
use Videona\Backend\SocialBundle\Services\ImageManager;
use Videona\Backend\SocialBundle\Services\SocialManager;

/**
 * UserManager is a class that extends the default fos user bundle doctrine
 * usermanager to fit our own user entity.
 *
 * @author vlf
 */
class UserManager extends BaseUserManager {

    /**
     * @var ObjectManager
     */
    protected $imageManager;

    /**
     * @var ObjectManager
     */
    protected $socialManager;

    /**
     * Constructor.
     *
     * @param EncoderFactoryInterface $encoderFactory
     * @param CanonicalizerInterface  $usernameCanonicalizer
     * @param CanonicalizerInterface  $emailCanonicalizer
     * @param EntityManager           $em
     * @param string                  $class
     * @param ImageManager            $imageManager
     * @param SocialManager           $socialManager
     */
    public function __construct(EncoderFactoryInterface $encoderFactory, CanonicalizerInterface $usernameCanonicalizer, CanonicalizerInterface $emailCanonicalizer, EntityManager $em, $class, ImageManager $imageManager, SocialManager $socialManager) {

        parent::__construct($encoderFactory, $usernameCanonicalizer, $emailCanonicalizer, $em, $class);

        $this->imageManager = $imageManager;
        $this->socialManager = $socialManager;
    }

    /**
     * Identifies the social network that the user uses for log in and get the 
     * manager of the service.
     * 
     * @param string $serviceName
     * 
     * @return ObjectManager
     */
    public function getServiceManager($serviceName) {
        return $this->socialManager->getServiceManager($serviceName);
    }

    /**
     * Save the image in the profile picture's folder
     * 
     * @param User $user the image's owner
     * @param string $url the url where is the image
     * 
     * @return $profilePicture the profile picture of the user or null if not exists
     */
    public function saveOriginalImage($user, $url) {
        return $this->imageManager->saveOriginalImage($user, $url);
    }

}
