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

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Videona\DBBundle\Entity\ImageRepository")
 */
class Image {

    /**
     * The image's identifier
     * 
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The user who uploaded the image
     * 
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(name="usr", referencedColumnName="id")
     */
    protected $usr;

    /**
     * The image's location
     * 
     * @var string
     * 
     * @ORM\Column(name="real_uri", type="string", length=255, nullable=true)
     */
    protected $realUri;

    /**
     * The uploaded date
     * 
     * @var datetime
     * 
     * @ORM\Column(name="created_at", type="datetime", nullable=true) 
     */
    protected $createdAt;

    /**
     * The width of the image
     * 
     * @var integer
     * 
     * @ORM\Column(name="width", type="bigint", nullable=true) 
     */
    protected $width;

    /**
     * The height of the image
     * 
     * @var integer
     * 
     * @ORM\Column(name="height", type="bigint", nullable=true) 
     */
    protected $height;

    /**
     * The size in bytes of the image
     * 
     * @var integer
     * 
     * @ORM\Column(name="size", type="bigint", nullable=true) 
     */
    protected $size;

    /**
     * The type of the image
     * 
     * @var string
     * 
     * @ORM\Column(name="type", type="string", length=50, nullable=true)
     */
    protected $type;

    /**
     * The extension of the image
     * 
     * @var string
     * 
     * @ORM\Column(name="extension", type="string", length=50, nullable=true)
     */
    protected $extension;

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
     * @param \Videona\DBBundle\Entity\User $usr
     *
     * @return Image
     */
    public function setUsr(\Videona\DBBundle\Entity\User $usr = null) {
        $this->usr = $usr;

        return $this;
    }

    /**
     * Get usr
     *
     * @return \Videona\DBBundle\Entity\User
     */
    public function getUsr() {
        return $this->usr;
    }

    /**
     * Set realUri
     *
     * @param string $realUri
     *
     * @return Image
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
     * @return Image
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
     * Set width
     *
     * @param integer $width
     *
     * @return Image
     */
    public function setWidth($width) {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return Image
     */
    public function setHeight($height) {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Image
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
     * Set type
     *
     * @param string $type
     *
     * @return Image
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return Image
     */
    public function setExtension($extension) {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension() {
        return $this->extension;
    }

}
