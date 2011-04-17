#!/bin/bash

echo "===	Generate lexer"
java -cp ../../3dparty/JLexPHP/JLexPHP.jar JLexPHP.Main instructions.lex
echo
echo "===	Generate parser"
../../3dparty/lemon-php/lemon -LPHP -m instructions.y
