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

namespace Videona\Backend\SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * TwitterController is a class for connecting to the Twitter API
 *
 * @author vlf
 */
class TwitterController extends Controller {

    // Define our parameters constants
    const REQUEST_METHOD = 'POST';
    const SIGNATURE_METHOD = 'HMAC-SHA1';
    const OAUTH_VERSION = '1.0';
    const REQUEST_TOKEN_URI = 'https://api.twitter.com/oauth/request_token';
    const ACCESS_TOKEN_URI = 'https://api.twitter.com/oauth/access_token';

    /**
     * Method for sending a request to authenticate the user in Twitter.
     * 
     * @return redirect to Twitter API
     */
    public function getOauthTokenAction() {
        // Set request parameters
        $baseURI = self::REQUEST_TOKEN_URI;
        $nonce = time();
        $timestamp = time();
        $oauth = array('oauth_callback' => 'http://localhost/Videona/web/app_dev.php/login/twitter/getOauthAccessToken',
            'oauth_consumer_key' => $this->container->getParameter('twitter_id'),
            'oauth_nonce' => $nonce,
            'oauth_signature_method' => self::SIGNATURE_METHOD,
            'oauth_timestamp' => $timestamp,
            'oauth_version' => self::OAUTH_VERSION);

        // Get base string
        $baseString = self::buildBaseString($baseURI, $oauth);
        // Get composite key
        $compositeKey = self::getCompositeKey($this->container->getParameter('twitter_key'), null); //first request, no request token yet
        // Sign the base string
        $oauthSignature = base64_encode(hash_hmac('sha1', $baseString, $compositeKey, true));
        // Add the signature to our array
        $oauth['oauth_signature'] = $oauthSignature;

        // Get complete oauth response
        $oauthResponseToken = self::sendRequest($oauth, $baseURI, null);
        list($oauthToken, $oauthTokenSecret, $oauthCallbackConfirmed) = explode("&", $oauthResponseToken);

        // Get oauth response token value
        list($oauthTokenKey, $oauthTokenValue) = explode("=", $oauthToken);
        list($oauthTokenSecretKey, $oauthTokenSecretValue) = explode("=", $oauthTokenSecret);

        // Save it in a session var
        $_SESSION['oauth_token'] = $oauthTokenValue;
        $_SESSION['oauth_token_secret'] = $oauthTokenSecretValue;

        // Call to Twitter API
        return $this->redirect('https://api.twitter.com/oauth/authenticate?' . $oauthToken);
    }

    /**
     * Method for sending oauth token and user data to our user provider.
     * 
     * @return redirect to oauth provider
     * 
     * @throws AuthenticationException
     */
    public function getOauthAccessTokenAction() {
        // Get cookie values
        $oauthToken = $_GET['oauth_token'];
        $oauthVerifier = $_GET['oauth_verifier'];

        // Ckeck if user token is the same as the value of access token session value
        if ($oauthToken == $_SESSION['oauth_token']) {
            // Set request parameters
            $baseURI = self::ACCESS_TOKEN_URI;
            $nonce = time();
            $timestamp = time();
            $oauth = array(
                'oauth_consumer_key' => $this->container->getParameter('twitter_id'),
                'oauth_nonce' => $nonce,
                'oauth_signature_method' => self::SIGNATURE_METHOD,
                'oauth_timestamp' => $timestamp,
                'oauth_version' => self::OAUTH_VERSION);

            // Get base string
            $baseString = self::buildBaseString($baseURI, $oauth);
            // Get composite key
            $compositeKey = self::getCompositeKey($this->container->getParameter('twitter_key'), $_SESSION['oauth_token_secret']); //second request, there is request token now
            // Sign the base string
            $oauthSignature = base64_encode(hash_hmac('sha1', $baseString, $compositeKey, true));
            // Add the signature to our oauth array
            $oauth['oauth_signature'] = $oauthSignature;
            // Add the oauth token to our oauth array
            $oauth['oauth_token'] = $oauthToken;
            // Remove the oauth callback from our oauth array
            unset($oauth['oauth_callback']);

            // Set post parameters
            $parameters = 'oauth_verifier=' . rawurlencode($oauthVerifier);

            // Get complete oauth response
            $oauthResponse = self::sendRequest($oauth, $baseURI, $parameters);

            // Register/login in to our database
            return $this->redirect($this->generateUrl('hwi_oauth_service_redirect', array('service' => 'twitter')));
        } else {
            //  The request token received is not the same as session token
            throw new AuthenticationException('Invalid oauth token in the request.');
        }
    }

    /**
     * Method for creating a base string from an array and base URI.
     * 
     * @param string $baseURI the URI of the request to twitter
     * @param array $params the OAuth associative array
     * 
     * @return string the encoded base string
     */
    private function buildBaseString($baseURI, $params) {

        $r = array(); //temporary array
        ksort($params); //sort params alphabetically by keys
        foreach ($params as $key => $value) {
            $r[] = "$key=" . rawurlencode($value); //create key=value strings
        }//end foreach                

        return self::REQUEST_METHOD . '&' . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r)); //return complete base string
    }

    /**
     * Method for creating the composite key.
     * 
     * @param string $consumerSecret the consumer secret authorized by Twitter
     * @param string $requestToken the request token from Twitter
     * 
     * @return string The composite key.
     */
    private function getCompositeKey($consumerSecret, $requestToken) {
        return rawurlencode($consumerSecret) . '&' . rawurlencode($requestToken);
    }

    /**
     * Method for building the OAuth header.
     * 
     * @param array $oauth the oauth array.
     * 
     * @return string the authorization header.
     */
    private function buildAuthorizationHeader($oauth) {
        $r = 'Authorization: OAuth '; //header prefix

        $values = array(); //temporary key=value array
        foreach ($oauth as $key => $value)
            $values[] = "$key=\"" . rawurlencode($value) . "\""; //encode key=value string

        $r .= implode(', ', $values); //reassemble

        return $r; //return full authorization header
    }

    /**
     * Method for sending a request to Twitter.
     * 
     * @param array $oauth The oauth array
     * @param string $baseURI The request URI
     * 
     * @return string the response from Twitter
     */
    private function sendRequest($oauth, $baseURI, $parameters) {
        $header = array(self::buildAuthorizationHeader($oauth), 'Expect:'); //create header array and add 'Expect:'

        $options = array(CURLOPT_HTTPHEADER => $header, //use our authorization and expect header
            CURLOPT_HEADER => false, //don't retrieve the header back from Twitter
            CURLOPT_URL => $baseURI, //the URI we're sending the request to
            CURLOPT_POST => true, //this is going to be a POST - required
            CURLOPT_POSTFIELDS => $parameters,
            CURLOPT_RETURNTRANSFER => true, //return content as a string, don't echo out directly
            CURLOPT_SSL_VERIFYPEER => false); //don't verify SSL certificate, just do it

        $ch = curl_init(); //get a channel
        curl_setopt_array($ch, $options); //set options
        $response = curl_exec($ch); //make the call
        curl_close($ch); //hang up

        return $response;
    }

}
