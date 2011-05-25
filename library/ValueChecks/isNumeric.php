<?php

namespace TrustedForms\ValueChecks;

/**
 * Checks if parameter can be represented as number
 */
class isNumeric extends \TrustedForms\ValidationChainItem
{
    protected function doProcess(&$value)
	{
        return is_numeric($value);
    }
	
	const jsValidator = 'return {value:value,passed:/^[+-]?\d+(\.\d+(e[+-]?\d+)?)?$|^0x[0-9a-f]+$/i.test(value)};';
}
