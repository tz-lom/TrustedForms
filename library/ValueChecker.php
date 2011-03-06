<?php

namespace TrustedForms;

/**
 * Performs control of variable
 */
abstract class ValueChecker extends \TrustedForms\ValidationChainItem
{
    /**
     * @param mixed $value
     * @return bool
     */
    abstract protected function performCheck($value);

    /**
     *
     * @param mixed $value
     * @return bool
     */
    public function process($value)
    {
		parent::process($value);
        if(!$this->performCheck($value))
		{
			$this->reportError($value);
		}
		return $value;
    }
}

