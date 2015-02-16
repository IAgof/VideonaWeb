<?php

namespace Videona\UtilsBundle\Tests\Utility;

use Videona\UtilsBundle\Utility\Utils;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of UtilsTest
 *
 * @author vlf
 */
class UtilsTest extends KernelTestCase {
    
    public function testRemoveDots()
    {
        $actual = array('v.prueba','p.pr@ueba.','p...','',' ','...');
        
        $expected = array('vprueba','ppr@ueba','p','',' ','');
        
        $util = new Utils();
        
        for ($i = 0; $i < sizeof($actual); $i++) {
            $result = $util->removeDots($actual[$i]);
            
            // Ensures that this method removes dots from the username
            $this->assertEquals($expected[$i], $result, $actual[$i].": ".$expected[$i]);
        }
    }
    
    public function testValidateUsername()
    {
        $actual = array('v.prueba','p.pr@ueba.','vd','123456789123456','1234567891234567',
            'AASSSDWF','asmSsAde','asdM1k3234','asd4mea.w21.','asdn','','a','bcd',' ',
            '12345','asdn kasdmeka','asdk{m','asdme}','asdm?e','asdm;jasj','asdmeké',
            'kamsdkme_ksne','asjnem@nasme.com','asdnken@sakn, ','jahf...asf','asmSsAdñ',
            'kjh_asf','ab_c','abc-d','#asdf','asf#asf','a.bc','abcdef.ghijklmno','abc<fdv>',
            'asdM1Çk3234','ÇÇÇÇÇÇÇÇ','123456789abcdeÇ','<asdM1k32>');
        
        $expected = array(true,false,false,true,false,true,true,true,true,true,false,
            false,false,false,true,false,false,false,false,false,true,true,false,
            false,true,true,true,true,false,false,false,false,true,false,true,true,
            true,false);
                            
        $util = new Utils();
        
        for ($i = 0; $i < sizeof($actual); $i++) {
            $result = $util->validateUsername($actual[$i]);
            
            // Ensures that this username is valid
            $this->assertEquals($expected[$i], $result, $actual[$i].": ".$expected[$i]);
        }
    }
    
    public function testValidateEmail()
    {
        $actual = array('pr.prueba@gmail.com','p.pr@ueba','v','13456@789123456.es','1234@gmail.com',
            'kme121.34f4@abcd.com','kme121@abcd.efg.es','a_mel@llea.me','AsdneAsU@mmma.fr',
            'smeeqeop@MAYUSCULAS.COM','?9jasn@mail.com','kasm}e@mail.com','abcd@','abcd@.com',
            'abcd@hie.','@','@emsd.com','mkasme@asje@asnde.com','mkasd-asdme@mail.com',
            '',' ','lkjasf@asfjk.f','asf@asdf.asdff','asf@asdf.asdf','asf@asdf.123',
            'asd@192.168.0.1.es','<1234@gmail.com>','asd@192.168.0.1');
        
        $expected = array('1','0','0','1','1','1','1','1','1','1','0','0','0','0',
            '0','0','0','0','1','0','0','1','1','1','0','1','0','0');
        
        $util = new Utils();
        
        for ($i = 0; $i < sizeof($actual); $i++) {
            $result = $util->validateEmail($actual[$i]);
            
            // Ensures that this email address is valid
            $this->assertEquals($expected[$i], $result, $actual[$i].": ".$expected[$i]);
        }
    }
    
    public function testValidatePassword()
    {           
        $actual = array('',' ','vprueba','123','12345678','Ab123456+','Ab123456$','Ab123456%',
            'Ab12#3456','@Ab123456','%Ab123456%','<Ab123456$>','%%%%%%%%','$%#@12Ll',
            '123456789abcde$%#@','12345678abcd$%#@','12345678AbC$%#@','12345ñabcde$%#@',
            '123_8AbC$%#@','123 8AbC$%#@',' 1238AbC$%#@','1238A.bC$%#@','<Ab123456$>',
            '1238A.bC$%#?','123,A.bC$%#?','!1238A.b!$%#?','123¿A.bC$%#?','¡123!.bC$%#',
            '¡123!.abÇC$%#?¿p');
        
        $expected = array(false,false,false,false,false,false,true,true,true,true,
            true,false,false,true,false,false,true,false,false,false,false,true,false,
            true,true,true,true,true,true);
        
        $util = new Utils();
        
        for ($i = 0; $i < sizeof($actual); $i++) {
            $result = $util->validatePassword($actual[$i]);
             
            // Ensures that this username is valid
            $this->assertEquals($expected[$i], $result, $actual[$i].": ".$expected[$i]);
        }
    }
}
