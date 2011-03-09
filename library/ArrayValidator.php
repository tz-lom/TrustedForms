<?php

namespace TrustedForms;

/**
 * Performs control of array , works like container of VariableValidator's
 */
class ArrayValidator implements \ArrayAccess
{
    /**
     * @see \ArrayAccess
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {

    }

    /**
     * @see \ArrayAccess
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {

    }

    /**
     * @see \ArrayAccess
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset,$value)
    {

    }

    /**
     * @see \ArrayAccess
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {

    }
    /**
     * Проверяет все значения массива
     *
     * @param array $array Проверяемый массив
     * @return bool результат проверки
     */
    public function checkArray($array)
    {

    }

    /**
     * @return bool были ли ошибки при последней проверке
     */
    public function isError()
    {

    }

    /**
     * @return array возвращает массив ошибок по всем полям массива
     */
    public function getErrors()
    {

    }
}
