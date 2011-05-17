<?php

namespace TrustedForms;

require_once 'autoload.php';

class isLengthNumericTest extends \PHPUnit_Framework_TestCase
{
	public function testChecker()
	{
		$checker = new \TrustedForms\ValueChecks\isLengthNumeric(array('5'));
		$value = 561;
		$checker->process($value);
		$this->assertEquals(false,$checker->isError());
		
		$value = 'sdad';
		$checker->process($value);
		$this->assertNotEquals(false,$checker->isError());

		$value = 123456;
		$checker->process($value);
		$this->assertNotEquals(false,$checker->isError());
	}

}	
