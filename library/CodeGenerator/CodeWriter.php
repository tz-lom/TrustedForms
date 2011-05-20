<?php

namespace TrustedForms\CodeGenerator;

interface CodeWriter
{
    public function newReporter(); // reporter must have addFlag($flag,$value);
	public function newRule($name,$param);
	public function newInput($name,$form,$element);
	public function formDefinition($name);
	//public function newJSvalidation($form,$element,$rules);
}
