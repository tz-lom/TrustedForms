<?php
/**
 * @version 0.0.1
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator\PHPCode
 */

namespace TrustedForms\CodeGenerator\PHPCode;

class CodeWriter implements \TrustedForms\CodeGenerator\CodeWriter
{
	public function newInput($name,$form,$element)
	{
		return new \TrustedForms\CodeGenerator\PHPCode\Input($name,$form,$element);
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
        $jsCode = '';
        if(count($tests)>0)
        {
            $jsCode = "TrustedForms";
            foreach($tests as $test)
            {
                $clsName = '\\TrustedForms\\ValueChecks\\'.$test;
                $jsCode.='.register({name:'.json_encode($test).',validator:function(value,config){'.$clsName::jsValidator.'}})';
            }
            $jsCode.=";\n";
        }
        $jsCode.=$validators;
        return $jsCode;
	}
	
}