<?php
/**
 * @version 0.0.2
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator\AbstractTree\Reporters;

class DisplayMessage extends \TrustedForms\CodeGenerator\AbstractTree\Reporter
{
    protected $text;
    
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }
    
    public function toJScode()
    {
        return array(
					'element'   => $this->element,
					'type'      => 'message',
					'argument'  => $this->text
				);
    }
    
    public function toPHPcode(\TrustedForms\CodeGenerator\TemplateManipulator &$tpl)
    {
        $code = '->addFlag(';
        $code.= var_export($tpl->addMessageToElement($this->element),true);
        $code.= ',';
        $code.= var_export($this->text,true);
        return $code.')';
    }
}

