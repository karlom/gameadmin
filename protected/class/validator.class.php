<?php
/**
 * 验证方法类，提供一套验证的方法库
 */
class Validator
{
	/**
     * 本地化变量
     *
     * @var array
     */
	protected static $_locale;
	
	/**
	 * 
	 * 根据本地化的信息来格式化整型和浮点型的字符串。
	 * @param string $digit_string
	 * 
	 * @return boolean
	 */
	public static function formatByLocale( $digit_string )
	{
		if (is_null(self::$_locale))
        {
            self::$_locale = localeconv();
        }
        
        $digit_string = str_replace(self::$_locale['decimal_point'], '.', $digit_string);
        $digit_string = str_replace(self::$_locale['thousands_sep'], '', $digit_string);
        
        return $digit_string;
	}
	/**
	 * 
	 * 验证整型
	 * @param string $int_string
	 * 
	 * @return boolean
	 */
	public static function isInt( $int_string )
	{
		$int_string = self::formatByLocale($int_string);
        
		return $int_string == strval(intval($int_string)) ;
	}
	
	/**
	 * 
	 * 验证浮点型
	 * @param string $float_string
	 * 
	 * @return boolean
	 */
	public static function isFloat( $float_string )
	{
		$float_string = self::formatByLocale($float_string);
		
		return $float_string == strval(floatval($float_string)) ;
	}
	
	/**
	 * 
	 * 验证字符串是否为空
	 * @param string $string
	 * 
	 * @return boolean
	 */
	public static function stringNotEmpty( $string )
	{
		return strlen(trim($string));
	}
	
	/**
	 * 
	 * 验证字符串长度是否为给定长度
	 * 
	 * @return boolean
	 */
	public static function stringEqLength( $string, $length )
	{
		return strlen($string) === intval($length);
	}
	
	/**
	 * 
	 * 验证字符串长度是否大于或等于给定长度
	 * 
	 * @return boolean
	 */
	public static function stringGeLength( $string, $length )
	{
		return strlen($string) >= intval($length);
	}
	
	/**
	 * 
	 * 验证字符串长度是否小于或等于给定长度
	 * 
	 * @return boolean
	 */
	public static function stringLeLength( $string, $length )
	{
		return strlen($string) <= intval($length);
	}
	
	
	/**
	 * 
	 * 验证字符串是否为email的格式
	 * 
	 * @return boolean
	 */
	public static function isEmail( $string )
    {
        //return preg_match('/^[a-z0-9]+[._\-\+]*@([a-z0-9]+[-a-z0-9]*\.)+[a-z0-9]+$/i', $value);
        return preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i', $string);
    }
    
	/**
     * 是否是 IPv4 地址（格式为 a.b.c.h）
     *
     * @param mixed $string
     *
     * @return boolean
     */
    public static function isIpv4( $string )
    {
        $test = @ip2long( $string );
        return $test !== - 1 && $test !== false;
    }

    /**
     * 是否是八进制数值
     *
     * @param mixed $value
     *
     * @return boolean
     */
    public static function isOctal( $string )
    {
        return preg_match('/0[0-7]+/', $string);
    }

    /**
     * 是否是二进制数值
     *
     * @param mixed $string
     *
     * @return boolean
     */
    public static function isBinary( $string )
    {
        return preg_match('/[01]+/', $string);
    }

    /**
     * 是否是 Internet 域名
     *
     * @param mixed $string
     *
     * @return boolean
     */
    public static function isDomain( $string )
    {
        $regular = "/^([0-9a-z\-]{1,}\.)?[0-9a-z\-]{2,}\.([0-9a-z\-]{2,}\.)?[a-z]{2,}$/i";
        return preg_match($regular, $string);
    }
    
	/**
     * 是否是日期（yyyy/mm/dd、yyyy-mm-dd）
     *
     * @param mixed $string
     *
     * @return boolean
     */
    public static function isDate( $string )
    {
        if (strpos($string, '-') !== false)
        {
            $p = '-';
        }
        elseif (strpos($string, '/') !== false)
        {
            $p = '\/';
        }
        else
        {
            return false;
        }

        if (preg_match('/^\d{4}' . $p . '\d{1,2}' . $p . '\d{1,2}$/', $string))
        {
            $arr = explode($p, $string);
            if (count($arr) < 3) return false;

            list($year, $month, $day) = $arr;
            return checkdate($month, $day, $year);
        }
        else
        {
            return false;
        }
    }
    
	/**
     * 是否是时间（hh:mm:ss）
     *
     * @param mixed $string
     *
     * @return boolean
     */
    public static function isTime( $string )
    {
        $parts = explode(':', $string);
        $count = count($parts);

        if ($count != 2 && $count != 3)
        {
            return false;
        }

        if ($count == 2)
        {
            $parts[2] = '00';
        }

        $test = @strtotime($parts[0] . ':' . $parts[1] . ':' . $parts[2]);

        if ($test === - 1 || $test === false || date('H:i:s', $test) != implode(':', $parts))
        {
            return false;
        }

        return true;
    }

    /**
     * 是否是日期 + 时间
     *
     * @param mixed $string
     *
     * @return boolean
     */
    public static function isDatetime( $string )
    {
        $test = @strtotime($string);
        if ($test === false || $test === - 1)
        {
            return false;
        }
        return true;
    }
    
	/**
     * 
     * 是否在指定范围内
     * @param mixed $string
     * @param string $type
     * @param mixed $begin
     * @param mixed $end
     * @param boolean $inclusive
	 *
     * 
     * @return boolean
     */
    public static function isBetween( $string, $type = 'int', $begin, $end, $inclusive = true )
    {
    	$format_valid = false;
    	$compare_value = 0;
    	$begin_value  = 0;
    	$end_value 	  = 0;
    	
    	$method_name = 'is' . ucfirst( strtolower($type) ); 
    	switch( $type ) 
    	{
    		case 'datetime': 
    		case 'time': 
    		case 'date' : 
    			$compare_value = strtotime( $string );
    			$begin_value = strtotime( $begin );
    			$end_value = strtotime( $end );
    			break;
    			
    		case 'float': 
    			$compare_value = floatval( $string );
    			$begin_value = floatval( $begin );
    			$end_value = floatval( $end );
    			break;
    			
    		default: 
    			$compare_value = intval( $string );
    			$begin_value = intval( $begin );
    			$end_value = intval( $end );
    			break;
    	}
    	
    	if (self::$method_name($string) && self::$method_name($begin) && self::$method_name($end))
    	{
    		$format_valid = true;
    	}
    	else
    	{
    		return false;
    	}
    	
    	if ($format_valid)
    	{
    		if ( $inclusive )
    		{
    			return ($compare_value >= $begin_value && $compare_value <= $end_value );
    		}
    		else
    		{
    			return ($compare_value > $begin_value && $compare_value < $end_value );
    		}
    	}
    }
}