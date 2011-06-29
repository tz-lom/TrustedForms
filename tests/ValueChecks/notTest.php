<?php

namespace TrustedForms;

require_once 'autoload.php';

class notTest extends \PHPUnit_Framework_TestCase
{
    public function testChecker()
    {
        $checker = new \TrustedForms\ValueChecks\not(array(
            VariableValidator::instance()
                ->addToChain(new \TrustedForms\ValueChecks\isNumeric())
                ->addToChain(new \TrustedForms\ValueChecks\length(array(5)))
        ));

        $value = '123';
        $checker->process($value);
        $this->assertTrue($checker->isError());
        $value = 'abc';
        $checker->process($value);
        $this->assertFalse($checker->isError());
        $value = '123456';
        $checker->process($value);
        $this->assertFalse($checker->isError());
    }

}
