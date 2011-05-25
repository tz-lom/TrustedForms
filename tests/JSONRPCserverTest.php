<?php
namespace TrustedForms;

require_once('autoload.php');

class JSONRPCserverTest extends PHPUnit_Framework_TestCase
{
    public function testCompilationFromJSON()
    {
        $server = new JSONRPCserver;
        //$server->compileDescription($jsonDescription)
    }
}
