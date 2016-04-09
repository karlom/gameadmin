<?php
/*
 * 装备继承查询
 */

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
$filter = isset($_POST['filter']) ? true : false;//是否去掉内部赠送元宝

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

$where = 1;
$where .= " and t1.`mtime`>=$startDateStamp and t1.`mtime`<=$endDateStamp ";

$where .=  $accountName ? " and t1.`account_name` = '{$accountName}' ":'';
$where .=  $roleName ? " and t1.`role_name` = '{$roleName}' ":'';

//页数
$recordCount = 0;                          //总记录
$startNum  = ($page - 1) * $pageLine;      //每页开始位置
$viewData  = getCopySceneRecord(1,$where,$order,$startNum,$pageLine,&$recordCount, $filter);
$pageCount = ceil($recordCount/$pageLine ); //总页数
$pageList  = getPages($page, $recordCount, $pageLine);

//继承顺序： 力量1-体力2-定力3-身法4-攻击5-最小攻击6-最大攻击7-风攻击8-火攻击9-水攻击10-电攻击11-命中12-暴击13-防御14-风防御15-火防御16-水防御17-电防御18-闪避19-坚韧20-最大气血21-最大法力22-速度23
$inheritAttr = array(
	'power'		 => $lang->inherit->power,		   //'力量',
	'phy'		 => $lang->inherit->phy,		   //'体力',
	'energy'	 => $lang->inherit->energy,		   //'定力',
	'steps'		 => $lang->inherit->steps,		   //'身法',
	'atk'		 => $lang->inherit->atk,		   //'攻击',
	'atkMin'	 => $lang->inherit->atkMin,		   //'最小攻击',
	'atkMax'	 => $lang->inherit->atkMax,		   //'最大攻击',
	'atkWind'	 => $lang->inherit->atkWind,	   //'风攻击',
	'atkFire'	 => $lang->inherit->atkFire,	   //'火攻击',
	'atkWater'   => $lang->inherit->atkWater,	   //'水攻击',
	'atkElec'    => $lang->inherit->atkElec,	   //'电攻击',
	'hitRate'	 => $lang->inherit->hitRate,	   //'命中',
	'baoJi'      => $lang->inherit->baoJi,		   //'暴击',
	'def'        => $lang->inherit->def,		   //'防御',
	'defWind'    => $lang->inherit->defWind,	   //'风防御',
	'defFire'    => $lang->inherit->defFire,	   //'火防御',
	'defWater'   => $lang->inherit->defWater,	   //'水防御',
	'defElec'    => $lang->inherit->defElec,	   //'电防御',
	'dodgeRate'  => $lang->inherit->dodgeRate,	   //'闪避',
	'jianRen'    => $lang->inherit->jianRen,	   //'坚韧',
	'maxHp'		 => $lang->inherit->maxHp,		   //'最大气血',
	'maxMp'		 => $lang->inherit->maxMp,		   //'最大法力',
	'speed'		 => $lang->inherit->speed,		   //'速度'
);

//洗练顺序:  力量-体力-定力-身法-攻击-防御-最大气血-最大法力
$washAttr = array(
	'power'		 => $lang->inherit->power,		   //'力量',
	'phy'		 => $lang->inherit->phy,		   //'体力',
	'energy'	 => $lang->inherit->energy,		   //'定力',
	'steps'		 => $lang->inherit->steps,		   //'身法',
	'atk'		 => $lang->inherit->atk,		   //'攻击',
	'def'        => $lang->inherit->def,		   //'防御',
	'maxHp'		 => $lang->inherit->maxHp,		   //'最大气血',
	'maxMp'		 => $lang->inherit->maxMp,		   //'最大法力',
);


$arr = array();
// low_wash_attr,low_wash_star,high_main,high_ass,after_wash_attr,after_wash_star

