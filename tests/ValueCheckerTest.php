<?php

require_once './autoload.php';
 
class Checker extends \TrustedForms\ValueChecker
{
	protected function performCheck($value)
	{
		return $value!=false;
	}
}


class ValueCheckerTest extends PHPUnit_Framework_TestCase
{
	public function testReporterAssignment()
	{
		$reporter = new \TrustedForms\ErrorReporter('Error occured');
		$checker = new Checker();
		$checker->setReporter($reporter);

		$this->assertEquals($reporter,$checker->getReporter());
	}

	public function testSimpleCheck()
	{
		$checker = new Checker();
		$this->assertEquals(true,$checker->check(true));
		$this->assertEquals(false,$checker->check(false));
	}

}

