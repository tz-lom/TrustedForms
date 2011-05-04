<?php
include 'jlex.php';
include 'instructions.php';

%%

%full
%function nextToken
%line
%char
%state COMMENT
%class VILexer

D	=	[0-9]
L	=	[a-zA-Z_]

%%

<YYINITIAL> //[^\r\n]*      { /* do nothing on comments*/ }

<YYINITIAL> "/*"			{ $this->yybegin(self::COMMENT); }
<COMMENT>   "*/"            { $this->yybegin(self::YYINITIAL); }
<COMMENT>   (.|[\r\n])      { }

<YYINITIAL> "="				{ return $this->createToken(VIParser::TK_EQUALS); }
<YYINITIAL> "("				{ return $this->createToken(VIParser::TK_LBRACKET); }
<YYINITIAL> ")"				{ return $this->createToken(VIParser::TK_RBRACKET); }
<YYINITIAL> "-"				{ return $this->createToken(VIParser::TK_MINUS); }
<YYINITIAL> "+"				{ return $this->createToken(VIParser::TK_PLUS); }
<YYINITIAL> ","				{ return $this->createToken(VIParser::TK_COMA); }
<YYINITIAL> "||"			{ return $this->createToken(VIParser::TK_OR); }
<YYINITIAL> ":"				{ return $this->createToken(VIParser::TK_COLON); }

<YYINITIAL> <<(.)*>>	 	{
								$tok = $this->createToken(VIParser::TK_HTML);
								$tok->value = substr($tok->value,2,-2);		//trim << and >>
								return $tok;
							}

<YYINITIAL> @[^@]*@			{
								$tok = $this->createToken(VIParser::TK_CSS);
								$tok->value = substr($tok->value,1,-1);		//trim @ characters
								return $tok;
							}
<YYINITIAL> -?{D}+(\.{D}+)?		{ return $this->createToken(VIParser::TK_NUMBER); }
<YYINITIAL> {L}({L}|{D})*		{ return $this->createToken(VIParser::TK_IDENTIFIER); }
<YYINITIAL> \"(\\.|[^\\\"])*\" 	{
									$tok = $this->createToken(VIParser::TK_STRING);
									$tok->value = substr($tok->value,1,-1);		//trim " characters
									return $tok;
								}

<YYINITIAL> [ \t\v\n\f\r] {}
.			{ /*skip*/ }