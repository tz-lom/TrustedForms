#!/bin/bash

git clone https://github.com/wez/JLexPHP.git
git clone https://github.com/wez/lemon-php.git

cd JLexPHP
make
cd ../lemon-php
cc -o lemon lemon.c