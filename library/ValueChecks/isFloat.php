<?php

namespace TrustedForms\ValueChecks;

class isFloat extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    const jsValidator = "return { value: value, passed: value.match(/^[+-]?[0-9]+\.{1}[0-9]+$/)? true: false }";
	
    protected function doProcess(&$value)
	{
        if (preg_match('/^[+-]?[0-9]+\.{1}[0-9]+$/',$value)) {
		settype($value,"float");		
		return true;
	} else {
		return false;
	}
    }
}
