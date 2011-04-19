<?php

namespace TrustedForms\CodeGenerator;

class Generator
{
	/**
	 * @var TemplateManipulator
	 */
	protected $tpl;
	protected $writer;
	
	/**
	 * @var string
	 */
	protected $fieldName;

    protected $specialRules =   array(
                                    '||' => 'specOrRule'
                                );

	public function __construct(TemplateManipulator $tpl,CodeWriter $writer)
	{
		$this->tpl = $tpl;
		$this->writer = $writer;
	}
	
	public function addInputCheck($definition)
	{
		// get name of input
		$name = $this->tpl->getNameOfElement($definition['element']);
        $this->tpl->addValueReplacement($name);

        $input = $this->writer->newInput();
		foreach($definition['rules'] as $rule)
		{
			$input->addRule($this->parceRule($rule));
		}
	}
	
	protected function parceRule($rule)
	{
		$reporter = $this->parceReporter($rule['reporter']);

        if(in_array($rule['name'],$this->specialRules))
        {
            // call rule with params
            $rule = $this->{$this->specialRules[$rule['name']]}($rule['params'],$reporter);
        }
        else
        {
            $rule = $this->writer->newRule($rule['name'],$rule['params']);
            $rule->addReporter($reporter);
        }
        return $rule;
	}
	
	protected function parceReporter($reporter)
	{
		$rep = $this->writer->newReporter();
		if($rep==NULL) return $rep;
		foreach($reporter as $notify)
		{
            $value = '';
			if($notify['action']=='message')
			{
				//print message
				$flag = $this->tpl->addMessageToElement($notify['target']);
                $value = $notify['message'];
			}
			else
			{
				//class manipulation
                if($notify['add'])
                {
                    $flag = $this->tpl->addClassToElement($notify['target'],$notify['class']);
                }
                if($notify['remove'])
                {
                    $flag = $this->tpl->removeClassFromElement($notify['target'],$notify['class']);
                }
			}
            $rep->addFlag($flag,$value);
		}
        return $rep;
	}

    protected function specOrRule($params,$reporter)
    {
        foreach($params as &$rule)
        {
            $rule = $this->parceRule($rule);
        }
        return $this->writer->newRule('paramOr',$params);
    }
}