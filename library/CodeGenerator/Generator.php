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

	public function __construct(TemplateManipulator $tpl,CodeWriter $writer)
	{
		$this->tpl = $tpl;
		$this->writer = $writer;
	}
	
	public function addInputCheck($definition)
	{
		// get name of input
		$name = $this->tpl->getNameOfElement($definition['element']);
		
		foreach($definition['rules'] as $rule)
		{
			$this->parceRule($rule);
		}
	}
	
	protected function parceRule($rule)
	{
		// process error reporter
		
		if($rule['reporter']!=NULL)
		{
			//parce reporter 
			$reporter = $this->parceReporter($rule['reporter']);
		}
		else	
		{
			$reporter = NULL;
		}
		
		if($rule['rule']['name']=='||')
		{
			// special OR rule
			
		}
	}
	
	protected function parceReporter($reporter)
	{
		$reporter = $this->writer->newReporter();
		
		foreach($reporter as $notify)
		{
			if($notify['action']=='message')
			{
				//print message
				$id = $this->tpl->addMessageToElement($notify['target']);
				$reporter->addFlag($id);
			}
			else
			{
				//class manipulation
				$id = $this->tpl->addClassToElement
			}
		}
	}
}