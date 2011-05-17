<?php

namespace TrustedForms;

require_once 'autoload.php';

class isFloatTest extends \PHPUnit_Framework_TestCase
{
	public function testChecker()
	{
		$checker = new \TrustedForms\ValueChecks\isFloat();

		$value = 404.502;
		$checker->process($value);
		$this->assertEquals(false,$checker->isError());
		$value = 42;
		$checker->process($value);
		$this->assertNotEquals(false,$checker->isError());
	}

}	
