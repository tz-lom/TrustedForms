<?php

namespace TrustedForms\ValueChecks;

class isAvailSymbols extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     *
     *In config[0] - permissible values
     *In value - values
     *
     */
    const jsValidator = "
function symb(symbols,string) {
    for (var i = (string.length - 1); i>=0; i--) {
        if (symbols.indexOf(string.charAt(i)) === -1) {
            return false;
    }
}
    return true;
}

return { value: value, passed: symb(config[0],value) }";

protected function doProcess(&$value) {
    for ($i =  (mb_strlen($value)-1); $i>=0; $i--) {
        if (mb_strpos($this->config[0],mb_substr($value,$i,1)) === false) {
            return false; 
        }
    } 
    return true;
    }
}
