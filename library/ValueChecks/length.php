<?php

namespace TrustedForms\ValueChecks;
/**
 * Checks if string length less or equal param
 * @param max length
 */
class length extends \TrustedForms\ValidationChainItem
{
 
    const jsValidator = 'return {value:value,passed: value.length<=config[0] }';

    protected function doProcess(&$value)
    {
        return strlen($value)<=$this->config[0];
    }
}
