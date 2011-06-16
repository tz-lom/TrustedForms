<?php

namespace TrustedForms;

require_once 'autoload.php';

/**
 * Test class for ErrorReporter.
 * Generated by PHPUnit on 2011-03-11 at 20:56:30.
 */
class ErrorReporterTest extends \PHPUnit_Framework_TestCase
{

    public function testGetMessage()
    {
        $report = new ErrorReporter('test message');
        $this->assertEquals('test message',$report->getMessage());
    }

    public function testSetErrorValue()
    {
        $report = new ErrorReporter('error value: %s');
        $report->setErrorValue('42');
        $this->assertEquals('error value: 42',$report->getMessage());
    }

    public function testSetVariableName()
    {
        $report = new ErrorReporter('value: %s key:%s');
        $report->setErrorValue('v');
        $report->setVariableName('k');
        $this->assertEquals('value: v key:k',$report->getMessage());
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('TrustedForms\ErrorReporter', \TrustedForms\ErrorReporter::instance(''));
    }

}
