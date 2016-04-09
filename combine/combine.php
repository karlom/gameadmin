<?php
/**
 * combine.php
 * 合区
 */

include_once dirname ( __FILE__ ) . '/../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global_not_auth.php';

if($argc < 3){
	echo "use: php {$argv[0]} NEW_DB db1 db2 db3 ...\n";
	exit ;
}

//echo $argc;
//print_r($argv);

$dbs = $argv;
$new_db = $argv[1];
unset($dbs[0]);
unset($dbs[1]);
/*
//print_r($dbs);
$server_ids = array();
foreach($dbs as $k => $db){
	$id = substr($db,7);
	$server_ids[] = "s".$id;
}

$loadServerList = getServerList();

$configs = array();
foreach($loadServerList as $key => $value) {
	if(in_array($key,$server_ids) ){
		$configs[] = getLogDb($loadServerList[$key]);
	}
}
*/
$configs = array();
foreach($dbs as $k => $db){
	$configs[] = array(
		'dbname' => $db,
		'host' => $dbConfig['game_admin']['host'],
		'user' => $dbConfig['game_admin']['user'],
		'passwd' => $dbConfig['game_admin']['passwd'],
	);
}


if(!$server_db){
	$server_db =  new DBMysqlClass();
}
//$new_db = "D3_qq_S20001";

//$excludeTable = array(
//	"t_apply_goods","t_ban_ip","t_ban_account","t_log_online","t_log_billboard_role_atk","t_log_bmsl_live","t_log_mwbd_family_rank","c_role_label",
//	"t_log_task","t_log_store","t_log_lingqi","t_log_tiancheng","t_log_family_contribute","t_log_family_contribution_get_and_use","t_log_jingjie_skill",
//	"t_log_family_enter_and_exit","t_log_team","t_log_friend","t_log_friend_chat","t_log_family_chat","t_log_skill_upgrade","","","",
//	);
/*
$combineTable = array(
	"t_log_register", "t_log_login", "t_log_logout", "t_log_die", "t_log_item", "t_log_career", "t_log_create_loss", 
	"t_log_gold", "t_log_money", "t_log_liquan", "t_log_level_up", "t_log_market_sell", "t_log_market_cancel_sell", 
	"t_log_market_buy", "t_log_jingjie", "t_log_deal", "t_log_refine_strengthen", "t_log_refine_purify", "t_log_refine_purify_reset", 
	"t_log_refine_inlay", "t_log_refine_extend", "t_log_open_vip", "t_log_buy_goods", "t_log_shop_rand", "t_log_talisman_upgrade", 
	"t_log_talisman_illusion", "t_log_npc_shop_buy", "t_message_broadcast", "t_log_task_market", "t_log_blue_icon", "t_log_blue_libao", 
	"t_log_bind_money", "t_log_refine_resolve", "t_log_yuanbao_sum", 
);
*/

$combineTable = array(
	"t_log_register", "t_log_buy_goods", "t_log_pay", "t_log_gold", 
//	"t_log_liquan",  "t_log_open_vip","t_log_blue_icon", "t_log_blue_libao", "t_log_yuanbao_sum", 
);

foreach($configs as $config){
	$dbName = $config['dbname'];	//被合数据库名
	$tablesConfig = array();
	echo "DB: {$dbName}\n";
	$server_db->connect($config);
//	$sql = "insert into " . $new_db . ".t_log_item select * from ".$config['dbname'].".t_log_item";
//	GQuery($sql);
	$getTableSql = "show tables";
	$tables = GFetchRowSet($getTableSql);
	if(!empty($tables)) {
		foreach($tables as $k => $v){
			$table = $v['Tables_in_'.$config['dbname']];
			echo "Get table fields, DB: {$dbName} , table: {$table} \n";
//			if(in_array($table, $excludeTable)){
//				echo "    Table [{$table}] skip.\n";
//				continue;
//			}
			if(!in_array($table, $combineTable)){
				echo "    Table [{$table}] skip.\n";
				continue;
			}
			$getFieldSql = "desc " . $table;
			$fields = GFetchRowSet($getFieldSql);
			$fieldStr = "";
			if(empty($fields)){
				echo "Table [{$table}] can not get fields, exits.";
				exit ;
			}
			foreach($fields as $j => $w){
				$f = $w['Field'];
				if($f == "id"){	//排除id字段
					continue;
				}
				$fieldStr .= '`'.$f.'`,';
			}
			$fieldStr = trim($fieldStr,',');
			$tablesConfig[$table] = array( "name" => $table, "fieldString" => $fieldStr, );
//			$combineTableSql = "insert into " . $new_db . "." . $table ." ({$fieldStr}) select {$fieldStr} from " . $dbName . "." . $table;
		}
	} else {
		echo $config['dbname'].": no table found, exits.";
		exit ;
	}
	
	if(!empty($tablesConfig)){
		foreach($tablesConfig as $k => $t){
			$table = $t['name'];
			$fieldStr = $t['fieldString'];
			echo "Transfer data, DB: {$dbName} , table: {$table} \n";
			$combineTableSql = "insert into " . $new_db . "." . $table ." ({$fieldStr}) select {$fieldStr} from " . $dbName . "." . $table;
			try {
				GQuery($combineTableSql);
				echo "    [ok] table: {$table} \n";
			} catch (Exception $e){
				echo "    [FAIL] table: {$table} , msg: {$e}\n";
			}
//			echo "{$k}:  ".$combineTableSql ."\n";
		}
	} else {
		echo "Can not get any table config, exits.";
		exit;
	}
	
}

/*
foreach($loadServerList as $key => $value) {
	//连接数据库
	$config = getLogDb($loadServerList[$key]);
//	$server_db->connect($config);
}

*/