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
use Videona\UtilsBundle\Utility\Utils;

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
        
        // Load service manager
        $socialManager = $this->userManager->getServiceManager($serviceName);
                        
        // Get the social user data
        $data = $socialManager->loadSocialData($response);
        
        // Get id, email and profile picture of the user in his social account
        $userid = $data[$serviceName.'_id'];
        $profilePicture = $data['profile_picture'];
        if($data['email']) {
            $socialEmail = $data['email'];
        } else {
            $socialEmail = null;
        }
        
        // Check if this user exists in the database
        $socialUser = $socialManager->loadUserBySocialId($userid);

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
                    $profilePictureId = $this->userManager->saveOriginalImage($user, $profilePicture);

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
            $user->setPlainPassword(Utils::generateStrongPassword(16));
            $user->setEnabled(true);

            // Download the social profile picture if user has a profile picture
            if ($profilePicture) {
                $profilePictureId = $this->userManager->saveOriginalImage($user, $profilePicture);

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
            $profilePictureId = $this->userManager->saveOriginalImage($user, $profilePicture);

            // Update the profile picture
            $user->setProfilePicture($profilePictureId);

            // Update control variable
            $changeControl = 1;
        }

        if ($changeControl) {
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
