<?php

#line 7 "instructions.y"

class ParceTokenException extends ErrorException{};
#line 7 "instructions.php"
#include "instructions.h"

class VIParser {
  private $yyidx = -1;               /* Index of top element in stack */
  private $yyerrcnt;                 /* Shifts left before out of the error */
  private $yystack = array();
  private $yyTraceFILE = null;
  private $yyTracePrompt = null;


  const TK_CSS =  1;
  const TK_COLON =  2;
  const TK_STRING =  3;
  const TK_HTML =  4;
  const TK_NUMBER =  5;
  const TK_IDENTIFIER =  6;
  const TK_COMA =  7;
  const TK_EQUALS =  8;
  const TK_LBRACKET =  9;
  const TK_RBRACKET = 10;
  const TK_PLUS = 11;
  const TK_MINUS = 12;
  const TK_OR = 13;

  const YYNOCODE = 30;
#if INTERFACE
  const YYNSTATE = 42;
  const YYNRULE = 29;

  private $YY_NO_ACTION;
  private $YY_ACCEPT_ACTION;
  private $YY_ERROR_ACTION;

  /* action tables */ 

static $yy_action = array(
 /*     0 */    21,   22,   23,   24,   17,   25,    3,   72,    9,   16,
 /*    10 */    38,   18,   19,   15,   21,   22,   23,   24,   17,   35,
 /*    20 */    41,   26,   14,    4,   38,   20,   10,   11,   33,   12,
 /*    30 */    27,   36,   13,   42,   15,   17,    7,   30,   10,   11,
 /*    40 */    29,   39,    8,   31,   32,   28,   40,   34,   37,    1,
 /*    50 */     5,    6,    2,
);
static $yy_lookahead = array(
 /*     0 */     3,    4,    5,    6,   19,   17,    9,   15,   16,    6,
 /*    10 */    25,   26,   27,    1,    3,    4,    5,    6,   19,    4,
 /*    20 */    28,   17,   18,    1,   25,   26,   11,   12,   21,   22,
 /*    30 */    17,   23,   24,    0,    1,   19,    8,    3,   11,   12,
 /*    40 */     6,   25,    7,   20,   20,   10,   28,   21,   23,    2,
 /*    50 */     2,   13,    7,
);
  const YY_SHIFT_USE_DFLT = -4;
  const YY_SHIFT_MAX = 20;
static $yy_shift_ofst = array(
 /*     0 */    12,    3,    3,   11,   15,   22,    3,   -3,   11,   33,
 /*    10 */    34,   34,   27,   -4,   35,   47,   28,   48,   38,   45,
 /*    20 */    38,
);
  const YY_REDUCE_USE_DFLT = -16;
  const YY_REDUCE_MAX = 13;
static $yy_reduce_ofst = array(
 /*     0 */    -8,  -15,   -1,    4,    7,    8,   16,  -12,   13,   18,
 /*    10 */    23,   24,   26,   25,
);
static $yy_default = array(
 /*     0 */    71,   71,   71,   71,   71,   71,   71,   71,   71,   71,
 /*    10 */    71,   71,   59,   63,   71,   71,   49,   62,   66,   68,
 /*    20 */    67,   43,   44,   45,   46,   50,   47,   48,   51,   52,
 /*    30 */    53,   54,   55,   56,   57,   58,   60,   61,   64,   65,
 /*    40 */    70,   69,
);

  /* fallback */

  private static $yyFallback = array(
  );

  private static $yyTokenName = array( 
  '$',             'CSS',           'COLON',         'STRING',      
  'HTML',          'NUMBER',        'IDENTIFIER',    'COMA',        
  'EQUALS',        'LBRACKET',      'RBRACKET',      'PLUS',        
  'MINUS',         'OR',            'error',         'start',       
  'translation_unit',  'parameter',     'param_list',    'validation_rule',
  'vr_ct_class_name',  'vr_ct_rule',    'class_transformations',  'vr_definition',
  'validation_reporter',  'validator',     'opt_rules',     'rules',       
  'element_rules_definition',
  );

