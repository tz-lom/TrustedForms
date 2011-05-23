<?php

namespace TrustedForms\ValueChecks;

/**
 * Checks whether the number is in desired range
 * @param lower bound
 * @param upper bound
 */
class inRange extends \TrustedForms\ValidationChainItem
{
	const jsValidator = 'return {value:value,passed:parseFloat(config[0])<=value && value<=parseFloat(config[1])}';
	
	protected function doProcess(&$value)
	{
		return ( $this->config[0] <= $value  && $value <= $this->config[1]);
	}

}
