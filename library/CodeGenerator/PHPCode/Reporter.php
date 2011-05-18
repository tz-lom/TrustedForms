<?php

namespace TrustedForms\CodeGenerator\PHPCode;

class Reporter extends \TrustedForms\CodeGenerator\Reporter
{
    public function __toString()
    {
        $code = "\\TrustedForms\\FormErrorReporter::instance()";
        foreach($this->flags as $flag=>$value)
        {
            $value = var_export($value,true);
            $code.="->addFlag('{$flag}',{$value})";
        }
        return $code;
    }
    
    public function toJScode()
    {
        $ret = array();
        if($this->source['action']=='message')
        {
            return array(
                'element'   => $this->source['target'],
                'type'      => $this->source['message'],
                'argument'  => $this->source['value']
            );
        }
        else
        {
            if($this->source['cmd']=='add')
            {
                return array(
                    'element'   => $this->source['target'],
                    'type'      => $this->source['addClass'],
                    'argument'  => $this->source['class']
                );
            }
            if($this->source['cmd']=='remove')
            {
                return array(
                    'element'   => $this->source['target'],
                    'type'      => $this->source['removeClass'],
                    'argument'  => $this->source['class']
                );
            }
        }
    }
}
