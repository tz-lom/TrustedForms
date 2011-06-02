<?php

namespace TrustedForms\ValueChecks;

class isInteger extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    const jsValidator = "function is_integer (numb) { return typeof numb == 'number' && numb == ~~numb; } return { value:value, passed: is_integer(value) }";

    protected function doProcess(&$value)
	{
        return is_integer($value);
    }
}

