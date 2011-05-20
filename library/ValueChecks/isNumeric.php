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
	
	const jsValidator = 'return {value:value,passed:/^[+-]?\d+(\.\d+(e[+-]?\d+)?)?$|^0x[0-9a-f]+$/i.test(value)};';
}
