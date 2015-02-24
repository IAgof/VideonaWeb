<?php

namespace Videona\Backend\UserManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class SelectUsernameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label' => 'form.registration.username.name',
                'data' => preg_replace('/\s+/', '', trim($options['data']->getUsername()))
            ))
            ->add('select', 'submit', array('label' => 'form.registration.submit'));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {       
        $resolver->setDefaults(array(
            'data_class' => 'Videona\DBBundle\Entity\User',
            'translation_domain' => 'messages'
        ));
    }

    public function getName()
    {
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