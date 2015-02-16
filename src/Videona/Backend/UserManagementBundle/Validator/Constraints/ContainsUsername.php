<?php

namespace Videona\Backend\UserManagementBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Description of ContainsUsername
 *
 * @author vlf
 * 
 * @Annotation
 */
class ContainsUsername extends Constraint {
    public $message = '';
}
