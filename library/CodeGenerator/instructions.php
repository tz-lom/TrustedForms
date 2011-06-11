<?php

#line 7 "instructions.y"


namespace TrustedForms\CodeGenerator;

use AbstractTree\Field;
use AbstractTree\Check;
use AbstractTree\Rules;
use AbstractTree\Reporters\AddClass;
use AbstractTree\Reporters\RemoveClass;
use AbstractTree\Reporters\DisplayMessage;

class ParceTokenException extends ErrorException{};
#line 17 "instructions.php"
#include "instructions.h"

class VIParser {
  private $yyidx = -1;               /* Index of top element in stack */
  private $yyerrcnt;                 /* Shifts left before out of the error */
  private $yystack = array();
  private $yyTraceFILE = null;
  private $yyTracePrompt = null;


  const TK_STRING =  1;
  const TK_HTML =  2;
  const TK_NUMBER =  3;
  const TK_IDENTIFIER =  4;
  const TK_COMA =  5;
  const TK_EQUALS =  6;
  const TK_SQARE_LBRACKET =  7;
  const TK_SQARE_RBRACKET =  8;
  const TK_PLUS =  9;
  const TK_MINUS = 10;
  const TK_CSS = 11;
  const TK_COLON = 12;
  const TK_CURLY_LBRACKET = 13;
  const TK_CCURLY_RBRACKET = 14;

  const YYNOCODE = 31;
#if INTERFACE
  const YYNSTATE = 42;
  const YYNRULE = 29;

  private $YY_NO_ACTION;
  private $YY_ACCEPT_ACTION;
  private $YY_ERROR_ACTION;

  /* action tables */ 

static $yy_action = array(
 /*     0 */    18,   19,   20,   21,   72,    8,    1,   12,   18,   19,
 /*    10 */    20,   21,    2,   24,   22,   14,   28,   41,   17,   27,
 /*    20 */     2,   33,   23,   22,   36,   15,   31,   11,    9,   10,
 /*    30 */    25,   22,   17,   42,   34,   13,    9,   10,   37,    4,
 /*    40 */     7,   16,   26,    5,   12,   40,   29,   30,   39,   38,
 /*    50 */     3,   32,    2,    6,   73,   35,
);
static $yy_lookahead = array(
 /*     0 */     1,    2,    3,    4,   16,   17,    7,   11,    1,    2,
 /*    10 */     3,    4,   13,   18,   19,   20,    1,   29,   21,    4,
 /*    20 */    13,    2,   18,   19,   27,   28,   23,   24,    9,   10,
 /*    30 */    18,   19,   21,    0,   25,   26,    9,   10,   27,    5,
 /*    40 */     5,    4,    8,   11,   11,   29,   22,   22,   19,   14,
 /*    50 */     6,   23,   13,   12,   30,   25,
);
  const YY_SHIFT_USE_DFLT = -5;
  const YY_SHIFT_MAX = 17;
static $yy_shift_ofst = array(
 /*     0 */    -4,    7,   37,   -1,    7,   19,   32,   37,   33,   15,
 /*    10 */    15,   27,   39,   32,   34,   35,   44,   41,
);
  const YY_REDUCE_USE_DFLT = -13;
  const YY_REDUCE_MAX = 13;
static $yy_reduce_ofst = array(
 /*     0 */   -12,   -5,   -3,    4,   12,    3,    9,   11,   16,   24,
 /*    10 */    25,   28,   29,   30,
);
static $yy_default = array(
 /*     0 */    71,   71,   71,   71,   71,   71,   71,   71,   71,   71,
 /*    10 */    71,   60,   71,   64,   71,   71,   50,   63,   43,   44,
 /*    20 */    45,   46,   47,   51,   48,   49,   52,   53,   54,   55,
 /*    30 */    56,   57,   58,   59,   61,   62,   65,   66,   67,   68,
 /*    40 */    70,   69,
);

  /* fallback */

  private static $yyFallback = array(
  );

