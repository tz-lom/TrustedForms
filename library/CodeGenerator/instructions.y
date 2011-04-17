%name VIParser

%token_prefix TK_

%right CSS COLON.

start ::= translation_unit.

parameter ::= STRING.
parameter ::= HTML.
parameter ::= NUMBER.
parameter ::= IDENTIFIER.

param_list ::= parameter.
param_list ::= param_list COMA parameter.

validation_rule ::= IDENTIFIER.
validation_rule ::= IDENTIFIER EQUALS parameter.
validation_rule ::= IDENTIFIER EQUALS LBRACKET param_list RBRACKET.

vr_ct_class_name ::= IDENTIFIER.
vr_ct_class_name ::= STRING.

vr_ct_rule ::= PLUS  vr_ct_class_name.
vr_ct_rule ::= MINUS vr_ct_class_name.

class_transformations ::= vr_ct_rule.
class_transformations ::= class_transformations vr_ct_rule.

vr_definition ::= CSS HTML.
vr_definition ::= CSS class_transformations.

validation_reporter ::= vr_definition.
validation_reporter ::= validation_reporter vr_definition.

validator ::= validation_rule COLON validation_reporter.
validator ::= validation_rule.

opt_rules ::= validator.
opt_rules ::= opt_rules OR validator.

rules ::= opt_rules.
rules ::= rules COMA opt_rules.

element_rules_definition ::= CSS COLON rules.

translation_unit ::= element_rules_definition.
translation_unit ::= translation_unit element_rules_definition.