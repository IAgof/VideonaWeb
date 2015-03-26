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
use Symfony\Component\HttpFoundation\Request;
use Videona\Backend\UserManagementBundle\Form\Type\SelectUsernameFormType;

/**
 * UsernameController is a class that allows users to select his username in the
 * register
 *
 * @author vlf
 */
class UsernameController extends Controller {

    /**
     * Finds a user by username.
     * 
     * @param string $usernameSelected the username selected by user
     * 
     * @return UserInterface or null if user does not exist
     */
    private function findUserByUsername($usernameSelected) {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $checkUser = $userManager->findUserBy(array('username' => $usernameSelected));

        return $checkUser; //return user
    }

    /**
     * Method for updating username.
     * 
     * @param UserInterface $user
     * @param string $usernameSelected The username selected by user
     */
    private function selectUsername($user, $usernameSelected) {
        // Update username_change to 1
        $user->setUsernameChange('1');
        // Update username
        $user->setUsername($usernameSelected);
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $userManager->updateUser($user);
    }

    /**
     * Method for updating username.
     * 
     * @param Request $request
     */
    public function getSocialUsernameAction(Request $request) {
        // Get user
        $user = $this->getUser();
        $userid = $user->getId();
        $usernameChange = $user->getUsernameChange();

        // Select username first time
        if ($usernameChange != 1) {
            $form = $this->createForm(new SelectUsernameFormType(), $user);

            $form->handleRequest($request);

            if ($request->isMethod('POST')) {
                if ($form->isValid()) {
                    // Get username selected
                    $usernameSelected = $form->get('username')->getData();

                    // If username is valid, check if username exists
                    $checkUser = self::findUserByUsername($usernameSelected);
                    // If username does not exist
                    if (!$checkUser) {
                        // Update username
                        self::selectUsername($user, $usernameSelected);
                        // Redirect to home page
                        return $this->redirect($this->generateUrl('_home'));
                    }
                    // Check who owns the username
                    if ($userid != $checkUser->getId()) {
                        // Another user has got this username
                        $this->get('session')->getFlashBag()->set(
                                'success', array(
                            'title' => $this->get('translator')->trans('form.registration.username.duplicate.title'),
                            'message' => $this->get('translator')->trans('form.registration.username.duplicate.message')
                                )
                        );
                        // Redirect to username select form 
                        return $this->redirect($this->generateUrl('select_username'));
                    }
                    // Redirect to home page
                    return $this->redirect($this->generateUrl('_home'));
                }
            }

            // Show form to select a valid username
            return $this->render('VideonaBackendUserManagementBundle:Registration:username.html.twig', array(
                        'form' => $form->createView(),
            ));
        }
        // Redirect to home page
        return $this->redirect($this->generateUrl('_home'));
    }

}
