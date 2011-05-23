<?php
/**
 * @version 0.0.1
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms
 */

namespace TrustedForms;

class FormValidator extends \TrustedForms\ArrayValidator
{
    protected $flags = array();
	/**
	 * It is very useful, you can call checkArray without mentioning is form displayed first or not
	 */
	protected $skipEmptyArray = true;

    public function setFlag($flagName,$value=NULL)
    {
        $this->flags[$flagName] = $value;
    }

    public function setFlags($flags)
    {
        $this->flags  = array_merge($this->flags,$flags);
    }

    public function isFlag($flagName)
    {
        return array_key_exists($flagName, $this->flags);
    }

    public function clearFlags()
    {
        $this->flags = array();
    }

    public function getFlag($flagName)
    {
        return isset($this->flags[$flagName])?$this->flags[$flagName]:NULL;
    }

    public function checkArray($array)
    {
        $this->clearFlags();
        if(parent::checkArray($array)) return true;
        foreach($this->getErrors() as $error)
        {
            if($error instanceof \TrustedForms\FormErrorReporter)
            {
                $this->setFlags($error->getFlags());
            }
        }
        return false;
    }
}
