<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
global $dictSkill;

//职业
$jobArray = array (
	'1' => 'wuzun',
	'2' => 'lingxiu',
	'3' => 'jianxian',
);
//技能符文
$elementArray = array (
	'0' => 'nof',
	'1' => 'ff',
	'2' => 'hf',
	'3' => 'sf',
	'4' => 'tf',
);

$sql = "select * from t_log_skill_main_menu t1, (select max(mtime) as mtime, uuid from t_log_skill_main_menu group by uuid) t2 where t1.mtime=t2.mtime And t1.uuid=t2.uuid and t1.level>=35";

$result = GFetchRowSet($sql);

$tmpData = array();
foreach($result as $key => $value) {
	$job = "";
	if(is_array($value)) {
		$job = $jobArray[$value['job']];
		$tmpData[$job]['cnt'] ++;
		if(is_string($value['skills'])) {
			$skills = explode('|',$value['skills']);
			foreach($skills as $k => $v) {
				if(!empty($v)) {
					$p = explode('*',$v);
					$skId = $p[0];
					$skLv = $p[1];
					$skEl = $p[2];
					
					$tmpData[$job][$skId]['cnt'] ++;
					$tmpData[$job][$skId][$elementArray[$skEl]] ++;

				}
			}
		}
	}
}

$data = array();
foreach($tmpData as $key => $value) {
	if(is_array($value)) {
		foreach($value as $k => $v ) {
			if(is_array($v)) {
				$data[$key][$k]['name'] = $dictSkill[$k];
				$data[$key][$k]['selectCnt'] = $v['cnt'];
				$data[$key][$k]['perc'] = round($v['cnt']/$value['cnt']*100 , 1)."%";
				$data[$key][$k]['nof'] = round($v['nof']/$v['cnt']*100 , 1)."%";
				$data[$key][$k]['ff'] = round($v['ff']/$v['cnt']*100 , 1)."%";
				$data[$key][$k]['hf'] = round($v['hf']/$v['cnt']*100 , 1)."%";
				$data[$key][$k]['sf'] = round($v['sf']/$v['cnt']*100 , 1)."%";
				$data[$key][$k]['tf'] = round($v['tf']/$v['cnt']*100 , 1)."%";
			}
			
		}
	}
	
}

//
$counter = array(
	'wuzun' => $tmpData['wuzun']['cnt'],
	'lingxiu' => $tmpData['lingxiu']['cnt'],
	'jianxian' => $tmpData['jianxian']['cnt'],
);

$smarty->assign('data', $data );
$smarty->assign('counter', $counter );
$smarty->assign('lang', $lang );
$smarty->display( 'module/skill/skill_bar_data.tpl' );