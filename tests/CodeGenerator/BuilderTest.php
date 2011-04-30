<?php

namespace TrustedForms\CodeGenerator;

require_once '../autoload.php';

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testShortBuild()
    {
        $builder = new Builder('phpQueryTemplate','PHPCode');
        $builder->buildFile('
            <form name="frm">
                <div id="err"></div>
                <input id="first" type="text" name="a" />
                <!--
                    @#first@ :
                        required: @#err@<<error message>>
                -->
                <input id="second" type="text" name="b" />
                <!--
                    @#second@ :
                        required: @#err@<<error message>>
                -->
                <!-- variouse comment -->
            </form>
        ');
        echo $builder->getResultTemplate();
        echo $builder->getResultValidator();
    }
}
