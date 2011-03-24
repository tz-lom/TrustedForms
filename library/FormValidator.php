<?php

namespace TrustedForms;

/**
 * Description of FormValidator
 *
 * @author tz-lom
 */
class FormValidator extends \TrustedForms\ArrayValidator
{
    protected $flags = array();

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
