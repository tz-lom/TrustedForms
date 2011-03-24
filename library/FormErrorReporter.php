<?php

namespace TrustedForms;

/**
 * Carry information about changes to form
 *
 * @author tz-lom
 */
class FormErrorReporter extends \TrustedForms\ErrorReporter
{
    protected $flags = array();

    public function addFlag($flagName,$value=NULL)
    {
        $this->flags[$flagName] = $value;
    }

    public function getFlags()
    {
        $ret = $this->flags;
        array_walk($ret,
                function(&$value,$key,$message){
                    if($value===NULL)
                    {
                        $value = $message;
                    }
                },
                $this->getMessage());
        return $ret;
    }
}
