<?php
/**
 * @version 0.0.1
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */
namespace TrustedForms\CodeGenerator;

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
