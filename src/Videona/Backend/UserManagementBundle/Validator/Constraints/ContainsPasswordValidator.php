<?php

/*
 * LICENCIA!!
 */

namespace Videona\Backend\UserManagementBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Videona\UtilsBundle\Utility\Utils;

/**
 * ContainsPasswordValidator
 *
 * @author vlf
 */
class ContainsPasswordValidator extends ConstraintValidator {

    /**
     * Checks if the input value is a valid password
     * 
     * @param mixed $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     */
    public function validate($value, Constraint $constraint) {
        if (!Utils::validatePassword($value)) {
            // If you're using the new 2.5 validation API (you probably are!)
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }

}
