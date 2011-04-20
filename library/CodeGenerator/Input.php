<?php

namespace TrustedForms\CodeGenerator;

/**
 *
 * @author tz-lom
 */
class Input
{
	protected $rules = array();
	
	public function addRule(\TrustedForms\CodeGenerator\Rule $rule)
	{
		$this->rules[] = $rule;
	}
	
	abstract public function __toString();
}
