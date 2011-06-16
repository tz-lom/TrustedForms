<?php

namespace TrustedForms\ValueTransformers;
/**
 * Description of ToInteger
 *
 * @author tz-lom
 */
class ToInteger extends \TrustedForms\ValidationChainItem
{
    protected function doProcess(&$value)
    {
        $value = intval($value);
        return true;
    }
}
