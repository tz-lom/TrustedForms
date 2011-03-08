<?php

namespace TrustedForms\ValueTransformers;
/**
 * Description of Trim
 *
 * @author tz-lom
 */
class Trim extends \TrustedForms\ValidationChainItem
{
	protected function doProcess(&$value)
	{
		$value = trim($value);
		return true;
	}
}

