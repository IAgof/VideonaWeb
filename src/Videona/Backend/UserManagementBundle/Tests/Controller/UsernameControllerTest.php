<?php

namespace Videona\Backend\UserManagementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of UsernameControllerTest
 *
 * @author vlf
 */
class UsernameControllerTest extends WebTestCase {
    
    public function testGetSocialUsername()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register/username', array(), array(), 
                                    array(
                                          'PHP_AUTH_USER' => 'admin',
                                          'PHP_AUTH_PW' => 'adminpass'
                                        ));

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
