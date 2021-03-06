<?php
/**
 * @version 0.0.1
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator;

class Builder
{
    protected $template;
    protected $generator;
    protected $phpCache = NULL;
    
    public function errorHandler()
    {
        throw new \ErrorException();
    }

    public function __construct($templater)
    {   
        $templater = 'TrustedForms\\CodeGenerator\\'.$templater;
        $this->template = new $templater();
        $this->generator = new Generator($this->template);
    }

    public function buildFile($source)
    {
        $this->template->setHTML($source);
        $this->generator->prepare();
        $instructions = $this->template->firstInstruction();
        while($instructions)
        {
            $tempfile = fopen('php://temp/','rw');
            fwrite($tempfile, $instructions);
            fseek($tempfile, 0);
            try
            {
                $lexer = new VILexer($tempfile);
                $parser = new VIParser();
                $parser->generator = $this->generator;

                while($token = $lexer->nextToken())
                {
                    $parser->doParse($token->type, $token);
                }
                $parser->doParse(0);

                $this->template->removeInstruction();
            }
            catch(ParceTokenException $e)
            {
                echo $e->getMessage(),':',$e->getLine(),"\n";
            }
            catch(ReadTokenException $e)
            {
                echo $e->getMessage(),"\n";
            }
            fclose($tempfile);
            $instructions = $this->template->nextInstruction();
        }
    }
    
    public function getResultTemplate()
    {
        $this->getResultValidator();
        $this->template->appendJSvalidator($this->generator->generateJSvalidators());
        return $this->template->getHTML();
    }
    
    public function getTemplateWithoutJS()
    {
        return $this->template->getHTML();
    }
    
    public function getJSvalidator()
    {
        return $this->generator->generateJSvalidators();
    }
    
    public function getResultValidator()
    {
        if($this->phpCache===NULL)
        {
            $this->phpCache = $this->generator->generatePHPvalidators();
        }
        return $this->phpCache;
    }
}
