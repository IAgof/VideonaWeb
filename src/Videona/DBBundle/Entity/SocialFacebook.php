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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SocialFacebook
 *
 * @ORM\Table(name="social_facebook")
 * @ORM\Entity(repositoryClass="Videona\DBBundle\Entity\SocialFacebookRepository")
 */
class SocialFacebook {

    /**
     * The identifier of Facebook social network table
     * 
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The user's identifier
     * 
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="usr", referencedColumnName="id")
     */
    protected $usr;

    /**
     * The user's unique id on Facebook
     * 
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(name="facebook_id", type="string", length=255, unique=true)
     */
    protected $facebook_id;

    /**
     * The access token associated to the user on Facebook
     * 
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(name="facebook_access_token", type="string", length=255) 
     */
    protected $facebook_access_token;

    /**
     * When the access token associated to the user expires
     * 
     * @var string
     * 
     * @ORM\Column(name="facebook_access_token_expires_in", type="string", length=50, nullable=true) 
     */
    protected $facebook_access_token_expires_in;

    /**
     * The email address by which the user has registered on Facebook 
     * social network
     * 
     * @var string
     * 
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;

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
     * The personal url to access the user's profile on Facebook social network
     * 
     * @var string
     * 
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    protected $link;

    /**
     * The string description of the Facebook user's location
     * 
     * @var string
     * 
     * @ORM\Column(name="locale", type="string", length=50, nullable=true)
     */
    protected $locale;

    /**
     * The username
     * 
     * @var string
     * 
     * @ORM\Column(name="realname", type="string", length=255, nullable=true)
     */
    protected $realname;

    /**
     * The Facebook user's time zone
     * 
     * @var integer
     * 
     * @ORM\Column(name="timezone", type="integer", nullable=true) 
     */
    protected $timezone;

    /**
     * The time when the user was last updated
     * 
     * @var string
     * 
     * @ORM\Column(name="updated_time", type="string", length=50, nullable=true)
     */
    protected $updated_time;

    /**
     * This parameter indicates if user has verified his account on Facebook
     * 
     * @var boolean
     * 
     * @ORM\Column(name="verified", type="boolean", nullable=true)
     */
    protected $verified;

    /**
     * The user's profile image associated to the user on Facebook
     * 
     * @var string
     *
     * @ORM\Column(name="profile_picture", type="string", length=100, nullable=true)
     */
    protected $profile_picture;
    
    /**
     * The nickname
     * 
     * @var string
     * 
     * @ORM\Column(name="nickname", type="string", length=255, nullable=true)
     */
    protected $nickname;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set usr
     *
     * @param integer $usr
     * @return SocialFacebook
     */
    public function setUsr($usr) {
        $this->usr = $usr;

        return $this;
    }

    /**
     * Get usr
     *
     * @return integer 
     */
    public function getUsr() {
        return $this->usr;
    }

    /**
     * Set facebook_id
     *
     * @param string $facebookId
     * @return SocialFacebook
     */
    public function setFacebookId($facebookId) {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebook_id
     *
     * @return string 
     */
    public function getFacebookId() {
        return $this->facebook_id;
    }

    /**
     * Set facebook_access_token
     *
     * @param string $facebookAccessToken
     * @return SocialFacebook
     */
    public function setFacebookAccessToken($facebookAccessToken) {
        $this->facebook_access_token = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebook_access_token
     *
     * @return string 
     */
    public function getFacebookAccessToken() {
        return $this->facebook_access_token;
    }

    /**
     * Set facebook_access_token_expires_in
     *
     * @param integer $facebookAccessTokenExpiresIn
     * @return SocialFacebook
     */
    public function setFacebookAccessTokenExpiresIn($facebookAccessTokenExpiresIn) {
        $this->facebook_access_token_expires_in = $facebookAccessTokenExpiresIn;

        return $this;
    }

    /**
     * Get facebook_access_token_expires_in
     *
     * @return integer 
     */
    public function getFacebookAccessTokenExpiresIn() {
        return $this->facebook_access_token_expires_in;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return SocialFacebook
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return SocialFacebook
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return SocialFacebook
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return SocialFacebook
     */
    public function setGender($gender) {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return SocialFacebook
     */
    public function setLink($link) {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return SocialFacebook
     */
    public function setLocale($locale) {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string 
     */
    public function getLocale() {
        return $this->locale;
    }

    /**
     * Set realname
     *
     * @param string $realname
     * @return SocialFacebook
     */
    public function setRealname($realname) {
        $this->realname = $realname;

        return $this;
    }

    /**
     * Get realname
     *
     * @return string 
     */
    public function getRealname() {
        return $this->realname;
    }

    /**
     * Set timezone
     *
     * @param integer $timezone
     * @return SocialFacebook
     */
    public function setTimezone($timezone) {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return integer 
     */
    public function getTimezone() {
        return $this->timezone;
    }

    /**
     * Set updated_time
     *
     * @param string $updatedTime
     * @return SocialFacebook
     */
    public function setUpdatedTime($updatedTime) {
        $this->updated_time = $updatedTime;

        return $this;
    }

    /**
     * Get updated_time
     *
     * @return string 
     */
    public function getUpdatedTime() {
        return $this->updated_time;
    }

    /**
     * Set verified
     *
     * @param boolean $verified
     * @return SocialFacebook
     */
    public function setVerified($verified) {
        $this->verified = $verified;

        return $this;
    }

    /**
     * Get verified
     *
     * @return boolean 
     */
    public function getVerified() {
        return $this->verified;
    }

    /**
     * Set profile_picture
     *
     * @param integer $profilePicture
     * @return SocialFacebook
     */
    public function setProfilePicture($profilePicture) {
        $this->profile_picture = $profilePicture;

        return $this;
    }

    /**
     * Get profile_picture
     *
     * @return integer 
     */
    public function getProfilePicture() {
        return $this->profile_picture;
    }

    /**
     * Set user
     *
     * @param \Videona\DBBundle\Entity\User $user
     *
     * @return SocialFacebook
     */
    public function setUser(\Videona\DBBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Videona\DBBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set social
     *
     * @param \Videona\DBBundle\Entity\User $social
     *
     * @return SocialFacebook
     */
    public function setSocial(\Videona\DBBundle\Entity\User $social = null) {
        $this->social = $social;

        return $this;
    }

    /**
     * Get social
     *
     * @return \Videona\DBBundle\Entity\User
     */
    public function getSocial() {
        return $this->social;
    }


    /**
     * Set nickname
     *
     * @param string $nickname
     *
     * @return SocialFacebook
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    
        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }
}
