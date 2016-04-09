<?php
/*
 * Author: linruirong 
 * Author: linlisheng@feiyou.com
 * 2012-03-14
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
global $lang;

//查玩家帐号
$role = $_POST[role];
$msg = array();
if ($role['role_id'] || $role['role_name'] || $role['account_name'] ) { 
        $role = UserClass::getUser($role['role_name'], $role['account_name'], $role['role_id']);
        if (!$role['account_name']) {
                echo $msg[] = "<font color=red>".$lang->verify->playerFalse."</font>";
        }   
}

$record = SS(intval($_POST['record']));
$record = ( $record >=10 && $record <=500 ) ? $record : LIST_PER_PAGE_RECORDS;
$excelParam  = SS($_POST['excel']);

if ($role['account_name']) {
	$rowCount =1;
}else {
	$sqlCnt = " SELECT COUNT(DISTINCT account_name) as cnt FROM ".T_LOG_PAY." ";
	$rsCnt = GFetchRowOne($sqlCnt);
	$rowCount = $rsCnt['cnt'];
}
$pageCount = ceil($rowCount/$record);
$pageNo = getUrlParam('page');//设置初始页
$pageNo > $pageCount ? $pageCount : $pageNo;
$pageList = getPages($pageNo, $rowCount,$record);
$startNum = ( $pageNo - 1 ) * $record;

$where = " and A.`account_name`=B.`account_name` ";
if($role['account_name']){
	$where.= " and A.`account_name` like '%".$role['account_name']."%' "; 
}

$type = isset($_POST['type']) ? SS(trim($_POST['type'])) : "`total_pay` desc";
$arrType = array(
        '`total_pay`'            => " {$lang->sys->totalCost}↑ ",
        '`total_pay` desc'       => " {$lang->sys->totalCost}↓ ",
        '`min_pay`'              => " {$lang->sys->singleLess}↑ ",
        '`min_pay` desc'         => " {$lang->sys->singleLess}↓ ",
        '`max_pay`'              => " {$lang->sys->singleMore}↑ ",
        '`max_pay` desc'         => " {$lang->sys->singleMore}↓ ",
        '`avg_pay`'              => " {$lang->sys->avg}↑ ",
        '`avg_pay` desc'         => " {$lang->sys->avg}↓ ",
        '`times`'                => " {$lang->sys->totalCostTime}↑ ",
        '`times` desc'           => " {$lang->sys->totalCostTime}↓ ",
        '`max_pay_time`'         => " {$lang->sys->lastCostTime}↑ ",
        '`max_pay_time` desc'    => " {$lang->sys->lastCostTime}↓ ",
        'report_time'        	 => " {$lang->sys->alarm}↑ ",
        'report_time desc'       => " {$lang->sys->alarm}↓ ",
);

if($type){
	$where .= " GROUP BY `account_name` ORDER BY {$type} ";
}

$keyWordList = getPaySort( $tmp=1,$startNum,$record,$where );
foreach ($keyWordList as $key => &$row) {
        $row['rank_no'] = ( $pageNo - 1 ) * $record + $key + 1 ;
        $row['total_pay'] = formatMoney($row['total_pay'],true);
        $row['min_pay'] = formatMoney($row['min_pay'],true); //RMB按分显示
        $row['max_pay'] = formatMoney($row['max_pay'],true);
        $row['avg_pay'] = formatMoney($row['avg_pay'],true);
        $rowIdArr[] = "'".$row['account_name']."'";
}
//导出excel数据
if(isset($excelParam) && $excelParam == true ){
	$keyWordList2= getPaySort( $tmp=0,$startNum,$record>0,$where );
	foreach ($keyWordList2 as $key => &$row) {
		$row['rank_no'] = ( $pageNo - 1 ) * $record + $key + 1 ;
		$row['total_pay'] = formatMoney($row['total_pay'],true);
		$row['min_pay'] = formatMoney($row['min_pay'],true); //RMB按分显示
		$row['max_pay'] = formatMoney($row['max_pay'],true);
		$row['avg_pay'] = formatMoney($row['avg_pay'],true);
//		$rowIdArr[] = "'".$row['account_name']."'";
	}
}

//if (!empty($rowIdArr)) {
//	$rowIdStr = implode(',',$rowIdArr);
//	$sql = "select `account_name` , max(`mtime`) as `login_time` from ".T_LOG_LOGIN." where account_name in ({$rowIdStr}) group by account_name ";
//	$rsInout = GFetchRowSet($sql);
//	foreach ($rsInout as $r) {
//		$loginTimeArr[$r['account_name']] = $r['login_time'];
//	}
//	$now = time();
//	foreach ($keyWordList as $key => &$row) {
//        	$row['diff_day'] =  $loginTimeArr[$row['account_name']] ? intval( ( $now - $loginTimeArr[$row['account_name']])/86400 ) :'';
//    	}
//	//导出excel数据
//	if($keyWordList2){
//		foreach ($keyWordList2 as $key => &$row) {
//			$row['diff_day'] =  $loginTimeArr[$row['account_name']] ? intval( ( $now - $loginTimeArr[$row['account_name']])/86400 ) :'';
//		}
//	}
//}

if(isset($excelParam) && $excelParam == true){
        $excel  = true;
}
//输出Excel文件
if(isset($excelParam) && $excelParam == true ){
        $excel = getExcel();
        $smarty->assign('title', $excel['title']); // 标题
        $smarty->assign('hd', $excel['hd']);       // 表头
        $smarty->assign('num',$excel['hdnum']);    // 列数
        $smarty->assign('ct', $excel['content']);  // 内容

        // 输出文件头，表明是要输出 excel 文件
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$excel['title'].date('_Ymd_Gi').'.xls');
        $smarty->display('module/pay/pay_excel.tpl');
        exit;
}

//查看玩家实时元宝接口
$action  = SS($_POST['action']);
if( $action == 'start' )
{
		if(isPost()) {
				$accountName2 = $_POST['id'] ? SS($_POST['id']) : '';
				$roleName2    = $_POST['roleName'] ? SS($_POST['roleName']) : '';

				if ($accountName2=='' && $roleName2=='') { 
						$msg2  = $lang->player->paramWrong;	
				} else {
						$role = UserClass::getUser($roleName2, $accountName2);
						if (!$roleName2) {
								echo $msg2[] = "<font color=red>".$lang->verify->playerFalse."</font>";
						}   
				}

				$roleInfo = array();
				$method = "getuserstatus";
				$params = array(
					'accountName' => $accountName2,
					'roleName' => $roleName2,
				);  

				$interResult = interfaceRequest($method, $params);

				if(1 == $interResult['result']){
					$roleInfo['totalPayRmb'] = $interResult['data']['money']['totalPay'];//总充值金额
					$roleInfo['totalPayGold'] = $interResult['data']['money']['totalMoney'];//总充值元宝
					$roleInfo['gold'] = $interResult['data']['money']['unBindMoney'];//不绑定元宝
					$roleInfo['goldBind'] = $interResult['data']['money']['bindMoney'];//绑定元宝
					$roleInfo['money'] = $interResult['data']['money']['unBindCoin'];//不绑定铜币
					$roleInfo['moneyBind'] = $interResult['data']['money']['bindCoin'];//绑定铜币
					$roleInfo['level'] = $interResult['data']['player']['level'];
					$roleInfo['vipLevel'] = $interResult['data']['player']['vipLevel'];
					$stat = $roleInfo;
					$result = json_encode(array('stat'=>$stat,'msg'=>$roleInfo,));
					echo $result;
					exit();
				} else {
					$stat = 0;
					$msg2  = $lang->player->paramWrong;	
					$result = json_encode(array('stat'=>$stat,'msg'=>$msg2,));
					echo $result;
					exit();
				}	
		}
}

$data = array(
    'URL_SELF' => $_SERVER['PHP_SELF'],
    'rankList' => $keyWordList,
    'pageList'=> $pageList,
    'role'=> $role,
    'accountName'=> $role['account_name'],
    'pageNo'=> $pageNo,
    'record'=> $record,
    'rowCount'=> $rowCount,
    'pageCount'=> $pageCount,
    'lang'=> $lang,
    'type'=> $type,
    'arrType'=>$arrType,
);
$smarty->assign($data);
$smarty->display("module/pay/pay_sort.tpl");

function getPaySort ($tmp,$startNum='',$record='',$where='') {
//	$sql = " SELECT A.`account_name`, A.`role_name`, A.`role_level`, FORMAT(SUM(A.`pay_money`),2) as `total_pay`, FORMAT(MIN(A.`pay_money`),2) as `min_pay`, FORMAT(MAX(A.`pay_money`),2) AS `max_pay`, FORMAT(AVG(A.`pay_money`),2) AS `avg_pay`, COUNT(A.`account_name`) AS `times`, MAX(A.`mtime`) AS `max_pay_time`, Round((UNIX_TIMESTAMP()-MAX(B.`mtime`))/(60*60*24),2) as `report_time` FROM ".T_LOG_PAY." A, (select `account_name`,`role_name`,max(`mtime`) as `mtime` from ".T_LOG_LOGIN." group by `account_name`) B WHERE 1=1 {$where} ";
	$sql = " SELECT A.`account_name`, A.`role_name`,A.`role_level`,A.`total_pay`,A.`min_pay`,A.`max_pay`,A.`avg_pay`,A.`times`,A.`max_pay_time`,Round((UNIX_TIMESTAMP()-B.`mtime`)/(60*60*24),2) as `report_time` From (select `account_name`, `role_name`, MAX(`role_level`) as `role_level`, SUM(`pay_money`) as `total_pay`, MIN(`pay_money`) as `min_pay`, MAX(`pay_money`) AS `max_pay`, AVG(`pay_money`) AS `avg_pay`, COUNT(`account_name`) AS `times`, MAX(`mtime`) AS `max_pay_time` FROM ".T_LOG_PAY." group by `account_name`) A, (select `account_name`,`role_name`,max(`mtime`) as `mtime` from ".T_LOG_LOGIN." group by `account_name`) B WHERE 1=1 {$where} ";
	if($tmp==1) {
		$sql.= " LIMIT {$startNum}, {$record} ";
	}
	$result = GFetchRowSet($sql);		
	return $result;
}

function getExcel(){
        //记录数据
        global $keyWordList2,$lang;
        $excel = array();

        // 标题
        $excel['title'] = $lang->menu->paySort;
        // 表头
        $excel['hd'] =  array(
                        $lang->page->sort,
			$lang->sys->account,
                        $lang->page->roleName, 
			$lang->page->level,
			$lang->sys->totalCost."(".$lang->sys->rmb.")",
			$lang->sys->singleMore."(".$lang->sys->rmb.")",
			$lang->sys->singleLess."(".$lang->sys->rmb.")",
			$lang->sys->avg."(".$lang->sys->rmb.")",
			$lang->sys->totalCostTime,
			$lang->sys->lastCostTime,
			$lang->sys->alarm,
        );
        // 列数
        $excel['hdnum'] = count($excel['hd']);

        $excel['content'] = array();
        foreach($keyWordList2 as $k=>$v){
                $excel['content'][$k] = array();
                $excel['content'][$k][] = array('StyleID'=>'s28', 'Type'=>'String', 'content'=>$v['rank_no']);
                $excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['account_name']);
                $excel['content'][$k][] = array('StyleID'=>'s28', 'Type'=>'String', 'content'=>$v['role_name']);
                $excel['content'][$k][] = array('StyleID'=>'s28', 'Type'=>'String', 'content'=>$v['role_level']);
                $excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['total_pay']);
                $excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['max_pay']);
                $excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['min_pay']);
                $excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['avg_pay']);
                $excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['times']);
                $excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>date('Y-m-d H:i:s',$v['max_pay_time']));
//                $excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['diff_day'].$lang->page->dayNotLogin);
                $excel['content'][$k][] = array('StyleID'=>'s29', 'Type'=>'String', 'content'=>$v['report_time'].$lang->page->dayNotLogin);
        }
        return $excel;
}

//格式化人民币的形式
function formatMoney($number, $fractional=false) {
	if ($fractional) {
		$number = sprintf('%.2f', $number);
	}
	while (true) {
		$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
		if ($replaced != $number) {
			$number = $replaced;
		} else {
			break;
		}
	}
	return $number;
} 





