<?php

namespace TrustedForms\ValueChecks;

class isURL extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */

   const jsValidator = "return { value:value, 
passed: value.match(/^(?:http|ftp|https):\/\/((([a-z]+\.)?[a-z0-9-=-]+\.[a-z]{2,5})|(\d{3}\.\d{3}\.\d{3}\.\d{3}))(:[0-9]+)?([/a-z0-9?&%=-]+)?$/i) }";

    protected function doProcess(&$value)
	{
        return (bool)(filter_var($value, FILTER_VALIDATE_URL));
    }
}

