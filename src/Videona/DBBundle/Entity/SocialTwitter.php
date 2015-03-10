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
 * SocialTwitter
 *
 * @ORM\Table(name="social_twitter")
 * @ORM\Entity(repositoryClass="Videona\DBBundle\Entity\SocialTwitterRepository")
 */
class SocialTwitter {

    /**
     * The identifier of Twitter social network table
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
     * The user's unique id on Twitter
     * 
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="twitter_id", type="string", length=255, unique=true)
     */
    protected $twitter_id;

    /**
     * The access token associated to the user on Twitter
     * 
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="twitter_access_token", type="string", length=255)
     */
    protected $twitter_access_token;

    /**
     * The access token key associated to the user on Twitter
     * 
     * @var string
     *
     * @ORM\Column(name="twitter_access_token_secret", type="string", length=255)
     */
    protected $twitter_access_token_secret;

    /**
     * When the access token associated to the user expires
     * 
     * @var integer
     *
     * @ORM\Column(name="twitter_access_token_expires_in", type="bigint", nullable=true)
     */
    protected $twitter_access_token_expires_in;

    /**
     * The user's first name
     * 
     * @var string
     *
     * @ORM\Column(name="realname", type="string", length=255, nullable=true)
     */
    protected $realname;

    /**
     * The username
     * 
     * @var string
     *
     * @ORM\Column(name="screen_name", type="string", length=255, nullable=true)
     */
    protected $screen_name;

    /**
     * The number of users that follow him on Twitter
     * 
     * @var integer
     * 
     * @ORM\Column(name="followers_count", type="integer", nullable=true) 
     */
    protected $followers_count;

    /**
     * The number of people an author follows on Twitter
     * 
     * @var integer
     * 
     * @ORM\Column(name="friends_count", type="integer", nullable=true) 
     */
    protected $friends_count;

    /**
     * The number of Twitter lists on which the user appears like author of a Tweet
     * 
     * @var integer
     * 
     * @ORM\Column(name="listed_count", type="integer", nullable=true) 
     */
    protected $listed_count;

    /**
     * The register date of the user on Twitter
     * 
     * @var string
     * 
     * @ORM\Column(name="created_at", type="string", length=60, nullable=true) 
     */
    protected $created_at;

    /**
     * The number of Tweets the user has favorited
     * 
     * @var integer
     * 
     * @ORM\Column(name="favourites_count", type="integer", nullable=true) 
     */
    protected $favourites_count;

    /**
     * The string description of the Twitter user's location
     * 
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=50, nullable=true)
     */
    protected $locale;

    /**
     * The user's profile image associated to the user on Twitter
     * 
     * @var string
     *
     * @ORM\Column(name="profile_picture", type="string", length=100, nullable=true)
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
     * @return SocialTwitter
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
     * Set twitter_id
     *
     * @param string $twitterId
     * @return SocialTwitter
     */
    public function setTwitterId($twitterId) {
        $this->twitter_id = $twitterId;

        return $this;
    }

    /**
     * Get twitter_id
     *
     * @return string 
     */
    public function getTwitterId() {
        return $this->twitter_id;
    }

    /**
     * Set twitter_access_token
     *
     * @param string $twitterAccessToken
     * @return SocialTwitter
     */
    public function setTwitterAccessToken($twitterAccessToken) {
        $this->twitter_access_token = $twitterAccessToken;

        return $this;
    }

    /**
     * Get twitter_access_token
     *
     * @return string 
     */
    public function getTwitterAccessToken() {
        return $this->twitter_access_token;
    }

    /**
     * Set twitter_access_token_secret
     *
     * @param string $twitterAccessTokenSecret
     * @return SocialTwitter
     */
    public function setTwitterAccessTokenSecret($twitterAccessTokenSecret) {
        $this->twitter_access_token_secret = $twitterAccessTokenSecret;

        return $this;
    }

    /**
     * Get twitter_access_token_secret
     *
     * @return string 
     */
    public function getTwitterAccessTokenSecret() {
        return $this->twitter_access_token_secret;
    }

    /**
     * Set twitter_access_token_expires_in
     *
     * @param integer $twitterAccessTokenExpiresIn
     * @return SocialTwitter
     */
    public function setTwitterAccessTokenExpiresIn($twitterAccessTokenExpiresIn) {
        $this->twitter_access_token_expires_in = $twitterAccessTokenExpiresIn;

        return $this;
    }

    /**
     * Get twitter_access_token_expires_in
     *
     * @return integer 
     */
    public function getTwitterAccessTokenExpiresIn() {
        return $this->twitter_access_token_expires_in;
    }

    /**
     * Set realname
     *
     * @param string $realname
     * @return SocialTwitter
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
     * Set screen_name
     *
     * @param string $screenName
     * @return SocialTwitter
     */
    public function setScreenName($screenName) {
        $this->screen_name = $screenName;

        return $this;
    }

    /**
     * Get screen_name
     *
     * @return string 
     */
    public function getScreenName() {
        return $this->screen_name;
    }

    /**
     * Set followers_count
     *
     * @param integer $followersCount
     * @return SocialTwitter
     */
    public function setFollowersCount($followersCount) {
        $this->followers_count = $followersCount;

        return $this;
    }

    /**
     * Get followers_count
     *
     * @return integer 
     */
    public function getFollowersCount() {
        return $this->followers_count;
    }

    /**
     * Set friends_count
     *
     * @param integer $friendsCount
     * @return SocialTwitter
     */
    public function setFriendsCount($friendsCount) {
        $this->friends_count = $friendsCount;

        return $this;
    }

    /**
     * Get friends_count
     *
     * @return integer 
     */
    public function getFriendsCount() {
        return $this->friends_count;
    }

    /**
     * Set listed_count
     *
     * @param integer $listedCount
     * @return SocialTwitter
     */
    public function setListedCount($listedCount) {
        $this->listed_count = $listedCount;

        return $this;
    }

    /**
     * Get listed_count
     *
     * @return integer 
     */
    public function getListedCount() {
        return $this->listed_count;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return SocialTwitter
     */
    public function setCreatedAt($createdAt) {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * Set favourites_count
     *
     * @param integer $favouritesCount
     * @return SocialTwitter
     */
    public function setFavouritesCount($favouritesCount) {
        $this->favourites_count = $favouritesCount;

        return $this;
    }

    /**
     * Get favourites_count
     *
     * @return integer 
     */
    public function getFavouritesCount() {
        return $this->favourites_count;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return SocialTwitter
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
     * Set profile_picture
     *
     * @param integer $profilePicture
     * @return SocialTwitter
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
