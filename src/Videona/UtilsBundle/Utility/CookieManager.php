<?php

namespace Videona\UtilsBundle\Utility;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Cookie functions 
 *
 * @author vlf
 */
class CookieManager {
    
    // Define our parameters constants
    const COOKIE_DELIMITER = ':';
    const COOKIE_SECRET_KEY = 'videona_vlf_secret_key';
        
    /**
     * Deletes the remember-me cookie
     *
     * @param Request $request
     * @param string  $name The name of the remember me cookie
     * @param string  $path The path of the remember me cookie
     * @param string  $domain The domain of the remember me cookie
     */
    public static function cancelCookie(Request $request,$cookie_name, $name, $path, $domain)
    {
        $request->attributes->set($cookie_name, new Cookie($name, null, 1, $path, $domain));
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
        return hash_hmac('sha256', $class.$username.$expires.$password, self::COOKIE_SECRET_KEY);
    }
}
