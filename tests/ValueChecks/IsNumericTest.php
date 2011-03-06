<?php

require_once 'autoload.php';

class IsNumericTest extends PHPUnit_Framework_TestCase
{
	public function testChecker()
	{
		$checker = new \TrustedForms\ValueChecks\IsNumeric();

		$checker->process('42');
		$this->assertEquals(false,$checker->isError());
		$checker->process('abc');
		$this->assertNotEquals(false,$checker->isError());
	}

}

