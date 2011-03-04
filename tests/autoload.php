<?php

spl_autoload_register(function($classname){
	if(strpos($classname,'TrustedForms\\')===0)
	{
		require_once __DIR__.'/../library/'.str_replace('\\', '/', substr($classname, 13)).'.php';
	}
});