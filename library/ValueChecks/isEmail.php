<?php

namespace TrustedForms\ValueChecks;

class isEmail extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    protected function doProcess(&$value)
	{
        return (bool)(filter_var($value, FILTER_VALIDATE_EMAIL));
    }
}
