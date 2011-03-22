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

    public function addFlag($flagName)
    {
        $this->flags[] = $flagName;
    }

    public function getFlags()
    {
        return $this->flags;
    }
}
