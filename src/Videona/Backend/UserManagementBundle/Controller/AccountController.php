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

namespace Videona\Backend\UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * AccountController is a class to manage the accounts of the users.
 *
 * @author vlf
 */
class AccountController extends Controller {

    /**
     * Method for deleting user account on Videona and social data of the user.
     * 
     * @return view a view of home page
     */
    public function deleteAction() {
        
        
        $user = $this->getUser();
        
        $availableSocialNetworks = $this->container->getParameter('social_networks');
        $numSocialNetworks = count($availableSocialNetworks);
        $userSocialData = array();
                
        // Delete social data
        for ($i = 0; $i < $numSocialNetworks; $i++) {
            $getter = 'get' . ucfirst($availableSocialNetworks[$i]);
            $getterId = $getter . 'Id';
            $socialDataId = $user->$getterId();
            if ($socialDataId) {
                // Delete social data
                $manager = 'my_'.$availableSocialNetworks[$i].'_manager';
                $socialManager = $this->get($manager);
                $socialManager->deleteSocialData($socialDataId);   
            }
        }
        
        // Temporal disabled user account
        $userManager = $this->container->get('fos_user.user_manager');
        $user->setTempDisableAccount('1');
        $user->setDeletedAccount(new \DateTime());
        $userManager->updateUser($user);
          
        return $this->redirect($this->generateUrl('fos_user_security_logout'));
    }

}
