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

namespace Videona\DBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Videona\UtilsBundle\Utility\Utils;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Videona\DBBundle\Entity\UserRepository")
 */
class User extends BaseUser {

    /**
     * The user's identifier
     * 
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * This parameter specifies if the user has selected a valid username
     * 
     * @ORM\Column(name="username_change", type="boolean") 
     */
    protected $username_change;

    /**
     * This is the token that Facebook returns for every user
     * 
     * @var string
     * 
     * @ORM\Column(name="facebook_id", type="string", length=255, unique=true, nullable=true)
     */
    protected $facebook_id;

    /**
     * This is the token that Google+ returns for every user
     * 
     * @var string
     * 
     * @ORM\Column(name="google_id", type="string", length=255, unique=true, nullable=true)
     */
    protected $google_id;

    /**
     * This is the token that Twitter returns for every user
     * 
     * @var string
     * 
     * @ORM\Column(name="twitter_id", type="string", length=255, unique=true, nullable=true)
     */
    protected $twitter_id;

    /**
     * The user's profile image
     * 
     * @var integer
     * 
     * @ORM\OneToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="profile_picture", referencedColumnName="id")
     */
    protected $profile_picture;

    /**
     * This parameter indicates if the user has been registered by Videona
     * or another social network
     * 
     * @ORM\Column(name="videona_register", type="boolean") 
     */
    protected $videona_register;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        // your own logic
        //$this->images = new ArrayCollection();
        $this->username_change = '0';
        $this->videona_register = '0';
    }

    /**
     * Set usernameCanonical
     *
     * @param string $usernameCanonical
     *
     * @return User
     */
    public function setUsernameCanonical($usernameCanonical) {
        parent::setUsernameCanonical($usernameCanonical);
        $this->usernameCanonical = Utils::removeDots($usernameCanonical);

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Agrega un rol al usuario.
     * @throws Exception
     * @param Rol $rol 
     */
    /*
      public function addRole( $rol )
      {
      if($rol == 1) {
      array_push($this->roles, 'ROLE_ADMIN');
      }
      else if($rol == 2) {
      array_push($this->roles, 'ROLE_USER');
      }
      }
     */

    /**
     * Set usernameChange
     *
     * @param bool $usernameChange
     *
     * @return User
     */
    public function setUsernameChange($usernameChange) {
        $this->username_change = $usernameChange;

        return $this;
    }

    /**
     * Get usernameChange
     *
     * @return bool
     */
    public function getUsernameChange() {
        return $this->username_change;
    }

    /**
     * Set facebook_id
     *
     * @param integer $facebookId
     * 
     * @return User
     */
    public function setFacebookId($facebookId) {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebook_id
     *
     * @return integer 
     */
    public function getFacebookId() {
        return $this->facebook_id;
    }

    /**
     * Set google_id
     *
     * @param integer $googleId
     * 
     * @return User
     */
    public function setGoogleId($googleId) {
        $this->google_id = $googleId;

        return $this;
    }

    /**
     * Get google_id
     *
     * @return integer 
     */
    public function getGoogleId() {
        return $this->google_id;
    }

    /**
     * Set twitter_id
     *
     * @param integer $twitterId
     * 
     * @return User
     */
    public function setTwitterId($twitterId) {
        $this->twitter_id = $twitterId;

        return $this;
    }

    /**
     * Get twitter_id
     *
     * @return integer 
     */
    public function getTwitterId() {
        return $this->twitter_id;
    }

    /**
     * Set profilePicture
     *
     * @param integer $profilePicture
     *
     * @return User
     */
    public function setProfilePicture($profilePicture) {
        $this->profile_picture = $profilePicture;

        return $this;
    }

    /**
     * Get profilePicture
     *
     * @return integer
     */
    public function getProfilePicture() {
        return $this->profile_picture;
    }

    /**
     * Set videonaRegister
     *
     * @param bool $videonaRegister
     *
     * @return User
     */
    public function setVideonaRegister($videonaRegister) {
        $this->videona_register = $videonaRegister;

        return $this;
    }

    /**
     * Get videonaRegister
     *
     * @return bool
     */
    public function getVideonaRegister() {
        return $this->videona_register;
    }

}
