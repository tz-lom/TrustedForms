<?php
/**
 * @version 0.0.1
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator;

interface CodeWriter
{
    public function newReporter(); // reporter must have addFlag($flag,$value);
	public function newRule($name,$param);
	public function newInput($name,$form,$element);
	public function formDefinition($name);
	//public function newJSvalidation($form,$element,$rules);
}
