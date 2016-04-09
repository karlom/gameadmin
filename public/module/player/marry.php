<?php
/**
 * marry.php
 * 仙侣数据统计
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

//$roleName = $_POST['role_name'] ; 
//$accountName = $_POST['account_name'] ; 

$lookingday = $_POST['lookingday'];

$today = date("Y-m-d");

//获取时间段
if (! isset ( $_POST ['starttime'] )){
    $dateStart = Datatime::getPrevWeekString ();
}else{
    $dateStart = SS ( $_POST ['starttime'] );
}

$dateStart = (strtotime($dateStart) >= strtotime(ONLINEDATE)) ? $dateStart : ONLINEDATE;
$dateEnd = ! isset ($_POST['endtime']) ? Datatime::getTodayString() :  SS ($_POST['endtime']);

$lookingday = $_POST['lookingday'];

if( !empty($_POST['today']) ) {
	$dateStart = $dateEnd = $today;
}
if( !empty($_POST['all']) ) {
	$dateStart = ONLINEDATE;
	$dateEnd = $today;
}

if(!empty($_POST['preday'])){
	$dateStart = $dateEnd = date("Y-m-d", strtotime($dateStart)-86400 );
}
if(!empty($_POST['nextday'])){
	$dateStart = $dateEnd = date("Y-m-d", strtotime($dateEnd)+86400 );
}

$dateStartTamp = strtotime($dateStart." 0:0:0");
$dateEndTamp = strtotime($dateEnd." 23:59:59");

if($dateStartTamp < strtotime(ONLINEDATE)){
	$dateStart = ONLINEDATE;
}
if( $dateStartTamp > strtotime($today) ){
	$dateStart = $today;
}

//if($dateEndTamp > strtotime($today) ){
//	$dateEnd = $today;
//}
if($dateEndTamp < strtotime(ONLINEDATE)){
	$dateEnd = ONLINEDATE;
}

$dateStartTamp = strtotime($dateStart." 0:0:0");
$dateEndTamp = strtotime($dateEnd." 23:59:59");


$where = " mtime>={$dateStartTamp} AND mtime<={$dateEndTamp} ";
$where2 = $where;
if($roleName) {
	$where .= " AND role_name='{$roleName}' ";
}
if($accountName) {
	$where .= " AND account_name='{$accountName}' ";
}

$record = $_POST['record'] ? SS($_POST['record']) : LIST_PER_PAGE_RECORDS;

$counts = 0;//总记录
$pageno = getUrlParam('page');//设置初始页
$startNum = ($pageno - 1) * $record; //每页开始位置
$viewData = getYellowVipData($where, $startNum, $record, $counts);

$pageCount = ceil ( $counts/$record );
$pagelist = getPages($pageno, $counts,$record);

$statisticsData = getStatisticsData($where2,$dateStartTamp,$dateEndTamp);

$lookingday = $dateEnd;
$maxDate = date ( "Y-m-d" );
$data = array(
    'dateStart' => $dateStart,
    'dateEnd' => $dateEnd,
    'minDate' => ONLINEDATE,
    'maxDate' => $maxDate+86400,
    'role_name' => $roleName,
    'account_name' => $accountName,
    'lookingday' => $lookingday,
    
    'counts' => $counts,
    'record' => $record,
    'pagelist' => $pagelist,
    'pageCount' => $pageCount,
    'pageno' => $pageno,
    
    'lang' => $lang,
    'viewData' => $viewData,
    'statisticsData' => $statisticsData,
);


$smarty->assign ($data);
$smarty->display("module/player/marry.tpl");


function getYellowVipData($where,$startNum,$record,&$counts) {
	
	$sqlYellowVipCount = "select count(*) as cnt from " . T_LOG_OPEN_VIP . " where {$where} ";
	$result = GFetchRowOne($sqlYellowVipCount);
	$counts = $result['cnt'];
	
	$sqlYellowVip = "select * from " . T_LOG_OPEN_VIP . " where {$where} order by mtime desc limit {$startNum},{$record} ";
	$result = GFetchRowSet($sqlYellowVip);
	
	return $result;
}

function getStatisticsData($where, $st="", $et=""){
	//总
	//求婚次数
	$sql01 = "select count(*) as proposeCnt  from t_log_marry_ask where {$where} ";
	$sql01Result = GFetchRowOne($sql01);
	$proposeCnt = $sql01Result['proposeCnt'];
	//求婚成功次数
	$sql01 = "select count(*) as proposeSucc  from t_log_marry_ask_result where {$where} and `result`=1 ";
	$sql01Result = GFetchRowOne($sql01);
	$proposeSucc = $sql01Result['proposeSucc'];
	
	if($proposeCnt){
		$proposeRate = round($proposeSucc/$proposeCnt, 4);
	}
	
	$propose = array( "proposeCnt" => $proposeCnt, "proposeSucc" => $proposeSucc,  "proposeRate" => $proposeRate ? $proposeRate : 0, );
	
	//婚宴预约
	$sql02 = "select t1.book_time, count(t1.id) as cnt, max(t1.price) as finalPrice, t1.role_name1, t1.role_name2 from (select * from t_log_marry_book where {$where} order by price desc) t1  group by t1.book_time ";
	$sql02Result = GFetchRowSet($sql02);
	
	if(!empty($sql02Result)){
		foreach($sql02Result as $k => $v){
			$weddingReserve[$k]['book_time'] = $v['book_time']; 
			$weddingReserve[$k]['field'] = date("Y-m-d H:i", $v['book_time']); 
			$weddingReserve[$k]['count'] = $v['cnt']; 
			$weddingReserve[$k]['finalPrice'] = $v['finalPrice']; 
			$weddingReserve[$k]['bid'] = $v['role_name1'].' / '.$v['role_name2']; 
		}
	}
	//婚宴预约历史最高竞价
	$sql02 = "select max(price) as maxPrice from t_log_marry_book ";
	$sql02Result = GFetchRowOne($sql02);
	
	$maxPrice = $sql02Result ? $sql02Result['maxPrice'] : 0;

	//婚宴红包赠送
	//婚宴场次：
//	$sql = "select distinct book_time, from_unixtime(book_time) as bdate from t_log_marry_book where book_time>={$st} and book_time<={$et} ";
	$sql ="select t1.book_time, t1.price, t1.role_name1, t1.role_name2, from_unixtime(t1.book_time) as bdate 
		from (select * from t_log_marry_book  where book_time>={$st} and book_time<={$et} ) t1
		join (select book_time, max(price) as price from t_log_marry_book group by book_time ) t2
		on t1.price=t2.price and t1.book_time=t2.book_time";
	$retFields = GFetchRowSet($sql);
	
	$weddingTime = (25+3)*60;	//婚宴时长，25分钟
	if(!empty($retFields)){
//		$fieldCount = count($retFields);
		foreach($retFields as $k => $v ){
			$retFields[$k]['start'] = $v['book_time']; 
			$retFields[$k]['end'] = $v['book_time'] + $weddingTime; 
			$retFields[$k]['datetime'] = date("Y-m-d H:i", $v['book_time']);
			
			$fields[$v['book_time']] = $retFields[$k];
		}

		foreach($retFields as $k => $v){
			$sql03 .= "select '{$v['start']}' as field, count(distinct uuid) as xs_cnt, sum(gold) as sum_gold from t_log_gold where mtime>={$v['start']} and mtime<{$v['end']} and type=20176 and gold<0 ";
			$sql04 .= "select '{$v['start']}' as field, count(distinct uuid) as tb_cnt, sum(money) as sum_money from t_log_money where mtime>={$v['start']} and mtime<{$v['end']} and type=30175 and money<0 ";
			
			if($k < count($retFields) -1 ){
				$sql03 .= " union all ";
				$sql04 .= " union all ";
			}
		}

		$sql = "select t1.*,t2.* from ({$sql03}) t1 join ({$sql04}) t2 on t1.field = t2.field";

		$result = GFetchRowSet($sql);
		if(!empty($result)){
			foreach($result as $k => $v) {
				$result[$k]['sum_gold'] = $v['sum_gold'] ? $v['sum_gold'] : 0;
				$result[$k]['sum_money'] = $v['sum_money'] ? $v['sum_money'] : 0;
				
				$fields[$v['field']]['role_count'] = $v['xs_cnt'] + $v['tb_cnt'] ;
				$fields[$v['field']]['sum_gold'] = $v['sum_gold'] ? -$v['sum_gold'] : 0;
				$fields[$v['field']]['sum_money'] = $v['sum_money'] ? -$v['sum_money'] : 0;
			}
		}
	}
	
	//日常宴会开启
	//铜币 百年好合, 仙石 龙凤比翼
	$sql05 = "select mtime, mdate, account_name, role_name,type, money from t_log_money where {$where} and type=30173 and money<0 " .
			" union all " .
			" select mtime, mdate, account_name, role_name,type, money from t_log_bind_money where {$where} and type=90173 and money<0 " .
			" union all " .
			" select mtime, mdate, account_name, role_name,type, gold as money from t_log_gold where {$where} and type=20174 and gold<0 ";
	$result = GFetchRowSet($sql05);
	
	if(!empty($result)){
		$sum_gold = 0 ;
		$sum_money = 0 ;
		foreach($result as $k => $v){
			$v['id'] = $k+1;
			$v['money'] = -$v['money'];
			
			if($v['type'] == 30173 || $v['type'] == 90173) {
				$sum_money += $v['money'];
				$v['name'] = '百年好合';
				$v['gold'] = 0;
			} else if ($v['type'] == 20174){
				$sum_gold += $v['money'];
				$v['name'] = '龙凤比翼';
				$v['gold'] = $v['money'];
				$v['money'] = 0;
			}
//			$sum_money += ($v['type']== 30173) ? $v['money'] : 0;
//			$sum_gold += ($v['type']== 20174) ? $v['money'] : 0;
//			$v['name'] = ($v['type'] == 30173 ) ? '百年好合' : '龙凤比翼';
			
			$banquet[$k] = $v;
		}
		$banquet = sortArrayByKey($banquet, 'mtime' , 'desc');
		$banquet_sum = array('sum_gold' => $sum_gold, 'sum_money' => $sum_money,);
	}
	
	//日常巡游开启
	//铜币 花车巡游, 仙石 仙空遨游
	$sql06 = " select t1.*, t2.* from " .
			" ( select mtime, mdate, account_name as account, role_name as role,type, money from t_log_money where {$where} and type=30183 and money<0 " .
			" union all " . 
			" select mtime, mdate, account_name as account, role_name as role,type, money from t_log_bind_money where {$where} and type=90183 and money<0 " .
			" union all " .
			" select mtime, mdate, account_name, role_name,type, gold as money from t_log_gold where {$where} and type=20184 and gold<0 " .
			" ) t1 , ( select account_name, role_name, target_account_name, target_role_name from t_log_marry_ask_result where result=1 order by mtime desc ) t2 " .
			" where t1.account = t2.account_name or t1.account = t2.target_account_name ";
	$result = GFetchRowSet($sql06);

	if(!empty($result)){
		$sum_gold = 0 ;
		$sum_money = 0 ;
		foreach($result as $k => $v){
			$v['id'] = $k+1;
			$v['money'] = -$v['money'];
			
			if($v['type'] == 30183 || $v['type'] == 90183) {
				$sum_money += $v['money'];
				$v['name'] = '花车巡游';
				$v['gold'] = 0;
			} else if ($v['type'] == 20184){
				$sum_gold += $v['money'];
				$v['name'] = '仙空遨游';
				$v['gold'] = $v['money'];
				$v['money'] = 0;
			}
			$parade[$k] = $v;
			$parade = sortArrayByKey($parade, 'mtime', 'desc' );
		}
		$parade_sum = array('sum_gold' => $sum_gold, 'sum_money' => $sum_money,);
	}
	
	//离婚次数
	$sql07 = "select count(*) as `divorce_cnt`, sum(if(divorceType=0, 1, 0) ) as `peace`, sum(if(divorceType=1, 1, 0) ) as `force`, " .
			" sum(if(moneyType=0, -money, 0)) as `sum_bind_xs`, sum(if(moneyType=1, -money, 0)) as `sum_xs`, sum(-money) as `sum_all_xs` " .
			" from " . T_LOG_MARRY_DIVORCE . " where {$where} and ( ( operator=1 and money<0 and divorceType=1 ) or ( operator=0 and divorceType=0) ) " .
			" having divorce_cnt>0 ";
	$divorce = GFetchRowOne($sql07);
	
	$data = array(
//		'propose' => array("count" => 11),
		'propose' => $propose,
		'weddingReserve' => $weddingReserve,
		'maxPrice' => $maxPrice,
		'givePaper' => $fields,
		'banquet' => $banquet,
		'banquet_sum' => $banquet_sum,
		'parade' => $parade,
		'parade_sum' => $parade_sum,
		'divorce' => $divorce,
	);
	
	return $data;
}