  private static $yyTokenName = array( 
  '$',             'STRING',        'HTML',          'NUMBER',      
  'IDENTIFIER',    'COMA',          'EQUALS',        'SQARE_LBRACKET',
  'SQARE_RBRACKET',  'PLUS',          'MINUS',         'CSS',         
  'COLON',         'CURLY_LBRACKET',  'CCURLY_RBRACKET',  'error',       
  'start',         'translation_unit',  'parameter',     'rules',       
  'param_list',    'validation_rule',  'vr_ct_class_name',  'vr_ct_rule',  
  'class_transformations',  'vr_definition',  'validation_reporter',  'validator',   
  'rules_list',    'element_rules_definition',
  );

  private static $yyRuleName = array(
 /*   0 */ "start ::= translation_unit",
 /*   1 */ "parameter ::= STRING",
 /*   2 */ "parameter ::= HTML",
 /*   3 */ "parameter ::= NUMBER",
 /*   4 */ "parameter ::= IDENTIFIER",
 /*   5 */ "parameter ::= rules",
 /*   6 */ "param_list ::= parameter",
 /*   7 */ "param_list ::= param_list COMA parameter",
 /*   8 */ "validation_rule ::= IDENTIFIER",
 /*   9 */ "validation_rule ::= IDENTIFIER EQUALS parameter",
 /*  10 */ "validation_rule ::= IDENTIFIER EQUALS SQARE_LBRACKET param_list SQARE_RBRACKET",
 /*  11 */ "vr_ct_class_name ::= IDENTIFIER",
 /*  12 */ "vr_ct_class_name ::= STRING",
 /*  13 */ "vr_ct_rule ::= PLUS vr_ct_class_name",
 /*  14 */ "vr_ct_rule ::= MINUS vr_ct_class_name",
 /*  15 */ "class_transformations ::= vr_ct_rule",
 /*  16 */ "class_transformations ::= class_transformations vr_ct_rule",
 /*  17 */ "vr_definition ::= CSS HTML",
 /*  18 */ "vr_definition ::= CSS class_transformations",
 /*  19 */ "validation_reporter ::= vr_definition",
 /*  20 */ "validation_reporter ::= validation_reporter vr_definition",
 /*  21 */ "validator ::= validation_rule",
 /*  22 */ "validator ::= validation_rule COLON validation_reporter",
 /*  23 */ "rules_list ::= validator",
 /*  24 */ "rules_list ::= rules_list COMA validator",
 /*  25 */ "rules ::= CURLY_LBRACKET rules_list CCURLY_RBRACKET",
 /*  26 */ "element_rules_definition ::= CSS rules",
 /*  27 */ "translation_unit ::= element_rules_definition",
 /*  28 */ "translation_unit ::= translation_unit element_rules_definition",
  );

  public function trace($TraceFILE, $zTracePrompt)
  {
    $this->yyTraceFILE = $TraceFILE;
    $this->yyTracePrompt = $zTracePrompt;

    if ($TraceFILE === null)
      $this->yyTracePrompt = null;
    else if ($zTracePrompt === null)
      $this->yyTraceFILE = null;
  }

  public function yy_token_name($tokenType)
  {
    if (isset(self::$yyTokenName[$tokenType]))
      return self::$yyTokenName[$tokenType];

    return "Unknown";
  }

  private function yy_destructor($yymajor, $yypminor)
  {
    switch ($yymajor)
    {
      default:  
        break;
    }
  }

  private function yy_pop_parser_stack() 
  {
    if ($this->yyidx < 0) 
      return 0;

    $yytos = $this->yystack[$this->yyidx];

    if ($this->yyTraceFILE) 
      fprintf($this->yyTraceFILE,"%sPopping %s\n", $this->yyTracePrompt, self::$yyTokenName[$yytos->major]);

    $this->yy_destructor( $yytos->major, $yytos->minor);
    unset($this->yystack[$this->yyidx]);
    $this->yyidx--;

    return $yytos->major;
  }

  public function __destruct()
  {
    while($this->yyidx >= 0)
      $this->yy_pop_parser_stack();
  }

