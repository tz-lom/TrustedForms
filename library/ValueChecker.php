<?php

namespace TrustedForms;

/**
 * Performs control of variable
 */
abstract class ValueChecker
{
    /**
     * @var ErrorReporter
     */
    protected $reporter;

    /**
     *
     * @param ErrorReporter $reporter
     * @return ValueChecker
     */
    public function setReporter(ErrorReporter $reporter)
    {
        $this->reporter = $reporter;
        return $this;
    }

    /**
     * @return ErrorReporter
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    abstract protected function performCheck($value);

    /**
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value)
    {
        return $this->performCheck($value);
    }
}

