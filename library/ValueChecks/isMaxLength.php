<?php

namespace TrustedForms\ValueChecks;
/**
 *In $this->config[0] must be set the maximum amount of symbols 
 *
 * @param mixed $value
 * @return bool 
 *
 */
class isMaxLength extends \TrustedForms\ValidationChainItem
{
 
    const jsValidator = 'return {value:value,passed: value.length<=config[0] }';

    protected function doProcess(&$value)
    {
    return strlen($value)<=$this->config[0];
    }
}
