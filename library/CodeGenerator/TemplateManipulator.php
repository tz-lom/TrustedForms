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
     * Compares two element descriptors, returns true if they are equal
     * 
     * @var element descriptor $a
     * @var element descriptor $b
     * @return boolean
     */
    public function compareElements($a,$b);
    
    /**
     * Returns element descriptor that belongs to <form> element
     * that owns element described by $css selector
     * 
     * @var string $css
     * @return element descriptor
     */
    public function getFormForElement($css);
    
    /**
     * Returns wether element is form or not
     * 
     * @var string $css
     * @return boolean
     */
    public function isForm($css);
    
    /**
     * Returns element descriptor
     * 
     * @var string $css
     * @return element descriptor
     */
    public function getElement($css);
    
    public function setFormContainer($name);

}

