<?php 
/**
 * 新增一个class，只需要在下面数组添加一条记录，无需另外include
 * 格式：
 * class_name => file_name
 */
$autoloadArray = array(
		'AdminAccessRuleClass' 	=> 'admin_access_rule.class.php',
		'AdminGroupClass'	   	=> 'admin_group.class.php',
		'AdminLogClass'			=> 'admin_log_class.php',
		'AdminUserClass'		=> 'admin_user.class.php',
		'AuthClass'				=> 'auth.class.php',
		'Datatime'				=> 'Datatime.php',
		'helper'				=> 'Help.class.php',
		'DBInfobrightClass'		=> 'infobright.class.php',
		'language'				=> 'Language.class.php',
		'DBMysqlClass'			=> 'mysql.class.php',
		'Templates'				=> 'templates.class.php',
		'UserClass'				=> 'user_class.php',
		'ExtMemcache'			=> 'extmemcache.class.php',
		'RequestCollection'		=> 'requestcollection.class.php',
		'Validator'				=> 'validator.class.php',
		'CentralLogClass'		=> 'central.log.php',
	);

	

function GameAdmin_Autoload( $className )
{
	global $autoloadArray;
	if ( array_key_exists( $className, $autoloadArray ) && file_exists( SYSDIR_ADMIN_CLASS .  DIRECTORY_SEPARATOR . $autoloadArray[$className] ) )
	{
		include_once( SYSDIR_ADMIN_CLASS .  DIRECTORY_SEPARATOR . $autoloadArray[$className] );
	}
}

spl_autoload_register('GameAdmin_Autoload');