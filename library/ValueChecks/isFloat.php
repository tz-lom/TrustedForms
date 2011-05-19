<?php

namespace TrustedForms\ValueChecks;

class isFloat extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    protected function doProcess(&$value)
	{
        return is_float($value);
    }
}
