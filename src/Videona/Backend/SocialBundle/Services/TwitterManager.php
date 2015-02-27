<?php

/*
 * LICENCIA!!
 */

namespace Videona\Backend\SocialBundle\Services;

use Doctrine\ORM\EntityManager;

/**
 * Manager for twitter user data
 *
 * @author vlf
 */
class TwitterManager {

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
     */
    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('VideonaDBBundle:SocialTwitter');
    }

}