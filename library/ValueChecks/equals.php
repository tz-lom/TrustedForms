<?php

namespace TrustedForms\ValueChecks;

/**
 * Compares value with etalon
 */
class equals extends \TrustedForms\ValidationChainItem
{
    protected function doProcess(&$value)
    {
        if(!array_key_exists(0,$this->config)) return false;
        return $this->config[0]==$value;
    }
    
    const jsValidator = 'return {value:value, passed:(value==config[0])};';
}

