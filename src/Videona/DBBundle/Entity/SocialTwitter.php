<?php

namespace Videona\DBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Videona\Backend\SocialBundle\Model\SocialTwitterManager;

/**
 * SocialTwitter
 *
 * @ORM\Table(name="social_twitter")
 * @ORM\Entity(repositoryClass="Videona\DBBundle\Entity\SocialTwitterRepository")
 */
class SocialTwitter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="usr", referencedColumnName="id")
     */
    protected $usr;
    
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="twitter_id", type="string", length=255, unique=true)
     */
    protected $twitter_id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="twitter_access_token", type="string", length=255)
     */
    protected $twitter_access_token;
    
    /**
     * @var string
     *
     * @ORM\Column(name="twitter_access_token_secret", type="string", length=255)
     */
    protected $twitter_access_token_secret;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="twitter_access_token_expires_in", type="bigint", nullable=true)
     */
    protected $twitter_access_token_expires_in;
    
    /**
     * @var string
     *
     * @ORM\Column(name="realname", type="string", length=255, nullable=true)
     */
    protected $realname;
    
    /**
     * @var string
     *
     * @ORM\Column(name="screen_name", type="string", length=255, nullable=true)
     */
    protected $screen_name;
    
    /** 
     * @var integer
     * 
     * @ORM\Column(name="followers_count", type="integer", nullable=true) 
     */
    protected $followers_count;
    
    /** 
     * @var integer
     * 
     * @ORM\Column(name="friends_count", type="integer", nullable=true) 
     */
    protected $friends_count;
    
    /** 
     * @var integer
     * 
     * @ORM\Column(name="listed_count", type="integer", nullable=true) 
     */
    protected $listed_count;
    
    /** 
     * @var datetime
     * 
     * @ORM\Column(name="created_at", type="datetime", nullable=true) 
     */
    protected $created_at;
    
    /** 
     * @var integer
     * 
     * @ORM\Column(name="favourites_count", type="integer", nullable=true) 
     */
    protected $favourites_count;
    
    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=50, nullable=true)
     */
    protected $locale;
    
    /**
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set usr
     *
     * @param integer $usr
     * @return SocialTwitter
     */
    public function setUsr($usr)
    {
        $this->usr = $usr;

        return $this;
    }

    /**
     * Get usr
     *
     * @return integer 
     */
    public function getUsr()
    {
        return $this->usr;
    }

    /**
     * Set twitter_id
     *
     * @param string $twitterId
     * @return SocialTwitter
     */
    public function setTwitterId($twitterId)
    {
        $this->twitter_id = $twitterId;

        return $this;
    }

    /**
     * Get twitter_id
     *
     * @return string 
     */
    public function getTwitterId()
    {
        return $this->twitter_id;
    }

    /**
     * Set twitter_access_token
     *
     * @param string $twitterAccessToken
     * @return SocialTwitter
     */
    public function setTwitterAccessToken($twitterAccessToken)
    {
        $this->twitter_access_token = $twitterAccessToken;

        return $this;
    }

    /**
     * Get twitter_access_token
     *
     * @return string 
     */
    public function getTwitterAccessToken()
    {
        return $this->twitter_access_token;
    }

    /**
     * Set twitter_access_token_secret
     *
     * @param string $twitterAccessTokenSecret
     * @return SocialTwitter
     */
    public function setTwitterAccessTokenSecret($twitterAccessTokenSecret)
    {
        $this->twitter_access_token_secret = $twitterAccessTokenSecret;

        return $this;
    }

    /**
     * Get twitter_access_token_secret
     *
     * @return string 
     */
    public function getTwitterAccessTokenSecret()
    {
        return $this->twitter_access_token_secret;
    }

    /**
     * Set twitter_access_token_expires_in
     *
     * @param integer $twitterAccessTokenExpiresIn
     * @return SocialTwitter
     */
    public function setTwitterAccessTokenExpiresIn($twitterAccessTokenExpiresIn)
    {
        $this->twitter_access_token_expires_in = $twitterAccessTokenExpiresIn;

        return $this;
    }

    /**
     * Get twitter_access_token_expires_in
     *
     * @return integer 
     */
    public function getTwitterAccessTokenExpiresIn()
    {
        return $this->twitter_access_token_expires_in;
    }

    /**
     * Set realname
     *
     * @param string $realname
     * @return SocialTwitter
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;

        return $this;
    }

    /**
     * Get realname
     *
     * @return string 
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * Set screen_name
     *
     * @param string $screenName
     * @return SocialTwitter
     */
    public function setScreenName($screenName)
    {
        $this->screen_name = $screenName;

        return $this;
    }

    /**
     * Get screen_name
     *
     * @return string 
     */
    public function getScreenName()
    {
        return $this->screen_name;
    }

    /**
     * Set followers_count
     *
     * @param integer $followersCount
     * @return SocialTwitter
     */
    public function setFollowersCount($followersCount)
    {
        $this->followers_count = $followersCount;

        return $this;
    }

    /**
     * Get followers_count
     *
     * @return integer 
     */
    public function getFollowersCount()
    {
        return $this->followers_count;
    }

    /**
     * Set friends_count
     *
     * @param integer $friendsCount
     * @return SocialTwitter
     */
    public function setFriendsCount($friendsCount)
    {
        $this->friends_count = $friendsCount;

        return $this;
    }

    /**
     * Get friends_count
     *
     * @return integer 
     */
    public function getFriendsCount()
    {
        return $this->friends_count;
    }

    /**
     * Set listed_count
     *
     * @param integer $listedCount
     * @return SocialTwitter
     */
    public function setListedCount($listedCount)
    {
        $this->listed_count = $listedCount;

        return $this;
    }

    /**
     * Get listed_count
     *
     * @return integer 
     */
    public function getListedCount()
    {
        return $this->listed_count;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return SocialTwitter
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set favourites_count
     *
     * @param integer $favouritesCount
     * @return SocialTwitter
     */
    public function setFavouritesCount($favouritesCount)
    {
        $this->favourites_count = $favouritesCount;

        return $this;
    }

    /**
     * Get favourites_count
     *
     * @return integer 
     */
    public function getFavouritesCount()
    {
        return $this->favourites_count;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return SocialTwitter
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
     * Set profile_picture
     *
     * @param integer $profilePicture
     * @return SocialTwitter
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profile_picture = $profilePicture;

        return $this;
    }

    /**
     * Get profile_picture
     *
     * @return integer 
     */
    public function getProfilePicture()
    {
        return $this->profile_picture;
    }
}
