<?php
/**
 * @version 0.0.2
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator\AbstractTree\Reporters;

class AddClass extends \TrustedForms\CodeGenerator\AbstractTree\Reporter
{
    protected $class;
    
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }
    
    public function toJScode()
    {
		return array(
						'element'   => $this->element,
						'type'      => 'addClass',
						'argument'  => $this->class
					);
    }
    
    public function toPHPcode(\TrustedForms\CodeGenerator\TemplateManipulator &$tpl)
    {
        $code = '->addFlag(';
        $code.= var_export($tpl->addClassToElement($this->element, $this->class),true);
        return $code.",'')";
    }
}

