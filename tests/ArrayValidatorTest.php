<?php

require_once './autoload.php';


class ArrayValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayValidator
     */
    protected $object;

    public function setUp()
    {
        $this->object = new TrustedForms\ArrayValidator();
        $this->object['int'] = new \TrustedForms\VariableValidator();
        $this->object['int']->addReporter(new \TrustedForms\ErrorReporter('int'))
                            ->addToChain(new TrustedForms\ValueTransformers\ToInteger());
        $this->object['str'] = new \TrustedForms\VariableValidator();
        $this->object['str']->addReporter(new TrustedForms\ErrorReporter('str'))
                            ->addToChain(new TrustedForms\ValueTransformers\Trim());
    }


    public function testArrayAccess()
	{
        $validator = new TrustedForms\VariableValidator();
        $validator->addReporter(new \TrustedForms\ErrorReporter('test'));
        $validator->addToChain(new \TrustedForms\ValueTransformers\Trim());

        $array = new TrustedForms\ArrayValidator();

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
        $this->assertEquals('simple check', $this->object['str']->value());
    }

}

