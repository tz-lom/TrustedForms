<?php

namespace TrustedForms\CodeGenerator;

require_once 'instructions.lex.php';

class Builder
{
    protected $template;
    protected $generator;

    
    public function errorHandler()
    {
        throw new \ErrorException();
    }

    public function __construct($templater,$writer)
    {   
        $templater = 'TrustedForms\\CodeGenerator\\'.$templater;
        $this->template = new $templater();
        $writer = 'TrustedForms\\CodeGenerator\\'.$writer.'\CodeWriter';
        $this->writer = new $writer();
        $this->generator = new Generator($this->template, $this->writer);
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
                $lexer = new \VILexer($tempfile);
                $parser = new \VIParser();
                $parser->generator = $this->generator;

                while($token = $lexer->nextToken())
                {
                    $parser->doParse($token->type, $token);
                }
                $parser->doParse(0);

                $this->template->removeInstruction();
            }
            catch(\ParceTokenException $e)
            {
                echo $e->getMessage(),':',$e->getLine(),"\n";
            }
            fclose($tempfile);
            $instructions = $this->template->nextInstruction();
        }
    }
    
    public function getResultTemplate()
    {
		$this->template->appendJSvalidator($this->generator->generateJSvalidator());
        return $this->template->getHTML();
    }
    
    public function getResultValidator()
    {
        return $this->generator->generateFile();
    }
}
