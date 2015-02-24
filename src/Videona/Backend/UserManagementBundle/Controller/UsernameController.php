<?php

namespace Videona\Backend\UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Videona\Backend\UserManagementBundle\Form\SelectUsernameFormType;

class UsernameController extends Controller
{
        
    /**
     * Finds a user by username.
     * @param string $username_selected
     * @return user
     **/
    private function findUserByUsername($username_selected) {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $check_user = $userManager->findUserBy(array('username' => $username_selected));
        
        return $check_user; //return user
    }
    
    /**
     * Method for updating username.
     * @param string $user the user
     * @param string $username_selected the username selected by user
     **/
    private function selectUsername($user, $username_selected) {
        // Update username_change to 1
        $user->setUsernameChange('1');
        // Update username
        $user->setUsername($username_selected);
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $userManager->updateUser($user);
    }
    
    public function getSocialUsernameAction(Request $request) {
        // Get user
        $user = $this->getUser();
        $userid = $user->getId();
        $username_change = $user->getUsernameChange();
                      
        // Select username first time
        if ($username_change != 1){
            $form = $this->createForm(new SelectUsernameFormType(), $user);
            
            $form->handleRequest($request);
                        
            if ($request->isMethod('POST')) {
                if ($form->isValid()) {
                    // Get username selected
                    $username_selected = $form->get('username')->getData();
                                                           
                    // If username is valid, check if username exists
                    $check_user = self::findUserByUsername($username_selected);
                    // If username does not exist
                    if (!$check_user) {
                        // Update username
                        self::selectUsername($user, $username_selected);
                        // Redirect to home page
                        return $this->redirect($this->generateUrl('_home'));            
                    }
                    // Check who owns the username
                    if ($userid != $check_user->getId()){
                        // Another user has got this username
                        $this->get('session')->getFlashBag()->set(
                            'success',
                            array(
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