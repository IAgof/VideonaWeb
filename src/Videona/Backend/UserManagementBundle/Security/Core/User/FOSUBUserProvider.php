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

namespace Videona\Backend\UserManagementBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * FOSUBUserProvider connects the user with the social networks defined in 
 * main firewall
 *
 * @author vlf
 */
class FOSUBUserProvider extends BaseClass {

    /**
     * Connects the current user if he is logged with one of the social 
     * networks defined in main firewall.
     * 
     * @param UserInterface $user
     * @param UserResponseInterface $response
     */
    public function connect(UserInterface $user, UserResponseInterface $response) {
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();

        $setter = 'set' . ucfirst($service);
        $setterId = $setter . 'Id';

        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setterId(null);
            $this->userManager->updateUser($previousUser);
        }

        //we connect current user
        $user->$setterId($username);

        $this->userManager->updateUser($user);
    }

    /**
     * Connects the current user if he is logged with one of the social 
     * networks defined in main firewall.
     * 
     * @param UserResponseInterface $response
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response) {
        // Check service login
        $serviceName = $response->getResourceOwner()->getName();

        switch ($serviceName) {
            case 'facebook':
                // Get user data from Facebook 
                $userData = $response->getResponse();
                $userid = $userData['id'];
                $socialEmail = $response->getEmail();
                $firstname = $userData['first_name'];
                $gender = $userData['gender'];
                $lastname = $userData['last_name'];
                $link = $userData['link'];
                $locale = $userData['locale'];
                $realName = $response->getRealName();
                $timezone = $userData['timezone'];
                $updatedTime = $userData['updated_time'];
                $verified = $userData['verified'];
                // Get profile image
                $userFb = "https://graph.facebook.com/" . $userid;
                $profilePicture = $userFb . "/picture?width=260&height=260";
                $nickname = $response->getNickname();
                // Get oauth token
                $oauthToken = $response->getAccessToken();
                $expiresIn = $response->getExpiresIn();
                $data = [
                    "facebook_id" => $userid,
                    "facebook_access_token" => $oauthToken,
                    "facebook_access_token_expires_in" => $expiresIn,
                    "email" => $socialEmail,
                    "firstname" => $firstname,
                    "lastname" => $lastname,
                    "gender" => $gender,
                    "link" => $link,
                    "locale" => $locale,
                    "realname" => $realName,
                    "timezone" => $timezone,
                    "updated_time" => $updatedTime,
                    "verified" => $verified,
                    "profile_picture" => $profilePicture,
                    "nick" => $nickname
                ];

                // Check if this user exists in the database
                $socialManager = $GLOBALS['kernel']->getContainer()->get('my_facebook_manager');
                $socialUser = $socialManager->loadUserBySocialId($userid);

                break;
            case 'google':
                // Get user data from Google 
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

                // Check if this user exists in the database
                $socialManager = $GLOBALS['kernel']->getContainer()->get('my_google_manager');
                $socialUser = $socialManager->loadUserBySocialId($userid);

                break;
            case 'twitter':
                // Get user data from Twitter
                $userData = $response->getResponse();
                $userid = $userData['id'];
                $socialEmail = null;
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

                // Check if this user exists in the database
                $socialManager = $GLOBALS['kernel']->getContainer()->get('my_twitter_manager');
                $socialUser = $socialManager->loadUserBySocialId($userid);

                break;
        }
                
        // Check if this id exists in the DB
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $userid));
                
        // When the user is registrating
        if (null === $user) {
            
            // Check if email is null
            if ($socialEmail == null) {
                $socialEmail = $userid . '@' . $userid . '.com';
            }
            
            // We check for the email existence - if so, update user.
            if ($existentUser = $this->userManager->findUserByEmail($socialEmail)) {
                // If user exists - go with the HWIOAuth way
                
                $setter = 'set' . ucfirst($serviceName);
                $setterId = $setter . 'Id';

                // Update access token
                $existentUser->$setterId($userid);
                
                // Download the social profile picture if user hasn't a profile picture with us
                if (null === $existentUser->getProfilePicture()) {
                    $imageManager = $GLOBALS['kernel']->getContainer()->get('my_image_manager');
                    $profilePictureId = $imageManager->saveOriginalImage($user, $profilePicture);
                    
                    // Update the profile picture
                    $existentUser->setProfilePicture($profilePictureId);
                }                

                $this->userManager->updateUser($existentUser);
                
                // Check if social user exists
                if (null === $socialUser) {
                    // Create new social user
                    $socialManager->createSocialUser($data, $existentUser);
                } else {
                    // Update social user data
                    $socialManager->updateSocialUserData($socialUser, $data, $existentUser);
                }

                return $existentUser;
            }

            // If user doesn't exist, create new user
            $setter = 'set' . ucfirst($serviceName);
            $setterId = $setter . 'Id';

            // Create new user here
            $user = $this->userManager->createUser();
            $user->$setterId($userid);
            // I have set all requested data with the user's username
            // Modify here with relevant data
            $user->setUsername(' ');
            $user->setUsernameChange('0');
            $user->setVideonaRegister('0');
            $user->setEmail($socialEmail);
            // Insert user id like a password until user creates a password with us
            $user->setPlainPassword($userid);
            $user->setEnabled(true);
            
            // Download the social profile picture if user has a profile picture
            if ($profilePicture) {
                $imageManager = $GLOBALS['kernel']->getContainer()->get('my_image_manager');
                $profilePictureId = $imageManager->saveOriginalImage($user, $profilePicture);

                // Update the profile picture
                $user->setProfilePicture($profilePictureId);
            } 

            // Update user
            $this->userManager->updateUser($user);
            
            // Check if social user exists
            if (null === $socialUser) {
                // Create new social user
                $socialManager->createSocialUser($data, $user);
            } else {
                // Update social user data
                $socialManager->updateSocialUserData($socialUser, $data, $user);
            }

            return $user;
        }

        // If user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);
        
        $changeControl = 0;
        
        // Check if the user has been deleted his account previously
        if ($user->getTempDisableAccount()) {
            $user->setTempDisableAccount('0');
            
            // Update control variable
            $changeControl = 1;
        }

        // Download the social profile picture if user hasn't a profile picture with us
        if (null === $user->getProfilePicture()) {
            $imageManager = $GLOBALS['kernel']->getContainer()->get('my_image_manager');
            $profilePictureId = $imageManager->saveOriginalImage($user, $profilePicture);
            
            // Update the profile picture
            $user->setProfilePicture($profilePictureId);
            
            // Update control variable
            $changeControl = 1;
        }
        
        if($changeControl) {
            // Update user
            $this->userManager->updateUser($user);
        }
                
        // Check if social user exists
        if (null === $socialUser) {
            // Create new social user
            $socialManager->createSocialUser($data, $user);
        } else {
            // Update social user data
            $socialManager->updateSocialUserData($socialUser, $data, $user);
        }

        return $user;
    }

}
