<?php

namespace TrustedForms\CodeGenerator;

/**
 *
 * @author tz-lom
 */
abstract class Input
{
	protected $commands = array();
    protected $form;
    protected $name;

    public function __construct($name,$form='$form')
    {
        $this->name = $name;
        $this->form = $form;
    }
	
	public function addCommand($cmd)
	{
		$this->commands[] = $cmd;
	}
	
	abstract public function __toString();
}
