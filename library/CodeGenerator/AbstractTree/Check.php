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
    
    public function toPHPcode(\TrustedForms\CodeGenerator\TemplateManipulator &$tpl, $inheritedReporters)
    {
        $code = '->addToChain(';
        
        $params = $this->varExport($this->params);
		$code .= "new \\TrustedForms\\ValueChecks\\{$this->name}($params)";
        
        $reporters = $this->reporters?$this->reporters:$inheritedReporters;
        return $code.','.$this->reportersToPHPcode($reporters,$tpl);
    }
    
    protected function reportersToPHPcode($reporters,\TrustedForms\CodeGenerator\TemplateManipulator &$tpl)
    {
        $code = "\\TrustedForms\\FormErrorReporter::instance()";
        $json = array();
        foreach($reporters as $reporter)
        {
            $code.= $reporter->toPHPcode($tpl);
            $json[] = $reporter->toJScode();
        }
        $code.='->setJSONdescription('.var_export(json_encode($json),true).')';
        return $code;
    }
    
    public function varExport($var)
    {
        switch(gettype($var))
        {
            case 'string':
                return "'$var'";
            case 'boolean':
                return $var?'true':'false';
            case 'array':
                $t = $this;
                array_walk($var,
                        function(&$var) use($t){
                            $var = $t->varExport($var);
                        }
                );
                return 'array('.implode(',', $var).')';
            default:
                return $var->toPHPcode();
        }
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

