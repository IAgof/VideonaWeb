<?php

/*
 * LICENCIA!!
 */

namespace Videona\Backend\UserManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * SelectUsernameFormType builds a select username form
 *
 * @author vlf
 */
class SelectUsernameFormType extends AbstractType {

    /**
     * Build the select username form with a username field.
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', 'text', array(
                    'label' => 'form.registration.username.name',
                    'data' => preg_replace('/\s+/', '', trim($options['data']->getUsername()))
                ))
                ->add('select', 'submit', array('label' => 'form.registration.submit'));
    }

    /**
     * Sets the default options.
     * 
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Videona\DBBundle\Entity\User',
            'translation_domain' => 'messages'
        ));
    }

    /**
     * Gets the name of this select username form type.
     * 
     * @return name of the select username form type
     */
    public function getName() {
        return 'choose_username';
    }

//    Para hacer validaciones en tiempo real
//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        $builder
//            ->add('username', 'text', array(
//                'attr' => array(
//                    'pattern'     => '.{4,}' //minlength
//                )
//            ));
//    }
//
//    public function setDefaultOptions(OptionsResolverInterface $resolver)
//    {
//        $collectionConstraint = new Collection(array(
//            'username' => array(
//                new NotBlank(array('message' => 'Username should not be blank.')),
//                new Length(array('min' => 3))
//            )
//        ));
//        
//        $resolver->setDefaults(array(
//            'data_class' => 'Videona\DBBundle\Entity\User',
//            'translation_domain' => 'messages',
//            'constraints' => $collectionConstraint
//        ));
//    }
//
}
