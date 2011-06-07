<?php

namespace TrustedForms;

require_once 'autoload.php';

class TypeTransformationTest extends \PHPUnit_Framework_TestCase
{
	public function testIsFloat()
	{
		$checker = new \TrustedForms\ValueChecks\isFloat();
		$value = 404.502;
		$checker->process($value);
		$this->assertFalse($checker->isError());
		$this->assertTrue(is_float($value));

		$value = 42;
		$checker->process($value);
		$this->assertFalse($checker->isError());
		$this->assertTrue(is_float($value));

		$value = 'abc';
		$checker->process($value);
		$this->assertTrue($checker->isError());
	}
	
	public function testIsInteger()
	{
		$checker = new \TrustedForms\ValueChecks\isInteger();
		$value = 404.502;
		$checker->process($value);
		$this->assertTrue($checker->isError());

		$value = 42;
		$checker->process($value);
		$this->assertFalse($checker->isError());
		$this->assertTrue(is_integer($value));

		$value = 'abc';
		$checker->process($value);
		$this->assertTrue($checker->isError());
	}
}
