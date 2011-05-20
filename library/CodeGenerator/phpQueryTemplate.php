<?php

namespace TrustedForms\CodeGenerator;

class phpQueryTemplate implements TemplateManipulator
{
    /**
     * @var phpQueryObject
     */
    protected $pq;

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
        $this->pq = \phpQuery::newDocumentPHP($html);
        $xpath = new \DOMXPath($this->pq->getDOMDocument());
        $this->instructions = $xpath->query('//comment()');
        $this->currentInstruction = 0;
    }

    public function setPHPQuery(&$pq)
    {
        $this->pq = $pq;
    }

    public function getHTML()
    {
        return $this->pq->php();
    }

    protected function getInstruction()
    {
        $i = $this->instructions->item($this->currentInstruction);
        if($i==NULL) return NULL;
        return substr(pq($i)->html(),4,-3);
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
        pq($this->instructions->item($this->currentInstruction))->remove();
    }

    public function setFormContainer($fc)
    {
        $this->formContainer = $fc;
    }


    public function getNameOfElement($css)
    {
        return $this->pq->find($css)->attr('name');
    }

    public function addValueReplacement($name)
    {
        /**
         * @todo lookup for escape codes
         */
        $el = $this->pq->find("[name=$name]");
        
        $name = str_replace("'", "\\'", $name);
        if($el->is('input'))
        {
            $val = $el->attr('value');
            $el->attrPHP('value',"if({$this->formContainer}['{$name}']->isChecked()) { echo {$this->formContainer}['{$name}']->value(); } else { ?>{$val}<?php }");
        }
        if($el->is('textarea'))
        {
            $val = $el->html();
            $el->php("if({$this->formContainer}['{$name}']->isChecked()) { echo {$this->formContainer}['{$name}']->value(); } else { ?>{$val}<?php }");
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
        if(!$fromCache)
        {
            $el = $this->pq->find($css);
            $el->appendPHP("echo {$this->formContainer}->getFlag('{$flag}');");
        }
        return $flag;
    }

	public function addClassToElement($css,$class)
    {
        $flag = $this->getFlagName('clsAdd', "+$class@$css",$fromCache);
        if(!$fromCache)
        {
            $this->pq->find($css)->addClassPHP("if({$this->formContainer}->isFlag('{$flag}')) echo '{$class}';");
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
                    $pq->addClassPHP("if(! {$this->formContainer}->isFlag('{$flag}')) echo '{$class}';");
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
        return $this->pq->find('form')->elements;
    }
    
    public function compareElements($a,$b)
    {
        return $a->isSameNode($b);
    }
    
    public function getFormForElement($css)
    {
        $el = $this->pq->find($css);
        $form = $el->parent('form');
        return $form->elements[0];
    }
    
    public function isForm($css)
    {
        return $this->pq->find($css)->is('form');
    }
    
    public function getElement($css)
    {
        return $this->pq->find($css)->elements[0];
    }
	
	public function appendJSvalidator($validator)
	{
		$this->pq->append(pq("<script type=\"text/javascript\">\n$validator\n</script>"));
	}
}
