<?php

namespace Videona\Backend\UserManagementBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Description of ContainsPassword
 *
 * @author vlf
 * 
 * @Annotation
 */
class ContainsPassword extends Constraint {
    public $message = '';
}
