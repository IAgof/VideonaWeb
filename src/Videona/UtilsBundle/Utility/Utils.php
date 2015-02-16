<?php

namespace Videona\UtilsBundle\Utility;
/**
 * Utility functions.
 *
 * @author vlf
 */
class Utils {
    
//    private $entityManager;
//
//    /**
//     * Constructor.
//     *
//     * @param SessionStorageInterface $storage    A SessionStorageInterface instance.
//     * @param AttributeBagInterface   $attributes An AttributeBagInterface instance, (defaults null for default AttributeBag)
//     * @param FlashBagInterface       $flashes    A FlashBagInterface instance (defaults null for default FlashBag)
//     */
//    public function __construct(EntityManager $entityManager) {
//        $this->entityManager = $entityManager;
//    }
    /**
     * This class should not be instantiated
     */
    public function __construct() {
        
    }
    
    /**
     * Remove dots from an input string.
     * 
     * @param string $data
     * @return string The original string without dots
     **/
    public static function removeDots($data){
        $data= str_replace('.', '', $data);
        
        return $data;
    }
    
    /**
     * Check if the username selected is valid.
     * 
     * @param string $username_selected
     * @return boolean
     **/
    public static function validateUsername($username_selected) {
        $username_selected = self::removeDots($username_selected);
        
        return mb_ereg_match('[a-zA-Z0-9_.ñÑáéíóúÁÉÍÓÚÇ]{4,15}$', $username_selected);
    }
    
    /**
     * Check if the email selected is valid.
     * 
     * @param string $email_selected
     * @return boolean
     **/
    public static function validateEmail($email_selected) {
        return preg_match('/^[a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{1,}$/', $email_selected);
    }
    
    /**
     * Check if the password selected is valid.
     * 
     * @param string $password_selected
     * @return boolean
     **/
    public static function validatePassword($password_selected) {
        return mb_ereg_match('(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d])(?=.*[@#$%&.,¿?¡!])[a-zA-Z0-9Ç@#$%&.,¿?¡!]{8,16}$', $password_selected);
    }
}
