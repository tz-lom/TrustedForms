<?php

namespace TrustedForms\ValueChecks;

/**
 * Checks if value can be transformed to float
 * Perform type cast if it possible
 */
class asFloat extends \TrustedForms\ValidationChainItem
{
    const jsValidator = "return { value: value, passed: value.match(/^[+-]?[0-9]+(\.[0-9]+)?(e[+-]?[0-9]+)?$/i) }";
	
    protected function doProcess(&$value)
	{
        if(preg_match('/^[+-]?[0-9]+(\.[0-9]+)?(e[+-]?[0-9]+)?$/i',$value))
        {
            settype($value,"float");		
            return true;
        }
        else
        {
            return false;
        }
    }
}
