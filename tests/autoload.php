<?php

spl_autoload_register(function($classname){
	if(strpos($classname,'TrustedForms\\')===0)
	{
        if(file_exists(__DIR__.'/../library/'.str_replace('\\', DIRECTORY_SEPARATOR, substr($classname, 13)).'.php'))
        {
            require_once __DIR__.'/../library/'.str_replace('\\', DIRECTORY_SEPARATOR, substr($classname, 13)).'.php';
            return true;
        }
	}
    if($classname=='phpQuery')
    {
        if(file_exists(__DIR__.'/../3dparty/phpQuery/phpQuery/phpQuery.php'))
        {
            require_once __DIR__.'/../3dparty/phpQuery/phpQuery/phpQuery.php';
        }
    }
    return false;
});