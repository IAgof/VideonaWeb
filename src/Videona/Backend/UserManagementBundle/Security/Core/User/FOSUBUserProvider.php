<?php

/*
 * LICENCIA!!
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

        $setter = 'set'.ucfirst($service);
        $setterId = $setter.'Id';
        
        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setterId(null);
            $this->userManager->updateUser($previousUser);
        }
        
        /*
         * TODO: intentar poner el username con utils::removedots()
         * En el loaduserbyoauthuserresponse también.
         * Así lo puedo quitar del formulario de seleccionar el username
         */

        /*
         * TODO: actualizar el token pero con la id asociada en la tabla, ya no va con el token!!!
         * Hacerlo también en la de loadUSerBuOathUserResponse
         */
        //we connect current user
        //$user->$setterId($username);
        
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
        switch($serviceName) {
            case 'facebook':
                // Get user data from Facebook 
                $userdata = $response->getResponse();
                $userid = $userdata['id'];
                $useremail = $response->getEmail();
                $firstname = $userdata['first_name'];
                $usergender = $userdata['gender'];
                $lastname = $userdata['last_name'];
                $userlink = $userdata['link'];
                $userlocale = $userdata['locale'];
                $userrealname = $response->getRealName();
                $usertimezone = $userdata['timezone'];
                $userupdatedtime = $userdata['updated_time'];
                $userverified = $userdata['verified'];
                // Get profile image
                $userFb = "https://graph.facebook.com/" .$userid;
                $profilepicture = $userFb."/picture?width=260&height=260";
                $usernickname = $response->getNickname();
                // Get oauth token
                $oauthToken = $response->getAccessToken();
                $expiresIn = $response->getExpiresIn();
                $info = [
                    "facebook_id"=>$userid,
                    "facebook_access_token"=>$oauthToken,
                    "facebook_access_token_expires_in"=>$expiresIn,
                    "email"=>$useremail,
                    "firstname"=>$firstname,
                    "lastname"=>$lastname,
                    "gender"=>$usergender,
                    "link"=>$userlink,
                    "locale"=>$userlocale,
                    "realname"=>$userrealname,
                    "timezone"=>$usertimezone,
                    "updated_time"=>$userupdatedtime,
                    "verified"=>$userverified,
                    "profile_picture"=>$profilepicture,
                    "nick"=>$usernickname
                ];
                // Create new facebook user if not exists
                //userManager->createUser();
                
                // Check if this user exists in the database
                $facebookManager = $GLOBALS['kernel']->getContainer()->get('my_facebook_manager');
                $socialUser = $facebookManager->loadUserByFacebookId($userid);
                
                
                //$prueba2 = $facebookmanager->updateFacebookUserData($prueba, $info);
        
                /* 
                 * TODO: guardar los datos en la tabla de facebook, google, twitter 
                 * y actualizar los datos aunque ya existan.
                 * Crear objetos de cada una de las redes y manejarlos con un manager.
                 * Pero lo tengo que hacer al final, cuando ya sepa la id del usuario.
                 * El servicio lo suyo sería crearlo dentro del bundle social que 
                 * hay dentro de videonaWeb. Crear un manager por cada red o uno 
                 * global que las maneje todas.
                 */
                /*
                $facebook_user = $this->socialfacebookManager->createSocialFacebook();
                $facebook_user->$facebook_id($userid);
                $facebook_user->$facebook_access_token($oauthToken);
                $this->socialfacebookManager->updateSocialFacebook($facebook_user);
                */
                /*
                $facebook_user = new SocialFacebook();
                $facebook_user->setUsr($userid);
                $facebook_user->setFacebookId($userid);
                $facebook_user->setFacebookAccessToken($oauthToken);
                $facebook_user->setFacebookAccessTokenExpiresIn($expiresIn);
                $facebook_user->setEmail($useremail);
                $facebook_user->setFirstname($firstname);
                $facebook_user->setLastname($lastname);
                $facebook_user->setGender($usergender);
                $facebook_user->setLink($userlink);
                $facebook_user->setLocale($userlocale);
                $facebook_user->setRealname($userrealname);
                $facebook_user->setTimezone($usertimezone);
                $facebook_user->setUpdatedTime($userupdatedtime);
                $facebook_user->setVerified($userverified);
                $facebook_user->setProfilePicture($profilepicture);
                 * 
                 */
                
                
                break;
            case 'google':
                // Get user data from Google 
                $userdata = $response->getResponse();
                $userid = $userdata['id'];
                $useremail = $response->getEmail();
                $firstname = $userdata['given_name'];
                $usergender = $userdata['gender'];
                $lastname = $userdata['family_name'];
                $userlink = $userdata['link'];
                $userlocale = $userdata['locale'];
                $userrealname = $response->getRealName();
                $userverified = $userdata['verified_email'];
                $profilepicture = $response->getProfilePicture();
                // Get oauth token
                $oauthToken = $response->getAccessToken();
                $expiresIn = $response->getExpiresIn();
                $info = [
                    "google_id"=>$userid,
                    "google_access_token"=>$oauthToken,
                    "google_access_token_expires_in"=>$expiresIn,
                    "email"=>$useremail,
                    "firstname"=>$firstname,
                    "lastname"=>$lastname,
                    "link"=>$userlink,
                    "locale"=>$userlocale,
                    "realname"=>$userrealname,
                    "verified"=>$userverified,
                    "profile_picture"=>$profilepicture
                ];
                break;
            case 'twitter':
                // Get user data from Twitter
                $userdata = $response->getResponse();
                $userid = $userdata['id'];
                $useremail = null;
                $userrealname = $response->getRealName();
                $screenName = $userdata['screen_name'];
                $followersCount = $userdata['followers_count'];
                $friendsCount = $userdata['friends_count'];
                $listedCount = $userdata['listed_count'];
                $createdAt = $userdata['created_at'];
                $favouritesCount = $userdata['favourites_count'];
                $userlocale = $userdata['lang'];
                $profilepicture = $userdata['profile_image_url'];
                // Get oauth token
                $oauthToken = $response->getAccessToken();
                $oauthTokenSecret = $response->getTokenSecret();
                $expiresIn = $response->getExpiresIn();
                $info = [
                    "twitter_id"=>$userid,
                    "twitter_access_token"=>$oauthToken,
                    "twitter_access_token_secret"=>$oauthTokenSecret,
                    "twitter_access_token_expires_in"=>$expiresIn,
                    "realname"=>$userrealname,
                    "screen_name"=>$screenName,
                    "followers_count"=>$followersCount,
                    "friends_count"=>$friendsCount,
                    "listed_count"=>$listedCount,
                    "created_at"=>$createdAt,
                    "favourites_count"=>$favouritesCount,
                    "locale"=>$userlocale,
                    "profile_picture"=>$profilepicture
                ];
                break;
        }
        
        /*
         * TODO: descargar las imágenes de perfil y actualizar el campo
         * correspondiente a la imagen de perfil en la base de datos. Pero hacer
         * primero una comprobación para ver si ya tiene una imagen de perfil. Si
         * la tiene no descargar la de la red social.
         */
         
        
        
        /*
         * TODO: hacer el deslogueo de las redes sociales justo antes de llamar 
         * al logout (en plan cuando el usuario clique en el enlace de cerrar
         * sesión), o hacerlo en el twig nada más loguearse?? Si no es en esos
         * instantes, entonces cuándo?
         */
        
        /*
         * TODO: para que funcionase bien la base de datos con la relación OneToOne,
         * he tenido que apuntar a la clave primaria id, en lugar de al token. 
         * Modificar en los datos del usuario el setter del token, porque ahora
         * lo que guardaré será la id del token!!!!
         */
                            
        // Check if this id exists in the DB
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $userid));
                        
        // When the user is registrating
        if (null === $user) {
            // We check for the username existence - if so, update user.
            if($existentUser = $this->userManager->findUserByEmail($response->getEmail())){
                //throw new \Symfony\Component\Security\Core\Exception\AuthenticationException($message);
                // If user exists - go with the HWIOAuth way
                $user = $existentUser;
                
                // Get user id
                $useridDB = $user->getId();
                // Add user id to array which contains the user data
                $info['usr'] = $useridDB;

                $setter = 'set'.ucfirst($serviceName);
                $setterId = $setter.'Id';
                
                // Update access token
                //$user->$setter_id($userid);
                                
                $this->userManager->updateUser($user);
                return $user;
            } 
            
            // If email doesn't exist, create new user
            $setter = 'set'.ucfirst($serviceName);
            $setterId = $setter.'Id';
            
            // Create new user here
            $user = $this->userManager->createUser();
            //$user->$setter_id($userid);
            // I have set all requested data with the user's username
            // Modify here with relevant data
            $user->setUsername($userrealname);
            $user->setUsernameChange('0');
            $user->setVideonaRegister('0');
            // Check if email is null
            if ($useremail == null){
                $user->setEmail($userid.'@'.$userid.'.com');
            } else {
                $user->setEmail($useremail);
            }
            // Insert user id like a password until user creates a password with us
            //$user->setPlainPassword($userid);
            $user->setPlainPassword('pRueba123!');
            $user->setEnabled(true);
            
            // Update user
            $this->userManager->updateUser($user);
            
            // Get user id
            $useridDB = $user->getId();
            // Add user id to array which contains the user data
            $info['usr'] = $useridDB;
            
            return $user;
        }
        
        // If user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);
        
        // Get user id
        $useridDB = $user->getId();
        // Add user id to array which contains the user data
        $info['usr'] = $useridDB;
        
        return $user;
    }
 
}

