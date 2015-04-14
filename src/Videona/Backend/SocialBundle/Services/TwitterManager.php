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
use Videona\DBBundle\Entity\SocialTwitter;
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
     * Gets the social user data from his Twitter account.
     * 
     * @param UserResponseInterface $response
     * 
     * @return array the user social data
     */
    public function loadSocialData($response) {
        
        $userData = $response->getResponse();
        $userid = $userData['id'];
        $realName = $response->getRealName();
        $screenName = $userData['screen_name'];
        $followersCount = $userData['followers_count'];
        $friendsCount = $userData['friends_count'];
        $listedCount = $userData['listed_count'];
        $createdAt = $userData['created_at'];
        $favouritesCount = $userData['favourites_count'];
        $locale = $userData['lang'];
        $profilePicture = $userData['profile_image_url'];
        // Get oauth token
        $oauthToken = $response->getAccessToken();
        $oauthTokenSecret = $response->getTokenSecret();
        $expiresIn = $response->getExpiresIn();
        $data = [
            "twitter_id" => $userid,
            "twitter_access_token" => $oauthToken,
            "twitter_access_token_secret" => $oauthTokenSecret,
            "twitter_access_token_expires_in" => $expiresIn,
            "realname" => $realName,
            "screen_name" => $screenName,
            "followers_count" => $followersCount,
            "friends_count" => $friendsCount,
            "listed_count" => $listedCount,
            "created_at" => $createdAt,
            "favourites_count" => $favouritesCount,
            "locale" => $locale,
            "profile_picture" => $profilePicture,
        ];

        return $data;
    }
    
    /**
     * Finds a user by the user's unique id on Twitter on social_twitter table
     * 
     * @param string $twitterId
     * 
     * @return UserInterface or null if user does not exist
     */
    public function loadUserBySocialId($twitterId) {
        $user = $this->repository->findOneBy(array('twitterId' => $twitterId));

        return $user;
    }
    
    /**
     * Update social user data.
     *
     * @param SocialTwitter $socialUser
     * @param array $data the social user data
     * @param User $user
     */
    public function updateSocialUserData($socialUser, $data, $user) {
        
        // Update social user data
        $socialUser->setUsr($user);
        $socialUser->setTwitterId($data['twitter_id']);
        $socialUser->setTwitterAccessToken($data['twitter_access_token']);
        $socialUser->setTwitterAccessTokenSecret($data['twitter_access_token_secret']);
        $socialUser->setTwitterAccessTokenExpiresIn($data['twitter_access_token_expires_in']);
        $socialUser->setRealname($data['realname']);
        $socialUser->setScreenName($data['screen_name']);
        $socialUser->setFollowersCount($data['followers_count']);
        $socialUser->setFriendsCount($data['friends_count']);
        $socialUser->setListedCount($data['listed_count']);
        $socialUser->setCreatedAt($data['created_at']);
        $socialUser->setFavouritesCount($data['favourites_count']);
        $socialUser->setLocale($data['locale']);
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
        
        // Create new user of Twitter
        $socialUser = new SocialTwitter();
        
        $socialUser->setUsr($user);
        $socialUser->setTwitterId($data['twitter_id']);
        $socialUser->setTwitterAccessToken($data['twitter_access_token']);
        $socialUser->setTwitterAccessTokenSecret($data['twitter_access_token_secret']);
        $socialUser->setTwitterAccessTokenExpiresIn($data['twitter_access_token_expires_in']);
        $socialUser->setRealname($data['realname']);
        $socialUser->setScreenName($data['screen_name']);
        $socialUser->setFollowersCount($data['followers_count']);
        $socialUser->setFriendsCount($data['friends_count']);
        $socialUser->setListedCount($data['listed_count']);
        $socialUser->setCreatedAt($data['created_at']);
        $socialUser->setFavouritesCount($data['favourites_count']);
        $socialUser->setLocale($data['locale']);
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
