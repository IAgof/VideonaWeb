<?php

namespace Videona\DBBundle\Entity;

use Doctrine\ORM\EntityManager;

class SocialFacebookManager {

    protected $entityManager;
    protected $class;
    protected $repository;

    /**
    * El contructor recibe los argumentos definidos en el archivo services.yml
    */
    public function __construct(EntityManager $em, $class){

        $this->entityManager = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->getName();

    }

}

