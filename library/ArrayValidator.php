<?php

namespace TrustedForms;

/**
 * Performs control of array , works like container of VariableValidator's
 */
class ArrayValidator implements \ArrayAccess
{
	/**
	 * Возвращать ошибку если для элемента массива нет валидатора
	 */
	const REPORT_UNDEFINED_ELEMENT	= 0;
	/**
	 * Игнорировать отсутсвие валидатора для элемента массива
	 */
	const IGNORE_UNDEFINED_ELEMENT	= 1;
	/**
	 * Добавляет пустой валидатор для необъявленного элемента массива
	 */
	const ADD_UNDEFINED_ELEMENT		= 2;


	/**
	 * @var int метод обработки ключей без валидаторов
	 */
	protected $undefKeysMode = 0;
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
					$this->errorOccured = true;
			}
		}
		
        foreach($this->variables as $name=>$var)
        {
            $var->setValue(isset($array[$name])?$array[$name]:
							new \TrustedForms\Exceptions\ValueNotExists);
			$this->errorOccured = $this->errorOccured || !$var->isCorrect();
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
     * @return array массив ошибок по всем полям массива
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

	/**
	 * Задаёт способ обратотки ключей проверяемого массива для которых нет валидатора
	 * @param \TrustedForms\ArrayValidator::const $mode
	 */
	public function handleUndefinedKeys($mode)
	{
		$this->undefKeysMode = $mode;
	}
}
