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
     * This parameter indicates when the user deleted his account
     * 
     * @ORM\Column(name="deleted_account", type="datetime", nullable=true) 
     */
    protected $deleted_account;
    
    /**
     * This parameter indicates if the user has deleted his account
     * 
     * @ORM\Column(name="temp_disable_account", type="boolean") 
     */
    protected $temp_disable_account;
    
    /**
     * This parameter indicates the birth date of the user
     * 
     * @ORM\Column(name="birthdate", type="datetime", nullable=true) 
     */
    protected $birthdate;
    
    /**
     * The user's first name
     * 
     * @var string
     * 
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    protected $firstname;

    /**
     * The user's last name
     * 
     * @var string
     * 
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    protected $lastname;
    
    /**
     * The gender of the user
     * 
     * @ORM\Column(name="gender", type="string", length=50, nullable=true)
     */
    protected $gender;

    /**
     * The string description of the Facebook user's location
     * 
     * @var string
     * 
     * @ORM\Column(name="locale", type="string", length=50, nullable=true)
     */
    protected $locale;
    
    /**
     * @ORM\ManyToMany(targetEntity="Video", inversedBy="users")
     * @ORM\JoinTable(name="users_videos")
     **/
    protected $videos;
    
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="usr")
     **/
    protected $images;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        // your own logic
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->username_change = '0';
        $this->videona_register = '0';
        $this->temp_disable_account = '0';
    }

    /**
     * Set usernameCanonical
     *
     * @param string $usernameCanonical
     *
     * @return User
     */
//    public function setUsernameCanonical($usernameCanonical) {
//        parent::setUsernameCanonical($usernameCanonical);
//        $this->usernameCanonical = Utils::removeDots($usernameCanonical);
//
//        return $this;
//    }

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


    /**
     * Set deletedAccount
     *
     * @param \DateTime $deletedAccount
     *
     * @return User
     */
    public function setDeletedAccount($deletedAccount)
    {
        $this->deleted_account = $deletedAccount;

        return $this;
    }

    /**
     * Get deletedAccount
     *
     * @return \DateTime
     */
    public function getDeletedAccount()
    {
        return $this->deleted_account;
    }

    /**
     * Set tempDisableAccount
     *
     * @param boolean $tempDisableAccount
     *
     * @return User
     */
    public function setTempDisableAccount($tempDisableAccount)
    {
        $this->temp_disable_account = $tempDisableAccount;

        return $this;
    }

    /**
     * Get tempDisableAccount
     *
     * @return boolean
     */
    public function getTempDisableAccount()
    {
        return $this->temp_disable_account;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set locale
     *
     * @param string $locale
     *
     * @return User
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Add video
     *
     * @param \Videona\DBBundle\Entity\Video $video
     *
     * @return User
     */
    public function addVideo(\Videona\DBBundle\Entity\Video $video)
    {
        $this->videos[] = $video;

        return $this;
    }

    /**
     * Remove video
     *
     * @param \Videona\DBBundle\Entity\Video $video
     */
    public function removeVideo(\Videona\DBBundle\Entity\Video $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Add image
     *
     * @param \Videona\DBBundle\Entity\Image $image
     *
     * @return User
     */
    public function addImage(\Videona\DBBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Videona\DBBundle\Entity\Image $image
     */
    public function removeImage(\Videona\DBBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}
