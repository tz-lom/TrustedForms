<?php

namespace TrustedForms\ValueChecks;

/**
 * Is not actual validator, but forces server-side validation
 * 
 */
class onServer extends \TrustedForms\ValidationChainItem
{    
    protected  function doProcess(&$value)
    {
        return true;
    }
}
