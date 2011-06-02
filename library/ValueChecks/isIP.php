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
if (config.length == 2) { 
var flag;
for (config in object) { 

switch (object[config]) {
		case "FLAG_IPV4":
		case "IS_IPV4":
		case "PROOF_IPV4":
		flag = true;
	 	break;

		case "PROOF_IPV6":
		case "IS_IPV6":
		case "FLAG_IPV6":
		flag = true;
		break;
		}
if (flag) {
return {value:value, passed: value.match(^([a-f0-9]{1,4})(?>:(?1)){5}:(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(?>\.(?2)){3}$/iD) } 
}

}

} else  {
switch (config[0]]) {
		case "FLAG_IPV4":
		case "IS_IPV4":
		case "PROOF_IPV4":
		return {value:value, passed: value.match(/^(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(?>\.(?1)){3}$/D) } 
	 	break;

		case "PROOF_IPV6":
		case "IS_IPV6":
		case "FLAG_IPV6":
		return {value:value, passed: value.match(^(?!(?:.*[a-f0-9](?>:|$)){8,})(([a-f0-9]{1,4})(?>:(?2)){0,6})?::(?1)?$/iD) } 
		break;
		}

}';

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
