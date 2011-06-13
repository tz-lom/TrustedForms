<?php
/**
 * @version 0.0.2
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator\AbstractTree;

class Form
{
    protected $name;
    protected $var = NULL;
    protected $enableJSvalidation = true;
    protected $rpcServer = '/jsonrpc/validate.php';
    protected $fields = array();

    public function __construct($name)
    {
        $this->name;
    }
    
    public function addField(Field $field)
    {
        $this->fields[] = $field;
    }
    
    public function setRpcServer($server)
    {
        $this->rpcServer = $server;
    }
    
    public function setVar($var)
    {
        $this->var = $var;
    }
    
    public function getVar()
    {
        return $this->var;
    }
    
    public function toPHPcode(\TrustedForms\CodeGenerator\TemplateManipulator &$tpl)
    {
        $code = "{$this->var} = new \\TrustedForms\\FormValidator();\n";
        $tpl->setFormContainer($this->var);
        foreach($this->fields as $field)
        {
            $code .= $field->toPHPcode($this,$tpl);
        }
        return $code;
    }
    
    public function toJScode()
    {
        $obj->code = '';
        $obj->validators = array();
        foreach($this->fields as $field)
        {
            $descr = $field->toJScode();
            $obj->code.= $descr->code;
            $obj->validators = array_merge($obj->validators,$descr->validators);
        }
        return $obj;
    }
}

