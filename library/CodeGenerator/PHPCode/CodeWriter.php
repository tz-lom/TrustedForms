<?php

namespace TrustedForms\CodeGenerator\PHPCode;

class CodeWriter implements \TrustedForms\CodeGenerator\CodeWriter
{
	public function newInput($name)
	{
		return new \TrustedForms\CodeGenerator\PHPCode\Input($name);
	}
	
	public function newReporter()
	{
		return new \TrustedForms\CodeGenerator\PHPCode\Reporter();
	}
	
	public function newRule($name,$param)
	{
		return new \TrustedForms\CodeGenerator\PHPCode\Rule($name,$param);
	}
}