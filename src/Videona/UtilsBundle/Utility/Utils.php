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

namespace Videona\UtilsBundle\Utility;

/**
 * Utility functions.
 *
 * @author vlf
 */
class Utils {

    /**
     * This class should not be instantiated
     */
    public function __construct() {
        
    }

    /**
     * Remove dots from an input string.
     * 
     * @param string $data
     * 
     * @return string The original string without dots
     * */
    public static function removeDots($data) {
        $newData = str_replace('.', '', $data);

        return $newData;
    }

    /**
     * Check if the username selected is valid.
     * 
     * @param string $usernameSelected
     * 
     * @return bool
     * */
    public static function validateUsername($usernameSelected) {
        $username = self::removeDots($usernameSelected);

        return mb_ereg_match('[a-zA-Z0-9_.ñÑáéíóúÁÉÍÓÚÇ]{4,15}$', $username);
    }

    /**
     * Check if the email selected is valid.
     * 
     * @param string $emailSelected
     * 
     * @return bool
     * */
    public static function validateEmail($emailSelected) {
        return preg_match('/^[a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{1,}$/', $emailSelected);
    }

    /**
     * Check if the password selected is valid.
     * 
     * @param string $passwordSelected
     * 
     * @return bool
     * */
    public static function validatePassword($passwordSelected) {
        return mb_ereg_match('(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d])(?=.*[@#$%&.,¿?¡!])[a-zA-Z0-9Ç@#$%&.,¿?¡!]{8,16}$', $passwordSelected);
    }

}
