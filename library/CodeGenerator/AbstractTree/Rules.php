<?php
/**
 * @version 0.0.2
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator\AbstractTree;

class Rules
{
    protected $checks = array();

    public function addCheck(Check $check)
    {
        $this->checks[] = $check;
        return $this;
    }
    
    public function addPrefix(Rules $rules)
    {
        $this->checks = array_merge($rules->checks,$this->checks);
    }
    
    public function addPostfix(Rules $rules)
    {
        $this->checks = array_merge($this->checks,$rules->checks);
    }

    static public function instance()
    {
        return new static;
    }
    
    public function getChecks()
    {
        return $this->checks;
    }
    
    public function toJScode(ParceEnvironment $env)
    {
        $obj = new \stdClass();
        $obj->code = array();
        $obj->validators = array();
        foreach($this->checks as $check)
        {
            if($check->getName()=='defaultErrorReport')
            {
                $env->defaultReporter = $check->getReporters();
                continue;
            }
            $descr = $check->toJScode($env);
            if($descr===NULL)
                return NULL;
            
            $obj->validators = array_merge($obj->validators,$descr->validators);
            $obj->code[] = $descr->code;
        }
        return $obj;
    }
    
    public function toPHPcode(ParceEnvironment $env)
    {
        $code = '\TrustedForms\VariableValidator::instance()';
        
        foreach($this->checks as $check)
        {
            if($check->getName()=='defaultErrorReport')
            {
                $env->defaultReporter = $check->getReporters();
                continue;
            }
            $code.=$check->toPHPcode($env);
        }
        
        return $code;
    }
}
