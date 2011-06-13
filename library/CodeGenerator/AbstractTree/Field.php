<?php
/**
 * @version 0.0.2
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator\AbstractTree;

class Field
{
    protected $field;
    protected $form;
    /**
     * @var Rules
     */
    protected $rules;
    
    protected $jsEnabled = true;


    public function __construct($field,$form,Rules $rules)
    {
        $this->field = $field;
        $this->form = $form;
        $this->rules = $rules;
    }
    
    public function getField()
    {
        return $this->field;
    }
    
    public function getForm()
    {
        return $this->form;
    }
    
    public function getRules()
    {
        return $this->rules;
    }


    public function toJScode()
    {
        
    }
    
    public function toPHPcode(Form &$form,\TrustedForms\CodeGenerator\TemplateManipulator &$tpl)
    {
        $tpl->addValueReplacement($this->field); // @todo: and form name too
        $code = "{$form->getVar()}['{$this->field}'] = ";
        $code.= $this->rules->toPHPcode($tpl);
        return $code.";\n";
    }
    
    public function setJSvalidation($bool)
    {
        $this->jsEnabled = $bool;
    }
}
