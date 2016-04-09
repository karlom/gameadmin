<?php
/*
 *日期时间的工具类
 */
class Datatime {
	/*
	 * 获取前一天的日期，输入格式是：年-月-日
	 */
	static public function getPreDay($day, $pre=1) {
		return date("Y-m-d",(strtotime($day)-$pre*3600*24));
	}
	
	static public function getTotleDay($startDay,$endDay) {
		return((strtotime($endDay)-strtotime($startDay))/(3600*24));
	}
	/**
	 * 返回当前天0时0分0秒的时间
	 * @param $outstring	是否返回字符串类型，默认为false
	 * 如果$outstring为true则返回该时间的字符串形式，否则为时间戳
	 */
	static public function getTime_Today0($outstring = false) {
		$str_today0 = strftime ( "%Y-%m-%d", time () );
		$result = strtotime ( $str_today0 );
		if ($outstring)
			return strftime ( "%Y-%m-%d %H:%M:%S", $result );
		else
			return $result;
	}
	
	static public function getTimeString($srcTimeStamp) {
		return strftime ( "%Y-%m-%d %H:%M:%S", $srcTimeStamp );
	}
	
	static public function getDayString($srcTimeStamp) {
		return strftime ( "%Y-%m-%d", $srcTimeStamp );
	}
	
	static public function getTodayString() {
		return strftime ( "%Y-%m-%d" );
	}
	
	static public function getCurTimeString() {
		return strftime ( "%Y-%m-%d %H:%M:%S" );
	}
    static public function getPrevWeekString(){
        return strftime("%Y-%m-%d", strtotime(date('Y-m-d',strtotime('-6day'))));
    }
	/**
     * 
     * 获得所给日期的月头的时间戳
     * @param string $dateString
     */
    static public function getMonthBeginTimestamp($dateString){
    	$beginMonthTS = strtotime($dateString);
		$year = date('Y', $beginMonthTS);
		$month = date('m', $beginMonthTS);
		$dateString = $year . '-' . $month;
		return strtotime($dateString);
    }
    
    /**
     * 
     * 获得所给日期的月末的时间戳
     * @param string $dateString
     */
    static public function getMonthEndTimestamp($dateString){
    	$endMonthTS = strtotime($dateString);
		$year = date('Y', $endMonthTS);
		$month = date('m', $endMonthTS);
		if($month == 12)
		{
			$year++;
			$dateString = $year . '-' . 1;
		}
		else
		{
			$dateString = $year . '-' . ($month + 1);
		}

		return strtotime($dateString) - 1;
    }
    
	/**
     * 
     * 获得所给日期的一天开始的时间戳
     * @param string $dateString
     */
    static public function getDayBeginTimestamp($dateString){
    	$beginMonthTS = strtotime($dateString);
		$year = date('Y', $beginMonthTS);
		$month = date('m', $beginMonthTS);
		$day = date('d', $beginMonthTS);
		$dateString = $year . '-' . $month . '-' . $day . ' 00:00:00';
		return strtotime($dateString);
    }
    
    /**
     * 
     * 获得所给日期的一天结束的时间戳
     * @param string $dateString
     */
    static public function getDayEndTimestamp($dateString){
    	$endMonthTS = strtotime($dateString);
		$year = date('Y', $endMonthTS);
		$month = date('m', $endMonthTS);
		$day = date('d', $endMonthTS);
		$dateString = $year . '-' . $month . '-' . $day . ' 23:59:59';
		return strtotime($dateString);
    }
	
    static public function getFormatStringByString($format, $dateString)
    {
    	return date($format, strtotime($dateString));
    }
	
	static public function timestampToDayHourMinute($timestamp)
	{
		return array(	
				floor($timestamp / 86400),
				floor(($timestamp % 86400) / 3600),
				floor(($timestamp % 3600) / 60)
			);
	}
	
	static public function dayHourMinuteToTimestamp($day, $hour, $minute)
	{
		return ( ($day * 86400) + ($hour * 3600) + ($minute * 60) ) ;
	}
	
	/**
	 *秒数转日时分秒
	 *@param int second
	 *@return 格式：3天5小时11分20秒
	 *@author Libiao 
	 */
	static public function secondToDay($second) {
		$sec = $second%60;
		$min = $second/60%60 ;
		$hour = $second/3600%60;
		$day = $second/86400%24;
		if ($day) {
			return $day."天 ".$hour."小时 ".$min."分 ".$sec."秒";
		} elseif($hour) {
			return $hour."小时 ".$min."分 ".$sec."秒";
		} elseif ($min) {
			return $min."分 ".$sec."秒";
		} else {
			return $sec."秒";
		}
	}
}