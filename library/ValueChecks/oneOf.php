<?php

namespace TrustedForms\ValueChecks;

class oneOf extends \TrustedForms\ValidationChainItem
{
	protected function doProcess(&$value)
	{
        $val = $value;
		foreach($this->config as $variant)
        {
            if(! $variant instanceof \TrustedForms\VariableValidator)
                return false;
            $variant->setValue($val);
            if($variant->isCorrect())
            {
                $value = $variant->value();
                return true;
            }
        }
        return false;
	}
	
	const jsValidator = 'for(var t=0;t<config.length;t++){
    var res = {value: value, passed: true};
    for(var i=0; res.passed && i<config[t].length;i++){
        res = this.validators[config[t][i].test].call(this,res.value,config[t][i].arguments);
        if(res.passed){
            return res;
        }
    }
}
return {value:value, passed: false};';
}
