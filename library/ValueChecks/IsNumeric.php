<?php

namespace TrustedForms\ValueChecks;

class IsNumeric extends \TrustedForms\ValueChecker
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    protected function performCheck($value)
    {
        return is_numeric($value);
    }
}

