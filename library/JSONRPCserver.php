<?php
/**
 * @version 0.0.2
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms
 */

namespace TrustedForms;

class JSONRPCserver
{
    protected $form;
    
    public function __construct($form=array())
    {
        $this->form = $form;
    }
    
    protected function parceValidationItem($validator)
    {
        $arguments = $validator->arguments;
        foreach($arguments as &$arg)
        {
            if(is_object($arg))
                $arg = $this->parceValidationItem ($arg);
        }
        
        $class = 'ValueChecks\\'.$validator->test;
        $v = new $class($arguments);
        $v->setReporter(new ErrorReporter($validator->error));
        return $v;
    }
    
    public function compileDescription($jsonDescription)
    {
        $validators = json_decode($jsonDescription);
        $test = new VariableValidator();
        
        foreach($validators as $validator)
        {
            $test->addToChain($this->parceValidationItem($validator));
        }
        return $test;
    }
    
    public function checkField(VariableValidator $test,$value)
    {
        $test->setValue($value);
                
        if($test->isCorrect())
        {
            return array('passed'=>true);
        }
        else
        {
            return array('passed'=>false , 'error' => $test->getError()->getMessage());
        }
    }
    
    public function processRPCcall()
    {
        $request = json_decode(file_get_contents('php://input'));
        $result = array('passed'=>false,'error'=>null);
        switch($request->mode)
        {
            case 'fromSource':
                $result = $this->checkField(
                            $this->compileDescription($request->src),
                            $request->value
                       );
                break;
        }
        //$request['id'] = $request->id;
        header('content-type: text/javascript');
        echo json_encode($result);
    }
}
