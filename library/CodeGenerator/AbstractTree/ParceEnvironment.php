<?php
/**
 * @version 0.0.2
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator\AbstractTree;

class ParceEnvironment
{
    /**
     * @var TrustedForms\CodeGenerator\TemplateManipulator
     */
    public $tpl = NULL;
    /**
     * @var TrustedForms\CodeGenerator\AbstractTree\Form
     */
    public $form = NULL;
    /**
     * @var TrustedForms\CodeGenerator\AbstractTree\Field
     */
    public $field = NULL;
    /**
     * @var array[TrustedForms\CodeGenerator\AbstractTree\Repoter]
     */
    public $defaultReporter = array();
}

