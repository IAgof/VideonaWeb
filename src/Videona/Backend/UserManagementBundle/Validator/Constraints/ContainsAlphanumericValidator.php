<?php

namespace Videona\Backend\UserManagementBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Description of ContainsAlphanumericValidator
 *
 * @author vlf
 */
class ContainsAlphanumericValidator extends ConstraintValidator {
        
    /**
     * @param mixed $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('/^[a-zA-Za0-9]+$/', $value, $matches)) {
            // If you're using the new 2.5 validation API (you probably are!)
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
