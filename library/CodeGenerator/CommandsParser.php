<?php

namespace TrustedForms\CodeGenerator;
/**
 * Description of CommandsParser
 *
 * @author tz-lom
 */
class CommandsParser
{
    public function parseBlock($text)
    {
        $text = explode("\n", $text);
        foreach($text as $line)
        {
            $line = trim($line);
            preg_match_all('//i', $subject);
        }
    }

    public function classify($char)
    {
        
    }

    public function lexer($input)
    {
        $lexems = array();
        $lexem = '';

        $ip = 0;
        $ilim = strlen($input);

        $state = 0;

        while($ip<$ilim)
        {
            $char = $input[$ip++];
            $newstate = $automat[$state][$charClass];
            if($newstate != $state)
            {
                $lexems[]
            }
        }
    }
}
