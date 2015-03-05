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
use Symfony\Component\Validator\ConstraintValidator;
use Videona\UtilsBundle\Utility\Utils;

/**
 * ContainsUsernameValidator
 *
 * @author vlf
 */
class ContainsUsernameValidator extends ConstraintValidator {

    /**
     * Checks if the input value is a valid username
     * 
     * @param mixed $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     */
    public function validate($value, Constraint $constraint) {
        if (!Utils::validateUsername($value)) {
            // If you're using the new 2.5 validation API (you probably are!)
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }

}
