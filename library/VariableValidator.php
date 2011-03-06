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

	public function addToChain(ValidationChainItem $item)
	{
		if(! $this->reporter instanceof \TrustedForms\ErrorReporter) throw new \TrustedForms\Exceptions\ErrorReporterNotSet;
		$item->setReporter($this->reporter);
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
				$this->value = $item->process($this->value);
				if($item->isError())
                {
                    $this->correct = false;
					$this->occuredError = $item->isError();
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
			return $this->value;
		else
		{
			throw $this->occuredError;
		}
    }
}

