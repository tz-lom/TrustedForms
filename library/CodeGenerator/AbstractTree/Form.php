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
    protected $defaultErrorReporter = array();
    protected $prefixRules = NULL;
    protected $postfixRules = NULL;

    public function __construct($name)
    {
        $this->name;
    }
    
    public function addField(Field $field)
    {
        if($this->prefixRules)  $field->addPrefixRules($this->prefixRules);
        if($this->postfixRules) $field->addPostfixRules($this->postfixRules);
        $this->fields[] = $field;
    }
    
    public function setRpcServer($server)
    {
        $this->rpcServer = $server;
    }
    
    public function getRpcServer()
    {
        return $this->rpcServer;
    }
    
    public function setVar($var)
    {
        $this->var = $var;
    }
    
    public function getVar()
    {
        return $this->var;
    }
    
    public function enableJS($bool)
    {
        $this->enableJSvalidation = $bool;
    }
    
    public function setDefaultErrorReporter($reporter)
    {
        $this->defaultErrorReporter = $reporter;
    }
    
    public function toPHPcode(ParceEnvironment $env)
    {
        $env->form = &$this;
        $env->defaultReporter = $this->defaultErrorReporter;
        
        $postfix = '';
        $code = '';
        
        if(substr($this->var,0,6)=='class ')
        {                   
            $class = ltrim(trim(substr($this->var,6)),'\\');
            
            if($pos = strrpos($class,'\\'))
            {
                $code = 'namespace '.substr($class,0,$pos)." {\n";
                $postfix = "}\n";
                $class = substr($class,$pos+1);
            }
            
            $code.= "class $class extends \\TrustedForms\\FormValidator\n{\n\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n";
            
            $env->tpl->setFormContainer('$this');    
            
            $var = $this->var;
            $this->var = '$this';
            
            foreach($this->fields as $field)
            {
                $code.= "\t\t".$field->toPHPcode($env);
            }
            
            $this->var = $var;
            
            $code.= "\t}\n}\n";
            
            return $code.$postfix;
        }
        else
        {
            $code = "{$this->var} = new \\TrustedForms\\FormValidator();\n";
            $env->tpl->setFormContainer($this->var);

            foreach($this->fields as $field)
            {
                $code .= $field->toPHPcode($env);
            }
            
            
            
            return $code;
        }
    }
    
    public function toJScode(ParceEnvironment $env)
    {
        $obj = new \stdClass();
        $obj->code = '';
        $obj->validators = array();        
        
        if(!$this->enableJSvalidation) return $obj;
        
        $env->form = &$this;
        $env->defaultReporter = $this->defaultErrorReporter;
        
        foreach($this->fields as $field)
        {
            $descr = $field->toJScode($env);
            $obj->code.= $descr->code;
            $obj->validators = array_merge($obj->validators,$descr->validators);
        }
        return $obj;
    }
    
    public function setPrefixRules(Rules $rules)
    {
        $this->prefixRules = $rules;
    }
    
    public function setPostfixRules(Rules $rules)
    {
        $this->postfixRules = $rules;
    }
}