foreach ($viewData as $key=>&$value){
	$inheritAttr = array_values($inheritAttr);
	$washAttr = array_values($washAttr);
	
	if(!empty($value['low_wash_attr'])){
		$lowWashAttr = explode('-',$value['low_wash_attr']);
		foreach($lowWashAttr as $lwak=>$lwav){
				foreach($washAttr as $wak=>$wav){
						if($lowWashAttr[$lwak]>0 && $lwak==$wak){
								$lowWashAttr[$lwak] = $wav.$lwav." | ";
								$value['low_wash_attr_change'] .= $lowWashAttr[$lwak];
						}
				}
		}
		$value['low_wash_attr_change'] = trim($value['low_wash_attr_change'],' | ');
	}

	if(!empty($value['low_wash_star'])){
		$lowWashStar = explode('-',$value['low_wash_star']);
		foreach($lowWashStar as $lwsk=>$lwsv){
				foreach($washAttr as $wak2=>$wav2){
						if($lowWashStar[$lwsk]>0 && $lwsk==$wak2){
								$lowWashStar[$lwsk] = $wav2.$lwsv." | ";
								$value['low_wash_star_change'] .= $lowWashStar[$lwsk];
						}
				}
		}
		$value['low_wash_star_change'] = trim($value['low_wash_star_change'],' | ');
	}

	if(!empty($value['high_main'])){
		$arrMain = explode('-',$value['high_main']);
		foreach($arrMain as $i=>$a){
				foreach($inheritAttr as $h=>$v){
						if($arrMain[$i]>0 && $i==$h){
								$arrMain[$i] = $v.$a." | ";
								$value['high_main_change'] .= $arrMain[$i];
						}
				}
		}
		$value['high_main_change'] = trim($value['high_main_change'],' | ');
	}

	if(!empty($value['high_ass'])){
		$arrAss  = explode('-',$value['high_ass']);
		foreach($arrAss as $i2=>$a2){
				foreach($inheritAttr as $h2=>$v2){
						if($arrAss[$i2]>0 && $i2==$h2){
								$arrAss[$i2] = $v2.$a2." | ";
								$value['high_ass_change'] .= $arrAss[$i2];
						}
				}
		}
		$value['high_ass_change'] = trim($value['high_ass_change'],' | ');
	}

	if(!empty($value['after_wash_attr'])){
		$afterWashAttr  = explode('-',$value['after_wash_attr']);
		foreach($afterWashAttr as $awak=>$awav){
				foreach($washAttr as $wak3=>$wav3){
						if($afterWashAttr[$awak]>0 && $awak==$wak3){
								$afterWashAttr[$awak] = $wav3.$awav." | ";
								$value['after_wash_attr_change'] .= $afterWashAttr[$awak];
						}
				}
		}
		$value['after_wash_attr_change'] = trim($value['after_wash_attr_change'],' | ');
	}

	if(!empty($value['after_wash_star'])){
		$afterWashStar  = explode('-',$value['after_wash_star']);
		foreach($afterWashStar as $awak2=>$awav2){
				foreach($washAttr as $wak4=>$wav4){
						if($afterWashStar[$awak2]>0 && $awak2==$wak4){
								$afterWashStar[$awak2] = $wav4.$awav2." | ";
								$value['after_wash_star_change'] .= $afterWashStar[$awak2];
						}
				}
		}
		$value['after_wash_star_change'] = trim($value['after_wash_star_change'],' | ');
	}
}
//print_r($viewData);

$dateStrPrev = strftime("%Y-%m-%d", strtotime($startDate) - 86400);
$dateStrToday = strftime("%Y-%m-%d");
$dateStrNext = strftime("%Y-%m-%d", strtotime($startDate) + 86400);
$dateOnline = ONLINEDATE;

$minDate = ONLINEDATE;
$maxDate = Datatime :: getTodayString();
$smarty->assign( "filter", $filter);
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
$smarty->assign('arrItemsAll', $arrItemsAll);
$smarty->assign('pageList', $pageList);
$smarty->assign('pageLine', $pageLine);
$smarty->assign('pageCount', $pageCount);
$smarty->assign('role', $role);
$smarty->assign('recordCount', $recordCount);
$smarty->display("module/basedata/equip_inherit_check.tpl");
exit;

/**
 * @param $tmp 是否使用LIMIT
 */
function getCopySceneRecord($tmp,$where='',$order='',$startNum='',$record='',&$counts='', $filter = false){
	$join = '';
    $filterWhere = '';
    if( $filter )
    {
        $join = ' LEFT JOIN
                            (
                                SELECT DISTINCT role_name t_role_name
                                FROM '.T_LOG_SEND_YUANBAO.'  
                                WHERE `type`=2
                            ) ts ON t1.role_name = ts.t_role_name ';
        $whereCond .= ' AND ts.t_role_name is null';
    }
		$sql = " select t1.`mtime`,t1.`account_name`,t1.`role_name`,t1.`level`,t1.`low_id`,t1.`low_uid`,t1.`low_quality`,t1.`low_strengthen`,t1.`low_wash_attr`,t1.`low_wash_star`,t1.`high_id`,t1.`high_uid`,t1.`high_quality`,t1.`high_main`,t1.`high_ass`,t1.`after_strengthen`,t1.`after_wash_attr`,t1.`after_wash_star` from `".T_LOG_INHERIT."` t1 $join where {$where} $whereCond "; 
		if(!empty($order)) {
			$sql .= " {$order} ";
		}
		if($tmp==1) {
			$sql.= " LIMIT {$startNum}, {$record} ";
		} 
		$result = GFetchRowSet($sql);
		$counts = GFetchRowOne("SELECT COUNT(t1.`account_name`) as counts FROM `".T_LOG_INHERIT."` t1 $join where {$where} $whereCond");
		$counts = $counts['counts'];
		return $result;
}

