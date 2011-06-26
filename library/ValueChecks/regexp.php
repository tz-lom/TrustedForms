<?php

namespace TrustedForms\ValueChecks;

/**
 * Checks if value matches regexp
 * @param regexp
 * @param optional individual JS regexp
 * 
 */
class regexp extends \TrustedForms\ValidationChainItem
{    
    protected  function doProcess(&$value)
    {
        if(empty($this->config[0])) return false;
        return preg_match($this->config[0], $value)>0;
    }
    
    const jsValidator = 'var regexp = config[1]?config[1]:config[0];
        var sep = regexp[0];
        var psep = regexp.indexOf(sep,1);
        while((p = regexp.indexOf(sep,psep+1)) >0) { psep = p; }
        var mod = regexp.slice(psep+1);
        regexp = regexp.slice(1,psep);
        return {value:value,passed: (new RegExp(regexp,mod)).test(value)};';
}
