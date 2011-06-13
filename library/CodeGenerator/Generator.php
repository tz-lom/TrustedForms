<?php
/**
 * @version 0.0.1
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

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
    
    /**
     *
     * @var array[AbstractTree\Form]
     */
    protected $forms = array();
/*	
    protected $inputCommands =  array(
                                    'defaultErrorReport' => 'defaultErrorReport',
                                    'disableJSvalidation' => 'disableJSvalidation'
                                );*/

	public function __construct(TemplateManipulator $tpl,CodeWriter $writer)
	{
		$this->tpl = $tpl;
		$this->writer = $writer;
	}
    
    /**
     * Retrieve some basic info form template
     */
    public function prepare()
    {
        $forms = $this->tpl->getAllForms();
        // check if only one unnamed form (or form with empty name)
        if(count($forms)!=count(array_unique($forms))) throw new \Exception(); // @todo: customize it
        
        foreach($forms as $form)
        {
            $this->forms[$form] = new AbstractTree\Form($form);
        }
        /*if(count($this->forms)==1)
        {
            $this->forms[0]['name']='$form';
        }*/
    }
    /*
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
    
    public function getFormRPC($element)
    {
        $form = $this->forms[$this->getFormId($this->tpl->getFormForElement($element))];
        return $form['rpcServer'];
    }*/

    /**
     * Main entrance from VIParser
     * 
     * @param AbstractTree\Field $definition 
     */
    public function addDefinition(AbstractTree\Field $definition)
	{
        if($definition->getField()=='')
        {
            $this->addFormDescription($definition);
        }
        else
        {
            $this->addFieldDescription($definition);
        }
	}
    
    /**
     *
     * @param AbstractTree\Field $definition 
     */
    protected function addFormDescription(AbstractTree\Field $definition)
    {
        $form = &$this->forms[$definition->getForm()];
        //parse params for this form
        foreach($definition->getRules()->getChecks() as $check)
        {
            switch($check->getName())
            {
                case 'var':
                    $params = $check->getParams();
                    $form->setVar($params[0]);
                    break;
                case 'enableJS':
                    $params = $check->getParams();
                    $form->enableJS((bool) $params[0]);
                    break;
                case 'rpcServer':
                    $params = $check->getParams();
                    $form->setRpcServer($params[0]);
                    break;
                default :
                    // show error message
                    throw new \Exception(); // @todo: Invalid form parameter:',$rule['rule']['name'],"\n";
            }
        }
    }
    
    /**
     *
     * @param AbstractTree\Field $definition 
     */
    protected function addFieldDescription(AbstractTree\Field$definition)
    {
        $addJSvalidation = true; // keep this flag up , it can be lowered by validation rule
        
        /*$name = $this->tpl->getNameOfElement($definition['element']);
        $form = $this->forms[$this->getFormId($this->tpl->getFormForElement($definition['element']))];
        $formName = $form['name'];
        $this->tpl->setFormContainer($formName);

        $this->tpl->addValueReplacement($name);
        $input = $this->writer->newInput($name,$formName,$definition['element']);

         
        foreach($definition['rules'] as $rule)
        {
            $input->addCommand($this->parceRule($rule));
        }
        $this->inputs[] = $input;*/
        
        $rules = new AbstractTree\Rules;
        foreach($definition->getRules()->getChecks() as $check)
        {
            switch($check->getName())
            {
                case 'disableJSvalidation':
                    $addJSvalidation = false;
                    break;
                default :
                    $rules->addCheck($check);
            }
        }
                                    
        $def = new AbstractTree\Field($definition->getField(), $definition->getForm(), $rules);
        
        $def->setJSvalidation($addJSvalidation);
        
        $this->forms[$definition->getForm()]->addField($def);
        
        /*if($addJSvalidation && $form['outJScode'])
        {
            $this->js[] = $input; // add if not switched off
        }*/
    }

    /*
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
	}*/

    /**
     *
     * @return string
     */
    public function generatePHPvalidators()
    {
        $code = '';
        /*foreach($this->forms as $form)
        {
            $code.= "{$form['var']} = new \\TrustedForms\\FormValidator();\n";
        }
        foreach($this->inputs as $input)
        {
            $code.=$input->toPHPcode();
        }*/
        foreach($this->forms as $form)
        {
            $code.= $form->toPHPcode(&$this->tpl);
        }
        return $code;
    }
	
    /**
     *
     * @return string
     */
	public function generateJSvalidators()
	{
		$jscode = '';
        $tests = array();
        foreach($this->js as $js)
        {
            $tests = array_merge($tests,$js->getAllTestNames());
            $jscode.=$js->toJScode($this);
        }        
        
        $tests = array_unique($tests);
        
        $ret = '';
        if(count($tests)>0)
        {
            $ret = "TrustedForms";
            foreach($tests as $test)
            {
                $clsName = '\\TrustedForms\\ValueChecks\\'.$test;
                $ret.='.register({name:'.json_encode($test).',validator:function(value,config){'.$clsName::jsValidator.'}})';
            }
            $ret.=";\n";
        }
        $ret.=$jscode;
        return $ret;
	}

    public function defaultErrorReport($params,$reporter)
    {
        return $reporter;
    }
}