  private static $yyRuleName = array(
 /*   0 */ "start ::= translation_unit",
 /*   1 */ "parameter ::= STRING",
 /*   2 */ "parameter ::= HTML",
 /*   3 */ "parameter ::= NUMBER",
 /*   4 */ "parameter ::= IDENTIFIER",
 /*   5 */ "param_list ::= parameter",
 /*   6 */ "param_list ::= param_list COMA parameter",
 /*   7 */ "validation_rule ::= IDENTIFIER",
 /*   8 */ "validation_rule ::= IDENTIFIER EQUALS parameter",
 /*   9 */ "validation_rule ::= IDENTIFIER EQUALS LBRACKET param_list RBRACKET",
 /*  10 */ "vr_ct_class_name ::= IDENTIFIER",
 /*  11 */ "vr_ct_class_name ::= STRING",
 /*  12 */ "vr_ct_rule ::= PLUS vr_ct_class_name",
 /*  13 */ "vr_ct_rule ::= MINUS vr_ct_class_name",
 /*  14 */ "class_transformations ::= vr_ct_rule",
 /*  15 */ "class_transformations ::= class_transformations vr_ct_rule",
 /*  16 */ "vr_definition ::= CSS HTML",
 /*  17 */ "vr_definition ::= CSS class_transformations",
 /*  18 */ "validation_reporter ::= vr_definition",
 /*  19 */ "validation_reporter ::= validation_reporter vr_definition",
 /*  20 */ "validator ::= validation_rule",
 /*  21 */ "validator ::= validation_rule COLON validation_reporter",
 /*  22 */ "opt_rules ::= validator",
 /*  23 */ "opt_rules ::= opt_rules OR validator",
 /*  24 */ "rules ::= opt_rules",
 /*  25 */ "rules ::= rules COMA opt_rules",
 /*  26 */ "element_rules_definition ::= CSS COLON rules",
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
#line 12 "instructions.y"
 throw new ParceTokenException('Stack overflow: '.$yyminor->value,$yymajor,0,'',$yyminor->line); 
#line 258 "instructions.php"
  }

