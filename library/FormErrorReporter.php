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
 * Carry information about changes to form
 *
 * @author tz-lom
 */
class FormErrorReporter extends \TrustedForms\ErrorReporter
{
    protected $flags = array();
    protected $asJSON = '';
    
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
    
    public function setJSONdescription($json)
    {
        $this->asJSON = $json;
        return $this;
    }
    
    public function getJSONdescription()
    {
        return $this->asJSON;
    }
}
