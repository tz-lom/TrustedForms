<?php

namespace TrustedForms;

require_once 'autoload.php';

class isURLTest extends \PHPUnit_Framework_TestCase
{
    public function testChecker()
    {
        $checker = new \TrustedForms\ValueChecks\isURL();

        $value = "http://www.google.com";
        $checker->process($value);
        $this->assertEquals(false,$checker->isError());
        $value = "it is not URL";
        $checker->process($value);
        $this->assertNotEquals(false,$checker->isError());
    }

}
