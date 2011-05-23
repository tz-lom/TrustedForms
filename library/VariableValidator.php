<?php
/**
 * @version 0.0.1
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms
 */

namespace TrustedForms;

/**
 * Performs control of one variable,implements chain of checks and transformations
 */
class VariableValidator
{
    /**
     *
     * @var ErrorReporter
     */
    protected $reporter;
	/**
	 * @var ErrorReporter
	 */
    protected $occuredError;
	/**
	 *
	 * @var array of ValidationChainItem 
	 */
    protected $chain = array();
    protected $inputValue;
    protected $value;
    /**
     *
     * @var boolean
     */
    protected $checked = false;
    /**
     *
     * @var boolean
     */
    protected $correct = false;

    /**
     *
     * @param mixed $defaultValue Значение по умолчанию
     */
	public function __construct($defaultValue = NULL)
	{
		$this->reporter = new \TrustedForms\ErrorReporter('Value %s is incorrect');
        $this->inputValue = $defaultValue;
	}
    
    /**
     *
     * @return TrustedForms\VariableValidator 
     */
    public static function instance()
    {
        return new self;
    }

    /**
     *
     * @param ErrorReporter $reporter
     * @return VariableValidator 
     */
    public function addReporter(ErrorReporter $reporter)
    {
        $this->reporter = $reporter;
        return $this;
    }

	public function clearChain()
	{
		$this->chain = array();
		$this->checked = false;
		return $this;
	}

	public function addToChain(ValidationChainItem $item, ErrorReporter $reporter=NULL)
	{
        if($reporter)
        {
            $item->setReporter($reporter);
        }
        else
        {
            $item->setReporter($this->reporter);
        }
		$this->chain[] = $item;
		return $this;
	}

    /**
     *
     * @param mixed $value
     * @return VariableValidator 
     */
    public function setValue($value)
    {
        $this->inputValue = $value;
        $this->value = NULL;
        $this->checked = false;
        $this->correct = false;
		$this->occuredError = NULL;
        return $this;
    }

    /**
     *
     * @return boolean
     */
    public function isCorrect()
    {
        if(!$this->checked)
        {
            $this->correct = true;
			$this->value = $this->inputValue;
			foreach($this->chain as $item)
            {
				if (!$item->process($this->value))
				{
					$this->correct = false;
					$this->occuredError = $item->getError();
					break;
				}
            }
        }
        $this->checked = true;
        return $this->correct;
    }

    /**
     *
     * @return mixed
     */
    public function value()
    {
		if($this->isCorrect())
		{
			return $this->value;
		}
		else
		{
			return NULL;
		}
    }
	
	/**
	 * Returns unchecked value, please be careful
	 *
	 * @return mixed
	 */
	public function inputValue()
	{
		return $this->inputValue;
	}

	/**
	 * Возвращает возникнувшую ошибку
	 * @return ErrorReporter or NULL
	 */
	public function getError()
	{
		if($this->isCorrect())
		{
			return NULL;
		}
		else
		{
			return $this->occuredError;
		}
	}
	
	/**
	 * Проверяет было ли значение проверено, не заданное/обновлённое значение  так же сбрасывает флаг проверки 
	 * 
	 * @return boolean
	 */
	public function isChecked()
	{
		return $this->checked;
	}
}
