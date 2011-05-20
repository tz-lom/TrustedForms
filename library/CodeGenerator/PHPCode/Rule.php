<?php

namespace TrustedForms\CodeGenerator\PHPCode;

class Rule extends \TrustedForms\CodeGenerator\Rule
{
    public function __toString()
    {
        $params = $this->varExport($this->params);
        if($this->reporter)
        {
            $params .= ",{$this->reporter}";
        }
        return "new \\TrustedForms\\ValueChecks\\{$this->name}($params)";
    }
    
    public function toJScode()
    {
        return array(
            'test'      => $this->name,
            'arguments' => $this->params,
            'error'     => $this->reporter->toJScode()
        );
    }
}
