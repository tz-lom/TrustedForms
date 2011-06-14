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
    
    public function toJScode(ParceEnvironment $env)
    {
        $check = '\\TrustedForms\\ValueChecks\\'.$this->name;
        
        $obj->validators = array();
        $obj->code = '';
        
        if($check::jsValidator===NULL)
        {
            return NULL;
        }
        else
        {
            $obj->validators[$this->name] = '.register({name:'.json_encode($this->name).',validator:function(value,config){'.$check::jsValidator.'}})';
            $reporters = array();
            $reportersOut = $this->reporters?$this->reporters:$env->defaultReporter;
            foreach($reportersOut as $reporter)
            {
                $reporters[] = $reporter->toJScode($env);
            }

            $obj->code = array(
                'test'      => $this->name,
                'arguments' => $this->params,
                'error'     => $reporters
            );
        }
        return $obj;
    }
    
    public function toPHPcode(ParceEnvironment $env)
    {
        $code = '->addToChain(';
        
        $params = $this->varExport($this->params,$env);
		$code .= "new \\TrustedForms\\ValueChecks\\{$this->name}($params)";
        
        $reporters = $this->reporters?$this->reporters:$env->defaultReporter;
        return $code.$this->reportersToPHPcode($reporters,$env).')';
    }
    
    protected function reportersToPHPcode($reporters,ParceEnvironment $env)
    {
        if(count($reporters)==0) return '';
        $code = ", \\TrustedForms\\FormErrorReporter::instance()";
        $json = array();
        foreach($reporters as $reporter)
        {
            $code.= $reporter->toPHPcode($env);
            $json[] = $reporter->toJScode($env);
        }
        $code.='->setJSONdescription('.var_export(json_encode($json),true).')';
        return $code;
    }
    
    public function varExport($var,ParceEnvironment $env)
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
                        function(&$var) use($t,$env){
                            $var = $t->varExport($var,$env);
                        }
                );
                return 'array('.implode(',', $var).')';
            default:
                return $var->toPHPcode($env);
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

