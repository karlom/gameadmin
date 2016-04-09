<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT.'/goldConfig.php';
include_once SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
global $lang;

$nowTime = time();
$action  = isset($_POST['action']) ? SS($_POST['action']) : '';
$role    = $_REQUEST['role'];
$role['roleName'] = $roleName    = $role['roleName'] ?  SS($role['roleName']) : '';
$role['accountName'] = $accountName = $role['accountName'] ?  SS($role['accountName']) : '';
$page    = getUrlParam('page');           //设置初始页
$pageLine  = $_POST['pageLine'] ? SS($_POST['pageLine']) : LIST_PER_PAGE_RECORDS;
$type = $_POST['type'] ? SS($_POST['type']) : -1;
$type2= isset($_POST['type2']) ? SS(trim($_POST['type2'])) : "`gold` desc";
$type3= isset($_POST['type3']) ? SS(trim($_POST['type3'])) : "`mtime` desc";
$strictMatch = SS($_POST['strict']);
$excelParam  = $_POST['excel'];
$excelParam  = SS($excelParam);
if($excelParam == 's'){
	$excelParam ='';
}

//获取时间段
if (!isset ($_POST['starttime'])) {
	$startDate = Datatime :: getPreDay(date("Y-m-d"), 7);
} else {
	$startDate = trim($_POST['starttime']);
}
if (!isset ($_POST['endtime'])) {
	$endDate   = Datatime :: getTodayString();
} else {
	$endDate   = trim($_POST['endtime']);
}

$startDate = (strtotime($startDate) >= strtotime(ONLINEDATE)) ? $startDate : ONLINEDATE;

$startDateStamp = strtotime($startDate . ' 0:0:0');
$endDateStamp  = strtotime($endDate . ' 23:59:59');

$where = 1;
$where .= " and `mtime`>=$startDateStamp and `mtime`<=$endDateStamp ";
if (-1 != $type) {
	$where .= " and  `type`=$type ";
}
if ($strictMatch ==1) {
	$where .=  $accountName ? " and `account_name` = '{$accountName}' ":'';
	$where .=  $roleName ? " and `role_name` = '{$roleName}' ":'';
} else {
	$where .=  $accountName ? " and `account_name` like '%{$accountName}%' ":'';
	$where .=  $roleName ? " and `role_name` like '%{$roleName}%' ":'';
}
$arrType2 = array(
        "`gold` desc"           => " {$lang->gold->consume}{$lang->currency->yuanbao}{$lang->page->number}↑ ",
        "`gold`"                => " {$lang->gold->consume}{$lang->currency->yuanbao}{$lang->page->number}↓ ",
        "`mtime`"           	=> " {$lang->gold->consume}{$lang->page->time}↑ ",
        "`mtime` desc"          => " {$lang->gold->consume}{$lang->page->time}↓ ",
        "`type`"            	=> " {$lang->gold->op_type}↑ ",
        "`type` desc"           => " {$lang->gold->op_type}↓ ",
        "`item_id`"         	=> " {$lang->page->itemsNum}↑ ",
        "`item_id` desc"        => " {$lang->page->itemsNum}↓ ",
        "`num`"             	=> " {$lang->gold->goldBalance}↑ ",
        "`num` desc"            => " {$lang->gold->goldBalance}↓ ",
);
if(-1 == $type){
	if($type2 || $type3){
		preg_match('/desc/',$type2,$mtype1);
		preg_match('/desc/',$type3,$mtype2);
		if($type2 == $type3){
			if($mtype1){
				$order .= " ORDER BY `type`,{$type2} ";    
			}else{
				$order .= " ORDER BY `type` desc,{$type2} ";    
			}
		} else {
			if($mtype1){
				$order .= " ORDER BY `type`,{$type2},{$type3} ";
			} else {
				$order .= " ORDER BY `type` desc,{$type2}, {$type3} ";
			}
		}           
	}
}

//页数
$recordCount = 0;                          //总记录
$startNum  = ($page - 1) * $pageLine;      //每页开始位置
$viewData  = getGoldUserRecord(1,$where,$order,$startNum,$pageLine,&$recordCount);
$pageCount = ceil($recordCount/$pageLine ); //总页数
$pageList  = getPages($page, $recordCount, $pageLine);

$dateStrPrev = strftime("%Y-%m-%d", strtotime($startDate) - 86400);
$dateStrToday = strftime("%Y-%m-%d");
$dateStrNext = strftime("%Y-%m-%d", strtotime($startDate) + 86400);
$dateOnline = ONLINEDATE;
$arrType = $goldType;
$arrType[-1] = $lang->page->showType1;
//ksort($arrType);

if($recordCount>=5000) { 
	$startNum2=array();
	$pageLine2 = 5000;
	$page2     = ceil($recordCount/$pageLine2);
	for($i=1;$i<=$page2;$i++){
		$startNum2['s']= $lang->msg->mustSelectOut;
		$startNum2[($i-1)*$pageLine2] = ($i-1)*$pageLine2." 到 ".($i)*$pageLine2." 行".$lang->page->excel ;
	}
}

