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
    }

    /**
     * Main entrance from VIParser
     * 
     * @param AbstractTree\Field $definition 
     */
    public function addDefinition(AbstractTree\Field $definition)
	{
        if((strpos($definition->getForm(),'"')!==false)||(strpos($definition->getField(),'"')!==false))
            throw new Exception(); // @todo: customize exception
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
    }

    /**
     *
     * @return string
     */
    public function generatePHPvalidators()
    {
        // @todo: give all forms name
        $code = '';
        $env = new AbstractTree\ParceEnvironment();
        $env->tpl = &$this->tpl;
        foreach($this->forms as $form)
        {
            $code.= $form->toPHPcode($env);
        }
        return $code;
    }
	
    /**
     *
     * @return string
     */
	public function generateJSvalidators()
	{
        $validators = array();
        $code = '';
        $env = new AbstractTree\ParceEnvironment();
        $env->tpl = &$this->tpl;
        foreach($this->forms as $form)
        {
            $descr = $form->toJScode($env);
            $code.= $descr->code;
            $validators = array_merge($validators,$descr->validators);
        }
        if(count($validators)>0)
        {
            return 'TrustedForms'.implode('', $validators).";\n".$code;
        }
        else
        {
            return $code;
        }
	}

    public function defaultErrorReport($params,$reporter)
    {
        return $reporter;
    }
}
