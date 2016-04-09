<?php 
/**
 * 请求方法集合
 */
class RequestCollection
{
	public static $onlineListCacheKey = 'online_list';
	public static $onlineListCacheExpire = 300;
	
	public static function getOnlineList( $forceRemote = false )
	{
		$cache = ExtMemcache::instance();
		if($forceRemote)
		{
			self::delOnlineListCache();
		}
		
		$onlineList = $cache->get(self::$onlineListCacheKey);

		if ( !$onlineList || empty($onlineList))
		{// 缓存不存在，从远程获取
			$ret = interfaceRequest('getonlinelist', array());
			$onlineList = array();
	
			if( $ret['result'] == 1 )
			{
				$onlineList['timestamp'] = time();
				$onlineList['data'] = $ret['data'];	
			}
			$cache->set(self::$onlineListCacheKey, $onlineList, true, MEMCACHE_COMPRESSED, self::$onlineListCacheExpire);
			
		}
		
		return $onlineList;
	}
	
	public static function delOnlineListCache()
	{
		$cache = ExtMemcache::instance();
		$cache->delete(self::$onlineListCacheKey);
	}
	
	public static function sendMail($params)
	{
		return interfaceRequest('sendmail', $params);
	}
}