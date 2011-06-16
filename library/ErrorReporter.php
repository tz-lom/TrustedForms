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
     * @param String $message Сообщение об ошибке задаётся в формате printf
     *               $1 - значение на котором произошла ошибка
     *               $2 - имя переменной содержащей ошибку
     */
    public function __construct($message = '$2%s: invalid value $1%s')
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

    public static function instance($message = '$2%s: invalid value $1%s')
    {
        return new static($message);
    }
}

