<?php

require_once '../library/CodeGenerator/instructions.lex.php';

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
					array('type'=>	VIParser::TK_COLON,'value'=>':'),
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
					array('type'=>	VIParser::TK_COLON,'value'=>':'),
					array('type'=>  VIParser::TK_IDENTIFIER,'value'=>'foo'),
					array('type'=>  VIParser::TK_EQUALS,'value'=>'='),
					array('type'=>  VIParser::TK_LBRACKET,'value'=>'('),
					array('type'=>	VIParser::TK_IDENTIFIER,'value'=>'bar'),
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
				'@id@-c1+c2-c3',		//some shorthand test
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
			)
		);
	}
}
