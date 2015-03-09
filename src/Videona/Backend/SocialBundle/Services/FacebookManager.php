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
use Videona\Backend\SocialBundle\Services\ImageManager;

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
        $this->repository = $this->em->getRepository('VideonaDBBundle:SocialFacebook');
        $this->imageManager = $imageManager;
    }

    /**
     * Finds a user by the user's unique id on Facebook on social_facebook table
     * 
     * @param string $facebookId
     * 
     * @return UserInterface or null if user does not exist
     */
    public function loadUserBySocialId($facebookId) {
        $user = $this->repository->findOneBy(array('facebook_id' => $facebookId));
        
        return $user;
    }

    /**
     * Update social user data.
     *
     * @param SocialFacebook $socialFacebook
     * @param array $data
     */
    public function updateSocialUserData($socialFacebook, $data) {
        
        // Save original image
        //$imageId = $this->imageManager->loadImage($data['usr'], $data['profile_picture']);
        
        // Update social user data
        //$socialFacebook->setUsr($data['usr']);
        $socialFacebook->setUsr('57');
        $socialFacebook->setFacebookAccessToken($data['facebook_access_token']);
        $socialFacebook->setFacebookAccessTokenExpiresIn($data['facebook_access_token_expires_in']);
        $socialFacebook->setEmail($data['email']);
        $socialFacebook->setFirstname($data['firstname']);
        $socialFacebook->setLastname($data['lastname']);
        $socialFacebook->setGender($data['gender']);
        $socialFacebook->setLink($data['link']);
        $socialFacebook->setLocale($data['locale']);
        $socialFacebook->setRealname($data['realname']);
        $socialFacebook->setTimezone($data['timezone']);
        $socialFacebook->setUpdatedTime($data['updated_time']);
        $socialFacebook->setVerified($data['verified']);
        $socialFacebook->setNickname($data['nick']);
        //$socialFacebook->setProfilePicture($imageId);
        
        $this->em->persist($socialFacebook);
        $this->em->flush();
    }

    /**
     * Create a user.
     *
     * @param array $data
     *
     * @return UserInterface or null if user does not exist
     */
    public function createSocialUser($data) {
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
