<?php

require_once 'autoload.php';

class IsNumericTest extends PHPUnit_Framework_TestCase
{
	public function testChecker()
	{
		$checker = new \TrustedForms\ValueChecks\IsNumeric();
		
		$this->assertEquals(true,$checker->check('42'));
		$this->assertEquals(false,$checker->check('abc'));
	}

}

