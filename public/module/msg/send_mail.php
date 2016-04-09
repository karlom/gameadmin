<?php
/**
 * 给玩家发送邮件
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
global $dictPet;
$errorMsg = $successMsg = array();
$action = isset($_GET['action'])&&Validator::stringNotEmpty($_GET['action'])?SS($_GET['action']):'';

if(isPost())
{
	$params = array();
	$receiver = (isset( $_POST['receiver'] ) && Validator::stringNotEmpty($_POST['receiver']) )?  SS($_POST['receiver']) : '';
	$title = (isset( $_POST['title'] ) && Validator::stringNotEmpty($_POST['title']) )? SS($_POST['title']) : '';
	$content = (isset( $_POST['content'] ) && Validator::stringNotEmpty($_POST['content']) )? SS($_POST['content']) : '';
	$all = (isset( $_POST['all'] ) && Validator::stringNotEmpty($_POST['all']) )?  SS($_POST['all']) : false;
	$pf = (isset( $_POST['pf'] ) && Validator::stringNotEmpty($_POST['pf']) )?  SS($_POST['pf']) : false;
	
	if(!Validator::stringNotEmpty($title)){
		$errorMsg[] = '邮件标题不能为空！';
	}else{
		$params['title'] = $title;
		$smarty->assign('title', 	$title );
	}
	if(!Validator::stringNotEmpty($content)){
		$errorMsg[] = '邮件内容不能为空！';
	}else{
//		$content = stripslashes($content);
		$params['content'] = stripslashes($content);
		$smarty->assign('content', 	$content );
	}
	
	if($all){
		$all = true;
		$params['all'] = 1; 
		if($pf && array_key_exists($pf,$dictPlatform)) {
			$params['pf'] = $pf;
		}
//		$smarty->assign('all', true );
	}else{
		if(!Validator::stringNotEmpty($receiver)){
			$errorMsg[] = '收件人列表不能为空！';
		}else{
			$receiver = str_replace('，', ',', $receiver);
			$roleNameList = explode(',', $receiver);
			
			$params['roleNameList'] = $roleNameList ;
			$smarty->assign('receiver', implode(',', $roleNameList) );
		}
	}
	
	if(empty($errorMsg)){
//		$ret = RequestCollection::sendMail($params);
		$ret = @interfaceRequest('mail', $params);
		
		if ($ret['result'] == 1 ){
			$successMsg[] = '发送成功';
		}elseif($ret['result'] == 2 ){
			$successMsg[] = '部分玩家发送失败，失败数：' . $ret['failCount'];
		}
		$msg = array();
		$msg['mtime'] = time();
		$msg['title'] = $params['title'];
		$msg['content'] = addslashes( $params['content'] );
//		$msg['content'] = $content;
		$msg['receiver'] = $all ? "all:{$pf}" : urldecode(implode(',', $roleNameList));
		$msg['result'] = $ret['result'];
		$msg['success'] = $ret['successCount'];
		$msg['fail'] = $ret['failCount'];
		$sql = makeInsertSqlFromArray($msg, T_SENDMAIL);
		GQuery($sql);
		
		//写日志
		$log = new AdminLogClass();
		$roleNameList = $msg['receiver'];
		$detail = "id={$id},发送时间：{$msg['mtime']},发送列表：{$roleNameList},成功数：{$msg['success']},失败数：{$msg['fail']},信件标题：{$msg['title']},内容：{$msg['content']}";
		$log->Log(AdminLogClass::TYPE_SEND_EMAIL,$detail,'','','','');	
	}
	
	$smarty->assign('displayForm', true);
}

if( Validator::stringNotEmpty($action) && $action == 'del'){
	$id = isset( $_GET['id'] ) && Validator::isInt($_GET['id']) ? intval( SS($_GET['id']) ): 0;
	if( $id > 0 ){
		$sql = 'DELETE FROM ' . T_SENDMAIL . ' WHERE id = ' . $id;
		GQuery($sql);
		$successMsg[] = '删除成功';
		//写日志
		$log = new AdminLogClass();
		$log->Log(AdminLogClass::TYPE_SEND_EMAIL,"id={$id}",'','删除信件','','');	
	}else{
		$errorMsg[] = '请提供消息的ID';
	}
}

//$typeArray = array(0,1);
$viewData = getHistoryMail();

$smarty->assign( 'lang', $lang );
$smarty->assign( 'highlightPercentage', HIGHTLIGHT_PERCENTAGE);
$smarty->assign( 'viewData', $viewData);
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
//$smarty->assign( 'selectedDay', $selectedDay);
//$smarty->assign( 'minDate', ONLINEDATE);
//$smarty->assign( 'maxDate', Datatime :: getTodayString());
//$smarty->assign( 'startDay', $startDay );
//$smarty->assign( 'endDay', $endDay );
//$smarty->assign( 'startTime', $startTimestamp );
//$smarty->assign( 'endTime', $endTimestamp );
//$smarty->assign( 'roleName', $roleName );
//$smarty->assign( 'accountName', $accountName );
$smarty->assign( 'dictPlatform' , $dictPlatform);
$smarty->assign( 'pf', $pf);
$smarty->display( 'module/msg/send_mail.tpl' );


function getHistoryMail(){
	global $dictPlatform;
	$sql = "SELECT * FROM " . T_SENDMAIL . " order by id desc";
	$data = GFetchRowSet($sql);
	if(!empty($data)) {
		foreach($data as $k => $v){
			if( substr($v['receiver'],0,3) == "all" ) {
				$tmpA = explode(":",$v['receiver']);
				$data[$k]["receiver"] = "all";
				if($tmpA[1]){
					$data[$k]["pf"] = $dictPlatform[$tmpA[1]]."平台";
				}
			}
		}
	}
	return $data;
}
