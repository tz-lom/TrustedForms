<?php

namespace TrustedForms\ValueChecks;

/**
 * Determines that this field is nesessary
 */
class required extends \TrustedForms\ValidationChainItem
{
    const jsValidator = ' return {value:value,passed:true};';
    
    public function doProcess(&$value)
	{
		return !($value instanceof \TrustedForms\Exceptions\ValueNotExists);
	}
}
