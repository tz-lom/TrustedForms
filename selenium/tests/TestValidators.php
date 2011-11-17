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
<form name="form">
   <input type="text" name="value" id="in">
   <!--
   
        <form> { var = "\$form" }
   
   <form>value {
        defaultErrorReport: @#in@+error ,
        $description
   }
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
            self::$selenium->runScript('TrustedForms.reset();TrustedForms.register({item:"rpcTest",validator:function(){ return {value:value,passed:true}; }});');
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
    
    public function testIsEqualToField()
    {
        $source = <<<HEREDOC
<form name="form">
   <input type="text" name="value" id="in">
   <input type="text" name="value2" id="in2">
   <!--
   
    <form>{ var= "\$form" }
    
   <form>value {
    isEqualToField=value2: @#in@+error 
   }
   
   <form>value2 {
    required: @#in@+error
   }
   -->
</form>
HEREDOC;
        
        $builder = new \TrustedForms\CodeGenerator\Builder('phpQueryTemplate','PHPCode');
        $builder->buildFile($source);
        
        eval($builder->getResultValidator()); // here $form will be defined
        
        $form->checkArray(array(
            'value'     => 'one',
            'value2'    => 'two'
        ));
        $this->assertTrue($form->isError());
        
        $form->checkArray(array(
            'value'     => 'two',
            'value2'    => 'two'
        ));
        $this->assertFalse($form->isError());
        
        // insert JS into form
        if(!defined('SKIP_SELENIUM_TESTS'))
        {
            self::$selenium->runScript('TrustedForms.reset();');
            self::$selenium->runScript($builder->getJSvalidator());
            self::$selenium->type('value2','two');
            self::$selenium->type('value','one');
            $this->assertFalse(strpos(self::$selenium->getAttribute("value@class"),'error')===false);
            self::$selenium->type('value','two');
            $this->assertTrue(strpos(self::$selenium->getAttribute("value@class"),'error')===false);
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
     * @param array $tests          array where tests will be added
     * @param string $definition    String describing test
     * @param array $pass           Correct values
     * @param array $fails          Incorrect values
     */
    protected function genTestConfig(&$tests,$definition,$pass,$fails)
    {
        foreach($pass as $data)
        {
            $tests[] = array($definition,(string)$data,true);
        }
        foreach($fails as $data)
        {
            $tests[] = array($definition,(string)$data,false);
        }
    }
    
    public function validatorsInfo()
    {
        $tests = array();
        
        /*
         * isNumeric
         */
        $this->genTestConfig(
                $tests,
                'isNumeric',
                array('2','3.14','0','-3','-2.18','0.12','-0.17','+3.24','1.6e5','-1.1e-2'),
                array('a','-a','0.1z')
        );
        
        /*
         * inRange
         */
        $this->genTestConfig(
            $tests,
            'inRange = (1,5)',
            array('2','3','4.5','0.45e1','1','5'),
            array('0','-4','6','5.1')
        );
        $this->genTestConfig(
            $tests,
            'inRange = (-2,2)',
            array('1','0','-2'),
            array('','a','-3a')
        );
        
        /*
         * isEmail
         */
        $this->genTestConfig(
                $tests,
                'isEmail',
                array('test@mailserver.ru','test.server@[127.0.0.1]'),
                array('text','d@!.ru','31232')
        );
        
        /*
         * asFloat
         */
        $this->genTestConfig(
            $tests,
            'asFloat',
            array('+2.213','-12.43','2.0','-99.2','22','0','+2','4.2e4'),
            array('!!!','')
        );

        /*
         * asInteger
         */
        $this->genTestConfig(
            $tests,
            'asInteger',
            array('0','-1','3'),
            array('',12321.123123,'sadasd','NaN')
        );
        
        /*
         * isURL
         */
        $this->genTestConfig(
            $tests,
            'isURL',
            array('http://www.google.com','https://www.github.com/tz-lom/TrustedForms'),
            array('www.google',12321.123123,'google.com')
        );
        
        /*
         * isMaxLength
         */
        $this->genTestConfig(
            $tests,
            'length = (5)',
            array('stri','321'),
            array('THIS IS SPARTAAAAAAAAAAAAAAAAAA!!!!!!!!!','teststring','123123124')
        );
            
        /*
         * isIP
         */
        $this->genTestConfig(
            $tests,
            'isIP = (IPv4)',
            array('195.244.233.12','127.0.0.1'),
            array('2312','256.255.255.255','fe80::200:f8ff:fe21:67cf','011.111.135.245')
        );
        $this->genTestConfig(
            $tests,
            'isIP = (IPv6)',
            array('fe80::200:f8ff:fe21:67cf','2001:0db8:11a3:09d7:1f34:8a2e:07a0:765d','::1','2001:0db8:11a3:09d7:1f34:8a2e:07a0::'),
            array('ze80::200:f8ff:fe21:67cf','255.255.255.255','lolipop')
        );
        $this->genTestConfig(
            $tests,
            'isIP = (IPv4,IPv6)',
            array('195.244.233.102','2001:0db8:11a3:09d7:1f34:8a2e:07a0:765d'),
            array('2312','255.2225.255.255','lolipop')
        );
        
        /*
         * isAvailSymbols
         */ 
        $this->genTestConfig(
            $tests,
            'isAvailSymbols = abcdefghijklmnopqrstuvwxyz0123456789',
            array('t','0'),
            array('Z','A','@')
        );
        
        /*
         * oneOf
         */
        $this->genTestConfig(
            $tests,
            'oneOf = ({asInteger} , {asFloat})',
            array('1','-1','-1.1','4.2e1','0','0.0'),
            array('a','','-e1')
        );
        
        /*
         * regexp
         */
        $this->genTestConfig(
            $tests,
            'regexp = "/s/i"',
            array('s','S','as','Sa'),
            array('','a','$')
        );
        $this->genTestConfig(
            $tests,
            'regexp = "@s\@@i"',
            array('s@','S@','as@','S@a'),
            array('','a','$','s','@')
        );
        
        /**
         * not
         */
        $this->genTestConfig(
            $tests,
            'not = { isNumeric }',
            array('asd'),
            array('123')
        );        
        $this->genTestConfig(
            $tests,
            'not = { isNumeric , length=5 }',
            array('asd','asdfe','123456'),
            array('123','12345')
        );
        
        /**
         * equals
         */
        $this->genTestConfig($tests,
            'equals = good',
            array('good'),
            array('bad'));
        
        /**
         * trim
         */
        $this->genTestConfig(
            $tests,
            'trim , equals = "good"',
            array('good','  good','     good  '),
            array());
        
        return $tests;
    }
}

