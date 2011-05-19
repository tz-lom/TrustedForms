<?php

namespace TrustedForms;

require_once 'autoload.php';

class isNumericRangeTest extends \PHPUnit_Framework_TestCase
{
	public function testChecker()
	{
		$checker = new \TrustedForms\ValueChecks\isNumericRange(array(5,15));
		$value = 6;
		$checker->process($value);
		$this->assertEquals(false,$checker->isError());

		$value = 123;
		$checker->process($value);
		$this->assertNotEquals(false,$checker->isError());

		$value = 2;
		$checker->process($value);
		$this->assertNotEquals(false,$checker->isError());
	}
}	
