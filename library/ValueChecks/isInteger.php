<?php

namespace TrustedForms\ValueChecks;

class isInteger extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    const jsValidator = " return { value: value, passed: value.match(/^[+-]?[0-9]+\.?[0]*$/)? true:false }";

    protected function doProcess(&$value)
	{
        if (preg_match('/^[+-]?[0-9]+\.?[0]*$/',$value)) {
		settype($value,"integer");		
		return true;	
	} else {
		return false;
	}
    }
}
