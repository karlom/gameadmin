<?php
class helper {

	static public function setMember($objName, $key, $value) {
		global $$objName;
		if (! is_object ( $$objName ) or empty ( $key ))
			return false;
		$key = str_replace ( '.', '->', $key );
		$value = serialize ( $value );
		$code = ("\$${objName}->{$key}=unserialize(<<<EOT\n$value\nEOT\n);");
		eval ( $code );
		return true;
	}
}