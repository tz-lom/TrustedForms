<?php

namespace TrustedForms\ValueChecks;

class isLengthNumeric extends \TrustedForms\ValidationChainItem
{
    /**
     *
     *In $this->config[0] must be set the maximum amount of numeric symbols. If $value is not numeric or numerical line, the method will return "false".
     *
     * @param mixed $value
     * @return bool 
     */
    protected function doProcess(&$value)
	{
	if (is_numeric($value)) {
		return (strlen($value)<=$this->config[0])? true : false;
	}
	else {
		return false;
	}
    }
}
