<?php

namespace Videona\DBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Video
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Videona\DBBundle\Entity\VideoRepository")
 */
class Video {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The user who uploaded the video
     * 
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="User",cascade={"persist"})
     * @ORM\JoinColumn(name="usr", referencedColumnName="id")
     */
    protected $usr;

    /**
     * The video's location
     * 
     * @var string
     *
     * @ORM\Column(name="real_uri", type="string", length=255, nullable=true)
     */
    protected $realUri;

    /**
     * The uploaded date
     * 
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * The title of the video
     * 
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=true)
     */
    protected $title;

    /**
     * The description of the video
     * 
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    protected $description;

    /**
     * The size of the video
     * 
     * @var integer
     *
     * @ORM\Column(name="size", type="bigint", nullable=true)
     */
    protected $size;

    /**
     * The duration of the video
     * 
     * @var integer
     *
     * @ORM\Column(name="duration", type="bigint", nullable=true)
     */
    protected $duration;

    /**
     * A key frame of the video
     * 
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="key_frame", referencedColumnName="id")
     * 
     */
    protected $keyFrame;

    /**
     * The video average
     * 
     * @var string
     *
     * @ORM\Column(name="avg", type="decimal", nullable=true)
     */
    protected $avg;

    /**
     * The number of views of the video
     * 
     * @var integer
     *
     * @ORM\Column(name="views", type="bigint", nullable=true)
     */
    protected $views;

    /**
     * The number of "likes" of the video
     * 
     * @var integer
     *
     * @ORM\Column(name="likes", type="bigint", nullable=true)
     */
    protected $likes;

    /**
     * The resolution of the video
     * 
     * @var string
     *
     * @ORM\Column(name="resolution", type="string", length=255, nullable=true)
     */
    protected $resolution;

    /**
     * The metadata of the video
     * 
     * @var array
     *
     * @ORM\Column(name="metadata", type="array", nullable=true)
     */
    protected $metadata;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="videos")
     * */
    protected $users;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        
        $this->users = new ArrayCollection();
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
     * Set usr
     *
     * @param integer $usr
     *
     * @return Video
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
     * Set realUri
     *
     * @param string $realUri
     *
     * @return Video
     */
    public function setRealUri($realUri) {
        $this->realUri = $realUri;

        return $this;
    }

    /**
     * Get realUri
     *
     * @return string
     */
    public function getRealUri() {
        return $this->realUri;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Video
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Video
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Video
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Video
     */
    public function setSize($size) {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Video
     */
    public function setDuration($duration) {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * Set keyFrame
     *
     * @param integer $keyFrame
     *
     * @return Video
     */
    public function setKeyFrame($keyFrame) {
        $this->keyFrame = $keyFrame;

        return $this;
    }

    /**
     * Get keyFrame
     *
     * @return integer
     */
    public function getKeyFrame() {
        return $this->keyFrame;
    }

    /**
     * Set avg
     *
     * @param string $avg
     *
     * @return Video
     */
    public function setAvg($avg) {
        $this->avg = $avg;

        return $this;
    }

    /**
     * Get avg
     *
     * @return string
     */
    public function getAvg() {
        return $this->avg;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return Video
     */
    public function setViews($views) {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews() {
        return $this->views;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return Video
     */
    public function setLikes($likes) {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return integer
     */
    public function getLikes() {
        return $this->likes;
    }

    /**
     * Set resolution
     *
     * @param string $resolution
     *
     * @return Video
     */
    public function setResolution($resolution) {
        $this->resolution = $resolution;

        return $this;
    }

    /**
     * Get resolution
     *
     * @return string
     */
    public function getResolution() {
        return $this->resolution;
    }

    /**
     * Set metadata
     *
     * @param array $metadata
     *
     * @return Video
     */
    public function setMetadata($metadata) {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get metadata
     *
     * @return array
     */
    public function getMetadata() {
        return $this->metadata;
    }


    /**
     * Add user
     *
     * @param \Videona\DBBundle\Entity\User $user
     *
     * @return Video
     */
    public function addUser(\Videona\DBBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Videona\DBBundle\Entity\User $user
     */
    public function removeUser(\Videona\DBBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
