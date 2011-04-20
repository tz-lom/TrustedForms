<?php

namespace TrustedForms\CodeGenerator;

/**
 *
 * @author tz-lom
 */
class Rule
{
	protected $reporter = NULL;
	protected $params;
	protected $name;

	public function __construct($name,$params)
	{
		$this->name = $name;
		$this->params = $params;
	}
	
	public function addReporter(\TrustedForms\CodeGenerator\Reporter $reporter)
	{
		$this->reporter = $reporter;
	}
	
	abstract public function __toString();
}
