/* This is a lemon grammar for the C language */
%name VI
%token_prefix TK_

/* this defines a symbol for the lexer */
%nonassoc PRAGMA.

start ::= translation_unit.

string ::= WORD.
string ::= STRING_LITERAL.
string ::= 
