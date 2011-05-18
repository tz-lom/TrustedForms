<?php

namespace TrustedForms\CodeGenerator\PHPCode;

class CodeWriter implements \TrustedForms\CodeGenerator\CodeWriter
{
	public function newInput($name,$form)
	{
		return new \TrustedForms\CodeGenerator\PHPCode\Input($name,$form);
	}
	
	public function newReporter()
	{
		return new \TrustedForms\CodeGenerator\PHPCode\Reporter();
	}
	
	public function newRule($name,$param)
	{
		return new \TrustedForms\CodeGenerator\PHPCode\Rule($name,$param);
	}
	
	public function formDefinition($name)
	{
		return "{$name} = new \\TrustedForms\\FormValidator();\n";
	}
	
	public function includeJSvalidators($tests,$validators)
	{
        $jsCode = "\n<script type=\"text/javascript\">\nTrustedForms";
		foreach($tests as $test)
        {
            $clsName = '\\TrustedForms\\ValueChecks\\'.$test;
            $c = new $clsName;
            //@todo: add support of undefined JS validators
            $jsCode.='.register(name:'.json_encode($test).',validator:function(value,config){'.$c->jsValidator.'})';
        }
        $jsCode.="\n";
        $jsCode.=$validators;
        return $jsCode."\n</script>\n";
	}
	
}