  private function yy_find_shift_action($iLookAhead) 
  {
    $i = 0;
    $stateno = $this->yystack[$this->yyidx]->stateno;

    if ($stateno > self::YY_SHIFT_MAX || ($i = self::$yy_shift_ofst[$stateno]) == self::YY_SHIFT_USE_DFLT)
      return self::$yy_default[$stateno];

    if ($iLookAhead == self::YYNOCODE)
      return $this->YY_NO_ACTION;

    $i += $iLookAhead;
    if ($i < 0 || $i >= count(self::$yy_action) || self::$yy_lookahead[$i] != $iLookAhead)
    {
      if ($iLookAhead > 0)
      {
        if (isset(self::$yyFallback[$iLookAhead]) && ($iFallback = self::$yyFallback[$iLookAhead]) != 0) 
        {
          if ($this->yyTraceFILE) 
            fprintf($this->yyTraceFILE, "%sFALLBACK %s => %s\n", $this->yyTracePrompt, self::$yyTokenName[$iLookAhead], self::$yyTokenName[$iFallback]);

          return $this->yy_find_shift_action($iFallback);
        }
        if (defined('VIParser::YYWILDCARD'))
        {
          $j = $i - $iLookAhead + self::YYWILDCARD;
          if ($j >= 0 && $j < count(self::$yy_action) && self::$yy_lookahead[$j] == self::YYWILDCARD)
          {
            if ($this->yyTraceFILE) 
              fprintf($this->yyTraceFILE, "%sWILDCARD %s => %s\n", $this->yyTracePrompt, self::$yyTokenName[$iLookAhead], self::$yyTokenName[self::YYWILDCARD]);

            return self::$yy_action[$j];
          }
        }
      }

      return self::$yy_default[$stateno];
    }
    else
      return self::$yy_action[$i];
  }

  private function yy_find_reduce_action($stateno, $iLookAhead)
  {
    $i = 0;

    if ($stateno > self::YY_REDUCE_MAX || ($i = self::$yy_reduce_ofst[$stateno]) == self::YY_REDUCE_USE_DFLT)
      return self::$yy_default[$stateno];

    if ($iLookAhead == self::YYNOCODE)
      return $this->YY_NO_ACTION;

    $i += $iLookAhead;
    if ($i < 0 || $i >= count(self::$yy_action) || self::$yy_lookahead[$i] != $iLookAhead)
      return self::$yy_default[$stateno];

    return self::$yy_action[$i];
  }

  private function yy_shift($yyNewState, $yyMajor, $yypMinor)
  {
    $this->yyidx++;

    if (isset($this->yystack[$this->yyidx])) 
    {
      $yytos = $this->yystack[$this->yyidx];
    } 
    else 
    {
      $yytos = new stdClass;
      $this->yystack[$this->yyidx] = $yytos;
    }

    $yytos->stateno = $yyNewState;
    $yytos->major = $yyMajor;
    $yytos->minor = $yypMinor;

    if ($this->yyTraceFILE) 
    {
      fprintf($this->yyTraceFILE,"%sShift %d\n", $this->yyTracePrompt, $yyNewState);
      fprintf($this->yyTraceFILE,"%sStack:", $this->yyTracePrompt);

      for ($i = 1; $i <= $this->yyidx; $i++) 
      {
        $ent = $this->yystack[$i];
        fprintf($this->yyTraceFILE, " %s", self::$yyTokenName[$ent->major]);
      }

      fprintf($this->yyTraceFILE, "\n");
    }
  }

  private function __overflow_dead_code() 
  {
#line 22 "instructions.y"
 throw new ParceTokenException('Stack overflow: '.$yyminor->value,$yymajor,0,'',$yyminor->line); 
#line 267 "instructions.php"
  }

  private static $yyRuleInfo = array(
  16, 1,
  18, 1,
  18, 1,
  18, 1,
  18, 1,
  18, 1,
  20, 1,
  20, 3,
  21, 1,
  21, 3,
  21, 5,
  22, 1,
  22, 1,
  23, 2,
  23, 2,
  24, 1,
  24, 2,
  25, 2,
  25, 2,
  26, 1,
  26, 2,
  27, 1,
  27, 3,
  28, 1,
  28, 3,
  19, 3,
  29, 2,
  17, 1,
  17, 2,
  );

