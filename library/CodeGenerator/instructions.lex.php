<?php
include 'jlex.php';
include 'instructions.php';


class VILexer extends JLexBase  {
	const YY_BUFFER_SIZE = 512;
	const YY_F = -1;
	const YY_NO_STATE = -1;
	const YY_NOT_ACCEPT = 0;
	const YY_START = 1;
	const YY_END = 2;
	const YY_NO_ANCHOR = 4;
	const YY_BOL = 256;
	var $YY_EOF = 257;
	protected $yy_count_chars = true;
	protected $yy_count_lines = true;

	function __construct($stream) {
		parent::__construct($stream);
		$this->yy_lexical_state = self::YYINITIAL;
	}

	const YYINITIAL = 0;
	const COMMENT = 1;
	static $yy_state_dtrans = array(
		0,
		33
	);
	static $yy_acpt = array(
		/* 0 */ self::YY_NOT_ACCEPT,
		/* 1 */ self::YY_NO_ANCHOR,
		/* 2 */ self::YY_NO_ANCHOR,
		/* 3 */ self::YY_NO_ANCHOR,
		/* 4 */ self::YY_NO_ANCHOR,
		/* 5 */ self::YY_NO_ANCHOR,
		/* 6 */ self::YY_NO_ANCHOR,
		/* 7 */ self::YY_NO_ANCHOR,
		/* 8 */ self::YY_NO_ANCHOR,
		/* 9 */ self::YY_NO_ANCHOR,
		/* 10 */ self::YY_NO_ANCHOR,
		/* 11 */ self::YY_NO_ANCHOR,
		/* 12 */ self::YY_NO_ANCHOR,
		/* 13 */ self::YY_NO_ANCHOR,
		/* 14 */ self::YY_NO_ANCHOR,
		/* 15 */ self::YY_NO_ANCHOR,
		/* 16 */ self::YY_NO_ANCHOR,
		/* 17 */ self::YY_NO_ANCHOR,
		/* 18 */ self::YY_NO_ANCHOR,
		/* 19 */ self::YY_NO_ANCHOR,
		/* 20 */ self::YY_NO_ANCHOR,
		/* 21 */ self::YY_NOT_ACCEPT,
		/* 22 */ self::YY_NO_ANCHOR,
		/* 23 */ self::YY_NO_ANCHOR,
		/* 24 */ self::YY_NO_ANCHOR,
		/* 25 */ self::YY_NOT_ACCEPT,
		/* 26 */ self::YY_NO_ANCHOR,
		/* 27 */ self::YY_NOT_ACCEPT,
		/* 28 */ self::YY_NO_ANCHOR,
		/* 29 */ self::YY_NOT_ACCEPT,
		/* 30 */ self::YY_NO_ANCHOR,
		/* 31 */ self::YY_NOT_ACCEPT,
		/* 32 */ self::YY_NO_ANCHOR,
		/* 33 */ self::YY_NOT_ACCEPT,
		/* 34 */ self::YY_NOT_ACCEPT
	);
		static $yy_cmap = array(
 2, 2, 2, 2, 2, 2, 2, 2, 2, 21, 4, 2, 21, 4, 2, 2, 2, 2, 2, 2,
 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 21, 2, 19, 2, 2, 2, 2, 2,
 6, 7, 3, 9, 10, 8, 17, 1, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 12, 2,
 13, 5, 14, 2, 15, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18,
 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 2, 20, 2, 2, 18, 2, 18, 18, 18,
 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18,
 18, 18, 18, 2, 11, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2,
 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2,
 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2,
 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2,
 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2,
 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2,
 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0, 0,);

		static $yy_rmap = array(
 0, 1, 2, 1, 1, 1, 1, 3, 1, 1, 1, 4, 5, 6, 1, 1, 1, 1, 7, 1,
 1, 8, 1, 9, 10, 11, 12, 9, 13, 14, 11, 7, 14, 15, 16,);

		static $yy_nxt = array(
array(
 1, 2, 22, 22, 3, 4, 5, 6, 7, 8, 9, 26, 10, 28, 22, 30, 11, 22, 12, 32,
 22, 3,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1,
),
array(
 -1, 13, -1, 14, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 11, -1, -1, -1,
 -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 11, 27, -1, -1,
 -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 12, -1, 12, -1,
 -1, -1,
),
array(
 -1, 13, 13, 13, -1, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13,
 13, 13,
),
array(
 -1, 21, 21, 21, -1, 21, 21, 21, 21, 21, 21, 21, 21, 21, 18, 21, 21, 21, 21, 21,
 21, 21,
),
array(
 -1, 21, 21, 21, -1, 21, 21, 21, 21, 21, 21, 21, 21, 21, 31, 21, 21, 21, 21, 21,
 21, 21,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 23, -1, -1, -1,
 -1, -1,
),
array(
 -1, 20, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1,
),
array(
 -1, 25, 25, 25, 25, 25, 25, 25, 25, 25, 25, 25, 25, 25, 25, 16, 25, 25, 25, 25,
 25, 25,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 15, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 21, -1, -1, -1, -1, -1, -1,
 -1, -1,
),
array(
 -1, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 17,
 34, 29,
),
array(
 1, 19, 19, 24, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19,
 19, 19,
),
array(
 -1, 29, 29, 29, -1, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29,
 29, 29,
),
);

