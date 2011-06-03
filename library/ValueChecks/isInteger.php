<?php

namespace TrustedForms\ValueChecks;

class isInteger extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    const jsValidator = " function to_numeric(value) {
	if (value !== '' && Number(value) || value == 0) { 
		if (typeof Number(value) == 'number' && value == Math.round(value)) {
			if (parseInt(value) === 0) {
				return true;
			} else {
				return Number(value);
			}
		} else { 
			return false;
		} 
	} else {
		return false;		
	}
}
 return { value: to_numeric(value), passed: to_numeric(value)? true : false }";

    protected function doProcess(&$value)
	{
        return is_integer($value);
    }
}
