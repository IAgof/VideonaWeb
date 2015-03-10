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

namespace Videona\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Request;
use Videona\UtilsBundle\Utility\Utils;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * UserRestController controls the access via API
 *
 * @author vlf
 */
class UserRestController extends Controller {

    /**
     * Create new user
     * 
     * POST Route annotation.
     * @Post("/signup")
     * 
     * @param Request $request
     * 
     * @return Response $response
     */
    public function signupAction(Request $request) {

        // Get request data
        $params = array();
        $content = $request->getContent();
        if (!empty($content)) {
            $params = json_decode($content, true); // 2nd param to get as array
        }
        $username = $params['username'];
        $email = $params['email'];
        $password = $params['password'];

        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        // Check if username is valid
        if ($username) {
            $usernameValid = Utils::validateUsername($username);
        } else {
            $usernameValid = false;
        }
        // Check if email is valid
        if ($email) {
            $emailValid = Utils::validateEmail($email);
        } else {
            $emailValid = false;
        }

        // If request data is valid, check if exists in the database
        if ($usernameValid) {
            $usernameExists = $userManager->findUserByUsername($username);
        }
        if ($emailValid) {
            $emailExists = $userManager->findUserByEmail($email);
        }

        // If username doesn't exist in the DB and username is valid, the user
        // can use this username
        if ($usernameValid == true && $usernameExists == false) {
            $usernameInvalid = false;
        } else {
            $usernameInvalid = true;
        }
        // If email doesn't exist in the DB and email is valid, the user
        // can use this email
        if ($emailValid == true && $emailExists == false) {
            $emailInvalid = false;
        } else {
            $emailInvalid = true;
        }

        // Generate response
        $response = new Response();

        // If username or email are invalid, the server return a bad request
        if ($usernameInvalid || $emailInvalid) {

            // Create json response
            $jsonResponse = array();
            $jsonResponse[] = array("error" => "Invalid request");

            $response->setContent(json_encode($jsonResponse));
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            // Set header as json
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        // Create new user
        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        // Update user
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setUsernameChange('0');
        $user->setVideonaRegister('0');
        $userManager->updateUser($user);

        // Check if user has been created
        if ($username == $user->getUsername()) {
            $response->setStatusCode(Response::HTTP_CREATED);
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }

    /**
     * Check if the username and/or the email are valid and exist
     * 
     * GET Route annotation.
     * @Get("/check-user")
     * 
     * @param Request $request
     *
     * @return Response $response
     */
    public function checkIfUserExistsAction(Request $request) {

        // Get request data
        $username = $request->get('username');
        $email = $request->get('email');

        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        // Create response
        $response = new Response();

        // If request has username data, check if username is valid
        if ($username === null) {
            $usernameInvalid = null;
        } else {
            $usernameValid = Utils::validateUsername($username);

            // If username is not valid, send 400 response code
            if (!$usernameValid) {

                // Create json response
                $jsonResponse = array();
                $jsonResponse[] = array("error" => "Invalid request");

                $response->setContent(json_encode($jsonResponse));
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                // Set header as json
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            } else {
                // If request data is valid, check if exists in the database
                $usernameExists = $userManager->findUserByUsername($username);
            }

            // If username doesn't exist in the DB and username is valid, the user
            // can use this username
            if ($usernameValid === true && $usernameExists === null) {
                $usernameInvalid = false;
            } else {
                $usernameInvalid = true;
            }
        }

        // If request has email data, check if email is valid
        if ($email === null) {
            $emailInvalid = null;
        } else {
            $emailValid = Utils::validateEmail($email);

            // If email is not valid, send 400 response code
            if (!$emailValid) {

                // Create json response
                $jsonResponse = array();
                $jsonResponse[] = array("error" => "Invalid request");

                $response->setContent(json_encode($jsonResponse));
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                // Set header as json
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            } else {
                // If request data is valid, check if exists in the database
                $emailExists = $userManager->findUserByEmail($email);
            }

            // If email doesn't exist in the DB and email is valid, the user
            // can use this email
            if ($emailValid === 1 && $emailExists === null) {
                $emailInvalid = false;
            } else {
                $emailInvalid = true;
            }
        }

        // Create json response
        $jsonResponse = array();
        $jsonResponse[] = array("username" => $usernameInvalid, "email" => $emailInvalid);

        $response->setContent(json_encode($jsonResponse));
        $response->setStatusCode(Response::HTTP_OK);
        // Set header as json
        $response->headers->set('Content-Type', 'application/json');

        // Send response
        return $response;
    }

    /**
     * Sign in user
     * 
     * GET Route annotation.
     * @Get("/login")
     * 
     * @return Response $response Response with cookie session
     */
    public function loginAction() {

//        // Get current user
//        $user = $this->getUser();
//
//        // Create response
//        $response = new Response();
//
//        // Update last login of this user
//        $user->setLastLogin(new \DateTime());
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($user);
//        $em->flush();
//
//        return $response;
    }

    /**
     * Función mía para probar
     * 
     * GET Route annotation.
     * @Get("/prueba")
     * 
     * @return
     */
    public function pruebaAction(Request $request) {

        $facebookmanager = $this->get('my_facebook_manager');

        //$facebookmanager = $GLOBALS['kernel']->getContainer()->get('my_facebook_manager');

        $user = $facebookmanager->loadUserByUserIdFacebook('10');
        ld($user);
        return new Response('ok');
    }

    /**
     * Retrieve user's profile
     * 
     * GET Route annotation.
     * @Get("/users/{id}/profile")
     * 
     * @param int $id The user's identifier
     * 
     * @throws createNotFoundException
     * @throws AccessDeniedException
     * 
     * @return UserInterface $user user that you find
     */
    public function getProfileAction($id) {

        // Check if user is logged
        if (false === $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }
        //ld($this->getRequest());
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->find($id);
        if (!is_object($user)) {
            throw $this->createNotFoundException();
        }

        $user2 = $this->getUser();
        $userid = $user2->getId();
        //ld($this->getRequest());
        //echo $userid;
        //var_dump($user);
        //var_dump($user->getImages());

        /*
         * TODO: Videona: tengo mis dudas sobre la relación entre la imagen de perfil y
         * el usuario. Realmente lo que es la imagen de perfil es uno a uno.
         * Si se trata de imágenes sí es uno a muchos.
         */

        //echo $user->getProfilePicture()->getId();

        return $user;
        //return new Response($username);
    }

    /**
     * Update user's profile
     * 
     * PUT Route annotation.
     * @Put("/users/{id}/profile")
     * 
     * @param int $id The user's identifier
     * 
     * @throws createNotFoundException
     * @throws AccessDeniedException
     * 
     * @return UserInterface $user User that you find
     */
    public function putProfileAction($id) {

        // Check if user is logged
        if (false === $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->find($id);
        if (!is_object($user)) {
            throw $this->createNotFoundException();
            //throw new NotFoundHttpException('User not found');
        }
        //var_dump($user);
        //var_dump($user->getImages());
        //echo $user->getProfilePicture()->getId();

        return $user;
        //return new Response($id);
    }

    /**
     * Retrieve user's profile icon
     * 
     * GET Route annotation.
     * @Get("/users/{id}/profile/avatar")
     * 
     * @param int $id The user's identifier
     * 
     * @throws createNotFoundException
     * @throws AccessDeniedException
     * 
     * @return UserInterface $user user that you find
     */
    public function getProfileImageAction($id) {

        // Check if user is logged
        if (false === $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->find($id);
        if (!is_object($user)) {
            throw $this->createNotFoundException();
        }

        if ($user->getProfilePicture()) {
            $profileiconid = $user->getProfilePicture()->getId();
            return $profileiconid;
        }

        return 'no tiene';
        //return new Response($username);
    }

    /**
     * Update user's profile icon
     * 
     * PUT Route annotation.
     * @Put("/users/{id}/profile/avatar")
     * 
     * @param int $id The user's identifier
     * 
     * @throws createNotFoundException
     * @throws AccessDeniedException
     * 
     * @return UserInterface $user user that you find
     */
    public function putProfileImageAction($id) {

        // Check if user is logged
        if (false === $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->find($id);
        if (!is_object($user)) {
            throw $this->createNotFoundException();
        }

//        if ($user->getProfilePicture()){
//            $profileiconid = $user->getProfilePicture()->getId();
//            return $profileiconid;
//        }

        return new Response('actualizado');
    }

    /**
     * Retrieve username of a user
     * 
     * GET Route annotation.
     * @Get("/users/{id}/profile/name")
     * 
     * @param int $id The user's identifier
     * 
     * @throws createNotFoundException
     * @throws AccessDeniedException
     * 
     * @return UserInterface $user user that you find
     */
    public function getUsernameAction($id) {

        // Check if user is logged
        if (false === $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->find($id);
        if (!is_object($user)) {
            throw $this->createNotFoundException();
        }

        return $user->getUsername();
        //return new Response($username);
    }

    /**
     * Retrieve username of a user
     * 
     * GET Route annotation.
     * @Get("/users/profile/name")
     * 
     * @param Request $request
     * 
     * @throws createNotFoundException
     * @throws AccessDeniedException
     * 
     * @return UserInterface $user user that you find
     */
    public function getUsernameMeAction(Request $request) {

        // Check if user is logged
        if (false === $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }

        $username = $request->getUser();
        return $this->getUser();
        //ld($this->getUser());
        //return $username;
        //return new Response($username);
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->findOneByUsername($username);
        if (!is_object($user)) {
            throw $this->createNotFoundException();
        }
        //ld($user->getEmail());    
        //return $user;
    }

    /**
     * List user videos
     * Retrieve a list of videos created by a specific user
     * 
     * GET Route annotation.
     * @Get("/users/{id}/videos")
     * 
     * @param int $id The user's identifier
     * 
     * @throws createNotFoundException
     * @throws AccessDeniedException
     * 
     * @return UserInterface $user user that you find
     */
    public function getVideosAction($id) {

        // Check if user is logged
        if (false === $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->find($id);
        if (!is_object($user)) {
            throw $this->createNotFoundException();
        }

        return new Response('ok');
    }

    /**
     * Retrieve a list of users
     * 
     * GET Route annotation.
     * @Get("/users/{username}/find")
     * 
     * @param String $username The user's name
     * 
     * @throws createNotFoundException
     * @throws AccessDeniedException
     * 
     * @return UserInterface $user user that you find
     */
    public function findUserAction($username) {
        
        // Check if user is logged
        if (false === $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }
        
        /*
         * Lo puedo usar para cuando implemente la función buscar usuarios y
         * en lugar de devolver un usuario pues que devuelva una lista
         */
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->findOneByUsername($username);
        if (!is_object($user)) {
            throw $this->createNotFoundException();
        }
        return $user;
        //return new Response($username);
    }

    /**
     * List of users
     * 
     * GET Route annotation.
     * @Get("/users")
     * 
     * @throws AccessDeniedException
     * 
     * @return UserInterface $users list of all users of database
     */
    public function getUsersAction() {

        // Check if user is logged
        if (false === $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('VideonaDBBundle:User')->findAll();
        //if(!is_object($user)){
        //throw $this->createNotFoundException();
        //}
        //var_dump($users);

        foreach ($users as $user) {
            // Retrieve data
            $id = $user->getId();
            $email = $user->getEmail();
        }
        //return new Response('ok');
        return $users;
    }

}
