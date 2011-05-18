<?php

namespace TrustedForms\CodeGenerator;

/**
 *
 * @author tz-lom
 */
abstract class Reporter
{
	protected $flags = array();
    /**
     *
     * @var array[action,cmd,target,value,class] 
     * @todo: remaster this shity array, it is awful
     */
    protected $sources = NULL;
	
	public function addFlag($name,$value=NULL)
	{
		$this->flags[$name] = $value;
        return $this;
	}
    
    public function addSourceNotify($notify)
    {
        $this->sources[] = $notify;
        return $this;
    }
	
	abstract public function __toString();
}
