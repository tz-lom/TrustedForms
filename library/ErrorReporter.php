<?php

namespace TrustedForms;

/**
 * Contains error description for invalid field
 */
class ErrorReporter
{
    protected $message;

	public function __construct($message)
	{
		$this->message = $message;
	}

	public function getMessage()
	{
		return $this->message;
	}
}

