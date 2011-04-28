<?php

spl_autoload_register(function($classname){
	if(strpos($classname,'TrustedForms\\')===0)
	{
		require_once __DIR__.'/../library/'.str_replace('\\', DIRECTORY_SEPARATOR, substr($classname, 13)).'.php';
	}
    if($classname=='phpQuery')
    {
        require_once __DIR__.'/../3dparty/phpQuery/phpQuery/phpQuery.php';
    }
});