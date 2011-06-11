<?php
/**
 * @version 0.0.2
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator\AbstractTree;

class Field
{
    protected $css;
    protected $rules;
    
    public function __construct($css, $rules)
    {
        $this->css = $css;
        $this->rules = $rules;
    }
}
