<?php

require_once('../../tests/autoload.php');

//define('SKIP_SELENIUM_TESTS',true);

class TestValidators extends PHPUnit_Framework_TestCase
{
    protected $description;
    protected $form;
    protected $selenium;
    
    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        if(!defined('SKIP_SELENIUM_TESTS'))
        {
            try
            {
                $this->selenium = new RunnerValidatorSelenium($name,$data,$dataName,array());
                $this->selenium->setBrowser("*chrome");
                $this->selenium->setBrowserUrl("http://selenium.tests.local");
                $this->selenium->open('/testValidator.html');
            }
            catch(PHPUnit_Framework_Exception $e)
            {
                define('SKIP_SELENIUM_TESTS',true);
            }
        }
    }
    
    protected function prepareTest($description)
    {
        $this->description = $description;
        $source = <<<HEREDOC
<form>
   <input type="text" name="value" id="in">
   <!--
   @#in@:
    $description : @#in@+error
   -->
</form>
HEREDOC;
        
        $builder = new \TrustedForms\CodeGenerator\Builder('phpQueryTemplate','PHPCode');
        $builder->buildFile($source);
        
        eval($builder->getResultValidator()); // here $form will be defined
        
        $this->form = $form;
        
        // insert JS into form
        if(!defined('SKIP_SELENIUM_TESTS'))
        {
            $this->selenium->addScript('TrustedForms.reset();');
            $this->selenium->addScript($builder->getJSvalidator());
        }
        
    }
    
    protected function performTest($data,$result)
    {
        $this->form->checkArray(array(
            'value' => $data
        ));
        $this->assertEquals(
                $result,
                $this->form['value']->isCorrect(),
                "Test `{$this->description}` is't ".($result?'pass':'fail')." on `{$data}` in PHP module"
        );
        if(!defined('SKIP_SELENIUM_TESTS'))
        {
            $this->selenium->type('value',$data);
            $this->selenium->assertEquals(
                    $result,
                    $this->getAttribute("value@class")=='error',
                    "Test `{$this->description}` is't ".($result?'pass':'fail')." on `{$data}` in JS module"
            );
        }
    }
    
    public function testIsNumeric()
    {
        $this->prepareTest('IsNumeric');
        $this->performTest('2',true);
        $this->performTest('a',false);
    }
}

class RunnerValidatorSelenium extends PHPUnit_Extensions_SeleniumTestCase
{
/*    public function load($url)
    {
        return parent::load($url);
    }
    
    public function getAttribute($attr)
    {
        return $this->__call('load',array($attr));
    }
    
    public function addScript($script)
    {
        return $this->__call('load',array($script));
    }*/
}
