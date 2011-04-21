<?php

namespace TrustedForms\CodeGenerator;

class phpQueryTemplate implements TemplateManipulator
{
    /**
     * @var phpQueryObject
     */
    protected $pq;

    /**
     * @var string
     */
    protected $formContainer = '$form';

    /**
     * @var array[string]
     */
    protected $flagCache = array();

    public function  setHTML($html)
    {
        $this->pq = \phpQuery::newDocumentPHP($html);
    }

    public function setPHPQuery($pq)
    {
        $this->pq = $pq;
    }

    public function getHTML()
    {
        return $this->pq->php();
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
        $val = $el->attr('value');
        /**
         * @todo not only inputs can be affected
         */
        $el->attrPHP('value',"if({$this->formContainer}[{$name}]->haveValue()) { echo {$this->formContainer}[{$name}]->value(); } else { ?>{$val}<?php }");
    }

	public function addMessageToElement($css)
    {
        $flag = $this->getFlagName('msg', "message@$css");
        $el = $this->pq->find($css);
        $el->appendPHP("echo {$this->formContainer}->getFlag('{$flag}');");
        return $flag;
    }

	public function addClassToElement($css,$class)
    {
        $flag = $this->getFlagName('clsAdd', "+$class@$css");
        $this->pq->find($css)->addClassPHP("if({$this->formContainer}->isFlag('{$flag}')) echo '{$class}';");
        return $flag;
    }

	public function removeClassFromElement($css,$class)
    {
        $flag = $this->getFlagName('clsRemove', "-$class@$css");
        foreach($this->pq->find($css) as $el)
        {
            $pq = pq($el);
            if($pq->hasClass($class))
            {
                $pq->removeClass($class);
                $pq->addClassPHP("if(! {$this->formContainer}->isFlag('{$flag}')) echo '{$class}';");
            }
        }
        return $flag;
    }

    protected function getFlagName($prefix,$shortHash)
    {
        if(isset($this->flagCache[$shortHash]))
        {
            return $prefix.$this->flagCache[$shortHash];
        }
        $id = end(array_values($this->flagCache));
        $id = $id+1;
        $this->flagCache[$shortHash] = $id;
        return $prefix.$id;
    }
}
