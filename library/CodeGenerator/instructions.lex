<?php
include 'jlex.php';
include 'instructions.php';

%%


%function nextToken
%line
%char
%state COMMENT
%class VILexer


WORD =	[0-9a-zA-Z_\\-:.А-Яа-я]
D	=	[0-9]
L	=	[a-zA-Z_]

%%

<YYINITIAL> "/*"			{ 
								$this->commentTok = $this->createToken(VIParser::TK_COMMENT);
								$this->yybegin(self::COMMENT);
						    }
<YYINITIAL> //[^\r\n]*      { return $this->createToken(VIParser::TK_COMMENT); }

<COMMENT>   "*/"            { 
								$this->commentTok->value .= $this->yytext();
							    $this->yybegin(self::YYINITIAL); 
							    return $this->commentTok;
							}
<COMMENT>   (.|[\r\n])      { $this->commentTok->value .= $this->yytext(); }

<YYINITIAL> #[^\r\n]*       { return $this->createToken(VIParser::TK_COMMENT); }

<YYINITIAL> @\\.*@			{ return $this->createToken(VIParser::TK_CSS); }
<YYINITIAL> "="				{ return $this->createToken(VIParser::TK_EQUALS); }
<YYINITIAL>	"("				{ return $this->createToken(VIParser::TK_LBRACKET); }
<YYINITIAL> ")"				{ return $this->createToken(VIParser::TK_RBRACKET); }
<YYINITIAL> <<\\.*>>	 	{ return $this->createToken(VIParser::TK_HTML); }


<YYINITIAL> {L}({L}|{D})*		{ return $this->createToken(VIParser::TK_IDENTIFIER); }
<YYINITIAL> \"(\\.|[^\\\"])*\" 	{ return $this->createToken(VIParser::TK_STRING); }

<YYINITIAL> ","				{ return $this->createToken(VIParser::TK_COMA); }
<YYINITIAL> "||"			{ return $this->createToken(VIParser::TK_OR); }
<YYINITIAL> ":"				{ return $this->createToken(VIParser::TK_COLON); }
<YYINITIAL> "+"				{ return $this->createToken(VIParser::TK_ADD_CLASS); }
<YYINITIAL> "-"				{ return $this->createToken(VIParser::TK_REMOVE_CLASS); }

<YYINITIAL> defaultReport	{ return $this->createToken(VIParser::TK_DEFAULT_REPORT); }

<YYINITIAL> [ \t\v\n\f] { }
.			{ echo "Unrecognized character\n"; }