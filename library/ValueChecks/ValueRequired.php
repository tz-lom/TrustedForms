<?php

namespace TrustedForms\ValueChecks;

class ValueRequired extends \TrustedForms\ValidationChainItem
{
	/**
	 *
	 * @param mixed $value
	 * @return bool
	 */
    public function doProcess(&$value)
	{
		return !($value instanceof \TrustedForms\Exceptions\ValueNotExists);
	}
}

