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
     * @var string
     */
    protected $variableName;

	/**
     *
     * @param String $message Сообщение об ошибке задаётся в формате printf , где $1 - значение на котором произошла ошибка
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
		return sprintf($this->message,$this->errorValue,$this->variableName);
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

    /**
     * @param string $name
     * @return ErrorReporter
     */
    public function setVariableName($name)
    {
        $this->variableName = $name;
        return $this;
    }

    public static function instance($message)
    {
        return new self($message);
    }
}

