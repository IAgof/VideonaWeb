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
use Videona\DBBundle\Entity\SocialGoogle;
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
     * Gets the social user data from his Google account.
     * 
     * @param UserResponseInterface $response
     * 
     * @return array the user social data
     */
    public function loadSocialData($response) {

        $userData = $response->getResponse();
        $userid = $userData['id'];
        $socialEmail = $response->getEmail();
        $firstname = $userData['given_name'];
        $lastname = $userData['family_name'];
        $gender = $userData['gender'];
        $link = $userData['link'];
        $locale = $userData['locale'];
        $realName = $response->getRealName();
        $verified = $userData['verified_email'];
        $profilePicture = $response->getProfilePicture();
        // Get oauth token
        $oauthToken = $response->getAccessToken();
        $expiresIn = $response->getExpiresIn();
        $data = [
            "google_id" => $userid,
            "google_access_token" => $oauthToken,
            "google_access_token_expires_in" => $expiresIn,
            "email" => $socialEmail,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "gender" => $gender,
            "link" => $link,
            "locale" => $locale,
            "realname" => $realName,
            "verified" => $verified,
            "profile_picture" => $profilePicture
        ];

        return $data;
    }

    /**
     * Finds a user by the user's unique id on Google on social_google table
     * 
     * @param string $googleId
     * 
     * @return UserInterface or null if user does not exist
     */
    public function loadUserBySocialId($googleId) {
        $user = $this->repository->findOneBy(array('googleId' => $googleId));

        return $user;
    }

    /**
     * Update social user data.
     *
     * @param SocialGoogle $socialUser
     * @param array $data the social user data
     * @param User $user
     */
    public function updateSocialUserData($socialUser, $data, $user) {

        // Update social user data
        $socialUser->setUsr($user);
        $socialUser->setGoogleId($data['google_id']);
        $socialUser->setGoogleAccessToken($data['google_access_token']);
        $socialUser->setGoogleAccessTokenExpiresIn($data['google_access_token_expires_in']);
        $socialUser->setEmail($data['email']);
        $socialUser->setFirstname($data['firstname']);
        $socialUser->setLastname($data['lastname']);
        $socialUser->setGender($data['gender']);
        $socialUser->setLink($data['link']);
        $socialUser->setLocale($data['locale']);
        $socialUser->setRealname($data['realname']);
        $socialUser->setVerified($data['verified']);
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

        // Create new user of Google+
        $socialUser = new SocialGoogle();

        $socialUser->setUsr($user);
        $socialUser->setGoogleId($data['google_id']);
        $socialUser->setGoogleAccessToken($data['google_access_token']);
        $socialUser->setGoogleAccessTokenExpiresIn($data['google_access_token_expires_in']);
        $socialUser->setEmail($data['email']);
        $socialUser->setFirstname($data['firstname']);
        $socialUser->setLastname($data['lastname']);
        $socialUser->setGender($data['gender']);
        $socialUser->setLink($data['link']);
        $socialUser->setLocale($data['locale']);
        $socialUser->setRealname($data['realname']);
        $socialUser->setVerified($data['verified']);
        $socialUser->setProfilePicture($data['profile_picture']);

        $this->em->persist($socialUser);
        $this->em->flush();
    }

    /**
     * Get access token of the user by the user's unique id on Google 
     * on social_google table
     * 
     * @param string $googleId
     * 
     * @return string access token of the user
     */
    public function getAccessToken($googleId) {
        $user = $this->repository->findOneBy(array('googleId' => $googleId));

        return $user->getGoogleAccessToken();
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
