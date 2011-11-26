<?php

#line 7 "VIParser.y"


namespace TrustedForms\CodeGenerator;

use stdClass;
use TrustedForms\CodeGenerator\AbstractTree\Field;
use TrustedForms\CodeGenerator\AbstractTree\Check;
use TrustedForms\CodeGenerator\AbstractTree\Rules;

class ParceTokenException extends \ErrorException{};
#line 15 "VIParser.php"
#include "VIParser.h"

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
  const TK_LBRACKET =  7;
  const TK_RBRACKET =  8;
  const TK_PLUS =  9;
  const TK_MINUS = 10;
  const TK_CSS = 11;
  const TK_COLON = 12;
  const TK_CURLY_LBRACKET = 13;
  const TK_CURLY_RBRACKET = 14;
  const TK_ANGLE_LBRACKET = 15;
  const TK_ANGLE_RBRACKET = 16;

  const YYNOCODE = 34;
#if INTERFACE
  const YYNSTATE = 57;
  const YYNRULE = 36;

  private $YY_NO_ACTION;
  private $YY_ACCEPT_ACTION;
  private $YY_ERROR_ACTION;

  /* action tables */ 

static $yy_action = array(
 /*     0 */    28,   29,   30,   31,   94,    5,    1,   43,   28,   29,
 /*    10 */    30,   31,    2,   26,   12,   13,   27,   11,   56,    9,
 /*    20 */     2,   57,   26,   11,   55,   27,   23,   10,   48,   34,
 /*    30 */    32,   20,   46,   21,   26,   26,   10,   27,   27,   22,
 /*    40 */    41,   14,   33,   32,   53,   22,    2,   35,   32,   49,
 /*    50 */    19,   44,   16,   23,   18,    2,    6,   15,   51,   47,
 /*    60 */    25,   38,   12,   13,   37,   26,   45,    4,   27,   42,
 /*    70 */    36,   39,   40,   50,   24,   52,    2,   54,    3,    8,
 /*    80 */    95,   17,    7,
);
static $yy_lookahead = array(
 /*     0 */     1,    2,    3,    4,   18,   19,    7,    2,    1,    2,
 /*    10 */     3,    4,   13,    1,    9,   10,    4,   31,   32,    5,
 /*    20 */    13,    0,    1,   31,   32,    4,   23,   15,   14,   20,
 /*    30 */    21,   22,   29,   30,    1,    1,   15,    4,    4,    4,
 /*    40 */    25,   26,   20,   21,   21,    4,   13,   20,   21,   14,
 /*    50 */    16,   27,   28,   23,   31,   13,   11,   15,   21,   29,
 /*    60 */    31,    1,    9,   10,    4,    1,   27,    5,    4,   25,
 /*    70 */     8,   24,   24,   21,   31,   21,   13,   21,    6,   12,
 /*    80 */    33,   16,   16,
);
  const YY_SHIFT_USE_DFLT = -2;
  const YY_SHIFT_MAX = 25;
static $yy_shift_ofst = array(
 /*     0 */    12,    7,   35,   -1,    7,   21,    5,   33,   45,   41,
 /*    10 */    34,   42,   60,   60,   53,   64,   45,   63,   63,   63,
 /*    20 */    62,   14,   72,   67,   65,   66,
);
  const YY_REDUCE_USE_DFLT = -15;
  const YY_REDUCE_MAX = 19;
