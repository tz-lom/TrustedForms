<?php

namespace TrustedForms\ValueChecks;

class isNumeric extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    protected function doProcess(&$value)
	{
        return is_numeric($value);
    }
	
	const jsValidator = 'return {value:value,passed:/^\d+$/.test(value)};';
}
