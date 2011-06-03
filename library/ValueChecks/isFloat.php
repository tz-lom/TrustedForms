<?php

namespace TrustedForms\ValueChecks;

class isFloat extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    const jsValidator = "function is_float (numb) { return typeof numb == 'number' && numb != ~~numb; } return { value:value, passed: is_float(value) }";
	
    protected function doProcess(&$value)
	{
        return is_float($value);
    }
}
