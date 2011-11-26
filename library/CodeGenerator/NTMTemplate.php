<?php
/**
 * @version 0.2
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator;

class NTMTemplate implements TemplateManipulator
{
    /**
     * @var \NTM
     */
    protected $ntm;

    /**
     * @var \DOMNodeList
     */
    protected $instructions;

    /**
     * @var integer
     */
    protected $currentInstruction;

    /**
     * @var string
     */
    protected $formContainer = '';

    /**
     * @var array[string]
     */
    protected $flagCache = array();

    public function  setHTML($html)
    {
        $this->ntm = new \NTM($html);
        $this->instructions = $this->ntm->getXPath()->query('//comment()');
        $this->currentInstruction = 0;
    }

    public function getHTML()
    {
        return $this->ntm->getHTML();
    }

    protected function getInstruction()
    {
        $i = $this->instructions->item($this->currentInstruction);
        
        if($i==NULL) return NULL;
        return $i->textContent;
    }

    public function firstInstruction()
    {
        $this->currentInstruction = 0;
        return $this->getInstruction();
    }

    public function nextInstruction()
    {
        $this->currentInstruction++;
        return $this->getInstruction();
    }

    public function removeInstruction()
    {
        $i = $this->instructions->item($this->currentInstruction);
        $i->parentNode->removeChild($i);
    }

    public function setFormContainer($fc)
    {
        $this->formContainer = $fc;
    }

    public function addValueReplacement($field,$form)
    {
        $selector = $form?('form[name="'.$form.'"] [name="'.$field.'"]'):('[name="'.$field.'"]');
        $name = var_export($field,true);
        
        $el = $this->ntm->getElementsByCSS($selector);        
        $el = $el[0];
    
        if($el->tagName =='input')
        {
            $val = $el->getAttribute('value');
            $el->setAttribute('value',$this->ntm->encodeMarkdown("<?php if({$this->formContainer}[{$name}]->isChecked()) { if({$this->formContainer}[{$name}]->isCorrect()) { echo {$this->formContainer}[{$name}]->value(); } else { echo htmlentities({$this->formContainer}[{$name}]->inputValue()); } } else { ?>{$val}<?php } ?>"));
        }
        if($el->tagName=='textarea')
        {
            $val = $el->textContent;
            $el->textContent = $this->ntm->encodeMarkdown("<?php if({$this->formContainer}[{$name}]->isChecked()) { echo {$this->formContainer}[{$name}]->value(); } else { ?>{$val}<?php } ?>");
        }
        if($el->tagName=='select')
        {
            $opts = $this->ntm->getElementsByCSS('option',$el);
            foreach($opts as $opt)
            {
                if($opt->getAttribute('selected')!==NULL)
                {
                    $opt->removeAttribute('selected');
                    $value = $opt->getAttribute('value');
                    if($value===NULL)
                    {
                        $value = $opt->innerHTML;
                    }
                    $value = var_export($value,true);
                    $opt->setAttribute($this->ntm->encodeMarkdown("<?php if({$this->formContainer}[{$name}]->isChecked()) { if({$this->formContainer}[{$name}]->value()==$value) echo ' selected '; } else { echo ' selected ';} ?>"));
                }
                else
                {
                    $value = $opt->getAttribute('value');
                    if($value===NULL)
                    {
                        $value = $opt->innerHTML;
                    }
                    $value = var_export($value,true);
                    $opt->setAttribute($this->ntm->encodeMarkdown("<?php if({$this->formContainer}[{$name}]->isChecked() && ({$this->formContainer}[{$name}]->value()==$value)) echo ' selected '; ?>"));                    
                }
            }
            
        }
    }

    public function addMessageToElement($css)
    {
        $flag = $this->getFlagName('msg', "message@$css",$fromCache);
        $flag = var_export($flag,true);
        if(!$fromCache)
        {
            $el = $this->ntm->getElementsByCSS($css);
            $el = $el[0];
            $el->textContent.= $this->ntm->encodeMarkdown("<?php echo {$this->formContainer}->getFlag({$flag}); ?>");
        }
        return $flag;
    }

    public function addClassToElement($css,$class)
    {
        $flag = $this->getFlagName('clsAdd', "+$class@$css",$fromCache);
        if(!$fromCache)
        {
            $flag = var_export($flag,true);
            $class = var_export($class,true);
            $els = $this->ntm->getElementsByCSS($css);
            foreach($els as $el)
            {
                $ca = $el->getAttribute('class');
                $el->setAttribute('class',$ca.' '.$this->ntm->encodeMarkdown("<?php if({$this->formContainer}->isFlag({$flag})) echo {$class}; ?>"));
            }
        }
        return $flag;
    }

    public function removeClassFromElement($css,$class)
    {
        $flag = $this->getFlagName('clsRemove', "-$class@$css",$fromCache);
        if(!$fromCache)
        {
            $flag = var_export($flag,true);
            $class = var_export($class,true);

            $els = $this->ntm->getElementsByCSS($css);
            foreach($els as $el)
            {
                $ca = $el->getAttribute('class');
                
                if(strpos($ca,$class)===NULL) continue;
                
                $ca = str_replace($class, '', $ca);
                $ca.= $this->ntm->encodeMarkdown("<?php if(! {$this->formContainer}->isFlag({$flag})) echo {$class}; ?>");
                $el->setAttribute('class',$ca);
            }
        }
        return $flag;
    }

    protected function getFlagName($prefix,$shortHash,&$takenFromCache)
    {
        if(isset($this->flagCache[$shortHash]))
        {
            $takenFromCache = true;
            return $prefix.$this->flagCache[$shortHash];
        }
        $id = end(array_values($this->flagCache));
        $id = $id+1;
        $this->flagCache[$shortHash] = $id;
        $takenFromCache = false;
        return $prefix.$id;
    }
    
    public function getAllForms()
    {
        $ret = array();
        foreach($this->ntm->getElementsByCSS('form') as $form)
        {
            $ret[] = $form->getAttribute('name');
        }
        return $ret;
    }
    
    public function appendJSvalidator($validator)
    {
        if($validator)
        {
            $el = $this->ntm->getDOM()->createElement('script',$validator);
            $el->setAttribute('type','text/javascript');
            $this->ntm->getRoot()->appendChild($el);
        }
    }
}
