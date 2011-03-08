<?php

namespace TrustedForms\ValueChecks;

class IsNumeric extends \TrustedForms\ValidationChainItem
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
}

