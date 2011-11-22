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
        $i = NULL;
       
        // i hope this will work
        for(;
            $i = $this->instructions->item($this->currentInstruction);
            $this->currentInstruction++ );
        
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
        $el = $this->pq->find($selector);
        
        $name = var_export($field,true);
        if($el->is('input'))
        {
            $val = $el->attr('value');
            $el->attrPHP('value',"if({$this->formContainer}[{$name}]->isChecked()) { if({$this->formContainer}[{$name}]->isCorrect()) { echo {$this->formContainer}[{$name}]->value(); } else { echo htmlentities({$this->formContainer}[{$name}]->inputValue()); } } else { ?>{$val}<?php }");
        }
        if($el->is('textarea'))
        {
            $val = $el->html();
            $el->php("if({$this->formContainer}[{$name}]->isChecked()) { echo {$this->formContainer}[{$name}]->value(); } else { ?>{$val}<?php }");
        }
        if($el->is('select'))
        {
            // @todo: Невозможно реализовать на phpQuery (убогий)
            //$def = $el->find('option [selected]');
            //$def->attrPHP('selected', "if({$this->formContainer[{$name}])")
        }
    }

    public function addMessageToElement($css)
    {
        $flag = $this->getFlagName('msg', "message@$css",$fromCache);
        $flag = var_export($flag,true);
        if(!$fromCache)
        {
            $el = $this->pq->find($css);
            $el->appendPHP("echo {$this->formContainer}->getFlag({$flag});");
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
            $this->pq->find($css)->addClassPHP("if({$this->formContainer}->isFlag({$flag})) echo {$class};");
        }
        return $flag;
    }

    public function removeClassFromElement($css,$class)
    {
        $flag = $this->getFlagName('clsRemove', "-$class@$css",$fromCache);
        if(!$fromCache)
        {
            foreach($this->pq->find($css) as $el)
            {
                $pq = pq($el);
                if($pq->hasClass($class))
                {
                    $pq->removeClass($class);
                    $flag = var_export($flag,true);
                    $class = var_export($class,true);
                    $pq->addClassPHP("if(! {$this->formContainer}->isFlag({$flag})) echo {$class};");
                }
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
        foreach($this->pq->find('form') as $form)
        {
            $ret[] = pq($form)->attr('name');
        }
        return $ret;
    }
    
    public function appendJSvalidator($validator)
    {
        if($validator)
            $this->pq->append(pq("<script type=\"text/javascript\">\n$validator\n</script>"));
    }
}
