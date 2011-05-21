<?php

require_once('../../tests/autoload.php');

//define('SKIP_SELENIUM_TESTS',true);


class SeleniumUndoControll extends PHPUnit_Extensions_SeleniumTestCase_Driver
{
	public function __destruct()
	{
		$this->stop();
	}
}

/**
 * @backupGlobals disabled
 */
class TestValidators extends PHPUnit_Framework_TestCase
{
    protected $description;
    protected $form;
    static $selenium = NULL;
    
    public function setUp()
    {
        if(!self::$selenium && !defined('SKIP_SELENIUM_TESTS'))
        {
            try
            {
                self::$selenium = new SeleniumUndoControll();
				self::$selenium->setHost('localhost');
				self::$selenium->setPort(4444);
				self::$selenium->setTimeout(30);
				self::$selenium->setHttpTimeout(45);
				self::$selenium->setTestId('TestValidators');
                self::$selenium->setBrowser("*chrome");
                self::$selenium->setBrowserUrl("http://selenium.tests.local");
				
				$tcMock = $this->getMock('PHPUnit_Extensions_SeleniumTestCase');
				
				self::$selenium->setTestCase($tcMock);
				
                self::$selenium->start();
                self::$selenium->open('/testValidator.html');
            }
            catch(PHPUnit_Framework_Exception $e)
            {
				self::$selenium->stop();
				self::$selenium = NULL;
                define('SKIP_SELENIUM_TESTS',true);
            }
        }
    }
	
    
    protected function prepareTest($description)
    {
		if($this->description==$description) return;
        $this->description = $description;
        $source = <<<HEREDOC
<form>
   <input type="text" name="value" id="in">
   <!--
   @#in@:
	defaultErrorReport: @#in@+error ,
    $description
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
            self::$selenium->runScript('TrustedForms.reset();');
            self::$selenium->runScript($builder->getJSvalidator());
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
                "Test `{$this->description}` don't ".($result?'pass':'fail')." on `{$data}` in PHP module"
        );
        if(!defined('SKIP_SELENIUM_TESTS'))
        {
            self::$selenium->type('value',$data);
			if((strpos(self::$selenium->getAttribute("value@class"),'error')===false)!=$result)
			{
				$this->fail("Test `{$this->description}` don't ".($result?'pass':'fail')." on `{$data}` in JS module");
			}
        }
    }
    
    public function testSelenium()
    {
		if(defined('SKIP_SELENIUM_TESTS'))
		{
			$this->fail('Selenium tests are not executed due to error with selenium (or they are disabled)');
		}
    }
    
	/**
	 * @dataProvider validatorsInfo
	 */
	public function testValidator($validator,$data,$result)
	{
		$this->prepareTest($validator);
		$this->performTest($data, $result);
	}


	/**
	 * Useful to create tests definitions
	 * 
	 * @param array $tests			array where tests will be added
	 * @param string $definition	String describing test
	 * @param array $pass			Correct values
	 * @param array $fails			Incorrect values
	 */
	protected function genTestConfig(&$tests,$definition,$pass,$fails)
	{
		foreach($pass as $data)
		{
			$tests[] = array($definition,$data,true);
		}
		foreach($fails as $data)
		{
			$tests[] = array($definition,$data,false);
		}
	}
	
	public function validatorsInfo()
	{
		$tests = array();
		
		$this->genTestConfig(
				$tests,
				'isNumeric',
				array('2','3.14','0','-3','-2.18','0.12','-0.17','+3.24','1.6e5','-1.1e-2'),
				array('a','-a','0.1z')
		);
		
		return $tests;
	}
}

