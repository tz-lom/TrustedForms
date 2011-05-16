<?php

namespace TrustedForms\CodeGenerator\PHPCode;

class CodeWriter implements \TrustedForms\CodeGenerator\CodeWriter
{
	public function newInput($name,$form)
	{
		return new \TrustedForms\CodeGenerator\PHPCode\Input($name,$form);
	}
	
	public function newReporter()
	{
		return new \TrustedForms\CodeGenerator\PHPCode\Reporter();
	}
	
	public function newRule($name,$param)
	{
		return new \TrustedForms\CodeGenerator\PHPCode\Rule($name,$param);
	}
	
	public function formDefinition($name)
	{
		return "{$name} = new \\TrustedForms\\FormValidator();\n";
	}
	
	public function newJSvalidation($form,$element,$rules)
	{
		
	}
	
}