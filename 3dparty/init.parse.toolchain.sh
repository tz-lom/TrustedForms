#!/bin/bash

git clone https://github.com/wez/JLexPHP.git
git clone https://github.com/tz-lom/lemon-php.git

cd JLexPHP
make
cd ../lemon-php
make
