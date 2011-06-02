<?php

namespace TrustedForms\ValueChecks;

class ValueRequired extends \TrustedForms\ValidationChainItem
{
	/**
	 *
	 * @param mixed $value
	 * @return bool
	 */

    const jsValidator = 'return { value:value, passed: true }';

    public function doProcess(&$value)
	{
		return !($value instanceof \TrustedForms\Exceptions\ValueNotExists);
	}
}
