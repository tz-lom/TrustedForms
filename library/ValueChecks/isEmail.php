<?php

namespace TrustedForms\ValueChecks;

class IsEmail extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    protected function doProcess(&$value)
	{
        return (bool)(preg_match("/\S+@[a-zA-Z]{3,20}\.[a-zA-Z]{2,10}/is", $value));
    }
}
