<?php

namespace Videona\RestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of UserRestControllerTest
 *
 * @author vlf
 */
class UserRestControllerTest extends WebTestCase {

    public function testValidateUsernameOrEmail() {
        $client = static::createClient();

        $actual = array('username=admin&email=prueba@gmail.com', 'username=admi&email=prueba@gmail.com',
            'username=admin&email=prue@gmail.com', 'username=admi&email=prueba@gmail.co',
            'username=admin', 'username=admi', 'email=prueba@gmail.com', 'email=prue@gmail.com',
            '', ' ', 'username=adm@in&email=prueba@gmail.com', 'username=admin&email=pruebagmail.com',
            'username=adm@in', 'email=pruebagmail.com', 'username=&email=prueba@gmail.com',
            'username=adm@in&email=');

        $expected = array('[{"username":true,"email":true}]', '[{"username":false,"email":true}]',
            '[{"username":true,"email":false}]', '[{"username":false,"email":false}]',
            '[{"username":true,"email":null}]', '[{"username":false,"email":null}]',
            '[{"username":null,"email":true}]', '[{"username":null,"email":false}]',
            '[{"username":null,"email":null}]', '[{"username":null,"email":null}]',
            '[{"error":"Invalid request"}]', '[{"error":"Invalid request"}]',
            '[{"error":"Invalid request"}]', '[{"error":"Invalid request"}]',
            '[{"error":"Invalid request"}]', '[{"error":"Invalid request"}]');

        $expected_code = array(200, 200, 200, 200, 200, 200, 200, 200, 200, 200, 400, 400,
            400, 400, 400, 400);

        for ($i = 0; $i < sizeof($actual); $i++) {

            $crawler = $client->request('GET', '/api/search-user?' . $actual[$i], array(), array(), array(
                'PHP_AUTH_USER' => 'admin',
                'PHP_AUTH_PW' => 'adminpass'
            ));

            $response = $client->getResponse();

            $this->assertEquals($expected_code[$i], $response->getStatusCode());
            // Ensures that the header 'Content-Type' is 'application / json'
            $this->assertTrue(
                    $client->getResponse()->headers->contains(
                            'Content-Type', 'application/json'
                    )
            );
            $this->assertEquals($expected[$i], $response->getContent(), $actual[$i] . ": " . $expected[$i]);
        }
    }

    // TODO: Videona: hacer un array para comprobar el registro
    public function testSignupSuccess() {
        $client = static::createClient();

        $crawler = $client->request('POST', '/api/signup', array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode(array("username" => "vprueba",
            "email" => "vprueba@vprueba.es",
            "password" => "prueba"))
        );

        $response = $client->getResponse();

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testLoginSuccess() {
        $client = static::createClient();

        $actual_user = array('admin', 'admin', 'adm', 'adm', '', ' ', 'admin', 'admin',
            '', ' ');

        $actual_pass = array('adminpass', 'adminfalse', 'adminpass', 'adminfalse',
            'adminpass', 'adminpass', '', ' ', '', ' ');

        $expected_code = array(200, 401, 401, 401, 401, 401, 401, 401, 401, 401);

        for ($i = 0; $i < sizeof($actual_user); $i++) {

            $crawler = $client->request('GET', '/api/login', array(), array(), array(
                'PHP_AUTH_USER' => $actual_user[$i],
                'PHP_AUTH_PW' => $actual_pass[$i]
            ));

            $response = $client->getResponse();

            $this->assertEquals($expected_code[$i], $response->getStatusCode(), $actual_user[$i] . ", " . $actual_pass[$i] . ": " . $expected_code[$i]);
        }
    }

    /*
     * TODO: Videona: añadir un test funcional que compruebe que todas las páginas de la
     * aplicación se cargan correctamente. Mirar en el pdf "Buenas prácticas Symfony"
     * en la página 56!!!
     */
}
