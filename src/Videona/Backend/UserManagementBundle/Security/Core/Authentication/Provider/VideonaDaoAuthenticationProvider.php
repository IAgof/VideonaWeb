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

namespace Videona\Backend\UserManagementBundle\Security\Core\Authentication\Provider;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Provider\DaoAuthenticationProvider;

/**
 * VideonaDaoAuthenticationProvider is a class that extends from DaoAuthenticationProvider
 * class.
 *
 * @author vlf
 */
class VideonaDaoAuthenticationProvider extends DaoAuthenticationProvider {
    //put your code here
    protected function checkAuthentication(UserInterface $user, UsernamePasswordToken $token) {
        
        //parent::checkAuthentication($user, $token);
        
        $currentUser = $token->getUser();
        
        if ($currentUser instanceof UserInterface) {
            if ($currentUser->getPassword() !== $user->getPassword()) {
                throw new BadCredentialsException('The credentials were changed from another session.');
            }
        } else {
            if ("" === ($presentedPassword = $token->getCredentials())) {
                throw new BadCredentialsException('The presented password cannot be empty.');
            }

            // Check if the user has registered with Videona or not
            if(!$user->getVideonaRegister()) {
                // If this user has not registered with Videona, throws exception
                throw new BadCredentialsException('The presented password is invalid.');
            }
        
            if (!$this->encoderFactory->getEncoder($user)->isPasswordValid($user->getPassword(), $presentedPassword, $user->getSalt())) {
                throw new BadCredentialsException('The presented password is invalid.');
            }
        }
    }
}
