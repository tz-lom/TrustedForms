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
    
    /**
     *
     * @var array
     */
    protected $js = array();
    
    protected $forms = array();
	
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
    
    public function prepare()
    {
        $forms = $this->tpl->getAllForms();
        foreach($forms as $form)
        {
            $this->forms[] = array('element'=>$form,'name'=>NULL,'outJScode'=>true);
        }
        if(count($this->forms)==1)
        {
            $this->forms[0]['name']='$form';
        }
    }
    
    protected function getFormId($el)
    {
        foreach($this->forms as $i=>$form)
        {
            if($this->tpl->compareElements($form['element'],$el))
            {
                return $i;
            }
        }
        return NULL;
    }
    
    protected function getFormName($el)
    {
        $form = $this->getFormId($el);
        return ($form!==NULL)?$this->forms[$form]['name']:NULL;
    }


    public function addInputCheck($definition)
	{
        if($this->tpl->isForm($definition['element']))
        {
            //this is form
            $form = &$this->forms[$this->getFormId($this->tpl->getElement($definition['element']))];
            //parse params for this form
            foreach($definition['rules'] as $rule)
            {
                switch($rule['rule']['name'])
                {
                    case 'name':
                        $form['name'] = $rule['rule']['params'][0];
                        break;
                    case 'enableJS':
                        $form['outJScode'] = (bool) $rule['rule']['params'][0];
                        break;
                    default :
                        // show error message
                        echo 'Invalid form parameter:',$rule['rule']['name'],"\n";
                }
            }
			
        }
        else
        {
            // get name of input
            $name = $this->tpl->getNameOfElement($definition['element']);
            $formName = $this->getFormName($this->tpl->getFormForElement($definition['element']));
            $this->tpl->setFormContainer($formName);
            
            $this->tpl->addValueReplacement($name);
            $input = $this->writer->newInput($name,$formName);
            
            foreach($definition['rules'] as $rule)
            {
                $input->addCommand($this->parceRule($rule));
            }
            $this->inputs[] = $input;
			
			// @todo: add JS validation
			
			$form = $this->getFormId($definition['element']);
			
			$this->js[] = new $this->writer->newJSvalidation($form['css'],$definition['element'],$defenition['rules']);
			
        }
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
            $rep->addFlag($flag,$value)->addSourceNotify($notify);
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
        foreach($this->forms as $form)
        {
            $code.=$this->writer->formDefinition($form['name']);
        }
        foreach($this->inputs as $input)
        {
            $code.=(string)$input;
        }
        $jscode = '';
        $tests = array();
        foreach($this->js as $js)
        {
            $tests = array_merge($tests,$js->getAllTestNames());
            $jscode.=$js->toJScode();
        }        
        $code .= $this->writer->includeJSvalidators(array_unique($tests),$jscode);
        return $code;
    }

    public function defaultErrorReport($params,$reporter)
    {
        return $reporter;
    }
}
