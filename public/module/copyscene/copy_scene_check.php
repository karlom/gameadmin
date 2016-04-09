<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
include_once SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
global $lang;

$nowTime = time();
$action  = isset($_POST['action']) ? SS($_POST['action']) : '';
$role    = $_REQUEST['role'];
$role['roleName'] = $roleName    = $role['roleName'] ? autoAddPrefix( SS($role['roleName']) ): '';
$role['accountName'] = $accountName = $role['accountName'] ? autoAddPrefix( SS($role['accountName'])) : '';
$page    = getUrlParam('page');           //设置初始页
$pageLine  = $_POST['pageLine'] ? SS($_POST['pageLine']) : LIST_PER_PAGE_RECORDS;
$type = $_POST['type'] ? SS($_POST['type']) : '200';
//$type2= isset($_POST['type2']) ? SS(trim($_POST['type2'])) : "B.`level` desc";
$type2= isset($_POST['type2']) ? SS(trim($_POST['type2'])) : '';
$strictMatch = SS($_POST['strict']);
$excelParam  = $_POST['excel'];
$excelParam  = SS($excelParam);
if($excelParam == 's'){
	$excelParam ='';
}

//获取时间段
if (!isset ($_POST['starttime'])) {
	$startDate = Datatime :: getPreDay(date("Y-m-d"), 1);
} else {
	$startDate = trim($_POST['starttime']);
}
if (!isset ($_POST['endtime'])) {
	$endDate   = Datatime :: getTodayString();
} else {
	$endDate   = trim($_POST['endtime']);
}

$startDateStamp = strtotime($startDate . ' 0:0:0');
$endDateStamp  = strtotime($endDate . ' 23:59:59');
$openTimestamp = strtotime( ONLINEDATE );
if($startDateStamp < $openTimestamp)
{
	$startDateStamp = $openTimestamp;
	$startDate = ONLINEDATE;
}

if($action == 'start'){
		if(isPost()) {
				$accountName2 = SS($_POST['an']);
				$sTime2 = strtotime(SS($_POST['st']));
				$eTime2 = strtotime(SS($_POST['et']));
				$mapId2 = SS($_POST['mi']);
				if(isset($accountName2)) {
						$sql = " select `id`,`mdate`,`mtime`,`item_id`,`isbind`,`num`,`color`,`type`,`detail` from ".T_LOG_ITEM." where `account_name`='$accountName2' and `map_id`=$mapId2 and `mtime`>=$sTime2 and `mtime`<=$eTime2 ";
						$rs  = GFetchRowSet($sql,'id');
						if(empty($rs)){
								$stat = 0;
								$msg  = $lang->copyscene->itemNotExists;
								$result = json_encode(array('stat'=>$stat,'msg'=>$msg,));
								echo $result;
								exit();
						} else {
								foreach($rs as $r=>&$s){
										$s['id'] = $s['id'];
										$s['item_id'] = $s['item_id'];
										$s['mdate'] = $s['mdate']; 
										$s['item_name'] = $arrItemsAll[$s['item_id']]['name'];	
										if($s['isbind'] = 0){
											$s['isbind'] = $lang->copyscene->unfinish;
										} else {
											$s['isbind'] = $lang->copyscene->finish;
										}
										$s['num'] = $s['num'];
										$s['color'] = $dictColor[$s['color']];
										$s['type'] = $dictItemUsageType[$s['type']];
										$s['detail'] = $s['detail'];
								}
								$stat = $rs;
								$msg = 0;	
								$result = json_encode(array('stat'=>$stat,'msg'=>$msg,));
								echo $result;
								exit();
						}
				}	
		}
}

$where = 1;
$where .= " and `mtime`>=$startDateStamp and `mtime`<=$endDateStamp ";
if($type != '200') {
	$where .= " and  `map_id`=$type ";
}

$where .=  $accountName ? " and `account_name` = '{$accountName}' ":'';
$where .=  $roleName ? " and `role_name` = '{$roleName}' ":'';

