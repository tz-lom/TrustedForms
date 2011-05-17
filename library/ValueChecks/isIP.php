<?php

namespace TrustedForms\ValueChecks;

class isIP extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    protected function doProcess(&$value)
	{
	$flag = 0;
	foreach ($this->config as $flagvalue) {
	 switch ($flagvalue) {

		case 'FLAG_IPV4':
		case 'IS_IPV4':
		case 'PROOF_IPV4':
		$flag = $flag | FILTER_FLAG_IPV4;	
	 	break;

		case 'PROOF_IPV6':
		case 'IS_IPV6':
		case 'FLAG_IPV6':
		$flag = $flag | FILTER_FLAG_IPV6;
		break;
	 
		}	
	}

        return (bool)(filter_var($value, FILTER_VALIDATE_IP, $flag));
    }
}
