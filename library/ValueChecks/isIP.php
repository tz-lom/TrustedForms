<?php

namespace TrustedForms\ValueChecks;

class isIP extends \TrustedForms\ValidationChainItem
{
    /**
     *
     * @param mixed $value
     * @return bool 
     */
    const jsValidator = 'var ipv4 = /^(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(\\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}/;
function testIpv6(ip){
  return /^[a-f0-9:]+$/i.test(ip) &&       // limit allowed chars
         (ip.indexOf(":")>=0) &&         // there must be colon
         (ip.indexOf(":::")==-1) &&      // there cannot be more than 2 colons in row 
         (!/::.+::/.test(ip)) &&         // and more than one double colons
         (!/[a-f0-9]{5}/.test(ip)) &&    // blocks are up to 4 octets
         (ip.match(/[a-f0-9]{1,4}/g).length<=8) &&      // not more than  groups
         (!/(^:[^:])|([^:]:$)/.test(ip)); // cannot starts or ends with single colon
}
if(config.length==0) return {value:value, passed:(ipv4.test(value)||testIpv6(value))};
for(var i in config) { 
  switch (config[i]) {
    case "IPv4":
      if(ipv4.test(value)) return {value:value, passed:true};
      break;
    case "IPv6":
      if(testIpv6(value)) return {value:value, passed:true};
      break;
  }
}
return {value:value, passed:false};';

    protected function doProcess(&$value)
	{
        $flag = 0;
        foreach($this->config as $flagvalue)
        {
            switch($flagvalue)
            {
                case 'IPv4':
                    $flag = $flag | FILTER_FLAG_IPV4;	
                break;
                case 'IPv6':
                    $flag = $flag | FILTER_FLAG_IPV6;
                    break;
            }	
        }
        if(($flag & ( FILTER_FLAG_IPV4|FILTER_FLAG_IPV6 ))==( FILTER_FLAG_IPV4|FILTER_FLAG_IPV6 ))
        {
            // due to bug in PHP<5.4, with  both flags raised check works unstable , but without any of them - all works as desired
            $flag = $flag ^(FILTER_FLAG_IPV4|FILTER_FLAG_IPV6);
        }
        return (bool)(filter_var($value, FILTER_VALIDATE_IP, $flag));
    }
}
