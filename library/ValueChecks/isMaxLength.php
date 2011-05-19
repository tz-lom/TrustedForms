<?php

namespace TrustedForms\ValueChecks;

class isMaxLength extends \TrustedForms\ValidationChainItem
{
    /**
     *In $this->config[0] must be set the maximum amount of symbols 
     *
     * @param mixed $value
     * @return bool 
     *
     */
    protected function doProcess(&$value)
	{
	return (strlen($value)<=$this->config[0])? true : false;
    }
}
