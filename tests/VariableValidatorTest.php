<?php

require_once './autoload.php';

/**
 * Test class for VariableValidator.
 * Generated by PHPUnit on 2011-02-23 at 19:57:06.
 */
class VariableValidatorTest extends PHPUnit_Framework_TestCase
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
		$this->object->addToChain(new \TrustedForms\ValueChecks\IsNumeric());
		$this->object->setValue('"value"');
		$this->assertFalse($this->object->isCorrect());
		$this->assertInstanceOf('\TrustedForms\ErrorReporter',$this->object->getError());
		$this->assertEquals('Value "value" is incorrect',$this->object->getError()->getMessage());
	}

	public function testLazyValuePass()
	{
		$this->object->addToChain(new \TrustedForms\ValueChecks\IsNumeric());
		$this->object->setValue('42');
		$this->assertEquals('42',$this->object->value());
	}

	public function testLazyValueFails()
	{
		$this->object->addToChain(new \TrustedForms\ValueChecks\IsNumeric());
		$this->object->setValue('test');
		$this->assertNull($this->object->value());
	}

	public function testLazyGetErrorPass()
	{
		$this->object->addToChain(new \TrustedForms\ValueChecks\IsNumeric());
		$this->object->setValue('test');
		$this->assertInstanceOf('\TrustedForms\ErrorReporter',$this->object->getError());
	}

	public function testLazyGetErrorFails()
	{
		$this->object->addToChain(new \TrustedForms\ValueChecks\IsNumeric());
		$this->object->setValue('42');
		$this->assertNull($this->object->getError());
	}

	public function testAdditionOfCheck()
	{
		$this->object->addReporter(new \TrustedForms\ErrorReporter('Error occured'));
		$this->object->addToChain(new \TrustedForms\ValueChecks\IsNumeric());
		$this->object->setValue('42');
		$this->assertEquals(true,$this->object->isCorrect());
		$this->assertEquals('42',$this->object->value());
		$this->object->setValue('abc');
		$this->assertEquals(false,$this->object->isCorrect());
	}

	public function testAdditionOfTransformers()
	{
		$this->object->addReporter(new \TrustedForms\ErrorReporter('Error occured'));
		$this->object->addToChain(new \TrustedForms\ValueTransformers\Trim());
		$this->object->setValue(' some text  ');
		$this->assertEquals('some text',$this->object->value());
	}

	public function testComplexChain()
	{
		$this->object->addReporter(new \TrustedForms\ErrorReporter('Error occured'));
		$this->object->addToChain(new \TrustedForms\ValueTransformers\Trim());
		$this->object->addToChain(new \TrustedForms\ValueChecks\IsNumeric());
		$this->object->addToChain(new \TrustedForms\ValueTransformers\ToInteger());
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
		$this->object->addToChain(new \TrustedForms\ValueChecks\IsNumeric());
		$this->object->setValue('string');
		$this->assertFalse($this->object->isCorrect());
		$this->assertInstanceOf('TrustedForms\ErrorReporter',$this->object->getError());
	}

}

