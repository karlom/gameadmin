<?php
/*
 * 游戏特殊处理的方法，如果不用作特殊处理则不用相关的方法
 */
 
/**
 * 对参数添加前缀标记
 * @param int $server
 * @param mix $key
 * @param mix $value
 * @return mix
 */
function addPrefix($server, $key, $value){
	if("roleName" == $key || "accountName" == $key){
		if("" != $server){
			$server = ltrim($server, "s");
			if(10 > $server){
				$server = "0".$server;
			}
			return "[{$server}]".$value;
		}else{
			return false;
		}
	}else{
		return $value;
	}
}

/**
 * 对参数删除前缀标记
 * @param str $server 如:s1
 * @param mix $key
 * @param mix $value
 * @return mix
 */
function delPrefix($server, $key, $value){
	if("roleName" == $key || "accountName" == $key){
		if("" != $server){
			$server = ltrim($server, "s");
			if(10 > $server){
				$server = "0".$server;
			}
			return str_replace("[{$server}]", "", $value);
		}else{
			return false;
		}
	}else{
		return $value;
	}
}

/**
 * 对参数添加前缀标记
 * @param int $server
 * @param mix $key
 * @param mix $value
 * @return mix
 */
function addPrefixStr($server){
	if("" != $server){
		$server = ltrim($server, "s");
		if(10 > $server){
			$server = "0".$server;
		}
		return "[{$server}]";
	}else{
		return "";
	}
}

function delPrefix2($server, $value){
	if("" != $server){
		$server = ltrim($server, "s");
		if(10 > $server){
			$server = "0".$server;
		}
		return str_replace("[{$server}]", "", $value);
	}else{
		return $value;
	}
}