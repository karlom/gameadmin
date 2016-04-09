<?php
/**
*	Description:获取游戏在线数据,读取数据库中的最新数据，不去游戏服取即时数据。
*/


include dirname(dirname(__FILE__)).'/idip_api/idip_auth.php';


$tableName = T_LOG_ONLINE;

$sql = " select online from `t_log_online` order by id desc limit 0,1;";
$rs = GFetchRowOne($sql);
$result = $rs['online'];
echo $result;
	

