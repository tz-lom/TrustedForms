<?php

namespace TrustedForms\ValueChecks;

class isFloat extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    const jsValidator = "
 function is_float(value) {
	if (value !== '' && Number(value)) { 
		if (typeof Number(value) == 'number' && value != Math.round(value)) {
				return value;
			}
		} else { 
			return false;
		} 
	} else {
		return false;		
	}
}
 return { value: is_float(value), passed: is_float(value)? true : false }";
	
    protected function doProcess(&$value)
	{
        return is_float($value);
    }
}
