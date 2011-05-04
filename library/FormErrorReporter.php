<?php

namespace TrustedForms;

/**
 * Carry information about changes to form
 *
 * @author tz-lom
 */
class FormErrorReporter extends \TrustedForms\ErrorReporter
{
    protected $flags = array();
	
	public function __construct($message = '%2$s :: value `%1$s` is incorrect')
	{
		parent::__construct($message);
	}

    public function addFlag($flagName,$value=NULL)
    {
        $this->flags[$flagName] = $value;
        return $this;
    }

    public function getFlags()
    {
        $ret = $this->flags;
		$errorValue = $this->errorValue;
		$variableName = $this->variableName;
        array_walk($ret,
                function(&$value,$key,$message) use($errorValue,$variableName) {
                    if($value===NULL)
                    {
                        $value = $message;
                    }
					else
					{
						$value = sprintf($value,$errorValue,$variableName);
					}
                },
                $this->getMessage());
        return $ret;
    }
}