  private static $yyRuleInfo = array(
  15, 1,
  17, 1,
  17, 1,
  17, 1,
  17, 1,
  18, 1,
  18, 3,
  19, 1,
  19, 3,
  19, 5,
  20, 1,
  20, 1,
  21, 2,
  21, 2,
  22, 1,
  22, 2,
  23, 2,
  23, 2,
  24, 1,
  24, 2,
  25, 1,
  25, 3,
  26, 1,
  26, 3,
  27, 1,
  27, 3,
  28, 3,
  16, 1,
  16, 2,
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
      case 10: /* vr_ct_class_name ::= IDENTIFIER */
      case 11: /* vr_ct_class_name ::= STRING */
#line 17 "instructions.y"
{ $yygotominor = $this->yystack[$this->yyidx + 0]->minor->value; }
#line 316 "instructions.php"
        break;
      case 5: /* param_list ::= parameter */
      case 14: /* class_transformations ::= vr_ct_rule */
      case 24: /* rules ::= opt_rules */
#line 22 "instructions.y"
{ $yygotominor = array($this->yystack[$this->yyidx + 0]->minor); }
#line 323 "instructions.php"
        break;
      case 6: /* param_list ::= param_list COMA parameter */
      case 25: /* rules ::= rules COMA opt_rules */
#line 23 "instructions.y"
{ $yygotominor=$this->yystack[$this->yyidx + -2]->minor; $yygotominor[]=$this->yystack[$this->yyidx + 0]->minor; }
#line 329 "instructions.php"
        break;
      case 7: /* validation_rule ::= IDENTIFIER */
#line 25 "instructions.y"
{ $yygotominor = array('name'=>$this->yystack[$this->yyidx + 0]->minor->value , 'params'=> array() );}
#line 334 "instructions.php"
        break;
      case 8: /* validation_rule ::= IDENTIFIER EQUALS parameter */
#line 26 "instructions.y"
{ $yygotominor = array('name'=>$this->yystack[$this->yyidx + -2]->minor->value , 'params'=> array($this->yystack[$this->yyidx + 0]->minor) ); }
#line 339 "instructions.php"
        break;
      case 9: /* validation_rule ::= IDENTIFIER EQUALS LBRACKET param_list RBRACKET */
#line 27 "instructions.y"
{ $yygotominor = array('name'=>$this->yystack[$this->yyidx + -4]->minor->value , 'params'=> $this->yystack[$this->yyidx + -1]->minor ); }
#line 344 "instructions.php"
        break;
      case 12: /* vr_ct_rule ::= PLUS vr_ct_class_name */
#line 32 "instructions.y"
{ $yygotominor = array('cmd'=>'add'	, 'class'=>$this->yystack[$this->yyidx + 0]->minor); }
#line 349 "instructions.php"
        break;
      case 13: /* vr_ct_rule ::= MINUS vr_ct_class_name */
#line 33 "instructions.y"
{ $yygotominor = array('cmd'=>'remove'	, 'class'=>$this->yystack[$this->yyidx + 0]->minor); }
#line 354 "instructions.php"
        break;
      case 15: /* class_transformations ::= class_transformations vr_ct_rule */
#line 36 "instructions.y"
{ $yygotominor=$this->yystack[$this->yyidx + -1]->minor; $yygotominor[]=$this->yystack[$this->yyidx + 0]->minor; }
#line 359 "instructions.php"
        break;
      case 16: /* vr_definition ::= CSS HTML */
#line 38 "instructions.y"
{ $yygotominor = array(array('target'=>$this->yystack[$this->yyidx + -1]->minor->value , 'action'=>'message' , 'value'=>$this->yystack[$this->yyidx + 0]->minor->value )); }
#line 364 "instructions.php"
        break;
      case 17: /* vr_definition ::= CSS class_transformations */
#line 39 "instructions.y"
{
																	$yygotominor = array();
																	foreach($this->yystack[$this->yyidx + 0]->minor as $action)
																	{
																		$yygotominor[] = array_merge(array('target'=>$this->yystack[$this->yyidx + -1]->minor->value , 'action'=>'classes'),$action);
																	}
																}
#line 375 "instructions.php"
        break;
      case 18: /* validation_reporter ::= vr_definition */
      case 22: /* opt_rules ::= validator */
#line 47 "instructions.y"
{ $yygotominor = $this->yystack[$this->yyidx + 0]->minor; }
#line 381 "instructions.php"
        break;
      case 19: /* validation_reporter ::= validation_reporter vr_definition */
#line 48 "instructions.y"
{ $yygotominor=array_merge($this->yystack[$this->yyidx + -1]->minor,$this->yystack[$this->yyidx + 0]->minor); }
#line 386 "instructions.php"
        break;
      case 20: /* validator ::= validation_rule */
#line 50 "instructions.y"
{ $yygotominor = array('rule'=>$this->yystack[$this->yyidx + 0]->minor , 'reporter'=>NULL ); }
#line 391 "instructions.php"
        break;
      case 21: /* validator ::= validation_rule COLON validation_reporter */
#line 51 "instructions.y"
{ $yygotominor = array('rule'=>$this->yystack[$this->yyidx + -2]->minor , 'reporter'=>$this->yystack[$this->yyidx + 0]->minor ); }
#line 396 "instructions.php"
        break;
      case 23: /* opt_rules ::= opt_rules OR validator */
#line 54 "instructions.y"
{
																if($this->yystack[$this->yyidx + -2]->minor['rule']['name']=='||')
																{
																	$yygotominor = $this->yystack[$this->yyidx + -2]->minor;
																	$yygotominor['rule']['params'][] = $this->yystack[$this->yyidx + 0]->minor;
																}
																else
																{
																	$yygotominor = array('rule'=>array('name'=>'||' , 'params'=> array($this->yystack[$this->yyidx + -2]->minor,$this->yystack[$this->yyidx + 0]->minor)) , 'reporter'=>NULL ); 
																}
															}
#line 411 "instructions.php"
        break;
      case 26: /* element_rules_definition ::= CSS COLON rules */
#line 69 "instructions.y"
{ $yygotominor = array('element'=>$this->yystack[$this->yyidx + -2]->minor->value , 'rules'=>$this->yystack[$this->yyidx + 0]->minor ); }
#line 416 "instructions.php"
        break;
      case 27: /* translation_unit ::= element_rules_definition */
      case 28: /* translation_unit ::= translation_unit element_rules_definition */
#line 71 "instructions.y"
{ $this->generator->addInputCheck($this->yystack[$this->yyidx + 0]->minor); }
#line 422 "instructions.php"
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

#line 13 "instructions.y"
 throw new ParceTokenException('Parse failure: '.$yyminor->value,$yymajor,0,'',$yyminor->line); 
#line 453 "instructions.php"
  }

  private function yy_syntax_error($yymajor, $yyminor)
  {
    $message = 'Unexpected ' . $this->yy_token_name($yymajor) . '(' . $yyminor . ')';
#line 11 "instructions.y"
 throw new ParceTokenException('Syntax error: '.$yyminor->value,$yymajor,0,'',$yyminor->line); 
#line 461 "instructions.php"
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
