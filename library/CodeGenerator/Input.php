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
	protected $element;

    public function __construct($name,$form,$element)
    {
        $this->name = $name;
        $this->form = $form;
		$this->element = $element;
    }
	
	public function addCommand($cmd)
	{
		$this->commands[] = $cmd;
	}
	
	abstract public function __toString();
}