static $yy_reduce_ofst = array(
 /*     0 */   -14,    9,    3,   22,   27,   -8,   15,   23,   24,   30,
 /*    10 */    29,   37,   47,   48,   44,   43,   39,   52,   54,   56,
);
static $yy_default = array(
 /*     0 */    93,   93,   93,   93,   93,   93,   93,   93,   93,   93,
 /*    10 */    93,   93,   93,   93,   75,   93,   79,   93,   93,   93,
 /*    20 */    93,   93,   65,   78,   93,   93,   84,   85,   58,   59,
 /*    30 */    60,   61,   62,   66,   63,   64,   67,   68,   69,   70,
 /*    40 */    71,   72,   73,   74,   76,   77,   80,   81,   82,   83,
 /*    50 */    86,   90,   87,   88,   89,   92,   91,
);

  /* fallback */

  private static $yyFallback = array(
  );

  private static $yyTokenName = array( 
  '$',             'STRING',        'HTML',          'NUMBER',      
  'IDENTIFIER',    'COMA',          'EQUALS',        'LBRACKET',    
  'RBRACKET',      'PLUS',          'MINUS',         'CSS',         
  'COLON',         'CURLY_LBRACKET',  'CURLY_RBRACKET',  'ANGLE_LBRACKET',
  'ANGLE_RBRACKET',  'error',         'start',         'translation_unit',
  'parameter',     'rules',         'param_list',    'validation_rule',
  'vr_ct_class_name',  'vr_ct_rule',    'class_transformations',  'vr_definition',
  'validation_reporter',  'validator',     'rules_list',    'element_selector_name',
  'element_rules_definition',
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
 /*  10 */ "validation_rule ::= IDENTIFIER EQUALS LBRACKET param_list RBRACKET",
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
 /*  25 */ "rules ::= CURLY_LBRACKET rules_list CURLY_RBRACKET",
 /*  26 */ "rules ::= CURLY_LBRACKET CURLY_RBRACKET",
 /*  27 */ "element_selector_name ::= STRING",
 /*  28 */ "element_selector_name ::= IDENTIFIER",
 /*  29 */ "element_rules_definition ::= element_selector_name ANGLE_LBRACKET element_selector_name ANGLE_RBRACKET rules",
 /*  30 */ "element_rules_definition ::= ANGLE_LBRACKET element_selector_name ANGLE_RBRACKET element_selector_name rules",
 /*  31 */ "element_rules_definition ::= ANGLE_LBRACKET element_selector_name ANGLE_RBRACKET rules",
 /*  32 */ "element_rules_definition ::= ANGLE_LBRACKET ANGLE_RBRACKET rules",
 /*  33 */ "element_rules_definition ::= element_selector_name rules",
 /*  34 */ "translation_unit ::= element_rules_definition",
 /*  35 */ "translation_unit ::= translation_unit element_rules_definition",
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
#line 20 "VIParser.y"
 throw new ParceTokenException('Stack overflow: '.$yyminor->value,$yymajor,0,'',$yyminor->line); 
#line 281 "VIParser.php"
  }

  private static $yyRuleInfo = array(
  18, 1,
  20, 1,
  20, 1,
  20, 1,
  20, 1,
  20, 1,
  22, 1,
  22, 3,
  23, 1,
  23, 3,
  23, 5,
  24, 1,
  24, 1,
  25, 2,
  25, 2,
  26, 1,
  26, 2,
  27, 2,
  27, 2,
  28, 1,
  28, 2,
  29, 1,
  29, 3,
  30, 1,
  30, 3,
  21, 3,
  21, 2,
  31, 1,
  31, 1,
  32, 5,
  32, 5,
  32, 4,
  32, 3,
  32, 2,
  19, 1,
  19, 2,
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
      case 27: /* element_selector_name ::= STRING */
      case 28: /* element_selector_name ::= IDENTIFIER */
#line 25 "VIParser.y"
{ $yygotominor = $this->yystack[$this->yyidx + 0]->minor->value; }
#line 348 "VIParser.php"
        break;
      case 5: /* parameter ::= rules */
      case 19: /* validation_reporter ::= vr_definition */
      case 21: /* validator ::= validation_rule */
#line 29 "VIParser.y"
{ $yygotominor = $this->yystack[$this->yyidx + 0]->minor; }
#line 355 "VIParser.php"
        break;
      case 6: /* param_list ::= parameter */
      case 15: /* class_transformations ::= vr_ct_rule */
#line 31 "VIParser.y"
{ $yygotominor = array($this->yystack[$this->yyidx + 0]->minor); }
#line 361 "VIParser.php"
        break;
      case 7: /* param_list ::= param_list COMA parameter */
#line 32 "VIParser.y"
{ $yygotominor=$this->yystack[$this->yyidx + -2]->minor; $yygotominor[]=$this->yystack[$this->yyidx + 0]->minor; }
#line 366 "VIParser.php"
        break;
      case 8: /* validation_rule ::= IDENTIFIER */
#line 34 "VIParser.y"
{ $yygotominor = new Check($this->yystack[$this->yyidx + 0]->minor->value); }
#line 371 "VIParser.php"
        break;
      case 9: /* validation_rule ::= IDENTIFIER EQUALS parameter */
#line 35 "VIParser.y"
{ $yygotominor = new Check($this->yystack[$this->yyidx + -2]->minor->value,array($this->yystack[$this->yyidx + 0]->minor)); }
#line 376 "VIParser.php"
        break;
      case 10: /* validation_rule ::= IDENTIFIER EQUALS LBRACKET param_list RBRACKET */
#line 36 "VIParser.y"
{ $yygotominor = new Check($this->yystack[$this->yyidx + -4]->minor->value,$this->yystack[$this->yyidx + -1]->minor); }
#line 381 "VIParser.php"
        break;
      case 13: /* vr_ct_rule ::= PLUS vr_ct_class_name */
#line 41 "VIParser.y"
{ $yygotominor = array('className'=> __NAMESPACE__.'\\AbstractTree\\Reporters\\AddClass'	, 'class'=>$this->yystack[$this->yyidx + 0]->minor); }
#line 386 "VIParser.php"
        break;
      case 14: /* vr_ct_rule ::= MINUS vr_ct_class_name */
#line 42 "VIParser.y"
{ $yygotominor = array('className'=> __NAMESPACE__.'\\AbstractTree\\Reporters\\RemoveClass', 'class'=>$this->yystack[$this->yyidx + 0]->minor); }
#line 391 "VIParser.php"
        break;
      case 16: /* class_transformations ::= class_transformations vr_ct_rule */
#line 45 "VIParser.y"
{ $yygotominor=$this->yystack[$this->yyidx + -1]->minor; $yygotominor[]=$this->yystack[$this->yyidx + 0]->minor; }
#line 396 "VIParser.php"
        break;
      case 17: /* vr_definition ::= CSS HTML */
#line 47 "VIParser.y"
{ $yygotominor = array(AbstractTree\Reporters\DisplayMessage::instance($this->yystack[$this->yyidx + -1]->minor->value)->setText($this->yystack[$this->yyidx + 0]->minor->value)); }
#line 401 "VIParser.php"
        break;
      case 18: /* vr_definition ::= CSS class_transformations */
#line 48 "VIParser.y"
{
																	$yygotominor = array();
																	foreach($this->yystack[$this->yyidx + 0]->minor as $action)
																	{
																		$yygotominor[] = $action['className']::instance($this->yystack[$this->yyidx + -1]->minor->value)->setClass($action['class']);
																	}
																}
#line 412 "VIParser.php"
        break;
      case 20: /* validation_reporter ::= validation_reporter vr_definition */
#line 57 "VIParser.y"
{ $yygotominor=array_merge($this->yystack[$this->yyidx + -1]->minor,$this->yystack[$this->yyidx + 0]->minor); }
#line 417 "VIParser.php"
        break;
      case 22: /* validator ::= validation_rule COLON validation_reporter */
#line 60 "VIParser.y"
{ $yygotominor = $this->yystack[$this->yyidx + -2]->minor->addReporters($this->yystack[$this->yyidx + 0]->minor); }
#line 422 "VIParser.php"
        break;
      case 23: /* rules_list ::= validator */
#line 62 "VIParser.y"
{ $yygotominor = Rules::instance()->addCheck($this->yystack[$this->yyidx + 0]->minor); }
#line 427 "VIParser.php"
        break;
      case 24: /* rules_list ::= rules_list COMA validator */
#line 63 "VIParser.y"
{ $yygotominor = $this->yystack[$this->yyidx + -2]->minor->addCheck($this->yystack[$this->yyidx + 0]->minor); }
#line 432 "VIParser.php"
        break;
      case 25: /* rules ::= CURLY_LBRACKET rules_list CURLY_RBRACKET */
#line 65 "VIParser.y"
{ $yygotominor = $this->yystack[$this->yyidx + -1]->minor; }
#line 437 "VIParser.php"
        break;
      case 26: /* rules ::= CURLY_LBRACKET CURLY_RBRACKET */
#line 66 "VIParser.y"
{ $yygotominor = Rules::instance();}
#line 442 "VIParser.php"
        break;
      case 29: /* element_rules_definition ::= element_selector_name ANGLE_LBRACKET element_selector_name ANGLE_RBRACKET rules */
#line 71 "VIParser.y"
{ $yygotominor = new Field($this->yystack[$this->yyidx + -4]->minor,$this->yystack[$this->yyidx + -2]->minor,$this->yystack[$this->yyidx + 0]->minor); }
#line 447 "VIParser.php"
        break;
      case 30: /* element_rules_definition ::= ANGLE_LBRACKET element_selector_name ANGLE_RBRACKET element_selector_name rules */
#line 72 "VIParser.y"
{ $yygotominor = new Field($this->yystack[$this->yyidx + -1]->minor,$this->yystack[$this->yyidx + -3]->minor,$this->yystack[$this->yyidx + 0]->minor); }
#line 452 "VIParser.php"
        break;
      case 31: /* element_rules_definition ::= ANGLE_LBRACKET element_selector_name ANGLE_RBRACKET rules */
#line 73 "VIParser.y"
{ $yygotominor = new Field('',$this->yystack[$this->yyidx + -2]->minor,$this->yystack[$this->yyidx + 0]->minor); }
#line 457 "VIParser.php"
        break;
      case 32: /* element_rules_definition ::= ANGLE_LBRACKET ANGLE_RBRACKET rules */
#line 74 "VIParser.y"
{ $yygotominor = new Field('','',$this->yystack[$this->yyidx + 0]->minor); }
#line 462 "VIParser.php"
        break;
      case 33: /* element_rules_definition ::= element_selector_name rules */
#line 75 "VIParser.y"
{ $yygotominor = new Field($this->yystack[$this->yyidx + -1]->minor,'',$this->yystack[$this->yyidx + 0]->minor); }
#line 467 "VIParser.php"
        break;
      case 34: /* translation_unit ::= element_rules_definition */
      case 35: /* translation_unit ::= translation_unit element_rules_definition */
#line 77 "VIParser.y"
{ $this->generator->addDefinition($this->yystack[$this->yyidx + 0]->minor); }
#line 473 "VIParser.php"
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

#line 21 "VIParser.y"
 throw new ParceTokenException('Parse failure: '.$yyminor->value,$yymajor,0,'',$yyminor->line); 
#line 504 "VIParser.php"
  }

  private function yy_syntax_error($yymajor, $yyminor)
  {
    $message = 'Unexpected ' . $this->yy_token_name($yymajor) . '(' . $yyminor . ')';
#line 19 "VIParser.y"
 throw new ParceTokenException('Syntax error: '.$yyminor->value,$yymajor,0,'',$yyminor->line); 
#line 512 "VIParser.php"
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
