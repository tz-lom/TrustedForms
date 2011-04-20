<?php

namespace TrustedForms\CodeGenerator\PHPCode;

class CodeWriter implements \TrustedForms\CodeGenerator\CodeWriter
{
	public function newInput()
	{
		return new Input();
	}
	
	public function newReporter()
	{
		return new Reporter();
	}
	
	public function newRule($name,$param)
	{
		return new Rule($name,$param);
	}
}