$arrType2 = array(
        "B.`map_id`"           	=> " {$lang->copyscene->into}"."(".$lang->copyscene->level.")↑ ",
        "B.`map_id` desc"       => " {$lang->copyscene->into}"."(".$lang->copyscene->level.")↓ ",
        "B.`level`"           	=> " {$lang->sys->playerLevel}↑ ",
        "B.`level` desc"        => " {$lang->sys->playerLevel}↓ ",
        "B.`is_captain`"       	=> " {$lang->copyscene->isCaptain}↑ ",
        "B.`is_captain` desc"   => " {$lang->copyscene->isCaptain}↓ ",
        "B.`is_team`"         	=> " {$lang->copyscene->isTeam}↑ ",
        "B.`is_team` desc"      => " {$lang->copyscene->isTeam}↓ ",
        "B.`men_count`"         => " {$lang->copyscene->menCount}↑ ",
        "B.`men_count` desc"    => " {$lang->copyscene->menCount}↓ ",
        "B.`time_used`"     	=> " {$lang->copyscene->usedTime}↑ ",
        'B.`time_used` desc'    => " {$lang->copyscene->usedTime}↓ ",
        "B.`enter_times`"     	=> " {$lang->copyscene->enterTims}↑ ",
        'B.`enter_times` desc'  => " {$lang->copyscene->enterTims}↓ ",
        "B.`status`"			=> " {$lang->copyscene->isFinished}↑ ",
        'B.`status` desc'       => " {$lang->copyscene->isFinished}↓ ",
);
if($type2) {
//	$order .= " ORDER BY B.`map_id`, B.`enter_times`, {$type2} ";    
	$order .= " ORDER BY {$type2} ";    
} else {
//	$order .= " ORDER BY `map_id`,`enter_times` ";    
	$order .= " ORDER BY B.`map_id`, B.`enter_times` ";    
}

//页数
$recordCount = 0;                          //总记录
$startNum  = ($page - 1) * $pageLine;      //每页开始位置
$viewData  = getCopySceneRecord(1,$where,$order,$startNum,$pageLine,&$recordCount);
$pageCount = ceil($recordCount/$pageLine ); //总页数
$pageList  = getPages($page, $recordCount, $pageLine);

foreach ($viewData as $key => &$value) {
	$value['time_used'] = ConvertSecondToChinese($value['time_used']);
}

$dateStrPrev = strftime("%Y-%m-%d", strtotime($startDate) - 86400);
$dateStrToday = strftime("%Y-%m-%d");
$dateStrNext = strftime("%Y-%m-%d", strtotime($startDate) + 86400);
$dateOnline = ONLINEDATE;
$arrType = $goldType;
$arrType[-1] = $lang->page->showType1;
ksort($arrType);

if($recordCount>=5000) { 
	$startNum2=array();
	$pageLine2 = 5000;
	$page2     = ceil($recordCount/$pageLine2);
	for($i=1;$i<=$page2;$i++){
		$startNum2['s']= $lang->msg->mustSelectOut;
		$startNum2[($i-1)*$pageLine2] = ($i-1)*$pageLine2. $lang->page->to  .($i)*$pageLine2. $lang->page->row . $lang->page->excel ;
	}
}

//输出Excel文件
if($recordCount>0 && $excelParam == true || is_numeric($excelParam)){
	if($recordCount<5000) { 
		$viewData2 = getCopySceneRecord(0,$where,$order);
	} else {
		$viewData2 = getCopySceneRecord(1,$where,$order,$excelParam,$pageLine2);
	}

	$excel = getExcel();
	$smarty->assign('title', $excel['title']); // 标题
	$smarty->assign('hd', $excel['hd']);       // 表头
	$smarty->assign('num',$excel['hdnum']);    // 列数
	$smarty->assign('ct', $excel['content']);  // 内容

	// 输出文件头，表明是要输出 excel 文件
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename='.$excel['title'].date('_Ymd_Gi_Gs').'.xls');
	$smarty->display('module/pay/pay_excel.tpl');
	exit;
}

$minDate = ONLINEDATE;
$maxDate = Datatime :: getTodayString();
$smarty->assign("minDate", $minDate);
$smarty->assign("maxDate", $maxDate);
$smarty->assign("dateStrPrev", $dateStrPrev);
$smarty->assign("dateStrToday", $dateStrToday);
$smarty->assign("dateStrNext", $dateStrNext);
$smarty->assign("dateOnline", $dateOnline);
$smarty->assign("startDate", $startDate);
$smarty->assign("endDate", $endDate);

$smarty->assign('lang', $lang);
$smarty->assign('viewData', $viewData);
$smarty->assign('page', $page);
$smarty->assign('type', $type);
$smarty->assign('type2', $type2);
$smarty->assign('type3', $type3);
$smarty->assign('excelParam', $excelParam);
$smarty->assign('arrType', $arrType);
$smarty->assign('arrType2', $arrType2);
$smarty->assign('dictMapType', $dictMapType);
$smarty->assign('pageList', $pageList);
$smarty->assign('pageLine', $pageLine);
$smarty->assign('startNum2', $startNum2);
$smarty->assign('pageCount', $pageCount);
$smarty->assign('role', $role);
$smarty->assign('strictMatch', $strictMatch);
$smarty->assign('recordCount', $recordCount);
$smarty->display("module/copyscene/copy_scene_check.tpl");
exit;