//if(isset($excelParam) && $excelParam == true){
//        $excel  = true;
//}

//输出Excel文件
if($recordCount>0 && $excelParam == true || is_numeric($excelParam)){
	if($recordCount<5000) { 
		$viewData2 = getGoldUserRecord(0,$where,$order);
	} else {
		$viewData2 = getGoldUserRecord(1,$where,$order,$excelParam,$pageLine2);
	}

	$excel = getExcel();
	$smarty->assign('title', $excel['title']); // 标题
	$smarty->assign('hd', $excel['hd']);       // 表头
	$smarty->assign('num',$excel['hdnum']);    // 列数
	$smarty->assign('ct', $excel['content']);  // 内容

	// 输出文件头，表明是要输出 excel 文件
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename='.$excel['title'].date('_Ymd_Gi_Gs').'.xls');
	$smarty->display('module/gold/pay_excel.tpl');
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
//$smarty->assign('flowGold', $flowGold);
$smarty->assign('viewData', $viewData);
$smarty->assign('page', $page);
$smarty->assign('type', $type);
$smarty->assign('type2', $type2);
$smarty->assign('type3', $type3);
$smarty->assign('excelParam', $excelParam);
$smarty->assign('arrType', $arrType);
$smarty->assign('arrType2', $arrType2);
$smarty->assign('arrItemsAll', $arrItemsAll);
$smarty->assign('pageList', $pageList);
$smarty->assign('pageLine', $pageLine);
$smarty->assign('startNum2', $startNum2);
$smarty->assign('pageCount', $pageCount);
$smarty->assign('role', $role);
$smarty->assign('strictMatch', $strictMatch);
$smarty->assign('recordCount', $recordCount);
$smarty->display("module/gold/gold_use_record.tpl");
exit;

/**
 * @param $tmp 是否使用LIMIT
 */
function getGoldUserRecord($tmp,$where='',$order='',$startNum='',$record='',&$counts='',&$flowGold=''){
		$sql = " select `mdate`,`mtime`,`role_name`,`account_name`,`level`,`gold`,`type`,`item_id`,`num`,
				`remain_gold` from `".T_LOG_GOLD."` where {$where} ";
		if(!empty($order)) {
			$sql .= " {$order} ";
		}
		if($tmp==1) {
			$sql.= " LIMIT {$startNum}, {$record} ";
		} 
		$result = GFetchRowSet($sql);
		
		if(!empty($result)){
			foreach($result as $k => $v){
				$result[$k]['gold'] = -$v['gold'];
			}
		}
		
		$counts = GFetchRowOne("SELECT COUNT(`role_name`) as counts FROM `".T_LOG_GOLD."`  where {$where}");
		$counts = $counts['counts'];
//		$goldCount = GFetchRowSet(" SELECT type,SUM(`gold`) as `gold` FROM ".T_LOG_GOLD." WHERE {$where} group by `type`");
//		$flowGold = $goldCount[0]['gold'] - $goldCount[1]['glod'];
		return $result;
}

function getExcel(){
	//记录数据
        global $viewData2,$lang,$arrType,$arrItemsAll;
	$excel = array();

	// 标题
	$excel['title'] = $lang->menu->goldUserRecord;
	// 表头
	$excel['hd'] =  array(
			$lang->page->roleName,
                	$lang->sys->account,
			$lang->sys->playerLevel,
			$lang->gold->consume.$lang->currency->payYBUnbind.$lang->page->itemsNum,
			$lang->gold->consume.$lang->currency->bindYuanbao.$lang->page->itemsNum,
			$lang->gold->consume.$lang->page->time,
			$lang->gold->op_type,
			$lang->item->itemID,
			$lang->gold->item_name,
			$lang->page->itemsNum,
			$lang->gold->goldBalance,
			$lang->gold->bind_goldBalance,
	);
	// 列数
	$excel['hdnum'] = count($excel['hd']);

	$excel['content'] = array();
	foreach($viewData2 as $k=>$v){
		$excel['content'][$k] = array();
		$excel['content'][$k][] = array('StyleID'=>'s28', 'Type'=>'String', 'content'=>$v['role_name']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['account_name']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['level']);
		if($v['mtype']==1){
			$v['gold'] = $v['gold'];
			$v['bind_gold'] = $v['bind_gold'];	
		} else {
			$v['gold'] = -$v['gold'];
			$v['bind_gold'] = -$v['bind_gold'];	
		}
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['gold']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['bind_gold']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>date('Y-m-d H:i:s',$v['mtime']));
		foreach ($arrType as $k2=>$v2){
			if($v2[$v['type']]){
				$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v2[$v['type']]);
			}
		}
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['item_id']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$arrItemsAll[$v['item_id']]['name']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['num']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['remain_gold']);
		$excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['remain_bind_gold']);
	}
	return $excel;
}
