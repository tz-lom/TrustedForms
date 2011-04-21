<?php

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
     * @var bool
     */
    protected $checked = false;
    /**
     *
     * @var bool
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
     * @return bool
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
}
