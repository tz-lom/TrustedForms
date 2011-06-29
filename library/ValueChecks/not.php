<?php

namespace TrustedForms\ValueChecks;

/**
 * Passes if one of validator chains in params passes
 * return value from first non-fail validator chains
 * 
 * @param validation chain
 * @param validation chain
 * [@param validation chain, ...]
 */
class not extends \TrustedForms\ValidationChainItem
{
    protected function doProcess(&$value)
    {
        if(count($this->config)<1) return false;
        
        if(! $this->config[0] instanceof \TrustedForms\VariableValidator)
                return false;
        $this->config[0]->setValue($value);
        return !$this->config[0]->isCorrect();
        
    }
    
    const jsValidator = 'var res = {value: value, passed: true};
    for(var i=0; res.passed && i<config[0].length;i++){
        res = this.validators[config[0][i].test].call(this,res.value,config[0][i].arguments);
        if(!res.passed){
            return {value:value, passed: true};
        }
    }
return {value:value, passed: false};';
}
