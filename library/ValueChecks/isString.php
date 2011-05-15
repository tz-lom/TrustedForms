<?php

namespace TrustedForms\ValueChecks;

class IsString extends \TrustedForms\ValidationChainItem
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

