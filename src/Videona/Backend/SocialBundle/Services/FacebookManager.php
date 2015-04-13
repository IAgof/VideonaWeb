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
use Videona\DBBundle\Entity\User;
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
        $user = $this->repository->findOneBy(array('facebookId' => $facebookId));

        return $user;
    }

    /**
     * Update social user data.
     *
     * @param SocialFacebook $socialUser
     * @param array $data the social user data
     * @param User $user
     */
    public function updateSocialUserData($socialUser, $data, $user) {

        // Update social user data
        $socialUser->setUsr($user);
        $socialUser->setFacebookId($data['facebook_id']);
        $socialUser->setFacebookAccessToken($data['facebook_access_token']);
        $socialUser->setFacebookAccessTokenExpiresIn($data['facebook_access_token_expires_in']);
        $socialUser->setEmail($data['email']);
        $socialUser->setFirstname($data['firstname']);
        $socialUser->setLastname($data['lastname']);
        $socialUser->setGender($data['gender']);
        $socialUser->setLink($data['link']);
        $socialUser->setLocale($data['locale']);
        $socialUser->setRealname($data['realname']);
        $socialUser->setTimezone($data['timezone']);
        $socialUser->setUpdatedTime($data['updated_time']);
        $socialUser->setVerified($data['verified']);
        $socialUser->setNickname($data['nick']);
        $socialUser->setProfilePicture($data['profile_picture']);

        $this->em->persist($socialUser);
        $this->em->flush();
    }

    /**
     * Create a new social user.
     *
     * @param array $data the social user data
     * @param User $user
     */
    public function createSocialUser($data, $user) {

        // Create new user of Facebook
        $socialUser = new SocialFacebook();

        $socialUser->setUsr($user);
        $socialUser->setFacebookId($data['facebook_id']);
        $socialUser->setFacebookAccessToken($data['facebook_access_token']);
        $socialUser->setFacebookAccessTokenExpiresIn($data['facebook_access_token_expires_in']);
        $socialUser->setEmail($data['email']);
        $socialUser->setFirstname($data['firstname']);
        $socialUser->setLastname($data['lastname']);
        $socialUser->setGender($data['gender']);
        $socialUser->setLink($data['link']);
        $socialUser->setLocale($data['locale']);
        $socialUser->setRealname($data['realname']);
        $socialUser->setTimezone($data['timezone']);
        $socialUser->setUpdatedTime($data['updated_time']);
        $socialUser->setVerified($data['verified']);
        $socialUser->setNickname($data['nick']);
        $socialUser->setProfilePicture($data['profile_picture']);

        $this->em->persist($socialUser);
        $this->em->flush();
    }

    /**
     * Delete social user data.
     *
     * @param String $socialId
     */
    public function deleteSocialData($socialId) {
        // Delete social user data
        $socialUser = self::loadUserBySocialId($socialId);

        $this->em->remove($socialUser);
        $this->em->flush();
    }

}
