%name VIParser

%token_prefix TK_

//%left CSS COLON.

%include {

namespace TrustedForms\CodeGenerator;

use stdClass;
use TrustedForms\CodeGenerator\AbstractTree\Field;
use TrustedForms\CodeGenerator\AbstractTree\Check;
use TrustedForms\CodeGenerator\AbstractTree\Rules;

class ParceTokenException extends \ErrorException{};
}

%syntax_error { throw new ParceTokenException('Syntax error: '.$yyminor->value,$yymajor,0,'',$yyminor->line); }
%stack_overflow { throw new ParceTokenException('Stack overflow: '.$yyminor->value,$yymajor,0,'',$yyminor->line); }
%parse_failure { throw new ParceTokenException('Parse failure: '.$yyminor->value,$yymajor,0,'',$yyminor->line); }

start ::= translation_unit.

parameter(p) ::= STRING(v).			{ p = v->value; }
parameter(p) ::= HTML(v).			{ p = v->value; }
parameter(p) ::= NUMBER(v).			{ p = v->value; }
parameter(p) ::= IDENTIFIER(v).		{ p = v->value; }
parameter(p) ::= rules(rules).       { p = rules; }

param_list(list) ::= parameter(par).						{ list = array(par); }
param_list(list) ::= param_list(old) COMA parameter(par).	{ list=old; list[]=par; }

validation_rule(cmd) ::= IDENTIFIER(id).                                                        { cmd = new Check(id->value); }
validation_rule(cmd) ::= IDENTIFIER(id) EQUALS parameter(par).                                  { cmd = new Check(id->value,array(par)); }
validation_rule(cmd) ::= IDENTIFIER(id) EQUALS LBRACKET param_list(list) RBRACKET.	{ cmd = new Check(id->value,list); }

vr_ct_class_name(c) ::= IDENTIFIER(v).	{ c = v->value; }
vr_ct_class_name(c) ::= STRING(v).		{ c = v->value; }

vr_ct_rule(t) ::= PLUS  vr_ct_class_name(c).	{ t = array('className'=> __NAMESPACE__.'\\AbstractTree\\Reporters\\AddClass'	, 'class'=>c); }
vr_ct_rule(t) ::= MINUS vr_ct_class_name(c).	{ t = array('className'=> __NAMESPACE__.'\\AbstractTree\\Reporters\\RemoveClass', 'class'=>c); }

class_transformations(set) ::= vr_ct_rule(t).								{ set = array(t); }
class_transformations(set) ::= class_transformations(old) vr_ct_rule(t).	{ set=old; set[]=t; }

vr_definition(def) ::= CSS(css) HTML(html).						{ def = array(AbstractTree\Reporters\DisplayMessage::instance(css->value)->setText(html->value)); }
vr_definition(def) ::= CSS(css) class_transformations(set).		{
																	def = array();
																	foreach(set as $action)
																	{
																		def[] = $action['className']::instance(css->value)->setClass($action['class']);
																	}
																}

validation_reporter(rep) ::= vr_definition(def).							{ rep = def; }
validation_reporter(rep) ::= validation_reporter(old) vr_definition(def).	{ rep=array_merge(old,def); }

validator(v) ::= validation_rule(cmd).									{ v = cmd; }
validator(v) ::= validation_rule(cmd) COLON validation_reporter(rep).	{ v = cmd->addReporters(rep); }

rules_list(set) ::= validator(rule).						{ set = Rules::instance()->addCheck(rule); }
rules_list(set) ::= rules_list(old) COMA validator(rule).	{ set = old->addCheck(rule); }

rules(rules) ::= CURLY_LBRACKET rules_list(list) CURLY_RBRACKET.        { rules = list; }
rules(rules) ::= CURLY_LBRACKET CURLY_RBRACKET.                         { rules = Rules::instance();}

element_selector_name(p) ::= STRING(v).         { p = v->value; }
element_selector_name(p) ::= IDENTIFIER(v).     { p = v->value; }

element_rules_definition(def) ::= element_selector_name(name) ANGLE_LBRACKET element_selector_name(form) ANGLE_RBRACKET rules(r).	{ def = new Field(name,form,r); }
element_rules_definition(def) ::= ANGLE_LBRACKET element_selector_name(form) ANGLE_RBRACKET element_selector_name(name) rules(r).	{ def = new Field(name,form,r); }
element_rules_definition(def) ::= ANGLE_LBRACKET element_selector_name(form) ANGLE_RBRACKET rules(r).                               { def = new Field('',form,r); }
element_rules_definition(def) ::= element_selector_name(name) rules(r).                                                             { def = new Field(name,'',r); }

translation_unit ::= element_rules_definition(def).						{ $this->generator->addDefinition(def); }
translation_unit ::= translation_unit element_rules_definition(def).	{ $this->generator->addDefinition(def); }
