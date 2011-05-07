<?php
$test = new \TrustedForms\FormValidator();
$test['data'] = \TrustedForms\VariableValidator::instance()
	->addReporter(\TrustedForms\FormErrorReporter::instance()->addFlag('msg1','me-err'))
	->addToChain(new \TrustedForms\ValueChecks\IsNumeric(array(),\TrustedForms\FormErrorReporter::instance()->addFlag('msg2',' message ')->addFlag('clsAdd3','')));
