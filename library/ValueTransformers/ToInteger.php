<?php

namespace TrustedForms\ValueTransformers;
/**
 * Description of ToInteger
 *
 * @author tz-lom
 */
class ToInteger extends \TrustedForms\ValidationChainItem
{
	public function process($value)
	{
		return intval($value);
	}
}
