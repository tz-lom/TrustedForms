<?php

namespace TrustedForms\ValueChecks;
/**
 * Removes empty symbols from begin and and of string
 */
class trim extends \TrustedForms\ValidationChainItem
{
    protected function doProcess(&$value)
    {
        $value = trim($value);
        return true;
    }
    
    const jsValidator = 'return {value:value.trim(), passed:true};';
}

