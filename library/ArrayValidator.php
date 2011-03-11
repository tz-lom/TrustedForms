<?php

namespace TrustedForms;

/**
 * Performs control of array , works like container of VariableValidator's
 */
class ArrayValidator implements \ArrayAccess
{
    /**
     * @var array of \TrustedForms\VariableValidator
     */
    protected $variables = array();
    /**
     * @var bool Произошла ли ошибка при проверке
     */
    protected $errorOccured = false;


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
            return null;
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
        if(is_null($offset))
        {
            $this->variables[] = $value;
        }
        else
        {
            $this->variables[$offset] = $value;
        }
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
        $this->errorOccured = false;
        foreach($this->variables as $name=>$var)
        {
            if(isset($array[$name]))
            {
                $var->setValue($array[$name]);
                $this->errorOccured = $this->errorOccured || !$var->isCorrect();
            }
        }
        return $this->errorOccured;
    }

    /**
     * @return bool были ли ошибки при последней проверке
     */
    public function isError()
    {
        return $this->errorOccured;
    }

    /**
     * @return array возвращает массив ошибок по всем полям массива
     */
    public function getErrors()
    {
        if(!$this->errorOccured) return array();
        $result = array();
        foreach($this->variables as $var)
        {
            if(!$var->isCorrect())
                $result[] = $var->getError();
        }
        return $result;
    }
}
