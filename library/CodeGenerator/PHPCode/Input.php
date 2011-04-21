<?php

namespace TrustedForms\CodeGenerator\PHPCode;

class Input extends \TrustedForms\CodeGenerator\Input
{
	public function __toString()
	{
		$code = "{$this->form}[{$this->name}] = \TrustedForms\VariableValidator::instance()->";
        foreach($this->commands as $cmd)
        {
            $code.="\n\t->";

            if($cmd instanceof \TrustedForms\CodeGenerator\Reporter)
            {
                $code.="addReporter({$cmd})";
            }
            if($cmd instanceof \TrustedForms\CodeGenerator\Rule)
            {
                $code.="addToChain({$cmd})";
            }
        }
        $code.=";\n";
        return $code;
	}
}

