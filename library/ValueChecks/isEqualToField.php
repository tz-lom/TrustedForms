<?php

namespace TrustedForms\ValueChecks;

/**
 * Checks if value in one field equals value in other
 * 
 * @param name of field to compare
 */
class isEqualToField extends \TrustedForms\ValidationChainItem
{
    const jsValidator = 'return {value:value,passed:this.getValue(config[0])==value};';
    
    protected function doProcess(&$value)
    {
        if(empty($this->config[0])) return false;
        $collection = $this->getOwner()->getOwner();
        if(empty($collection[$this->config[0]])) return false;
        if(!$collection[$this->config[0]]->isCorrect()) return false;
        return $collection[$this->config[0]]->value() == $value;
    }
}

