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

    public function setFlag($flagName)
    {
        $this->flags = array_merge($this->flags,(array)$flagName);
    }

    public function isFlag($flagName)
    {
        return in_array($flagName, $this->flags);
    }

    public function clearFlags()
    {
        $this->flags = array();
    }

    public function checkArray($array)
    {
        $this->clearFlags();
        if(parent::checkArray($array)) return true;
        foreach($this->getErrors() as $error)
        {
            if($error instanceof \TrustedForms\FormErrorReporter)
            {
                $this->setFlag($error->getFlags());
            }
        }
        return false;
    }
}
