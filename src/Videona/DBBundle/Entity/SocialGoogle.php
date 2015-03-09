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
 * SocialGoogle
 *
 * @ORM\Table(name="social_google")
 * @ORM\Entity(repositoryClass="Videona\DBBundle\Entity\SocialGoogleRepository")
 */
class SocialGoogle {

    /**
     * The identifier of Google+ social network table
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
     * The user's unique id on Google+
     * 
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="google_id", type="string", length=255, unique=true)
     */
    protected $google_id;

    /**
     * The access token associated to the user on Google+
     * 
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="google_access_token", type="string", length=255)
     */
    protected $google_access_token;

    /**
     * When the access token associated to the user expires
     * 
     * @var integer
     *
     * @ORM\Column(name="google_access_token_expires_in", type="bigint", nullable=true)
     */
    protected $google_access_token_expires_in;

    /**
     * The email address by which the user has registered on Google+ social network
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
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=50, nullable=true)
     */
    protected $gender;

    /**
     * The personal url to access the user's profile on Google+ social network
     * 
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    protected $link;

    /**
     * The string description of the Google+ user's location
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
     * This parameter indicates if user has verified his account on Google+
     * 
     * @var boolean
     *
     * @ORM\Column(name="verified", type="boolean", nullable=true)
     */
    protected $verified;

    /**
     * The user's profile image associated to the user on Google+
     * 
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="profile_picture", referencedColumnName="id")
     */
    protected $profile_picture;

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
     * @return SocialGoogle
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
     * Set google_id
     *
     * @param string $googleId
     * @return SocialGoogle
     */
    public function setGoogleId($googleId) {
        $this->google_id = $googleId;

        return $this;
    }

    /**
     * Get google_id
     *
     * @return string 
     */
    public function getGoogleId() {
        return $this->google_id;
    }

    /**
     * Set google_access_token
     *
     * @param string $googleAccessToken
     * @return SocialGoogle
     */
    public function setGoogleAccessToken($googleAccessToken) {
        $this->google_access_token = $googleAccessToken;

        return $this;
    }

    /**
     * Get google_access_token
     *
     * @return string 
     */
    public function getGoogleAccessToken() {
        return $this->google_access_token;
    }

    /**
     * Set google_access_token_expires_in
     *
     * @param integer $googleAccessTokenExpiresIn
     * @return SocialGoogle
     */
    public function setGoogleAccessTokenExpiresIn($googleAccessTokenExpiresIn) {
        $this->google_access_token_expires_in = $googleAccessTokenExpiresIn;

        return $this;
    }

    /**
     * Get google_access_token_expires_in
     *
     * @return integer 
     */
    public function getGoogleAccessTokenExpiresIn() {
        return $this->google_access_token_expires_in;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return SocialGoogle
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
     * @return SocialGoogle
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
     * @return SocialGoogle
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
     * @return SocialGoogle
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
     * @return SocialGoogle
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
     * @return SocialGoogle
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
     * @return SocialGoogle
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
     * Set verified
     *
     * @param boolean $verified
     * @return SocialGoogle
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
     * @return SocialGoogle
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
    
}
