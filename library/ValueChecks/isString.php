<?php

namespace TrustedForms\ValueChecks;

class isString extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */

    const jsValidator = "function is_string(value) { return (typeof(value) == 'string'); } return { value:value, passed: is_string(value) }";

    protected function doProcess(&$value)
	{
        return is_string($value);
    }
}

