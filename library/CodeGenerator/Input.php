<?php
/**
 * @version 0.0.1
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator;

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
