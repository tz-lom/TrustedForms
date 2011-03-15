<?php

namespace TrustedForms;

require_once 'autoload.php';

class IsNumericTest extends \PHPUnit_Framework_TestCase
{
	public function testChecker()
	{
		$checker = new \TrustedForms\ValueChecks\IsNumeric();

		$value = 42;
		$checker->process($value);
		$this->assertEquals(false,$checker->isError());
		$value = 'abc';
		$checker->process($value);
		$this->assertNotEquals(false,$checker->isError());
	}

}

