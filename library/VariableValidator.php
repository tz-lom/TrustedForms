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
    protected $checkers = array();
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

    /**
     *
     * @param ValueChecker $checker
     * @return VariableValidator 
     */
    public function addCheck(ValueChecker $checker)
    {
        if(is_null($this->reporter)) throw new \TrustedForms\Exceptions\ErrorReporterNotSet;
        $checker->setReporter($this->reporter);
        $this->checkers[] = $checker;
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
            foreach($this->checkers as $checker)
            {
                if(!$checker->check($this->inputValue))
                {
                    $this->correct = false;
                    break;
                }
            }
        }
        $this->value = $this->inputValue;
        $this->checked = true;
        return $this->correct;
    }

    /**
     *
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}

