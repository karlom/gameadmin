<?php
include_once '../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE."/global.php";
include_once SYSDIR_ADMIN_CLASS."/admin_group.class.php";


$url = (Validator::stringNotEmpty($_GET['url'])  ) ? $_GET['url']: '';
$callback = Validator::stringNotEmpty($_GET['callback'])  ? $_GET['callback']: '';
$sourceEncoding = Validator::stringNotEmpty($_GET['srcencode'])  ? $_GET['srcencode']: 'UTF-8';
$ouputEncoding = Validator::stringNotEmpty($_GET['outencode'])  ? $_GET['outencode']: 'UTF-8';

if( Validator::stringNotEmpty( $url ))
{
	$response = curl_file_get_contents($url);
	$response = iconv($sourceEncoding, $ouputEncoding, $response);
	writeResponse($response, $callback);
}


function writeResponse($response, $callback = '')
{
	/*
	if( Validator::stringNotEmpty( $callback ) )
	{
		echo 'if (window.', $callback, '){' , $callback, '(';
	}
	*/
	echo $response;
	/*
	if( Validator::stringNotEmpty( $callback ) )
	{
		echo "');}";
	}*/
}

function curl_file_get_contents($get_url)
{
	$ch = curl_init();//	curl方式发起http请求
	curl_setopt($ch, CURLOPT_URL, $get_url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
	curl_setopt($ch, CURLOPT_REFERER,_REFERER_);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$content = curl_exec($ch);
	curl_close($ch);
	return $content;
}