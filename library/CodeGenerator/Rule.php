<?php

namespace TrustedForms\CodeGenerator;

/**
 *
 * @author tz-lom
 */
abstract class Rule
{
	protected $reporter = NULL;
	protected $params;
	protected $name;

	public function __construct($name,$params)
	{
		$this->name = $name;
		$this->params = $params;
	}
    
    public function getName()
    {
        return $this->name;
    }
	
	public function addReporter( $reporter)
	{
		$this->reporter = $reporter;
	}
    
    public function isDefaultReporter()
    {
        return $this->reporter==NULL;
    }
	
	abstract public function __toString();

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
                return (string)$var;
        }
    }
}
