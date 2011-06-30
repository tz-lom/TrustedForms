<?php

namespace TrustedForms;

require_once 'autoload.php';

class ArrayValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayValidator
     */
    protected $object;

    public function setUp()
    {
        $this->object = new \TrustedForms\ArrayValidator();
        $this->object['int'] = new \TrustedForms\VariableValidator();
        $this->object['int']->addReporter(new \TrustedForms\ErrorReporter('int'))
                            ->addToChain(new \TrustedForms\ValueChecks\isNumeric())
                            ->addToChain(new \TrustedForms\ValueChecks\asInteger());
        $this->object['str'] = new \TrustedForms\VariableValidator();
        $this->object['str']->addReporter(new \TrustedForms\ErrorReporter('str'))
                            ->addToChain(new \TrustedForms\ValueChecks\trim());
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testControllOfTypes()
    {
        $this->object['error'] = 1;
    }

    public function testArrayAccess()
    {
        $validator = new \TrustedForms\VariableValidator();
        $validator->addReporter(new \TrustedForms\ErrorReporter('test'));
        $validator->addToChain(new \TrustedForms\ValueChecks\Trim());

        $array = new \TrustedForms\ArrayValidator();

        $this->assertFalse(isset($array['test']));
        $array['test'] = $validator;
        $this->assertEquals($validator, $array['test']);
        $this->assertTrue(isset($array['test']));
        unset($array['test']);
        $this->assertNull($array['test']);    
    }

    public function testCheckPass()
    {
        $this->object->checkArray(array(
           'int'    => '42',
            'str'   => ' simple string '
        ));
        $this->assertFalse($this->object->isError());
        $this->assertEquals(42,$this->object['int']->value());
        $this->assertEquals('simple string',$this->object['str']->value());
    }

    public function testCheckFail()
    {
        $this->object->checkArray(array(
           'int'    => 'not integer',
            'str'   => ' simple string '
        ));
        $this->assertTrue($this->object->isError());
        $this->assertFalse($this->object['int']->isCorrect());
        $this->assertTrue($this->object['str']->isCorrect());
        $this->assertEquals('simple string', $this->object['str']->value());
        $this->assertEquals(1,sizeof($this->object->getErrors()));
        $this->assertContainsOnly('\TrustedForms\ErrorReporter',$this->object->getErrors());
    }

    public function testNotExistingKeys()
    {
        $this->object->handleUndefinedKeys(\TrustedForms\ArrayValidator::REPORT_UNDEFINED_ELEMENT);
        $this->object->checkArray(array(
            'int'   => 42,
            'str'   => 'test',
            'key'   => 'value'
        ));
        $this->assertTrue($this->object->isError());
        $this->assertEquals(1,sizeof($this->object->getErrors()));
        $errors = $this->object->getErrors();
        $this->assertEquals(1,count($errors));
        $this->assertEquals('Variable [key] not exists', $errors[0]->getMessage());
        
        $this->object->handleUndefinedKeys(\TrustedForms\ArrayValidator::IGNORE_UNDEFINED_ELEMENT);
        $this->object->checkArray(array(
            'int'   => 42,
            'str'   => 'test',
            'key'   => 'value'
        ));
        $this->assertFalse($this->object->isError());
        $this->assertTrue(isset($this->object['int']));
        $this->assertFalse(isset($this->object['key']));
        
        $this->object->handleUndefinedKeys(\TrustedForms\ArrayValidator::ADD_UNDEFINED_ELEMENT);
        $this->object->checkArray(array(
            'int'   => 42,
            'str'   => 'test',
            'key'   => 'value'
        ));
        $this->assertFalse($this->object->isError());
        $this->assertTrue(isset($this->object['int']));
        $this->assertTrue(isset($this->object['key']));
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('TrustedForms\ArrayValidator', \TrustedForms\ArrayValidator::instance());
    }
    
    public function testManualErrorReporter()
    {
        $this->object->setErrorReporter(new \TrustedForms\ErrorReporter('message'));
        $this->assertEquals('message', $this->object->getErrorReporter()->getMessage());
        $this->object->handleUndefinedKeys(\TrustedForms\ArrayValidator::REPORT_UNDEFINED_ELEMENT);
        $this->assertFalse($this->object->checkArray(array('int'=>1,
                                                            'str'=>'text',
                                                            'key'=>'value')));
        $errors = $this->object->getErrors();
        $this->assertEquals('message', $errors[0]->getMessage());
    }
     public function testNotExistingValues()
    {
        $validator = new \TrustedForms\ArrayValidator();
        $validator['test'] = new \TrustedForms\VariableValidator();
        $validator['test']->addToChain(new \TrustedForms\ValueChecks\required());
        $validator['skip'] = new \TrustedForms\VariableValidator(); // а этот может быть и не задан ошибку
        $validator->checkArray(array());    
        
        $this->assertTrue($validator->isError());
        $this->assertEquals(1,count($validator->getErrors()));
    }

}
