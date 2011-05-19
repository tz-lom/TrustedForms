<?php

namespace TrustedForms\ValueChecks;

class isInteger extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    protected function doProcess(&$value)
	{
        return is_integer($value);
    }
}