/**
 * @param $tmp 是否使用LIMIT
 */
function getCopySceneRecord($tmp,$where='',$order='',$startNum='',$record='',&$counts=''){
//		$sql = " select `mdate`,`mtime` as `etime`,`role_name`,`account_name`,`level`,`map_id`,`is_captain`,`is_team`,`men_count`,`time_used`,`enter_times`,`status` from `".T_LOG_COPY_SCENE."` where {$where} ";
		$sql = " select B.`mdate`, A.`stime`, B.`etime`, B.`role_name`, B.`account_name`, B.`level`, B.`map_id`, B.`is_captain`, B.`is_team`, B.`men_count`, B.`time_used`, B.`enter_times`, B.`status` from (select `mtime` as `stime`,`role_name`,`account_name`,`level`,`map_id`,`time_used`,`enter_times`,`status`,`day` from `".T_LOG_COPY_SCENE."` where {$where} and `status`=0) A, (select `mdate`,`mtime` as `etime`,`role_name`,`account_name`,`level`,`map_id`,`is_captain`,`is_team`,`men_count`,`time_used`,`enter_times`,`status`,`day` from `".T_LOG_COPY_SCENE."` where {$where} and `status`>0) B where A.`day`= B.`day` and  A.`map_id`=B.`map_id` and  A.`account_name`= B.`account_name` and  A.`enter_times`= B.`enter_times` and A.`stime`< B.`etime` ";
		if(!empty($order)) {
			$sql .= " {$order} ";
		}
		if($tmp==1) {
			$sql.= " LIMIT {$startNum}, {$record} ";
		} 
		$result = GFetchRowSet($sql);
		$countSql = " select count(B.`role_name`) count  from (select `mtime` as `stime`,`role_name`,`account_name`,`level`,`map_id`,`time_used`,`enter_times`,`status`, `day` from `".T_LOG_COPY_SCENE."` where {$where} and `status`=0) A, (select `mdate`,`mtime` as `etime`,`role_name`,`account_name`,`level`,`map_id`,`is_captain`,`is_team`,`men_count`,`time_used`,`enter_times`,`status`,`day` from `".T_LOG_COPY_SCENE."` where {$where} and `status`>0) B where A.`day`= B.`day` and  A.`map_id`=B.`map_id` and  A.`account_name`= B.`account_name` and  A.`enter_times`= B.`enter_times` and A.`stime`< B.`etime` ";
		$countsRs = GFetchRowOne($countSql);
		$counts = $countsRs['count'];
		return $result;
}

function getExcel(){
	//记录数据
        global $viewData2,$lang,$arrType,$dictMapType;
	$excel = array();

	// 标题
	$excel['title'] = $lang->menu->copySceneData;
	// 表头
	$excel['hd'] =  array(
                	$lang->sys->account,
			$lang->page->roleName,
			$lang->sys->playerLevel,
			$lang->copyscene->inTime,
			$lang->copyscene->outTime,
			$lang->copyscene->mapId,
			$lang->copyscene->into,
			$lang->copyscene->level,
			$lang->copyscene->enterTimes,
			$lang->copyscene->isFinished,
			$lang->copyscene->usedTime,
			$lang->copyscene->isCaptain,
			$lang->copyscene->isTeam,
			$lang->copyscene->menCount,
	);
	// 列数
	$excel['hdnum'] = count($excel['hd']);

	$excel['content'] = array();
	foreach($viewData2 as $k=>$v){
		$excel['content'][$k] = array();
		$excel['content'][$k][] = array('StyleID'=>'s28', 'Type'=>'String', 'content'=>$v['role_name']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['account_name']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['level']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['stime']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['etime']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['map_id']);
		if($dictMapType[$v['map_id']]['isCopyScene'] == true) {
			$copyName  = $dictMapType[$v['map_id']]['name'];
			$copyLevel = $dictMapType[$v['map_id']]['level'];
		}
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$copyName);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$copyLevel);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['enter_times']);
		if($v['status']==0) {
			$v['status'] = $lang->copyscene->goInto;
		} elseif ($v['status']==1) {
			$v['status'] = $lang->copyscene->finish;
		} else {
			$v['status'] = $lang->copyscene->unfinish;
		}
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['status']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['time_used'].$lang->copyscene->seconds);
		if($v['is_captain'] == 1) {
			$v['is_captain'] = $lang->player->yes;
		} else {
			$v['is_captain'] = $lang->player->no;
		}
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['is_captain']);
		if($v['is_captain'] == 1) {
			$v['is_team'] = $lang->player->yes;
		} else {
			$v['is_team'] = $lang->player->no;
		}
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['is_team']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['men_count']);
	}
	return $excel;
}
