<?php

/*
 * LICENCIA!!
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