	public function /*Yytoken*/ nextToken ()
 {
		$yy_anchor = self::YY_NO_ANCHOR;
		$yy_state = self::$yy_state_dtrans[$this->yy_lexical_state];
		$yy_next_state = self::YY_NO_STATE;
		$yy_last_accept_state = self::YY_NO_STATE;
		$yy_initial = true;

		$this->yy_mark_start();
		$yy_this_accept = self::$yy_acpt[$yy_state];
		if (self::YY_NOT_ACCEPT != $yy_this_accept) {
			$yy_last_accept_state = $yy_state;
			$this->yy_mark_end();
		}
		while (true) {
			if ($yy_initial && $this->yy_at_bol) $yy_lookahead = self::YY_BOL;
			else $yy_lookahead = $this->yy_advance();
			$yy_next_state = self::$yy_nxt[self::$yy_rmap[$yy_state]][self::$yy_cmap[$yy_lookahead]];
			if ($this->YY_EOF == $yy_lookahead && true == $yy_initial) {
				return null;
			}
			if (self::YY_F != $yy_next_state) {
				$yy_state = $yy_next_state;
				$yy_initial = false;
				$yy_this_accept = self::$yy_acpt[$yy_state];
				if (self::YY_NOT_ACCEPT != $yy_this_accept) {
					$yy_last_accept_state = $yy_state;
					$this->yy_mark_end();
				}
			}
			else {
				if (self::YY_NO_STATE == $yy_last_accept_state) {
					throw new Exception("Lexical Error: Unmatched Input.");
				}
				else {
					$yy_anchor = self::$yy_acpt[$yy_last_accept_state];
					if (0 != (self::YY_END & $yy_anchor)) {
						$this->yy_move_end();
					}
					$this->yy_to_mark();
					switch ($yy_last_accept_state) {
						case 1:
							
						case -2:
							break;
						case 2:
							{ /*skip*/ }
						case -3:
							break;
						case 3:
							{}
						case -4:
							break;
						case 4:
							{ return $this->createToken(VIParser::TK_EQUALS); }
						case -5:
							break;
						case 5:
							{ return $this->createToken(VIParser::TK_LBRACKET); }
						case -6:
							break;
						case 6:
							{ return $this->createToken(VIParser::TK_RBRACKET); }
						case -7:
							break;
						case 7:
							{ return $this->createToken(VIParser::TK_MINUS); }
						case -8:
							break;
						case 8:
							{ return $this->createToken(VIParser::TK_PLUS); }
						case -9:
							break;
						case 9:
							{ return $this->createToken(VIParser::TK_COMA); }
						case -10:
							break;
						case 10:
							{ return $this->createToken(VIParser::TK_COLON); }
						case -11:
							break;
						case 11:
							{ return $this->createToken(VIParser::TK_NUMBER); }
						case -12:
							break;
						case 12:
							{ return $this->createToken(VIParser::TK_IDENTIFIER); }
						case -13:
							break;
						case 13:
							{ /* do nothing on comments*/ }
						case -14:
							break;
						case 14:
							{ $this->yybegin(self::COMMENT); }
						case -15:
							break;
						case 15:
							{ return $this->createToken(VIParser::TK_OR); }
						case -16:
							break;
						case 16:
							{
								$tok = $this->createToken(VIParser::TK_CSS);
								$tok->value = substr($tok->value,1,-1);		//trim @ characters
								return $tok;
							}
						case -17:
							break;
						case 17:
							{
									$tok = $this->createToken(VIParser::TK_STRING);
									$tok->value = substr($tok->value,1,-1);		//trim " characters
									return $tok;
								}
						case -18:
							break;
						case 18:
							{
								$tok = $this->createToken(VIParser::TK_HTML);
								$tok->value = substr($tok->value,2,-2);		//trim << and >>
								return $tok;
							}
						case -19:
							break;
						case 19:
							{ }
						case -20:
							break;
						case 20:
							{ $this->yybegin(self::YYINITIAL); }
						case -21:
							break;
						case 22:
							{ /*skip*/ }
						case -22:
							break;
						case 23:
							{ return $this->createToken(VIParser::TK_NUMBER); }
						case -23:
							break;
						case 24:
							{ }
						case -24:
							break;
						case 26:
							{ /*skip*/ }
						case -25:
							break;
						case 28:
							{ /*skip*/ }
						case -26:
							break;
						case 30:
							{ /*skip*/ }
						case -27:
							break;
						case 32:
							{ /*skip*/ }
						case -28:
							break;
						default:
						$this->yy_error('INTERNAL',false);
					case -1:
					}
					$yy_initial = true;
					$yy_state = self::$yy_state_dtrans[$this->yy_lexical_state];
					$yy_next_state = self::YY_NO_STATE;
					$yy_last_accept_state = self::YY_NO_STATE;
					$this->yy_mark_start();
					$yy_this_accept = self::$yy_acpt[$yy_state];
					if (self::YY_NOT_ACCEPT != $yy_this_accept) {
						$yy_last_accept_state = $yy_state;
						$this->yy_mark_end();
					}
				}
			}
		}
	}
}
