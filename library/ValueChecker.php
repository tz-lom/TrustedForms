<?php
/**
 * @version 0.0.1
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms
 */

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

