<?php
if (!defined('INCLUDE_PHP_CLASS_FILE_CENTRAL_LOG_PHP')) {
	define('INCLUDE_PHP_CLASS_FILE_CENTRAL_LOG_PHP', true);
	
	global $UPDATE_LOG_TYPE;
	
	define(CENTRAL_LOG_TIME_PARAM_ERROR, 1);
	
	define(CENTRAL_LOG_TIME_TOO_LONG, 2);
	
	$UPDATE_LOG_TYPE = array(
	 0 => '显示全部',
	 1 => '每天重建充值统计表',  
	 2 => '当前在线及充值', 
	 3 => '收集各服昨天在线数据', 
	 4 => '收集各服昨天充值数据',
	 5 => '收集各服昨天仙石数据',
	 6 => '收集各服昨天仙石增耗存',
	 7 => '增加各级别段充值统计 ',
	 8 => '收集新增付费用户量统计 ',
	 9 => '收集付费玩家最后登陆时间 ',
	10 => '收集今天开服的注册量 ',
	11 => '每天统计当月的充值情况',
	12 => '每天统计昨天每小时充值',
	13 => '收集各服昨天银两使用数据',
	14 => '收集各服昨天银两购买数据',
	15 => '收集各服昨天军功令留存数据',
	16 => '收集各服当天异常事件',
	17 => '收集各服跨服PK统计',
	18 => '收集游戏功能使用统计',
	19 => '检测代理充值异常',
	20 => '收集玩家剩余仙石大于100数据',	
	21 => '收集每天游戏的注册数',
	22 => '收集各服昨天赠送仙石数据',
	23 => '检测仙石赠送记录异常',
	24 => '收集指定时间内的充值数据',
	25 => '收集仙石使用记录',
	26 => '道具购买统计',
	27 => '收集单服概况信息',
	);
	
	class CentralLogClass {
		private $lastID;
		
		public function __construct() {
			
		}
		
		/**
		 * 这里的$beginTime $endTime 用于指定收集该时间段内的数据
		 * @param string $ip
		 * @param string $url
		 * @param int $actionType
		 * @param int $beginTime
		 * @param int $endTime
		 */
		public function start($ip, $url, $actionType, $beginTime, $endTime) {
			$f = array();
			$f['ip'] = $ip;
			// 处理请求的开始时间
			$f['stime'] = time();
			$f['etime'] = 0;
			$f['status'] = 0;
			$f['url'] = $url;
			$f['action_type'] = $actionType;
			// 失败原因默认为0，表示没有发生失败情况
			$f['failed_reason'] = 0;
			// 例如中央服务器要求拉取 2011/5/6 - 2011/5/7之间的数据
			$f['action_begin_time'] = $beginTime;
			$f['action_end_time'] = $endTime;
			global $db;
			$db->query(makeInsertSqlFromArray($f, T_LOG_CENTRAL));
			$this->lastID = $db->insertID();
		}
		
		public function failed($failedReason, $detail=null) {
			$f = array();
			$f['failed_reason'] = intval($failedReason);
			if ($detail != null && $detail != '') {
				$f['failed_detail'] = $detail;
			}
			GQuery(makeUpdateSqlFromArray($f, T_LOG_CENTRAL, $this->lastID));
		}
		
		public function end() {
			$f = array();
			$f['etime'] = time();
			$f['status'] = 1;
			GQuery(makeUpdateSqlFromArray($f, T_LOG_CENTRAL, $this->lastID));
		}
	}
}