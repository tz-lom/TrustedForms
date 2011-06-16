<?php

namespace TrustedForms\ValueChecks;

/**
 * Checks whether the number is in desired range
 * @param lower bound
 * @param upper bound
 */
class inRange extends \TrustedForms\ValidationChainItem
{
    const jsValidator = 'var v=parseFloat(value);return {value:value,passed:isNaN(v)?false:(parseFloat(config[0])<=v && v<=parseFloat(config[1]))}';
    
    protected function doProcess(&$value)
    {
    if (count($this->config) != 2) {
        return false;
    }
        if(!is_numeric($value)) return false;
        return ( $this->config[0] <= $value  && $value <= $this->config[1]);
    }

}
