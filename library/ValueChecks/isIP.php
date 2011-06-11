<?php

namespace TrustedForms\ValueChecks;

class isIP extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    const jsValidator = '
function isIP(value,flag) {

	if (flag.length === 0) { 
		return (value.match(^([a-f0-9]{1,4})(?>:(?1)){5}:(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(?>\.(?2)){3}$/i)); 
	} else if (flag.length === 1)  {
		switch(flag[0]) {
				case "FLAG_IPV4":
				case "IS_IPV4":
				case "PROOF_IPV4":
				return value.match(/^(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(?>\.(?1)){3}$/);
			 	break;

				case "PROOF_IPV6":
				case "IS_IPV6":
				case "FLAG_IPV6":
				return value.match(^(?!(?:.*[a-f0-9](?>:|$)){8,})(([a-f0-9]{1,4})(?>:(?2)){0,6})?::(?1)?$/i); 
				break;
				}
	}
}
	return { value:value, isIP(value,config) }';

    protected function doProcess(&$value)
	{
	if (count($this->config) === 1) {
	 switch ($this->config[0]) {

		case 'FLAG_IPV4':
		case 'IS_IPV4':
		case 'PROOF_IPV4':
		return (bool)(filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4));
	 	break;

		case 'PROOF_IPV6':
		case 'IS_IPV6':
		case 'FLAG_IPV6':
		return (bool)(filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6));
		break;
	 
		}
	
	} elseif (count($this->config) === 0) {

	        return (bool)(filter_var($value, FILTER_VALIDATE_IP));		
	} 
    }
}
