<?php

namespace Videona\Backend\UserManagementBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Description of ContainsAlphanumeric
 *
 * @author vlf
 * 
 * @Annotation
 */
class ContainsAlphanumeric extends Constraint {
    public $message = '';
}
