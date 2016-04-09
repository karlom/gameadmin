<?php
/**
 * Memcache子类，用于扩展一些Memcache的方法
 */
class ExtMemcache extends Memcache
{
	private static $instance = null;
	
	/**
	 * 
	 * 私有化构造函数，防止外部实例化对象。
	 */
	private function __construct()
	{
		$this->instance = new parent;
		$this->instance->pconnect(MEMCACHE_HOST, MEMCACHE_PORT, MEMCACHE_TIMEOUT);
	}
	
	/**
	 * 
	 * 外部调用的实例化接口，单一实例。
	 */
	public static function instance()
	{
		if (self::$instance == null)
		{
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	/**
	 * 
	 * 设置/添加缓存
	 * @param string $key 缓存键值
	 * @param mixed $var 缓存内容
	 * @param boolean $isSeperate 是否按不同游戏服独立存储
	 * @param int $flag 是否启用压缩
	 * @param int $expire 过期时间，以秒为单位
	 */
	public function set( $key, $var, $isSeperate = true, $flag = MEMCACHE_COMPRESS , $expire = MEMCACHE_EXPIRE )
	{
		$cacheKey = $key;
		if( $isSeperate )
		{
			$cacheKey = $_SESSION ['gameAdminServer'] . '_' . $key;
		}
		if($expire > 0)
		{
			$expire = $expire + time();
		}
		$this->instance->set( $cacheKey, $var, $flag,  $expire);
	}
	
	/**
	 * 
	 * 获取缓存
	 * @param string $key 缓存键值
	 * @param boolean $isSeperate 是否按不同游戏服独立存储
	 */
	public function get( $key, $isSeperate = true )
	{
		$cacheKey = $key;
		if( $isSeperate )
		{
			$cacheKey = $_SESSION ['gameAdminServer'] . '_' . $key;
		}

		return $this->instance->get( $cacheKey );
	}
	
	/**
	 * 
	 * 删除缓存
	 * @param string $key 缓存键值
	 * @param boolean $isSeperate 是否按不同游戏服独立存储
	 * @param int $timeout 超时
	 */
	public function delete( $key, $isSeperate = true, $timeout = MEMCACHE_TIMEOUT )
	{
		$cacheKey = $key;
		if( $isSeperate )
		{
			$cacheKey = $_SESSION ['gameAdminServer'] . '_' . $key;
		}
		
		return $this->instance->delete( $cacheKey );
	}
}