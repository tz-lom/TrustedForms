<?php

namespace TrustedForms\CodeGenerator;

/**
 *
 * @author tz-lom
 */
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
	 * Return ``name`` attribute of element specified by selector or NULL if element or attribute not exists
	 * 
	 * @var string $css
	 * @return string Name of element
	 */
	public function getNameOfElement($css);

    /**
     * Adds code that replaces value of element in form with value from form validator
     *
     * @var string $name
     */
    public function addValueReplacement($name);

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

}

