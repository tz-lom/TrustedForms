<?php
/**
 * @version 0.0.1
 * @link http://github.com/tz-lom/TrustedForms
 * @author Nuzhdin Urii <nuzhdin.urii@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package TrustedForms\CodeGenerator
 */

namespace TrustedForms\CodeGenerator;

interface TemplateManipulator
{

    /**
     * Set HTML to transform
     *
     * @param string $html
     */
    public function setHTML($html);


    /**
     * Return resulting HTML
     *
     * @return string
     */
    public function getHTML();

    /**
     * Adds code that replaces value of element in form with value from form validator
     *
     * @var string $field
     * @var string $form
     */
    public function addValueReplacement($field,$form);

	/**
	 * Registers output of unique identifier as alternative text to element specified by selector
	 * 
	 * @var string $css
	 * @return string Unique identifier
	 */
	public function addMessageToElement($css);
	
	/**
	 * Registers class addition to element specified by selector
     *
     * @var string $css
     * @var string $class Class name
     * @return string Unique identifier
	 */
	public function addClassToElement($css,$class);
    
    /**
	 * Registers class removement to element specified by selector
     * 
     * @var string $css
     * @var string $class Class name
     * @return string Unique identifier
	 */
	public function removeClassFromElement($css,$class);
    
    /**
     * Returns array of form element descriptions,
     * descriptions may vary due to realization
     * of interface, but compareElements must correctly
     * compare them
     * 
     * @return array
     */
    public function getAllForms();
    
    /**
     * Set var name that identifies to what form (in terms of php validator)
     * changes are performed
     * 
     * @param string $name
     */
    public function setFormContainer($name);
	
    /**
     * Inserts JS code in form
     * 
     * @param string $validator
     */
	public function appendJSvalidator($validator);

}

