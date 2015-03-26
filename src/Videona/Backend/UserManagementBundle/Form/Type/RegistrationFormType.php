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

namespace Videona\Backend\UserManagementBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

/**
 * RegistrationFormType creates the registration form
 *
 * @author vlf
 */
class RegistrationFormType extends BaseType {

    /**
     * Creates a form based in registration form type of FOSUserBundle.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        /*
          $builder
          ->add('nombre')
          ->add('apellidos')
          ->add('fechaNacimiento')
          ->add('fbAccount')
          ->add('twAccount')
          ->add('gplusAccount')
          ;
         * Por si quiero añadir campos al formulario
         */
//        $builder
//            ->add('email', 'email', array(
//                'label' => 'form.email', 
//                'translation_domain' => 'FOSUserBundle'
//                ))
//            ->add('username', null, array(
//                'label' => 'form.username', 
//                'translation_domain' => 'FOSUserBundle',
//                'attr' => array(
//                    'pattern'     => '.{4,15}' //minlength
//                )))
//            ->add('plainPassword', 'repeated', array(
//                'type' => 'password',
//                'options' => array('translation_domain' => 'FOSUserBundle'),
//                'first_options' => array('label' => 'form.password'),
//                'second_options' => array('label' => 'form.password_confirmation'),
//                'invalid_message' => 'fos_user.password.mismatch',
//                'attr' => array(
//                    'pattern'     => '.{5,15}' //minlength
//                )
//            ))
//        ;
        //$builder->add('roles', 'choice', array('label' => 'Rol', 'required' => true, 'choices' => array( 1 => 'ROLE_ADMIN', 2 => 'ROLE_USER'), 'multiple' => true));
    }

    /**
     * Gets the name of this registration form type.
     * 
     * @return name of the registration form type
     */
    public function getName() {
        return 'my_user_registration';
    }

}
