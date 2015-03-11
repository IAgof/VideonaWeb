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

namespace Videona\Backend\UserManagementBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * ContainsUsername
 *
 * @author vlf
 * 
 * @Annotation
 */
class ContainsUsername extends Constraint {

    public $message = '';

}
