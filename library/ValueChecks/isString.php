<?php

namespace TrustedForms\ValueChecks;

class isString extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    protected function doProcess(&$value)
	{
        return is_string($value);
    }
}
