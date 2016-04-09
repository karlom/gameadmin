<?php
class Variables
{
	private static $variables = array();
	private static $table = T_VARIABLES;

	public static function get( $name )
	{
		if( !isset( self::$variables[$name] ) )
		{
			$sql = 'SELECT * FROM ' . self::$table . " WHERE name = '$name' LIMIT 1";
			$result = IFetchRowOne($sql);
			self::$variables[$name] = $result['value'];
		} 
		return self::$variables[$name];
	}
	

	public static function set( $name, $value )
	{
		$data = array('name' => $name, 'value' => $value);
		$sql = makeDuplicateInsertSqlFromArray($data, self::$table);
		IQuery($sql);
		return true;
	}
}