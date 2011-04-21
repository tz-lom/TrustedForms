<?php

namespace TrustedForms\CodeGenerator;

/**
 *
 * @author tz-lom
 */
abstract class Reporter
{
	protected $flags = array();
	
	public function addFlag($name,$value=NULL)
	{
		$this->flags[$name] = $value;
	}
	
	abstract public function __toString();
}
