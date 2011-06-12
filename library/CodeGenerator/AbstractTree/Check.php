<?php
/**
 * @version 0.0.2
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator\AbstractTree;

class Check
{
    protected $name;
    protected $params;
    protected $reporters = array();
    
    public function __construct($name,$params=array())
    {
        $this->params = $params;
        $this->name = $name;
    }
    
    static public function instance($name,$params = array())
    {
        return new static($name,$params);
    }


    public function addReporters($reporters)
    {
        $this->reporters = $reporters;
        return $this;
    }
    
    public function toJScode()
    {
        $reporters = array();
        foreach($this->reporters as $reporter)
        {
            $reporters[] = $reporter->toJScode();
        }
        
        return array(
            'test'      => $this->name,
            'arguments' => $this->params,
            'error'     => $reporters
        );
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getParams()
    {
        return $this->params;
    }
    
    public function getReporters()
    {
        return $this->reporters;
    }
}

