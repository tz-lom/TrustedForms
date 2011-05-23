<?php

namespace TrustedForms\ValueChecks;

class isNumericRange extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * 
     *
     * $this->config[0] - minimum of range
     * $this->config[1] - maximum of range
     *
     *
     *
     * @param mixed $value
     * @return bool 
     */
protected function doProcess(&$value)
{
        if (is_numeric($value)) {
		if ($this->config[0] > $value || $this->config[1] < $value) { return false; }
		else { return true; }
	}
	else {
		return false;
	}	
}

}
