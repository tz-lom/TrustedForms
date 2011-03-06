<?php

namespace TrustedForms\ValueTransformers;
/**
 * Description of Trim
 *
 * @author tz-lom
 */
class Trim extends \TrustedForms\ValidationChainItem
{
	public function process($value)
	{
		return trim($value);
	}
}

