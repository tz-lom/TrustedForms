%name VIParser

%token_prefix TK_

%right CSS COLON.

start ::= translation_unit.

parameter(p) ::= STRING(v).			{ p = v->value; }
parameter(p) ::= HTML(v).			{ p = v->value; }
parameter(p) ::= NUMBER(v).			{ p = v->value; }
parameter(p) ::= IDENTIFIER(v).		{ p = v->value; }

param_list(list) ::= parameter(par).						{ list = array(par); }
param_list(list) ::= param_list(old) COMA parameter(par).	{ list=old; list[]=par; }

validation_rule(cmd) ::= IDENTIFIER(id).											{ cmd = array('name'=>id->value , 'params'=> array() );}
validation_rule(cmd) ::= IDENTIFIER(id) EQUALS parameter(par).						{ cmd = array('name'=>id->value , 'params'=> array(par) ); }
validation_rule(cmd) ::= IDENTIFIER(id) EQUALS LBRACKET param_list(list) RBRACKET.	{ cmd = array('name'=>id->value , 'params'=> list ); }

vr_ct_class_name(c) ::= IDENTIFIER(v).	{ c = v->value; }
vr_ct_class_name(c) ::= STRING(v).		{ c = v->value; }

vr_ct_rule(t) ::= PLUS  vr_ct_class_name(c).	{ t = array('cmd'=>'add'	, 'class'=>c); }
vr_ct_rule(t) ::= MINUS vr_ct_class_name(c).	{ t = array('cmd'=>'remove'	, 'class'=>c); }

class_transformations(set) ::= vr_ct_rule(t).								{ set = array(t); }
class_transformations(set) ::= class_transformations(old) vr_ct_rule(t).	{ set=old; set[]=t; }

vr_definition(def) ::= CSS(css) HTML(html).						{ def = array('target'=>css->value , 'action'=>'message' , 'value'=>html->value ); }
vr_definition(def) ::= CSS(css) class_transformations(set).		{ def = array('action'=>css->value , 'action'=>'classes' , 'value'=>set ); }

validation_reporter(rep) ::= vr_definition(def).							{ rep = array(def); }
validation_reporter(rep) ::= validation_reporter(old) vr_definition(def).	{ rep=old; rep[]=def; }

validator(v) ::= validation_rule(cmd).									{ v = array('rule'=>cmd , 'reporter'=>NULL ); }
validator(v) ::= validation_rule(cmd) COLON validation_reporter(rep).	{ v = array('rule'=>cmd , 'reporter'=>rep ); }

opt_rules(set) ::= validator(rule).						{ set = array('mode'=>'or','items'=>array(rule)); }
opt_rules(set) ::= opt_rules(old) OR validator(rule).	{ set=old; set['items'][]=rule; }

rules(set) ::= opt_rules(rule).						{ 
														if(count(rule['items'])==1) rule['mode'] = 'plain';
														set = array(rule);
													}
rules(set) ::= rules(old) COMA opt_rules(rule).		{
														if(count(rule['items'])==1) rule['mode'] = 'plain';
														set=old;
														set[]=rule;
													}

element_rules_definition(def) ::= CSS(css) COLON rules(r).	{ def = array('element'=>css->value , 'rules'=>r ); }

translation_unit ::= element_rules_definition(def).						{ print_r(def); }
translation_unit ::= translation_unit element_rules_definition(def).	{ print_r(def); }