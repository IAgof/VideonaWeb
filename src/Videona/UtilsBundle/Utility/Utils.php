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
     * Removes dots from an input string.
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
     * Checks if the username selected is valid.
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
     * Checks if the email selected is valid.
     * 
     * @param string $emailSelected
     * 
     * @return bool
     * */
    public static function validateEmail($emailSelected) {
        return preg_match('/^[a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{1,}$/', $emailSelected);
    }

    /**
     * Checks if the password selected is valid.
     * 
     * @param string $passwordSelected
     * 
     * @return bool
     * */
    public static function validatePassword($passwordSelected) {
        return mb_ereg_match('(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d])(?=.*[@#$%&.,¿?¡!])[a-zA-Z0-9Ç@#$%&.,¿?¡!]{8,16}$', $passwordSelected);
    }

    /**
     * Generates a strong password of N length containing at least one lower case
     * letter, one uppercase letter, one digit, and one special character. The
     * remaining characters in the password are chosen at random from those
     * four sets.
     * 
     * @param int $length the length of the random password
     * @param bool $addDashes
     * @param string $availableSets the options to generate the password
     * 
     * @return string a random password
     * */
    public static function generateStrongPassword($length = 9, $addDashes = false, $availableSets = 'luds') {

        $sets = array();
        if (strpos($availableSets, 'l') !== false) {
            $sets[] = 'abcdefghijklmnopqrstuvwxyz';
        }
        if (strpos($availableSets, 'u') !== false) {
            $sets[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        if (strpos($availableSets, 'd') !== false) {
            $sets[] = '0123456789';
        }
        if (strpos($availableSets, 's') !== false) {
            $sets[] = '!@#$%&*?[]{}';
        }
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $password .= $all[array_rand($all)];
        }
        $password = str_shuffle($password);
        if (!$addDashes) {
            return $password;
        }
        $dashLen = floor(sqrt($length));
        $dashStr = '';
        while (strlen($password) > $dashLen) {
            $dashStr .= substr($password, 0, $dashLen) . '-';
            $password = substr($password, $dashLen);
        }
        $dashStr .= $password;

        return $dashStr;
    }

}
