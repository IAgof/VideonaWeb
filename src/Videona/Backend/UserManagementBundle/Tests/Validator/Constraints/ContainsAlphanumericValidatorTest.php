<?php

namespace Videona\Backend\UserManagementBundle\Tests\Validator\Constraints;

use Videona\Backend\UserManagementBundle\Validator\Constraints\ContainsAlphanumericValidator;
use Videona\Backend\UserManagementBundle\Validator\Constraints\ContainsAlphanumeric;
use Symfony\Component\Validator\Validation;

/**
 * Description of ContainsAlphanumericValidatorTest
 *
 * @author vlf
 */
class ContainsAlphanumericValidatorTest extends AbstractConstraintValidatorTest {
    
//    public function testContainsAlphanumeric()
//    {
//        $data = '123abc';
//        
//        $validator  = new ContainsAlphanumericValidator();
//        $constraint = new ContainsAlphanumeric();
//        
//        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')-> disableOriginalConstructor()->getMock();
//
//        $context->expects($this->once())
//            ->method('addViolation')
//            ->with($this->equalTo($constraint->message), $this->equalTo(array('%string%', '')));
//
//        $validator->initialize($context);
//
//        $validator->validate($data, $constraint);
//    }
//    private $constraint;
//    private $context;
//
//    public function setUp()
//    {
//        $this->constraint = new ContainsAlphanumeric();
//        $this->context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')->disableOriginalConstructor()->getMock();
//    }
//
//    public function testValidate()
//    {
//        $data = '123abc';
//                
//        /*ConstraintValidator*/
//        $validator = new ContainsAlphanumericValidator();
//        $validator->initialize($this->context);
//        
////        $this->context->expects($this->once())
////            ->method('addViolation')
////            ->with($this->constraint->message,array());
//        $context->expects($this->once())
//            ->method('addViolation')
//            ->with($this->equalTo('[message]'), $this->equalTo(array('%string%', '')));
//        
//        $validator->validate($data, $this->constraint);
//        //$this->assertCount(1, $violations);
//        
//    }
//
//    public function tearDown()
//    {
//        $this->constraint = null;
//    }
//    private $constraint;
//
//    public function setUp()
//    {
//        $this->constraint = $this->getMock('Symfony\Component\Validator\Constraint');
//    }
//
//    public function testValidate()
//    {
//        /*ConstraintValidator*/
//        $validator = new ContainsAlphanumericValidator();
//        $context = $this
//                                ->getMockBuilder('Symfony\Component\Validator\ExecutionContext')
//                                ->disableOriginalConstructor()
//                                ->getMock('ContainsAlphanumericValidator', array('validate'));
//
//        $context->expects($this->once())
//                        ->method('addViolation')
//                        ->with('hola');
//        $validator->initialize($context);
//        $validator->validate('hola', $this->constraint);
//    }
//
//    public function tearDown()
//    {
//        $this->constraint = null;
//    }
//    protected function getApiVersion()
//    {
//        return Validation::API_VERSION_2_5;
//    }
//
//    protected function createValidator()
//    {
//        return new ContainsAlphanumericValidator(false);
//    }
//    
//    /**
//     * @dataProvider getValidEmails
//     */
//    public function testValidEmails($email)
//    {
//        $this->validator->validate($email, new ContainsAlphanumeric());
//
//        $this->assertNoViolation();
//    }
//
//    public function getValidEmails()
//    {
//        return array(
//            array('123a'),
//            array('12ab'),
//            array('ok123'),
//        );
//    }
}
