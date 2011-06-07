<?php
/**
 * @version 0.0.1
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator\PHPCode
 */

namespace TrustedForms\CodeGenerator\PHPCode;

class Input extends \TrustedForms\CodeGenerator\Input
{
	public function __toString()
	{
		$code = "{$this->form}['{$this->name}'] = \TrustedForms\VariableValidator::instance()";
        foreach($this->commands as $cmd)
        {
            $code.="\n\t->";

            if($cmd instanceof \TrustedForms\CodeGenerator\Reporter)
            {
                $code.="addReporter({$cmd})";
            }
            if($cmd instanceof \TrustedForms\CodeGenerator\Rule)
            {
                $code.="addToChain({$cmd})";
            }
        }
        $code.=";\n";
        return $code;
	}
    
    public function getAllTestNames()
    {
        $res = array();
        foreach($this->commands as $cmd)
        {
            if($cmd instanceof \TrustedForms\CodeGenerator\Rule)
            {
                $clsName = '\\TrustedForms\\ValueChecks\\'.$cmd->getName();
                if(!$clsName::jsValidator) return array();
                $res[$cmd->getName()]= true;
            }
        }
        return array_keys($res);
    }
    
    public function toJScode($generator)
    {
        //test if all validators have JS realisation
        $allHaveJS = true;
        foreach($this->commands as $cmd)
        {
            if($cmd instanceof \TrustedForms\CodeGenerator\Rule)
            {
                $clsName = '\\TrustedForms\\ValueChecks\\'.$cmd->getName();
                if(!$clsName::jsValidator)
                {
                    $allHaveJS = false;
                    break;
                }
            }
        }
        
        if(!$allHaveJS)
        {
            $rpc = $generator->getFormRPC($this->element);
            
            $input = array(
                'element' => $this->element ,
                'tests' => array(
                    'test'      => 'rpcTest',
                    'arguments' => array($rpc,$this->name),
                    'error'     => array()
                )
            );
            return "TrustedForms.check(".  json_encode($input).");\n";
        }
        
        $input = array('element' => $this->element , 'tests' => array());
        $reporter = array();
        foreach($this->commands as $cmd)
        {
            if($cmd instanceof \TrustedForms\CodeGenerator\Reporter)
            {
                $reporter = $cmd;
            }
            if($cmd instanceof \TrustedForms\CodeGenerator\Rule)
            {
                if($cmd->isDefaultReporter())
                {
                    $c = clone $cmd;
                    $c->addReporter($reporter);
                    $input['tests'][] = $c->toJScode();
                }
                else
                {
                    $input['tests'][] = $cmd->toJScode();
                }
            }
        }
        return "TrustedForms.check(".json_encode($input).");\n";
    }
}