  private function yy_reduce($yyruleno)
  {
    $yygoto = 0;              /* The next state */
    $yyact = 0;               /* The next action */
    $yygotominor = null;      /* The LHS of the rule reduced */
    $yymsp = null;            /* The top of the parser's stack */
    $yysize = 0;              /* Amount to pop the stack */

    $yymsp = $this->yystack[$this->yyidx];

    if ($this->yyTraceFILE && isset(self::$yyRuleName[$yyruleno]))
      fprintf($this->yyTraceFILE, "%sReduce [%s].\n", $this->yyTracePrompt, self::$yyRuleName[$yyruleno]);

    switch($yyruleno)
    {
      case 1: /* parameter ::= STRING */
      case 2: /* parameter ::= HTML */
      case 3: /* parameter ::= NUMBER */
      case 4: /* parameter ::= IDENTIFIER */
      case 11: /* vr_ct_class_name ::= IDENTIFIER */
      case 12: /* vr_ct_class_name ::= STRING */
#line 27 "instructions.y"
{ $yygotominor = $this->yystack[$this->yyidx + 0]->minor->value; }
#line 325 "instructions.php"
        break;
      case 5: /* parameter ::= rules */
      case 19: /* validation_reporter ::= vr_definition */
#line 31 "instructions.y"
{ $yygotominor = $this->yystack[$this->yyidx + 0]->minor; }
#line 331 "instructions.php"
        break;
      case 6: /* param_list ::= parameter */
      case 15: /* class_transformations ::= vr_ct_rule */
      case 23: /* rules_list ::= validator */
#line 33 "instructions.y"
{ $yygotominor = array($this->yystack[$this->yyidx + 0]->minor); }
#line 338 "instructions.php"
        break;
      case 7: /* param_list ::= param_list COMA parameter */
      case 24: /* rules_list ::= rules_list COMA validator */
#line 34 "instructions.y"
{ $yygotominor=$this->yystack[$this->yyidx + -2]->minor; $yygotominor[]=$this->yystack[$this->yyidx + 0]->minor; }
#line 344 "instructions.php"
        break;
      case 8: /* validation_rule ::= IDENTIFIER */
#line 36 "instructions.y"
{ $yygotominor = new Check($this->yystack[$this->yyidx + 0]->minor->value); }
#line 349 "instructions.php"
        break;
      case 9: /* validation_rule ::= IDENTIFIER EQUALS parameter */
#line 37 "instructions.y"
{ $yygotominor = new Check($this->yystack[$this->yyidx + -2]->minor->value,array($this->yystack[$this->yyidx + 0]->minor)); }
#line 354 "instructions.php"
        break;
      case 10: /* validation_rule ::= IDENTIFIER EQUALS SQARE_LBRACKET param_list SQARE_RBRACKET */
#line 38 "instructions.y"
{ $yygotominor = new Check($this->yystack[$this->yyidx + -4]->minor->value,$this->yystack[$this->yyidx + -1]->minor); }
#line 359 "instructions.php"
        break;
      case 13: /* vr_ct_rule ::= PLUS vr_ct_class_name */
#line 43 "instructions.y"
{ $yygotominor = array('className'=>'AddClass'	, 'class'=>$this->yystack[$this->yyidx + 0]->minor); }
#line 364 "instructions.php"
        break;
      case 14: /* vr_ct_rule ::= MINUS vr_ct_class_name */
#line 44 "instructions.y"
{ $yygotominor = array('className'=>'RemoveClass', 'class'=>$this->yystack[$this->yyidx + 0]->minor); }
#line 369 "instructions.php"
        break;
      case 16: /* class_transformations ::= class_transformations vr_ct_rule */
#line 47 "instructions.y"
{ $yygotominor=$this->yystack[$this->yyidx + -1]->minor; $yygotominor[]=$this->yystack[$this->yyidx + 0]->minor; }
#line 374 "instructions.php"
        break;
      case 17: /* vr_definition ::= CSS HTML */
#line 49 "instructions.y"
{ $yygotominor = array(DisplayMessage::instance($this->yystack[$this->yyidx + -1]->minor->value)->setText($this->yystack[$this->yyidx + 0]->minor->value)); }
#line 379 "instructions.php"
        break;
      case 18: /* vr_definition ::= CSS class_transformations */
#line 50 "instructions.y"
{
																	$yygotominor = array();
																	foreach($this->yystack[$this->yyidx + 0]->minor as $action)
																	{
																		$yygotominor[] = $action['className']::instance($this->yystack[$this->yyidx + -1]->minor->value)->setClass($action['class']);
																	}
																}
#line 390 "instructions.php"
        break;
      case 20: /* validation_reporter ::= validation_reporter vr_definition */
#line 59 "instructions.y"
{ $yygotominor=array_merge($this->yystack[$this->yyidx + -1]->minor,$this->yystack[$this->yyidx + 0]->minor); }
#line 395 "instructions.php"
        break;
      case 21: /* validator ::= validation_rule */
#line 61 "instructions.y"
{ $yygotominor = array('rule'=>$this->yystack[$this->yyidx + 0]->minor , 'reporter'=>NULL ); }
#line 400 "instructions.php"
        break;
      case 22: /* validator ::= validation_rule COLON validation_reporter */
#line 62 "instructions.y"
{ $yygotominor = array('rule'=>$this->yystack[$this->yyidx + -2]->minor , 'reporter'=>$this->yystack[$this->yyidx + 0]->minor ); }
#line 405 "instructions.php"
        break;
      case 25: /* rules ::= CURLY_LBRACKET rules_list CCURLY_RBRACKET */
#line 67 "instructions.y"
{ $yygotominor = new Rules($this->yystack[$this->yyidx + -1]->minor); }
#line 410 "instructions.php"
        break;
      case 26: /* element_rules_definition ::= CSS rules */
#line 69 "instructions.y"
{ $yygotominor = array('element'=>$this->yystack[$this->yyidx + -1]->minor->value , 'rules'=>$this->yystack[$this->yyidx + 0]->minor ); }
#line 415 "instructions.php"
        break;
      case 27: /* translation_unit ::= element_rules_definition */
      case 28: /* translation_unit ::= translation_unit element_rules_definition */
#line 71 "instructions.y"
{ $this->generator->addInputCheck($this->yystack[$this->yyidx + 0]->minor); }
#line 421 "instructions.php"
        break;
      default:
      /* (0) start ::= translation_unit */
        break;
    }

    $yygoto = self::$yyRuleInfo[2 * $yyruleno];
    $yysize = self::$yyRuleInfo[(2 * $yyruleno) + 1];

    $state_for_reduce = $this->yystack[$this->yyidx - $yysize]->stateno;

    $this->yyidx -= $yysize;
    $yyact = $this->yy_find_reduce_action($state_for_reduce,$yygoto);

    if ($yyact < self::YYNSTATE)
      $this->yy_shift($yyact, $yygoto, $yygotominor);
    else if ($yyact == self::YYNSTATE + self::YYNRULE + 1)
      $this->yy_accept();
  }

