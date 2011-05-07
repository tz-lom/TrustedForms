<?php

namespace TrustedForms\ValueChecks;

class IsIPV4 extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    protected function doProcess(&$value)
	{
        return (bool)(filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4));
    }
}
?>
