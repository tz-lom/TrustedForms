<?php

namespace TrustedForms;

require_once 'autoload.php';

class isLengthStringTest extends \PHPUnit_Framework_TestCase
{
	public function testChecker()
	{
		$checker = new \TrustedForms\ValueChecks\isLengthString(array('5'));
		$value = 'strin';
		$checker->process($value);
		$this->assertEquals(false,$checker->isError());

		$value = 123;
		$checker->process($value);
		$this->assertNotEquals(false,$checker->isError());

		$value = 'thaaaasasdds';
		$checker->process($value);
		$this->assertNotEquals(false,$checker->isError());
	}

}	
