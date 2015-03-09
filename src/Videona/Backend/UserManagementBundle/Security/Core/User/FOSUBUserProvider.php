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

        /*
         * TODO: Videona: intentar poner el username con utils::removedots()
         * En el loaduserbyoauthuserresponse también.
         * Así lo puedo quitar del formulario de seleccionar el username
         */

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
        //ld($response);
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
                $userEmail = $response->getEmail();
                $firstname = $userData['given_name'];
                $gender = $userData['gender'];
                $lastname = $userData['family_name'];
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
                    "email" => $userEmail,
                    "firstname" => $firstname,
                    "lastname" => $lastname,
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
                $userEmail = null;
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

        //ld($userid);
        $socialManager->updateSocialUserData($socialUser, $data);
        return;
        /*
         * TODO: Videona: descargar las imágenes de perfil y actualizar el campo
         * correspondiente a la imagen de perfil en la base de datos. Pero hacer
         * primero una comprobación para ver si ya tiene una imagen de perfil. Si
         * la tiene no descargar la de la red social.
         */

        /*
         * TODO: Videona: guardar los datos en la tabla de facebook, google, twitter 
         * y actualizar los datos aunque ya existan.
         * Crear objetos de cada una de las redes y manejarlos con un manager.
         * Pero lo tengo que hacer al final, cuando ya sepa la id del usuario.
         * El servicio lo suyo sería crearlo dentro del bundle social que 
         * hay dentro de videonaWeb. Crear un manager por cada red o uno 
         * global que las maneje todas.
         */

        if (null === $socialUser) {
            // Create new social user if not exists
        } else {
            // Update social user data
            //$prueba2 = $socialManager->updateSocialUserData($socialUser, $data);
        }

//        if ($profilePicture) {
//            // Guardar la imagen de perfil
//        }

        /*
         * TODO: Videona: hacer el deslogueo de las redes sociales justo antes de llamar 
         * al logout (en plan cuando el usuario clique en el enlace de cerrar
         * sesión), o hacerlo en el twig nada más loguearse?? Si no es en esos
         * instantes, entonces cuándo?
         */

        // Check if this id exists in the DB
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $userid));

        // When the user is registrating
        if (null === $user) {
            // We check for the username existence - if so, update user.
            if ($existentUser = $this->userManager->findUserByEmail($response->getEmail())) {
                //throw new \Symfony\Component\Security\Core\Exception\AuthenticationException($message);
                // If user exists - go with the HWIOAuth way
                $user = $existentUser;

                // Get user id
                $useridDB = $user->getId();
                // Add user id to array which contains the user data
                $data['usr'] = $useridDB;

                $setter = 'set' . ucfirst($serviceName);
                $setterId = $setter . 'Id';

                // Update access token
                $user->$setterId($userid);

                $this->userManager->updateUser($user);
                return $user;
            }

            // If email doesn't exist, create new user
            $setter = 'set' . ucfirst($serviceName);
            $setterId = $setter . 'Id';

            // Create new user here
            $user = $this->userManager->createUser();
            $user->$setterId($userid);
            // I have set all requested data with the user's username
            // Modify here with relevant data
            $user->setUsername($userrealname);
            $user->setUsernameChange('0');
            $user->setVideonaRegister('0');
            // Check if email is null
            if ($useremail == null) {
                $user->setEmail($userid . '@' . $userid . '.com');
            } else {
                $user->setEmail($useremail);
            }
            // Insert user id like a password until user creates a password with us
            //$user->setPlainPassword($userid);
            // TODO: Videona: definir cómo guardar la contraseña
            $user->setPlainPassword('pRueba123!');
            $user->setEnabled(true);

            // Update user
            $this->userManager->updateUser($user);

            // Get user id
            $useridDB = $user->getId();
            // Add user id to array which contains the user data
            $data['usr'] = $useridDB;

            return $user;
        }

        // If user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);

        // Get user id
        $useridDB = $user->getId();
        // Add user id to array which contains the user data
        $data['usr'] = $useridDB;

        return $user;
    }

}
