<?php

namespace TrustedForms\CodeGenerator;

class phpQueryTemplate implements TemplateManipulator
{
   	public function getNameOfElement($css)
    {

    }

    public function addValueReplacement($name)
    {

    }

	public function addMessageToElement($css)
    {

        static $i=0;
        $i++;
        return "message:$i";
    }

	public function addClassToElement($css,$class)
    {
        static $i=0;
        $i++;
        return "+class:$i";
    }

	public function removeClassFromElement($css,$class)
    {
        static $i=0;
        $i++;
        return "-class:$i";
    }

}
