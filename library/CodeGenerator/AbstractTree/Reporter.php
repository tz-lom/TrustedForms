<?php
/**
 * @version 0.0.2
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator\AbstractTree;

abstract class Reporter
{
    protected $element;
    
    public function __construct($css)
    {
        $this->element = $css;
    }
    
    /**
     * Create object
     * 
     * @param string $css
     * @return self
     */
    static public function instance($css)
    {
        return new static($css);
    }
    
    abstract public function toJScode(ParceEnvironment $env);
    
    abstract public function toPHPcode(ParceEnvironment $env);
}

