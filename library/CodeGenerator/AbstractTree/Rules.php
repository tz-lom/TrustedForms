<?php
/**
 * @version 0.0.2
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator\AbstractTree;

class Rules
{
    protected $rules = array();

    public function addCheck($r)
    {
        $this->rules[] = $r;
        return $this;
    }

    static public function instance()
    {
        return new self;
    }
}
