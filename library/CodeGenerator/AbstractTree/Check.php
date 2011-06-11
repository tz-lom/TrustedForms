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
    protected $reporters;
    
    public function __construct($name,$params=array())
    {
        $this->params = $params;
        $this->name = $name;
    }
    
    public function addReporters($reporters)
    {
        $this->reporters = $reporters;
        return $this;
    }
}

