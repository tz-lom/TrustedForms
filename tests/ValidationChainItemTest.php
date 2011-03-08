<?php

require_once './autoload.php';

class Item extends \TrustedForms\ValidationChainItem
{
	protected function doProcess(&$value)
	{
        $value = $this->config[$value]['newValue'];
		return $this->config['error'];
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

	public function testSimpleCheck()
	{
		$item = new Item(array(
							'key'	=> 'key',
							'error'	=> true
						));
		$value = 'key';
		$this->assertTrue($item->process($value));
		$this->assertTrue($item->isError());
		$this->assertTrue($item->getError() instanceof \TrustedForms\ErrorReporter);
	}

	public function testConfiguration()
	{
		$item = new Item(array(
							'key'	=> 'value',
							'error'	=> false
						));
		$value = 'key';
		$this->assertFalse($item->process($value));
		$this->assertEquals('value',$value);
	}

}

