<?php

namespace TrustedForms;

/**
 * Contains error description for invalid field
 */
class ErrorReporter
{
    /**
     * @var String
     */
	protected $message;
	/**
	 * @var mixed
	 */
	protected $errorValue;

	/**
     *
     * @param String $message 
     */
    public function __construct($message)
	{
		$this->message = $message;
	}

	/**
     *
     * @return String
     */
    public function getMessage()
	{
		return $this->message;
	}

	/**
	 *
	 * @param mixed $value
	 * @return ErrorReporter
	 */
	public function setErrorValue($value)
	{
		$this->errorValue = $value;
		return $this;
	}
}

