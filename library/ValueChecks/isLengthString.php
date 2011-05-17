<?php

namespace TrustedForms\ValueChecks;

class isLengthString extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    protected function doProcess(&$value)
	{
        if (is_string($value)) {
		return (strlen($value)<=$this->config[0])? true : false;
	}
	else {
		return false;
	}
    }
}
