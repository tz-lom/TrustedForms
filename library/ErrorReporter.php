<?php

namespace TrustedForms;

/**
 * Contains error description for invalid field
 */
class ErrorReporter
{
    /**
     *
     * @var String
     */
	protected $message;

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
}

