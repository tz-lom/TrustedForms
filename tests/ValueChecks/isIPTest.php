<?php

namespace TrustedForms;

require_once 'autoload.php';

class isIPTest extends \PHPUnit_Framework_TestCase
{
	public function testChecker()
	{
		$checker = new \TrustedForms\ValueChecks\isIP(array('IS_IPV6'));
		$value = '3ffe:1900:4545:3:200:f8ff:fe21:67cf';
		$checker->process($value);
		$this->assertEquals(false,$checker->isError());
		$value = '543.152.3.9';
		$checker->process($value);
		$this->assertNotEquals(false,$checker->isError());
	}

}	
