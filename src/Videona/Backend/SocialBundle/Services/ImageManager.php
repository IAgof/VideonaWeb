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

namespace Videona\Backend\SocialBundle\Services;

use Doctrine\ORM\EntityManager;
use Videona\DBBundle\Entity\Image;
use Videona\DBBundle\Entity\User;

/**
 * Manager for image files
 *
 * @author vlf
 */
class ImageManager {

    // Define our parameters constants
    const ORIGINAL_PROFILE_PICTURES_PATH = '\file\profilepictures\originals\\';
    const PROFILE_PICTURE_MIN_WIDTH = 16;
    const PROFILE_PICTURE_MIN_HEIGHT = 16;
    const PROFILE_PICTURE_MAX_WIDTH = 1024;
    const PROFILE_PICTURE_MAX_HEIGHT = 1024;
    const GIF_FORMAT = 'image/gif';
    const GIF_EXTENSION = '.gif';
    const JPEG_FORMAT = 'image/jpeg';
    const JPEG_EXTENSION = '.jpg';
    const JPG_FORMAT = 'image/jpg';
    const JPG_EXTENSION = '.jpg';
    const PJPEG_FORMAT = 'image/pjpeg';
    const PJPEG_EXTENSION = '.pjpg';
    const XPNG_FORMAT = 'image/x-png';
    const XPNG_EXTENSION = '.xpng';
    const PNG_FORMAT = 'image/png';
    const PNG_EXTENSION = '.png';

    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param EntityManager $em
     * @param $rootDir the root directory
     */
    public function __construct(EntityManager $em, $rootDir) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('VideonaDBBundle:Image');
        $this->webRoot = realpath($rootDir . '\..\web');
    }

    /**
     * Save the image in the profile picture's folder
     * 
     * @param User $user the image's owner
     * @param string $url the url where is the image
     * 
     * @return $profilePicture the profile picture of the user or null if not exists
     */
    public function saveOriginalImage($user, $url) {

        // Get image info
        $imageInfo = getimagesize($url);
        
        // If there is not image return null
        if (!$imageInfo) {
            return;
        }
        // Get size of the uploaded file
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        // Get the type of the uploaded file
        $type = $imageInfo['mime'];

        // If the image size is not allowed, return null
        if ($width > self::PROFILE_PICTURE_MAX_WIDTH || $height > self::PROFILE_PICTURE_MAX_HEIGHT) {
            // Image too big 
            return;
        }
        if ($width < self::PROFILE_PICTURE_MIN_WIDTH || $height < self::PROFILE_PICTURE_MIN_HEIGHT) {
            // Image to small
            return;
        }

        // Get image file extension
        switch ($type) {
            case self::GIF_FORMAT:
                $extension = self::GIF_EXTENSION;
                break;
            case self::JPEG_FORMAT:
                $extension = self::JPEG_EXTENSION;
                break;
            case self::JPG_FORMAT:
                $extension = self::JPG_EXTENSION;
                break;
            case self::PJPEG_FORMAT:
                $extension = self::PJPEG_EXTENSION;
                break;
            case self::XPNG_FORMAT:
                $extension = self::XPNG_EXTENSION;
                break;
            case self::PNG_FORMAT:
                $extension = self::PNG_EXTENSION;
                break;
            default:
                $extension = 0;
                break;
        }
        // Define allowed extensions
        $allowedExts = array(
            self::GIF_EXTENSION,
            self::JPEG_EXTENSION,
            self::JPG_EXTENSION,
            self::PNG_EXTENSION,
        );

        // Check if the extension of the image is allowed
        if ((
                ($type != self::GIF_FORMAT) &&
                ($type != self::JPEG_FORMAT) &&
                ($type != self::JPG_FORMAT) &&
                ($type != self::PJPEG_FORMAT) &&
                ($type != self::XPNG_FORMAT) &&
                ($type != self::PNG_FORMAT) ||
                !in_array($extension, $allowedExts))
        ) {
            return;
        }

        // Store the new image in te DB
        $profilePicture = new Image();

        $profilePicture->setUsr($user);
        $profilePicture->setCreatedAt(new \DateTime());
        $profilePicture->setWidth($width);
        $profilePicture->setHeight($height);
        $profilePicture->setType($type);
        $profilePicture->setExtension($extension);

        $this->em->persist($profilePicture);
        $this->em->flush();

        // Get profile picture id
        $profilePictureId = $profilePicture->getId();

        // Save the image in the original profile pictures directory
        $originalDir = $this->webRoot . self::ORIGINAL_PROFILE_PICTURES_PATH;
        $imageDir = trim($originalDir . $profilePictureId . '\\');

        // Ckeck if this directory exists and create it if not exists
        $create = true;
        $status = true;

        if (!is_dir($imageDir)) {
            if (!$create) {
                $status = false;
            } else {
                $mask = umask(0000);
                $status = @mkdir($imageDir, 0700, true);
                umask($mask);
            }
        }

        // Copy the image in this directory
        $image = $imageDir . $profilePictureId;
        copy($url, $image);

        // Check if the image exists in the appropriate directory
        if (file_exists($image)) {
            // Save te real uri of the image
            $profilePicture->setSize(filesize($image));
            $profilePicture->setRealUri($image);
            
            $this->em->persist($profilePicture);
            $this->em->flush();
            
            return $profilePicture;
        } else {
            return;
        }
    }

}
