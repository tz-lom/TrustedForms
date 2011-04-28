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

	/**
	 * @var array
	 */
	protected $inputs = array();
	
	
    protected $specialRules =   array(
                                    '||' => 'specOrRule',
                                    'defaultErrorReport' => 'defaultErrorReport',
                                    '' => ''
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

        $input = $this->writer->newInput($name);
		foreach($definition['rules'] as $rule)
		{
			$input->addCommand($this->parceRule($rule));
		}
		$this->inputs[] = $input;
	}
	
	protected function parceRule($rule)
	{
		$reporter = $this->parceReporter($rule['reporter']);

        if(isset($this->specialRules[$rule['rule']['name']]))
        {
            // call rule with params
            $rule = $this->{$this->specialRules[$rule['rule']['name']]}($rule['rule']['params'],$reporter);
        }
        else
        {
            $rule = $this->writer->newRule($rule['rule']['name'],$rule['rule']['params']);
            $rule->addReporter($reporter);
        }
        return $rule;
	}
	
	protected function parceReporter($reporter)
	{
		if($reporter==NULL) return NULL;
        $rep = $this->writer->newReporter();
		
		foreach($reporter as $notify)
		{
            $value = '';
			if($notify['action']=='message')
			{
				//print message
				$flag = $this->tpl->addMessageToElement($notify['target']);
                $value = $notify['value'];
			}
			else
			{
				//class manipulation
                if($notify['cmd']=='add')
                {
                    $flag = $this->tpl->addClassToElement($notify['target'],$notify['class']);
                }
                if($notify['cmd']=='remove')
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

    public function generateFile()
    {
        $code = '';
        foreach($this->inputs as $input)
        {
            $code.=(string)$input;
        }
        return $code;
    }

    public function defaultErrorReport($params,$reporter)
    {
        return $reporter;
    }
}
