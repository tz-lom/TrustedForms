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

	public function testSimplePassedCheck()
	{
		$checker = new Checker();
		$checker->process(true);
		$this->assertFalse($checker->isError());
	}

	public function testSimpleFailedCheck()
	{
		$checker = new Checker();
		$checker->process(false);
		$this->assertTrue($checker->isError() instanceof \TrustedForms\ErrorReporter);
	}

}

