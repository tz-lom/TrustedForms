<?php

/**
 * Description of JSengineTest
 *
 * @author tz-lom
 */
class JSengineTest extends PHPUnit_Extensions_SeleniumTestCase
{

    function setUp()
    {
		$this->setBrowser("*chrome");
        $this->setBrowserUrl("http://selenium.tests.local");
    }

    function testSimpleIntValidation()
    {
        $this->open("/");
		$this->type("int", "abc");
		$this->assertEquals("error", $this->getAttribute("int@class"));
		$this->type("int", "1");
		$this->assertEquals(" ", $this->getAttribute("int@class"));
    }

}

