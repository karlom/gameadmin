<?php
class language {

	public function set($key, $value) {
		helper::setMember ( 'lang', $key, $value );
	}
	
	public function show($obj, $key) {
		$obj = ( array ) $obj;
		if (isset ( $obj [$key] ))
			echo $obj [$key];
		else
			echo '';
	}
}