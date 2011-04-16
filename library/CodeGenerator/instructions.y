/* This is a lemon grammar for the C language */
%name VI
%token_prefix TK_

/* this defines a symbol for the lexer */
%nonassoc PRAGMA.

%left PLUS MINUS.

start ::= translation_unit.

parameter ::= STRING.
parameter ::= HTML.

param_list ::= parameter.
param_list ::= param_list COMA parameter.

validation_rule ::= IDENTIFIER EQUALS parameter.
validation_rule ::= IDENTIFIER EQUALS LBRACKET param_list RBRACKET.

validation_reporter_text ::= CSS parameter.

class_method ::= PLUS.
class_method ::= MINUS.

validation_reporter_class ::= CSS class_method IDENTIFIER.

validation_reporter_classes ::= validation_reporter_class.
validation_reporter_classes ::= validation_reporter_classes validation_reporter_class.

//validation_reporter ::= validation_reporter_text.
//validation_reporter ::= validation_reporter_classes.
validation_reporter ::= validation_reporter_text validation_reporter_classes.

validator ::= validation_rule.
validator ::= validation_rule COLON validation_reporter.

rules ::= validator COMA validator.

element_rules_definition ::= CSS COLON rules.

translation_unit ::= element_rules_definition.
translation_unit ::= translation_unit element_rules_definition.