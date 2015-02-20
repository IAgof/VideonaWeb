<?php

namespace Videona\UtilsBundle\Utility;
/**
 * Utility functions.
 *
 * @author vlf
 */
class Utils {
    
    // Define our parameters constants
    const COOKIE_DELIMITER = ':';
    
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
    
    /**
     * Generates the cookie value.
     *
     * @param string  $class
     * @param string  $username The username
     * @param int     $expires  The Unix timestamp when the cookie expires
     * @param string  $password The encoded password
     *
     * @throws \RuntimeException if username contains invalid chars
     *
     * @return string
     */
    public static function generateCookieValue($class, $username, $expires, $password) {
        return self::encodeCookie(array(
            $class,
            base64_encode($username),
            $expires,
            self::generateCookieHash($class, $username, $expires, $password),
        ));
    }
    
    /**
     * Encodes the cookie parts
     *
     * @param array $cookieParts
     *
     * @return string
     */
    public static function encodeCookie(array $cookieParts)
    {
        return base64_encode(implode(self::COOKIE_DELIMITER, $cookieParts));
    }
    
    /**
     * Generates a hash for the cookie to ensure it is not being tempered with
     *
     * @param string  $class
     * @param string  $username The username
     * @param int     $expires  The Unix timestamp when the cookie expires
     * @param string  $password The encoded password
     *
     * @throws \RuntimeException when the private key is empty
     *
     * @return string
     */
    public static function generateCookieHash($class, $username, $expires, $password)
    {
        // TODO: meter la clase utils como servicio y pasarle la key como parámetro
        return hash_hmac('sha256', $class.$username.$expires.$password, 'videona_vlf_secret_key');
    }
}
