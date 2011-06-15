<?php

namespace TrustedForms\ValueChecks;

/**
 * Checks if value can be transformed to integer
 * Perform type cast if it possible
 */
class asInteger extends \TrustedForms\ValidationChainItem
{
    const jsValidator = " return { value: value, passed: value.match(/^[+-]?[0-9]+\.?[0]*$/) }";

    protected function doProcess(&$value)
	{
        if(preg_match('/^[+-]?[0-9]+\.?[0]*$/',$value))
        {
            settype($value,"integer");		
            return true;	
        }
        else
        {
            return false;
        }
    }
}
