<?php

namespace TrustedForms\CodeGenerator;

require_once 'autoload.php';

class LexerAndParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider lexerGrammarProvider
     * @param string $code
     * @param array $result 
     */
    public function testLexer($code,$result)
    {
        $tempfile = fopen('php://temp/','rw');
        fwrite($tempfile, $code);
        fseek($tempfile, 0);
        $lexer = new VILexer($tempfile);
        $lexems = array();
        
        while($t = $lexer->nextToken())
        {
            $lexems[] = array('type'=>$t->type,'value'=>$t->value);
        }
        
        $this->assertEquals($result, $lexems);
    }
    
    public function lexerGrammarProvider()
    {
        return array(
            array(
                '@selector@:
                    foo = bar,
                    foo2 = "bar2",
                    foo3 = << bar "3 here" >> ,
                    foo4 = 45
                ',
                array(
                    array('type'=>  VIParser::TK_CSS,'value'=>'selector'),
                    array('type'=>  VIParser::TK_COLON,'value'=>':'),
                    array('type'=>  VIParser::TK_IDENTIFIER,'value'=>'foo'),
                    array('type'=>  VIParser::TK_EQUALS,'value'=>'='),
                    array('type'=>  VIParser::TK_IDENTIFIER,'value'=>'bar'),
                    array('type'=>  VIParser::TK_COMA,'value'=>','),
                    array('type'=>  VIParser::TK_IDENTIFIER,'value'=>'foo2'),
                    array('type'=>  VIParser::TK_EQUALS,'value'=>'='),
                    array('type'=>  VIParser::TK_STRING,'value'=>'bar2'),
                    array('type'=>  VIParser::TK_COMA,'value'=>','),
                    array('type'=>  VIParser::TK_IDENTIFIER,'value'=>'foo3'),
                    array('type'=>  VIParser::TK_EQUALS,'value'=>'='),
                    array('type'=>  VIParser::TK_HTML,'value'=>' bar "3 here" '),
                    array('type'=>  VIParser::TK_COMA,'value'=>','),
                    array('type'=>  VIParser::TK_IDENTIFIER,'value'=>'foo4'),
                    array('type'=>  VIParser::TK_EQUALS,'value'=>'='),
                    array('type'=>  VIParser::TK_NUMBER,'value'=>'45')
                )
            ),
            array(
                '// @here@ "text"',
                array()
            ),
            array(
                '@selector@ : foo = (bar , 42 ,"baz" ,<<bee>> )',
                array(
                    array('type'=>  VIParser::TK_CSS,'value'=>'selector'),
                    array('type'=>  VIParser::TK_COLON,'value'=>':'),
                    array('type'=>  VIParser::TK_IDENTIFIER,'value'=>'foo'),
                    array('type'=>  VIParser::TK_EQUALS,'value'=>'='),
                    array('type'=>  VIParser::TK_LBRACKET,'value'=>'('),
                    array('type'=>  VIParser::TK_IDENTIFIER,'value'=>'bar'),
                    array('type'=>  VIParser::TK_COMA,'value'=>','),
                    array('type'=>  VIParser::TK_NUMBER,'value'=>'42'),
                    array('type'=>  VIParser::TK_COMA,'value'=>','),
                    array('type'=>  VIParser::TK_STRING,'value'=>'baz'),
                    array('type'=>  VIParser::TK_COMA,'value'=>','),
                    array('type'=>  VIParser::TK_HTML,'value'=>'bee'),
                    array('type'=>  VIParser::TK_RBRACKET,'value'=>')')
                )
            ),
            array(
                '@id@-c1+c2-c3',        //some shorthand test
                array(
                    array('type'=> VIParser::TK_CSS,'value'=>'id'),
                    array('type'=> VIParser::TK_MINUS,'value'=>'-'),
                    array('type'=> VIParser::TK_IDENTIFIER,'value'=>'c1'),
                    array('type'=> VIParser::TK_PLUS,'value'=>'+'),
                    array('type'=> VIParser::TK_IDENTIFIER,'value'=>'c2'),
                    array('type'=> VIParser::TK_MINUS,'value'=>'-'),
                    array('type'=> VIParser::TK_IDENTIFIER,'value'=>'c3')
                )
            ),
            array(
                '@selector@ : foo : @text@<<message>> @#id@+class-"class2" @.kill@-class+class2',
                array(
                    array('type'=> VIParser::TK_CSS,'value'=>'selector'),
                    array('type'=> VIParser::TK_COLON,'value'=>':'),
                    array('type'=> VIParser::TK_IDENTIFIER,'value'=>'foo'),
                    array('type'=> VIParser::TK_COLON,'value'=>':'),
                    array('type'=> VIParser::TK_CSS,'value'=>'text'),
                    array('type'=> VIParser::TK_HTML,'value'=>'message'),
                    array('type'=> VIParser::TK_CSS,'value'=>'#id'),
                    array('type'=> VIParser::TK_PLUS,'value'=>'+'),
                    array('type'=> VIParser::TK_IDENTIFIER,'value'=>'class'),
                    array('type'=> VIParser::TK_MINUS,'value'=>'-'),
                    array('type'=> VIParser::TK_STRING,'value'=>'class2'),
                    array('type'=> VIParser::TK_CSS,'value'=>'.kill'),
                    array('type'=> VIParser::TK_MINUS,'value'=>'-'),
                    array('type'=> VIParser::TK_IDENTIFIER,'value'=>'class'),
                    array('type'=> VIParser::TK_PLUS,'value'=>'+'),
                    array('type'=> VIParser::TK_IDENTIFIER,'value'=>'class2')
                )
            ),
            array(
                '+',
                array(
                    array('type'=> VIParser::TK_PLUS,'value'=>'+')
                )
            ),
            array(
                '1 2 -1 -2 0 0.0 -0.0 0.005 -1.230',
                array(
                    array('type'=> VIParser::TK_NUMBER,'value'=>'1'),
                    array('type'=> VIParser::TK_NUMBER,'value'=>'2'),
                    array('type'=> VIParser::TK_NUMBER,'value'=>'-1'),
                    array('type'=> VIParser::TK_NUMBER,'value'=>'-2'),
                    array('type'=> VIParser::TK_NUMBER,'value'=>'0'),
                    array('type'=> VIParser::TK_NUMBER,'value'=>'0.0'),
                    array('type'=> VIParser::TK_NUMBER,'value'=>'-0.0'),
                    array('type'=> VIParser::TK_NUMBER,'value'=>'0.005'),
                    array('type'=> VIParser::TK_NUMBER,'value'=>'-1.230')
                )
            ),
            array(
                '"text with \" quotes \" "',
                array(
                    array('type'=> VIParser::TK_STRING,'value'=>'text with \" quotes \" ')
                )
            )
        );
    }
    
    protected $actual = array();
    public function addDefinition($definition)
    {
        $this->actual[] = $definition;
    }


    /**
     * @dataProvider parserTestProvider
     * @param string $code
     * @param array $result 
     */
    public function testParser($code,$result)
    {
        
        $tempfile = fopen('php://temp/','rw');
        fwrite($tempfile, $code);
        fseek($tempfile, 0);
        
        $lexer = new VILexer($tempfile);
        $parser = new VIParser();
        
        $this->actual = array();
        $parser->generator =  $this;

        while($token = $lexer->nextToken())
        {
            $parser->doParse($token->type, $token);
        }
        $parser->doParse(0);
        
        fclose($tempfile);
        
        $this->assertEquals($result, $this->actual);
    }
    
    public function parserTestProvider()
    {
        return array(
            array(
                'id {
                    test,
                    test2
                }',
                array(
                    new AbstractTree\Field('id','',AbstractTree\Rules::instance()
                                                        ->addCheck(AbstractTree\Check::instance('test'))
                                                        ->addCheck(AbstractTree\Check::instance('test2'))
                                          )
                )
            ),
            array(
                'id {
                    test
                }
                
                "id 2" {
                    test2
                }',
                array(
                    new AbstractTree\Field('id','',AbstractTree\Rules::instance()->addCheck(AbstractTree\Check::instance('test'))),
                    new AbstractTree\Field('id 2','',AbstractTree\Rules::instance()->addCheck(AbstractTree\Check::instance('test2')))
                )
            ),
            array(
                '"id 1"<form> {
                    test = 42,
                    test2 = name,
                    test3 = "some text",
                    test4 = <<some html>>,
                    test5 = (42 , name , "some text" , <<some html>>)
                }',
                array(
                    new AbstractTree\Field('id 1','form', AbstractTree\Rules::instance()
                                                        ->addCheck(AbstractTree\Check::instance('test' , array('42')))
                                                        ->addCheck(AbstractTree\Check::instance('test2', array('name')))
                                                        ->addCheck(AbstractTree\Check::instance('test3', array('some text')))
                                                        ->addCheck(AbstractTree\Check::instance('test4', array('some html')))
                                                        ->addCheck(AbstractTree\Check::instance('test5', array('42','name','some text','some html')))
                                            )
                )
            ),
            array(
                '<"form 1">id {
                    test : @#error@+class-class2+class3 @#error2@-class-class2 @#error3@<<message here>>
                }',
                array(
                    new AbstractTree\Field('id','form 1', AbstractTree\Rules::instance()->addCheck(AbstractTree\Check::instance('test')->addReporters(array(
                        AbstractTree\Reporters\AddClass::instance('#error')->setClass('class'),
                        AbstractTree\Reporters\RemoveClass::instance('#error')->setClass('class2'),
                        AbstractTree\Reporters\AddClass::instance('#error')->setClass('class3'),
                        AbstractTree\Reporters\RemoveClass::instance('#error2')->setClass('class'),
                        AbstractTree\Reporters\RemoveClass::instance('#error2')->setClass('class2'),
                        AbstractTree\Reporters\DisplayMessage::instance('#error3')->setText('message here')
                    ))))
                )
            ),
            array(
                '"field 1"<"form 2"> {
                    test = simple,
                    test = {
                        inline,
                        withReporter: @#error@+class @#err@-class,
                        withAll = (42 , second) : @#err@<<message>> @#err2@+class-class2
                    }
                }
                <"form 2"> {
                    simple = 1 : @#err@<<message>>
                }',
                array(
                    new AbstractTree\Field('field 1','form 2',  AbstractTree\Rules::instance()
                                                            ->addCheck(AbstractTree\Check::instance('test',array('simple')))
                                                            ->addCheck(AbstractTree\Check::instance('test',array(
                                                                            AbstractTree\Rules::instance()
                                                                                    ->addCheck(AbstractTree\Check::instance('inline'))
                                                                                    ->addCheck(AbstractTree\Check::instance('withReporter')->addReporters(array(
                                                                                        AbstractTree\Reporters\AddClass::instance('#error')->setClass('class'),
                                                                                        AbstractTree\Reporters\RemoveClass::instance('#err')->setClass('class')
                                                                                    )))
                                                                                    ->addCheck(AbstractTree\Check::instance('withAll',array('42','second'))->addReporters(array(
                                                                                        AbstractTree\Reporters\DisplayMessage::instance('#err')->setText('message'),
                                                                                        AbstractTree\Reporters\AddClass::instance('#err2')->setClass('class'),
                                                                                        AbstractTree\Reporters\RemoveClass::instance('#err2')->setClass('class')
                                                                                    )))
                                                                    )))
                    ),
                    new AbstractTree\Field('','form 2', AbstractTree\Rules::instance()->addCheck(AbstractTree\Check::instance('simple',array('1'))->addReporters(array( AbstractTree\Reporters\DisplayMessage::instance('#err')->setText('message') ))))
                )
            ),
            array(
                '<form>id{
                    test = (
                        {
                            test2 = {
                                test3 = 42: @#err@<<message>>
                            },
                            test3
                        },
                        {
                            test4 = {
                                test5 = {
                                    test6 = {
                                        test7 = {}
                                    }
                                }
                            }
                        }
                    )
                }',
                array(
                    new AbstractTree\Field('id','form',
                            AbstractTree\Rules::instance()->addCheck(
                                AbstractTree\Check::instance('test',array(
                                    AbstractTree\Rules::instance()->addCheck(
                                        AbstractTree\Check::instance('test2',array(
                                            AbstractTree\Rules::instance()->addCheck(
                                                AbstractTree\Check::instance('test3',array('42'))->addReporters(array(AbstractTree\Reporters\DisplayMessage::instance('#err')->setText('message')))
                                            )
                                        ))
                                    )->addCheck(
                                        AbstractTree\Check::instance('test3')
                                    ),
                                    AbstractTree\Rules::instance()->addCheck(
                                        AbstractTree\Check::instance('test4',array(
                                            AbstractTree\Rules::instance()->addCheck(
                                                AbstractTree\Check::instance('test5',array(
                                                    AbstractTree\Rules::instance()->addCheck(
                                                        AbstractTree\Check::instance('test6',array(
                                                            AbstractTree\Rules::instance()->addCheck(
                                                                AbstractTree\Check::instance('test7',array(
                                                                    AbstractTree\Rules::instance()
                                                                ))
                                                            )
                                                        ))
                                                    )
                                                ))
                                            )
                                        ))
                                    )
                                ))
                            ))
                )
            )
        );
    }
}
