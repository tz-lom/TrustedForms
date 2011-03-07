<?php

namespace TrustedForms;
/**
 * Description of ValidationChainItem
 *
 * @author tz-lom
 */
abstract class ValidationChainItem
{
    /**
     * @var ErrorReporter
     */
    protected $reporter;
	protected $reportedError = false;
    protected $config = array();


    /**
     * @param array $config Параметры для валидатора
     */
	public function  __construct($config=array())
	{
        $this->config = $config;
		$this->reporter = new \TrustedForms\ErrorReporter('');
	}
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
     *
     * @param mixed $value
     * @return $value
     */
	public function process($value)
	{
		$this->reportedError = false;
		return $value;
	}

	/**
	 *
	 * @param mixed $value
	 */
	protected function reportError($value)
	{
		$this->reportedError = $this->getReporter()->setErrorValue($value);
	}

	/**
	 *
	 * @return bool | ErrorReporter
	 */
	public function isError()
	{
		return $this->reportedError;
	}
}

