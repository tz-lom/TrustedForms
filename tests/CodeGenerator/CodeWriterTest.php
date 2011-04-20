<?php

namespace TrustedForms;

require_once 'autoload.php';

class CodeWriterTest extends \PHPUnit_Framework_TestCase
{
  /*  public function testHeaderWrite()
    {
        $writer = new CodeGenerator\CodeWriter();
        $this->assertRegExp("@^<?php\n\n@x", $writer->generatePHPcode());
    }
    
    public function testEmptyFormCreation()
    {
        $writer = new CodeGenerator\CodeWriter();
        $writer->addForm('$form');
        $writer->addFieldToForm('$form', 'text');
        $writer->resetErrorReporter();
        $writer->setMessageToErrorReporter('message');
        $writer->addModifierToErrorReporter('');
        $writer->addCheckToField('$form','text','IsNumeric',array());
    }*/
}
