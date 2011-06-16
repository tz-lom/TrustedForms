<?php

namespace TrustedForms\ValueChecks;

/**
 * Checks if parameter can be represented as number
 */
class isNumeric extends \TrustedForms\ValidationChainItem
{
    const jsValidator = 'function is_numeric( mixed_var ) { return !isNaN( mixed_var ); } return {value:value, passed: is_numeric(value) }';
    
    protected function doProcess(&$value)
    {
        return is_numeric($value);
    }
    
}
