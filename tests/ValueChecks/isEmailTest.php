<?php

namespace TrustedForms;

require_once 'autoload.php';

class isEmailTest extends \PHPUnit_Framework_TestCase
{
    public function testChecker()
    {
        $checker = new \TrustedForms\ValueChecks\isEmail();

        $value = "prowoke@rambler.ru";
        $checker->process($value);
        $this->assertEquals(false,$checker->isError());
        $value = "it is not mail";
        $checker->process($value);
        $this->assertNotEquals(false,$checker->isError());
    }

}
