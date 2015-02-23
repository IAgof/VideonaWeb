<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Videona\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Videona\UtilsBundle\Utility\Utils;
use Videona\UtilsBundle\Utility\CookieManager;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;

/**
 * Description of UserRestController
 *
 * @author vlf
 */
class UserRestController extends Controller {
    
    /**
     * This attribute name can be used by the implementation if it needs to set
     * a cookie on the Request when there is no actual Response, yet.
     *
     * @var string
     */
    const COOKIE_ATTR_NAME = '_security_remember_me_cookie';
    
    // TODO: devolver en formato json los datos (mirar la configuración de RestBundle)
    
    /**
     * Create new user
     * 
     * POST Route annotation.
     * @Post("/signup")
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * 
     * @return \Symfony\Component\HttpFoundation\Response $response
     */
    public function signupAction(Request $request) {   
        
        // Get request data
        $params = array();
        $content = $request->getContent();
        if (!empty($content))
        {
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
        if ($username){
            $username_valid = Utils::validateUsername($username);
        } else {
            $username_valid = false;
        }
        // Check if email is valid
        if ($email){
            $email_valid = Utils::validateEmail($email);
        } else {
            $email_valid = false;
        }
        
        // If request data is valid, check if exists in the database
        if ($username_valid){
            $username_exists = $userManager->findUserByUsername($username);
        } 
        if ($email_valid){
            $email_exists = $userManager->findUserByEmail($email);
        }
        
        // If username doesn't exist in the DB and username is valid, the user
        // can use this username
        if ($username_valid == true && $username_exists == false) {
            $username_invalid = false;
        } else {
            $username_invalid = true;
        }
        // If email doesn't exist in the DB and email is valid, the user
        // can use this email
        if ($email_valid == true && $email_exists == false) {
            $email_invalid = false;
        } else {
            $email_invalid = true;
        }
        
        // Generate response
        $response = new Response(); 
        
        // If username or email are invalid, the server return a bad request
        if ($username_invalid || $email_invalid){
            
            // Create json response
            $json_response = array();
            $json_response[] = array("error" => "Invalid request");
            
            $response->setContent(json_encode($json_response));
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
        if ($username == $user->getUsername()){
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response $response
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
        if ($username === null){
            $username_invalid = null;
        } else {
            $username_valid = Utils::validateUsername($username);
            
            // If username is not valid, send 400 response code
            if (!$username_valid){

                // Create json response
                $json_response = array();
                $json_response[] = array("error" => "Invalid request");

                $response->setContent(json_encode($json_response));
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                // Set header as json
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            } else {
                // If request data is valid, check if exists in the database
                $username_exists = $userManager->findUserByUsername($username);
            }
            
            // If username doesn't exist in the DB and username is valid, the user
            // can use this username
            if ($username_valid === true && $username_exists === null) {
                $username_invalid = false;
            } else {
                $username_invalid = true;
            }
        }
        
        // If request has email data, check if email is valid
        if ($email === null){
            $email_invalid = null;
        } else {
            $email_valid = Utils::validateEmail($email);
            
            // If email is not valid, send 400 response code
            if (!$email_valid){

                // Create json response
                $json_response = array();
                $json_response[] = array("error" => "Invalid request");

                $response->setContent(json_encode($json_response));
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                // Set header as json
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            } else {
                // If request data is valid, check if exists in the database
                $email_exists = $userManager->findUserByEmail($email);
            } 
            
            // If email doesn't exist in the DB and email is valid, the user
            // can use this email
            if ($email_valid === 1 && $email_exists === null) {
                $email_invalid = false;
            } else {
                $email_invalid = true;
            }
        }
              
        // Create json response
        $json_response = array();
        $json_response[] = array("username" => $username_invalid, "email" => $email_invalid);
        
        $response->setContent(json_encode($json_response));
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
     * @return \Symfony\Component\HttpFoundation\Response $response Response with cookie session
     */
    public function loginAction(Request $request) {
                
        // Get token
        $token = $this->container->get('security.context')->getToken();
        // Get current user
        $user = $token->getUser();
        //$user = $this->getUser();
        
        // Get request parameters
        $rememeber_me = $request->query->get('_remember_me');
        
        // Create response
        $response = new Response();
        
        // Make sure any old remember-me cookies are cancelled
        $name = $this->container->getParameter('rememeberme_rest.name');
        $path = $this->container->getParameter('rememeberme_rest.path');
        $domain = $this->container->getParameter('rememeberme_rest.domain');
        //CookieManager::cancelCookie($request, self::COOKIE_ATTR_NAME, $name, $path, $domain);
        
        // If user has checked rememeber me option
        if ($rememeber_me === '1'){
            
            //$this->logger->debug('Remember-me was requested; setting cookie.');
            
            // Remove attribute from request that sets a NULL cookie.
            // It was set by $this->cancelCookie()
            // (cancelCookie does other things too for some RememberMeServices
            // so we should still call it at the start of this method)
            $request->attributes->remove(self::COOKIE_ATTR_NAME);
            
            // Create cookie REMEMBERME
            $expires = time() + $this->container->getParameter('rememeberme_rest.expires');
            $value = CookieManager::generateCookieValue(get_class($user), $user->getUsername(), $expires, $user->getPassword());
            $secure = $this->container->getParameter('rememeberme_rest.secure');
            $httponly = $this->container->getParameter('rememeberme_rest.httponly');

            $response->headers->setCookie(
                new Cookie(
                    $name,
                    $value,
                    $expires,
                    $path,
                    $domain,
                    $secure,
                    $httponly
                )
            );
        } else {
            //$this->logger->debug('Remember-me was not requested.');
        }
           
        // Update last login of this user
        $user->setLastLogin(new \DateTime());
                
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
               
        return $response;
    }
    
    /**
     * Sign out user
     * 
     * POST Route annotation.
     * @Post("/logout")
     * 
     * @return
     */
    public function logoutAction() {   
      
        // Throw new exception if the logout is not activate in the security firewall configuration
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
    
    /**
     * Redirect the user after logout success
     * 
     * GET Route annotation.
     * @Get("/logout-success")
     * 
     * @return \Symfony\Component\HttpFoundation\Response $response
     */
    public function logoutSuccessAction() {
        
        // Create response
        $response = new Response(); 
        
        return $response;
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
        
        Utils::validatePassword('¡123!.abcC$%#?¿p');
        $response = new Response();
        
        return new Response();
                
    }
    
    /**
     * Función mía para probar
     * 
     * GET Route annotation.
     * @Get("/email")
     * 
     * @return Array $users list of all users of database
     */
    public function isUsernameValidAction(Request $request) {   
        
        $email_valid = Utils::validateEmail($request->get('email'));
        ld($email_valid);
        
        return $request->get('email');
        //return $response;
    }
        
    /**
     * Retrieve user's profile
     * 
     * GET Route annotation.
     * @Get("/users/{id}/profile")
     * 
     * @param Integer $id The user's identifier
     * @return Array $user user that you find
     */
    public function getProfileAction($id) {
        //ld($this->getRequest());
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->find($id);
        if(!is_object($user)){
          throw $this->createNotFoundException();
        }
        
        $user2 = $this->getUser();
        $userid = $user2->getId();
        //ld($this->getRequest());
        //echo $userid;
        //var_dump($user);
        //var_dump($user->getImages());
        
        /*
         * TODO: tengo mis dudas sobre la relación entre la imagen de perfil y
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
     * @param Integer $id The user's identifier
     * @return Array $user User that you find
     */
    public function putProfileAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->find($id);
        if(!is_object($user)){
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
     * @param Integer $id The user's identifier
     * @return Array $user user that you find
     */
    public function getProfileImageAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->find($id);
        if(!is_object($user)){
          throw $this->createNotFoundException();
        }
        
        if ($user->getProfilePicture()){
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
     * @param Integer $id The user's identifier
     * @return Array $user user that you find
     */
    public function putProfileImageAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->find($id);
        if(!is_object($user)){
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
     * @param Integer $id The user's identifier
     * @return Array $user user that you find
     */
    public function getUsernameAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->find($id);
        if(!is_object($user)){
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
     * @return Array $user user that you find
     */
    public function getUsernameMeAction(Request $request) {
        
        
        $username = $request->getUser();
        return $this->getUser();
         //ld($this->getUser());
        //return $username;
        //return new Response($username);
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->findOneByUsername($username);
        if(!is_object($user)){
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
     * @param Integer $id The user's identifier
     * @return Array $user user that you find
     */
    public function getVideosAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->find($id);
        if(!is_object($user)){
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
     * @return Array $user user that you find
     */
    public function findUserAction($username) {
        /*
         * Lo puedo usar para cuando implemente la función buscar usuarios y
         * en lugar de devolver un usuario pues que devuelva una lista
         */
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('VideonaDBBundle:User')->findOneByUsername($username);
        if(!is_object($user)){
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
     * @return Array $users list of all users of database
     */
    public function getUsersAction() {
        
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('VideonaDBBundle:User')->findAll();
        //if(!is_object($user)){
          //throw $this->createNotFoundException();
        //}
        
        //var_dump($users);
        
        foreach($users as $user)
        {
            // Retrieve data
            $id = $user->getId();
            $email = $user->getEmail();
        }        
        //return new Response('ok');
        return $users;
    }
}
