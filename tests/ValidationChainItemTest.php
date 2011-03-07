<?php

require_once './autoload.php';

class Item extends \TrustedForms\ValidationChainItem
{
	public function process($value)
	{
        $this->reportedError = false;

		return $this->config[$value];
	}
}


class ValidadionChainItemTest extends PHPUnit_Framework_TestCase
{
	public function testReporterAssignment()
	{
		$reporter = new \TrustedForms\ErrorReporter('Error occured');
		$item = new Item();
		$item->setReporter($reporter);
		$this->assertEquals($reporter,$item->getReporter());
	}

	public function testConfiguration()
	{
		$item = new Item(array('key'=>'value'));
		$this->assertEquals('value',$item->process('key'));
	}

}

