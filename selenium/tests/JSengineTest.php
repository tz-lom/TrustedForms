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
        $this->setBrowserUrl("http://selenium.tests.local/");
    }

    function testMyTestCase()
    {
        $this->open("/");
        $this->addScript("", "
TrustedForms.check({
    name: 'int',
    form : '#form1',
    tests: [
        {
             test: 'isNumber',
             arguments: [],
             error: [
                 {element: '[name=int]',type:'addClass',argument: 'error'}
             ]
        }
      ]
});
        ");
        $this->waitForPageToLoad("1000");
        $this->assertEquals("", $this->getAttribute("css=[name=int]@class"));
    }

}

