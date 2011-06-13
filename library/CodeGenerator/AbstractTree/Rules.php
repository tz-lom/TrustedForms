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

    static public function instance()
    {
        return new static;
    }
    
    public function getChecks()
    {
        return $this->checks;
    }
    
    public function toJScode()
    {
        $obj->code = '';
        $obj->validators = array();
        foreach($this->checks as $check)
        {
            $descr = $check->toJScode();
//            $obj->code
        }
    }
    
    public function toPHPcode(\TrustedForms\CodeGenerator\TemplateManipulator &$tpl)
    {
        $code = '\TrustedForms\VariableValidator::instance()';
        
        foreach($this->checks as $check)
        {
            $code.=$check->toPHPcode($tpl,'@todo: change me'); //@todo: correct
        }
        
        return $code;
    }
}