  private function yy_parse_failed()
  {
    if ($this->yyTraceFILE)
      fprintf($this->yyTraceFILE, "%sFail!\n", $this->yyTracePrompt);

    while ($this->yyidx >= 0) 
      $this->yy_pop_parser_stack();

#line 23 "instructions.y"
 throw new ParceTokenException('Parse failure: '.$yyminor->value,$yymajor,0,'',$yyminor->line); 
#line 452 "instructions.php"
  }

  private function yy_syntax_error($yymajor, $yyminor)
  {
    $message = 'Unexpected ' . $this->yy_token_name($yymajor) . '(' . $yyminor . ')';
#line 21 "instructions.y"
 throw new ParceTokenException('Syntax error: '.$yyminor->value,$yymajor,0,'',$yyminor->line); 
#line 460 "instructions.php"
  }

  private function yy_accept()
  {
    if ($this->yyTraceFILE)
      fprintf($this->yyTraceFILE, "%sAccept!\n", $this->yyTracePrompt);

    while ($this->yyidx >= 0) 
      $this->yy_pop_parser_stack();
  }

  public function doParse($yymajor, $yyminor = null) 
  {
    $yyact = 0; /* The parser action. */
    $yyendofinput = 0; /* True if we are at the end of input */
    $yyerrorhit = 0; /* True if yymajor has invoked an error */

    /* (re)initialize the parser, if necessary */
    if ($this->yyidx < 0) 
    {
      $this->yyidx = 0;
      $this->yyerrcnt = - 1;
      $ent = new stdClass;
      $ent->stateno = 0;
      $ent->major = 0;
      $ent->minor = null;
      $this->yystack = array(0 => $ent);
      $this->YY_NO_ACTION = self::YYNSTATE + self::YYNRULE + 2;
      $this->YY_ACCEPT_ACTION = self::YYNSTATE + self::YYNRULE + 1;
      $this->YY_ERROR_ACTION = self::YYNSTATE + self::YYNRULE;
    }

    $yyendofinput = ($yymajor == 0);

    if ($this->yyTraceFILE) 
      fprintf($this->yyTraceFILE, "%sInput %s\n", $this->yyTracePrompt, self::$yyTokenName[$yymajor]);

    do 
    {
      $yyact = $this->yy_find_shift_action($yymajor);

      if ($yyact < self::YYNSTATE) 
      {
        $this->yy_shift($yyact, $yymajor, $yyminor);
        $this->yyerrcnt--;

        if ($yyendofinput && $this->yyidx >= 0) 
          $yymajor = 0;
        else
          $yymajor = self::YYNOCODE;
      } 
      else if ($yyact < self::YYNSTATE + self::YYNRULE) 
      {
        $this->yy_reduce($yyact - self::YYNSTATE);
      }
      else if ($yyact == $this->YY_ERROR_ACTION) 
      {
        if ($this->yyTraceFILE) 
          fprintf($this->yyTraceFILE, "%sSyntax Error!\n", $this->yyTracePrompt);

        if (defined('self::YYERRORSYMBOL')) 
        {
          if ($this->yyerrcnt < 0) 
            $this->yy_syntax_error($yymajor, $yyminor);

          $yymx = $this->yystack[$this->yyidx]->major;

          if ($yymx == self::YYERRORSYMBOL || $yyerrorhit) 
          {
            if ($this->yyTraceFILE) 
              fprintf($this->yyTraceFILE, "%sDiscard input token %s\n", $this->yyTracePrompt, self::$yyTokenName[$yymajor]);

            $this->yy_destructor($yymajor, $yyminor);
            $yymajor = self::YYNOCODE;
          }
          else
          {
            while ($this->yyidx >= 0 && $yymx != self::YYERRORSYMBOL && ($yyact = $this->yy_find_reduce_action($this->yystack[$this->yyidx]->stateno, self::YYERRORSYMBOL)) >= self::YYNSTATE) 
              $this->yy_pop_parser_stack();

            if ($this->yyidx < 0 || $yymajor == 0) 
            {
              $this->yy_destructor($yymajor, $yyminor);
              $this->yy_parse_failed();
              $yymajor = self::YYNOCODE;
            }
            else if ($yymx != self::YYERRORSYMBOL) 
            {
              $this->yy_shift($yyact, self::YYERRORSYMBOL, 0);
            }
          }

          $yypParser->yyerrcnt = 3;
          $yyerrorhit = 1;
        }
        else
        { 
          if ($this->yyerrcnt <= 0) 
            $this->yy_syntax_error($yymajor, $yyminor);

          $this->yyerrcnt = 3;
          $this->yy_destructor($yymajor, $yyminor);

          if ($yyendofinput) 
            $this->yy_parse_failed();

          $yymajor = self::YYNOCODE;
        }
      }
      else
      {
        $this->yy_accept();
        $yymajor = self::YYNOCODE;
      }
    }
    while ($yymajor != self::YYNOCODE && $this->yyidx >= 0);
  }
}
