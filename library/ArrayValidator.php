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
 * Performs control of array , works like container of VariableValidator's
 */
class ArrayValidator implements \ArrayAccess
{
    /**
     * Возвращать ошибку если для элемента массива нет валидатора
     */
    const REPORT_UNDEFINED_ELEMENT  = 0;
    /**
     * Игнорировать отсутсвие валидатора для элемента массива
     */
    const IGNORE_UNDEFINED_ELEMENT  = 1;
    /**
     * Добавляет пустой валидатор для необъявленного элемента массива
     */
    const ADD_UNDEFINED_ELEMENT     = 2;


    /**
     * @var int метод обработки ключей без валидаторов
     */
    protected $undefKeysMode = 0;
    /**
     * @var array of \TrustedForms\VariableValidator
     */
    protected $variables = array();
    /**
     * @var \TrustedForms\ErrorReporter
     */
    protected $errorReporter;
    /**
     * @var array of \TrustedForms\ErrorReporter
     */
    protected $errorPool;
    /**
     * @var boolean
     */
    protected $skipEmptyArray = false;

    public function  __construct()
    {
        $this->errorReporter = new \TrustedForms\ErrorReporter('Variable [%2$s] not exists');
    }

    /**
     * @see \ArrayAccess
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->variables[$offset]);
    }

    /**
     * @see \ArrayAccess
     * @param mixed $offset
     * @return \TrustedForms\VariableValidator
     */
    public function offsetGet($offset)
    {
        if($this->offsetExists($offset))
        {
            return $this->variables[$offset];
        }
        else
        {
            return NULL;
        }
    }

    /**
     * @see \ArrayAccess
     * @param mixed $offset
     * @param \TrustedForms\VariableValidator $value
     */
    public function offsetSet($offset,$value)
    {
        if(! $value instanceof \TrustedForms\VariableValidator)
            trigger_error('ArrayValidator items must be inherited from VariableValidator');
        $this->variables[$offset] = $value;
        $this->variables[$offset]->setOwner($this);
    }

    /**
     * @see \ArrayAccess
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->variables[$offset]);
    }
    /**
     * Проверяет все значения массива
     *
     * @param array $array Проверяемый массив
     * @return bool результат проверки
     */
    public function checkArray($array)
    {
        $this->errorPool = array();
        
        if($this->skipEmptyArray && count($array)==0) return false;
        
        $undescribedKeys = array_diff_key($array,$this->variables);
        if(count($undescribedKeys))
        {
            switch($this->undefKeysMode)
            {
                case ArrayValidator::IGNORE_UNDEFINED_ELEMENT:
                    break;
                case ArrayValidator::ADD_UNDEFINED_ELEMENT:
                    foreach($undescribedKeys as $key => $value)
                    {
                        $this[$key] = new \TrustedForms\VariableValidator();
                    }
                    break;
                default:
                    foreach($undescribedKeys as $key=>$value)
                    {
                        $err = $this->errorReporter;
                        $err->setVariableName($key);
                        $this->errorPool[] = $err;
                    }
            }
        }
        
        foreach($this->variables as $name=>$var)
        {
            if(isset($array[$name]))
            {
                $var->setValue($array[$name]);
            }
          else 
        {
        $var->setValue( new \TrustedForms\Exceptions\ValueNotExists());
        }
      
            if(!$var->isCorrect())
            {
                $this->errorPool[] = $var->getError();
            }
            
        }
        return !$this->isError();
    }

    /**
     * @return bool были ли ошибки при последней проверке
     */
    public function isError()
    {
        return count($this->errorPool)>0;
    }

    /**
     * @return array of \TrustedForms\ErrorReporter массив ошибок по всем полям массива
     */
    public function getErrors()
    {
        return $this->errorPool;
    }

    /**
     * Задаёт способ обратотки ключей проверяемого массива для которых нет валидатора
     * 
     * @param \TrustedForms\ArrayValidator::const $mode
     * @return ArrayValidator
     */
    public function handleUndefinedKeys($mode)
    {
        $this->undefKeysMode = $mode;
        return $this;
    }
    
    /**
     * If array is empty it can be skipped, useful for form validation when no data passed to form
     * 
     * @param boolean $skip
     * @return ArrayValidator 
     */
    public function skipEmptyArray($skip)
    {
        $this->skipEmptyArray = $bool;
        return $this;
    }

    /**
     * @param \TrustedForms\ErrorReporter $reporter
     * @return ArrayValidator
     */
    public function setErrorReporter(\TrustedForms\ErrorReporter $reporter)
    {
        $this->errorReporter = $reporter;
        return $this;
    }

    /**
     *
     * @return \TrustedForms\ErrorReporter
     */
    public function getErrorReporter()
    {
        return $this->errorReporter;
    }

    public static function instance()
    {
        return new static;
    }
}
