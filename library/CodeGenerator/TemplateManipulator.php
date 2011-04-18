<?php

namespace TrustedForms\CodeGenerator;

/**
 *
 * @author tz-lom
 */
interface TemplateManipulator
{
	/**
	 * Return ``name`` attribute of element specified by selector or NULL if element or attribute not exists
	 * 
	 * @var string $css
	 * @return string Name of element
	 */
	public function getNameOfElement($css);
	/**
	 * Registers output of unique identifier as alternative text to element specified by selector
	 * 
	 * @var string $css
	 * @return string Unique identifier
	 */
	public function addMessageToElement($css);
	
	/**
	 * Registers class addition to
	 */
	public function addClassToElement($css,$class);
}

