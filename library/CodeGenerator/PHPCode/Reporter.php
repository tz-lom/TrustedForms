<?php

namespace TrustedForms\CodeGenerator\PHPCode;

class Reporter extends \TrustedForms\CodeGenerator\Reporter
{
    public function __toString()
    {
        $code = "\\TrustedForms\\FormErrorReporter::instance()";
        foreach($this->flags as $flag=>$value)
        {
            $value = var_export($value,true);
            $code.="->addFlag('{$flag}',{$value})";
        }
        return $code;
    }
    
    public function toJScode()
    {
        $ret = array();
		foreach($this->sources as $error)
			if($error['action']=='message')
			{
				$ret[] = array(
					'element'   => $error['target'],
					'type'      => 'message',
					'argument'  => $error['value']
				);
			}
			else
			{
				if($error['cmd']=='add')
				{
					$ret[] = array(
						'element'   => $error['target'],
						'type'      => 'addClass',
						'argument'  => $error['class']
					);
				}
				if($error['cmd']=='remove')
				{
					$ret[] = array(
						'element'   => $error['target'],
						'type'      => 'removeClass',
						'argument'  => $error['class']
					);
				}
			}
		return $ret;
    }
}