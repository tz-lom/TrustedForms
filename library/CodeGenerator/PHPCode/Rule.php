<?php
/**
 * @version 0.0.1
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator\PHPCode
 */

namespace TrustedForms\CodeGenerator\PHPCode;

class Rule extends \TrustedForms\CodeGenerator\Rule
{
    public function __toString()
    {
        $params = $this->varExport($this->params);
		$str = "new \\TrustedForms\\ValueChecks\\{$this->name}($params)";
        if($this->reporter)
        {
            $str .= ",{$this->reporter}";
        }
        return $str;
    }
    
    public function toJScode()
    {
        return array(
            'test'      => $this->name,
            'arguments' => $this->params,
            'error'     => ($this->reporter)?$this->reporter->toJScode():array()
        );
    }
}
