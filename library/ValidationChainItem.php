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
 * Description of ValidationChainItem
 *
 * @author tz-lom
 */
abstract class ValidationChainItem
{
    
    /**
     * эквивалентный JS валидатор
     * @var string
     */
    const jsValidator = NULL;
    
    /**
     * @var ErrorReporter
     */
    protected $reporter;
    protected $reportedError = false;
    protected $config = array();
    /**
     * @var VariableValidator
     */
    protected $owner;
    

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
     * @param mixed &$value проверяемое значение,может быть изменено
     * @return bool результат проверки
     */
    protected abstract function doProcess(&$value);

    /**
     * Проверяет значение,изменяет его , возвращает результат проверки
     * в случае не прохождения проверки заносит ошибочное значение в ErrorReporter
     *
     * @param mixed &$value проверяемое значение,может быть изменено
     * @return bool результат проверки (true == прошло проверку)
     */
    public function process(&$value)
    {
        if ($this->doProcess($value)) 
        { 
            $this->reportedError = false; 
            return true;
        }
        else 
        {
            $this->reportedError = $this->getReporter()->setErrorValue($value); 
            return false;
        }
    }

    /**
     * Возвращает произошла ли ошибка
     * @return bool
     */
    public function isError()
    {
        return $this->reportedError != false;
    }

    /**
     * Возвращает ошибку или же false если ошибки не произошло
     * @return \TrustedForms\ErrorReporter
     */
    public function getError()
    {
        return $this->reportedError;
    }
    
    /**
     * Returns VariableValidator that contains that validator
     * 
     * @return VariableValidator
     */
    public function getOwner()
    {
        return $this->owner;
    }
    
    public function setOwner(VariableValidator &$owner)
    {
        $this->owner = $owner;
        return $this;
    }
}

