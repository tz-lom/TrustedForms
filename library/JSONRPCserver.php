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
    
    public function __construct(FormValidator $form)
    {
        $this->form = $form;
    }
        
    public function checkField($name,$value)
    {
        if(!isset($this->form[$name]))
            return array('passed'=>false,'error'=> "There is no field [$name]");
        $this->form[$name]->setValue($value);
        if($this->form[$name]->isCorrect())
        {
            return array('passed'=>true);
        }
        else
        {
            return array('passed'=>false , 'error' => json_decode($this->form[$name]->getError()->getJSONdescription()));
        }        
    }
    
    public function processRPCcall()
    {
        $request = json_decode(file_get_contents('php://input'));
        $result = array('passed'=>false,'error'=>null);
        /*switch($request->mode)
        {
            case 'fromSource':
                $result = $this->checkField(
                            $this->compileDescription($request->src),
                            $request->value
                       );
                break;
            case 'fromDefinition':
                break;
        }*/
        $result = $this->checkField($request->name, $request->value);
        //$request['id'] = $request->id;
        
        header('content-type: text/javascript');
        echo json_encode($result);
    }
}
