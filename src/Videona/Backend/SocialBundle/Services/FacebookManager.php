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
use Videona\DBBundle\Entity\SocialFacebook;

/**
 * Manager for facebook user data
 *
 * @author vlf
 */
class FacebookManager {

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
        $this->repository = $this->em->getRepository('VideonaDBBundle:SocialFacebook');
    }

    /**
     * Method
     * 
     * @param int $facebookId
     * 
     * @return UserInterface or null if user does not exist
     */
    public function loadUserByFacebookId($facebookId) {
        $user = $this->repository->findOneBy(array('facebook_id' => $facebookId));
        if (!$user) {
            throw new UsernameNotFoundException(sprintf("User '%s' not found.", $facebookId));
        }

        return $user;
    }

    /**
     * Finds a user by username.
     *
     * This method is meant to be an extension point for child classes.
     *
     * @param array $data
     *
     * @return UserInterface or null if user does not exist
     */
    public function updateFacebookUserData(\Videona\DBBundle\Entity\SocialFacebook $socialFacebook, $data) {
        $socialFacebook->setEmail('pruebaSocial@gmail.com');
//        if (!$user) {
//            throw new UsernameNotFoundException(sprintf("User '%s' not found.", $facebookId));
//        }

        $this->em->persist($socialFacebook);
        $this->em->flush();
        //return $data['facebook_id'];
        return $socialFacebook;
    }

    /**
     * Create a user.
     *
     * This method is meant to be an extension point for child classes.
     *
     * @param array $data
     *
     * @return UserInterface or null if user does not exist
     */
    public function createFacebookUser($data) {
        $facebook_user = new SocialFacebook();
        $facebook_user->setEmail($data['email']);
//        if (!$user) {
//            throw new UsernameNotFoundException(sprintf("User '%s' not found.", $facebookId));
//        }
        //$this->em->persist($socialFacebook);
        //$this->em->flush();
        return $facebook_user;
    }

    /**
     * Finds a user by username.
     *
     * This method is meant to be an extension point for child classes.
     *
     * @param string $username
     *
     * @return UserInterface or null if user does not exist
     */
    public function findUser($username) {
        //return $this->userManager->findUserByUsername($username);
    }

}
