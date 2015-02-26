<?php

namespace Videona\Backend\SocialBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TwitterController extends Controller
{
    // Define our parameters constants
    const REQUEST_METHOD = 'POST';
    const SIGNATURE_METHOD = 'HMAC-SHA1';
    const OAUTH_VERSION = '1.0';
    const REQUEST_TOKEN_URI = 'https://api.twitter.com/oauth/request_token';
    const ACCESS_TOKEN_URI = 'https://api.twitter.com/oauth/access_token';
        
    /**
     * Method for creating a base string from an array and base URI.
     * @param string $baseURI the URI of the request to twitter
     * @param array $params the OAuth associative array
     * @return string the encoded base string
     **/
    private function buildBaseString($baseURI, $params){

        $r = array(); //temporary array
        ksort($params); //sort params alphabetically by keys
        foreach($params as $key=>$value){
            $r[] = "$key=" . rawurlencode($value); //create key=value strings
        }//end foreach                

        return self::REQUEST_METHOD . '&' . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r)); //return complete base string
    }
     
    /**
     * Method for creating the composite key.
     * @param string $consumerSecret the consumer secret authorized by Twitter
     * @param string $requestToken the request token from Twitter
     * @return string the composite key.
     **/
    private function getCompositeKey($consumerSecret, $requestToken){
       return rawurlencode($consumerSecret) . '&' . rawurlencode($requestToken);
    }
    
    /**
     * Method for building the OAuth header.
     * @param array $oauth the oauth array.
     * @return string the authorization header.
     **/
    private function buildAuthorizationHeader($oauth){
       $r = 'Authorization: OAuth '; //header prefix

       $values = array(); //temporary key=value array
       foreach($oauth as $key=>$value)
           $values[] = "$key=\"" . rawurlencode($value) . "\""; //encode key=value string

       $r .= implode(', ', $values); //reassemble

       return $r; //return full authorization header
    }
        
    /**
     * Method for sending a request to Twitter.
     * @param array $oauth the oauth array
     * @param string $baseURI the request URI
     * @return string the response from Twitter
     **/
    private function sendRequest($oauth, $baseURI, $parameters){
       $header = array( self::buildAuthorizationHeader($oauth), 'Expect:'); //create header array and add 'Expect:'

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
        
    public function getOauthTokenAction()
    {
        // Set request parameters
        $baseURI = self::REQUEST_TOKEN_URI;
        $nonce = time();
        $timestamp = time();
        $oauth = array('oauth_callback' => 'http://localhost/Videona/web/app_dev.php/login/twitter/getOauthAccessToken',
                      'oauth_consumer_key' => $this->container->getParameter('twitterId'),
                      'oauth_nonce' => $nonce,
                      'oauth_signature_method' => self::SIGNATURE_METHOD,
                      'oauth_timestamp' => $timestamp,
                      'oauth_version' => self::OAUTH_VERSION);
        
        // Get base string
        $baseString = self::buildBaseString($baseURI, $oauth);       
        // Get composite key
        $compositeKey = self::getCompositeKey($this->container->getParameter('twitterKey'), null); //first request, no request token yet
        // Sign the base string
        $oauth_signature = base64_encode(hash_hmac('sha1', $baseString, $compositeKey, true));
        // Add the signature to our array
        $oauth['oauth_signature'] = $oauth_signature;
        
        // Get complete oauth response
        $oauth_response_token = self::sendRequest($oauth, $baseURI, null);
        list($oauth_token,$oauth_token_secret,$oauth_callback_confirmed) = explode("&",$oauth_response_token);
                      
        // Get oauth response token value
        list($oauth_token_key,$oauth_token_value) = explode("=",$oauth_token);
        list($oauth_token_secret_key,$oauth_token_secret_value) = explode("=",$oauth_token_secret);
        
        // Save it in a session var
        $_SESSION['oauth_token'] = $oauth_token_value;
        $_SESSION['oauth_token_secret'] = $oauth_token_secret_value;
        
        // Call to Twitter API
        return $this->redirect('https://api.twitter.com/oauth/authenticate?'.$oauth_token);
    }
    
    public function getOauthAccessTokenAction()
    {
        // Get cookie values
        $oauth_token = $_GET['oauth_token'];
        $oauth_verifier = $_GET['oauth_verifier'];
        
        // Ckeck if user token is the same as the value of access token session value
        if ($oauth_token == $_SESSION['oauth_token']){
            // Set request parameters
            $baseURI = self::ACCESS_TOKEN_URI;
            $nonce = time();
            $timestamp = time();
            $oauth = array(
                          'oauth_consumer_key' => $this->container->getParameter('twitterId'),
                          'oauth_nonce' => $nonce,
                          'oauth_signature_method' => self::SIGNATURE_METHOD,
                          'oauth_timestamp' => $timestamp,
                          'oauth_version' => self::OAUTH_VERSION);

            // Get base string
            $baseString = self::buildBaseString($baseURI, $oauth);
            // Get composite key
            $compositeKey = self::getCompositeKey($this->container->getParameter('twitterKey'), $_SESSION['oauth_token_secret']); //second request, there is request token now
            // Sign the base string
            $oauth_signature = base64_encode(hash_hmac('sha1', $baseString, $compositeKey, true));
            // Add the signature to our oauth array
            $oauth['oauth_signature'] = $oauth_signature;
            // Add the oauth token to our oauth array
            $oauth['oauth_token'] = $oauth_token;
            // Remove the oauth callback from our oauth array
            unset($oauth['oauth_callback']);
            
            // Set post parameters
            $parameters = 'oauth_verifier='.rawurlencode($oauth_verifier);
            
            // Get complete oauth response
            $oauth_response = self::sendRequest($oauth, $baseURI, $parameters);
            
            // Register/login in to our database
            return $this->redirect($this->generateUrl('hwi_oauth_service_redirect', array('service' => 'twitter')));            
        } else {
            //  The request token received is not the same as session token
            throw new AuthenticationException('Invalid oauth token in the request.');
        }
    }
}

