<?php

namespace TrustedForms;

require_once 'autoload.php';

/**
 * Test class for VariableValidator.
 * Generated by PHPUnit on 2011-02-23 at 19:57:06.
 */
class VariableValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var VariableValidator
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new \TrustedForms\VariableValidator();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testNoErrorWhenCheckAddedWithoutReporter()
    {
        $this->object->addToChain(new \TrustedForms\ValueChecks\isNumeric());
        $this->object->setValue('"value"');
        $this->assertFalse($this->object->isCorrect());
        $this->assertInstanceOf('\TrustedForms\ErrorReporter',$this->object->getError());
        $this->assertEquals('Value "value" is incorrect',$this->object->getError()->getMessage());
    }

    public function testLazyValuePass()
    {
        $this->object->addToChain(new \TrustedForms\ValueChecks\isNumeric());
        $this->object->setValue('42');
        $this->assertEquals('42',$this->object->value());
    }

    public function testLazyValueFails()
    {
        $this->object->addToChain(new \TrustedForms\ValueChecks\isNumeric());
        $this->object->setValue('test');
        $this->assertNull($this->object->value());
    }

    public function testLazyGetErrorPass()
    {
        $this->object->addToChain(new \TrustedForms\ValueChecks\isNumeric());
        $this->object->setValue('test');
        $this->assertInstanceOf('\TrustedForms\ErrorReporter',$this->object->getError());
    }

    public function testLazyGetErrorFails()
    {
        $this->object->addToChain(new \TrustedForms\ValueChecks\isNumeric());
        $this->object->setValue('42');
        $this->assertNull($this->object->getError());
    }

    public function testAdditionOfCheck()
    {
        $this->object->addReporter(new \TrustedForms\ErrorReporter('Error occured'));
        $this->object->addToChain(new \TrustedForms\ValueChecks\isNumeric());
        $this->object->setValue('42');
        $this->assertEquals(true,$this->object->isCorrect());
        $this->assertEquals('42',$this->object->value());
        $this->object->setValue('abc');
        $this->assertEquals(false,$this->object->isCorrect());
    }

    public function testAdditionOfTransformers()
    {
        $this->object->addReporter(new \TrustedForms\ErrorReporter('Error occured'));
        $this->object->addToChain(new \TrustedForms\ValueChecks\trim());
        $this->object->setValue(' some text  ');
        $this->assertEquals('some text',$this->object->value());
    }

    public function testComplexChain()
    {
        $this->object->addReporter(new \TrustedForms\ErrorReporter('Error occured'));
        $this->object->addToChain(new \TrustedForms\ValueChecks\trim());
        $this->object->addToChain(new \TrustedForms\ValueChecks\isNumeric());
        $this->object->addToChain(new \TrustedForms\ValueChecks\asInteger());
        $this->object->setValue(' 42 ');
        $this->assertEquals(true, $this->object->isCorrect());
        $this->assertEquals(42, $this->object->value());
    }

    public function testEmptyValidationChain()
    {
        $this->object->setValue('random 42');
        $this->assertTrue($this->object->isCorrect());
        $this->assertEquals('random 42',$this->object->value());
    }

    public function testGetError()
    {
        $this->object->addReporter(new \TrustedForms\ErrorReporter('Error occured'));
        $this->object->addToChain(new \TrustedForms\ValueChecks\isNumeric());
        $this->object->setValue('string');
        $this->assertFalse($this->object->isCorrect());
        $this->assertInstanceOf('TrustedForms\ErrorReporter',$this->object->getError());
    }

    public function testValueNotSet()
    {
        $this->assertNull($this->object->value());
        $o = new \TrustedForms\VariableValidator('default');
        $this->assertEquals('default', $o->value());
    }

    public function testReporterInterference()
    {
        $err = new \TrustedForms\ErrorReporter('value: %s');

        $var1 = new \TrustedForms\VariableValidator();
        $var1->addReporter($err);
        $var1->addToChain(new \TrustedForms\ValueChecks\isNumeric());
        
        $var2 = new \TrustedForms\VariableValidator();
        $var2->addReporter($err);
        $var2->addToChain(new \TrustedForms\ValueChecks\isNumeric());

        $var1->setValue('a');
        $var2->setValue('b');

        $this->assertEquals('value: a', $var1->getError()->getMessage());
        $this->assertEquals('value: b', $var2->getError()->getMessage());
    }
    
    public function testClearChain()
    {
        $this->object->addToChain(new \TrustedForms\ValueChecks\isNumeric());
        $this->object->setValue('"value"');
        $this->assertFalse($this->object->isCorrect());
        $this->object->clearChain();
        $this->object->setValue('"value"');
        $this->assertTrue($this->object->isCorrect());
    }
    
    public function testAddToChainWithReporter()
    {
        $reporter = new ErrorReporter('test message');
        $this->object->addToChain(new ValueChecks\isNumeric(), $reporter);
        $this->object->setValue('not integer');
        $this->assertFalse($this->object->isCorrect());
        $this->assertSame($reporter, $this->object->getError());
    }

}
