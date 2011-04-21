<?php

namespace TrustedForms\CodeGenerator\PHPCode;

class Reporter extends \TrustedForms\CodeGenerator\Reporter
{
    public function __toString()
    {
        $code = "\\TrustedForms\\FormErrorReporter::instance()";
        foreach($this->flags as $flag=>$value)
        {
            $value = var_export($value,true);
            $code.="->addFlag('{$flag}',{$value})";
        }
        return $code;
    }
}
