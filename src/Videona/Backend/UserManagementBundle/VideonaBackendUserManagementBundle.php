<?php

namespace Videona\Backend\UserManagementBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class VideonaBackendUserManagementBundle extends Bundle
{
    public function getParent()
    {
	return 'FOSUserBundle';
    }
}
