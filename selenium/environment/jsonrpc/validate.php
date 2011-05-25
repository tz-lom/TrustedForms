<?php

require_once '../../../tests/autoload.php';
require_once '../../../library/CodeGenerator/t.ll.validate.php';

$rpc = new TrustedForms\JSONRPCserver($test);
$rpc->processRPCcall();