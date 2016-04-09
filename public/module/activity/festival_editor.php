<?php
/**
  * 节日邮件活动
  */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/dict.php';
include_once SYSDIR_ADMIN_DICT . '/arrItemsAll.php';
global $lang;

$action = isset( $_GET['action'] )? SS($_GET['action']) : 'list';
$errorMsg = $successMsg = array();

$actType = array(1 => '整个活动期间只发送一次', 2 => '活动期间每天登录都发送一次');
if($action == 'edit')
{
	$now = time();
	$act = array(
			'id'		=> 0,
			'title' 	=> '', 
			'content' 	=> '', 
			'mailtype'	=> 1,
			'start' 	=> $now, 
			'end' 		=> $now,
			'extra'		=> array('reward' => array()),
	);
	if( isset( $_REQUEST['act_id'] ) )
	{
		$id 	 = intval( $_REQUEST['act_id'] );
		$act_tmp = GFetchRowOne('SELECT * FROM ' . T_FESTIVAL_ACTIVITY . ' WHERE id = ' . $id);
		if( isset( $act_tmp ) && intval( $act_tmp['id'] ) > 0 )
		{
			$act = $act_tmp;
		}
	}

	if( isset($_POST['save']) )
	{
		$act['title'] 	= SS($_POST['title']);
		$act['content'] = $_POST['content'];
		$act['start'] 	= strtotime( SS($_POST['start']) );
		$act['end'] 	= strtotime( SS($_POST['end']) );
		$act['extra'] 	=  $_POST['extra'] ;
		$act['mailtype'] = intval( SS( $_POST['mailtype'] ));
		$act['status']	= 0;
		
		foreach( $act['extra']['reward'] as $key => $item )
		{
			list($id,) = explode( '|', $act['extra']['reward'][$key]['id'] );
			$id = trim($id);
			$act['extra']['reward'][$key]['id'] = $id;
		}

		$act['extra'] = serialize($act['extra']);
		if( intval( $act['id'] ) > 0 )
		{
			$sql = makeUpdateSqlFromArray($act, T_FESTIVAL_ACTIVITY);
		}
		else
		{
			unset($act['id']);
			$sql = getInsertSQL($act,  T_FESTIVAL_ACTIVITY );
		}
		GQuery( $sql );
	}
	$act['start'] = date( 'Y-m-d H:i:s', $act['start'] );
	$act['end'] = date( 'Y-m-d H:i:s', $act['end'] );

	$minDate = $serverList[$_SESSION ['gameAdminServer']]['onlinedate'];
	$maxDate = date("Y-m-d");

	if( !is_array( $act['extra'] ) )
	{
		$act['extra'] = unserialize( $act['extra'] );
	}
	$smarty->assign('act', $act);
	$smarty->assign("minDate", $minDate);
	
}
else
{
	// 同步
	if( $action == 'sync' )
	{
		$id = intval( $_REQUEST['act_id'] );
		$ret = syncFestivalAct($id);

		if( $ret['ret'] == 1 )//success
		{
			$successMsg[] = '同步成功!';
			$sql = 'UPDATE ' . T_FESTIVAL_ACTIVITY . ' SET status = 1 WHERE id = ' . $id ;
			GQuery($sql);
		}
		else
		{
			$errorMsg[] = $ret['msg'];
		}
	}

	// 删除
	if( $action == 'del' )
	{
		$id = intval( $_REQUEST['act_id'] );
		$ret = delFestivalAct($id);

		if( $ret['ret'] == 1 )//success
		{
			$successMsg[] = '删除成功!';
			$sql = 'DELETE FROM ' . T_FESTIVAL_ACTIVITY . ' WHERE id = ' . $id ;
			GQuery($sql);
		}
		else
		{
			$errorMsg[] = $ret['msg'];
		}
	}



	$sql = "SELECT 
				id, title, content, 
				from_unixtime(start,'%Y-%m-%d %H:%i:%s') start,
				from_unixtime(end,'%Y-%m-%d %H:%i:%s') end,
				mailtype 
			FROM t_festival_activity";
	$actList = GFetchRowSet($sql);

	$smarty->assign('actList', $actList);

	
}
$itemList = array();
foreach($arrItemsAll as $item)
{
	$itemList[$item['id']] = $item['name'];
}

$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign('action', $action);
$smarty->assign('itemList', $itemList);
$smarty->assign('action', $action);
$smarty->assign('lang', $lang);
$smarty->assign('actType', $actType);
$smarty->display('module/activity/festival_editor.tpl');


function syncFestivalAct($actId)
{
	$act = GFetchRowOne('SELECT * FROM ' . T_FESTIVAL_ACTIVITY . ' WHERE id = ' . $actId);
	if( !empty($act) )
	{
		$curTime = time();
		if( $act['end'] <= $curTime )
		{
			return array('ret' => 998, 'msg' => '结束时间[' . date('Y-m-d', $act['end']) . ']已过！');
		}
		$api = 'add_festival';
//		$act['content'] = urlencode( $act['content']);
		$params = array(
			'festivalid'	=> intval( $act['id'] ),
			'title'	=> $act['title'],
			'content'	=> $act['content'],
			'mailtype'	=> intval( $act['mailtype'] ),
			'interval'	=> array( 
								'start' => intval( $act['start'] ), 
								'ending' => intval( $act['end'] )
							),
			'items'		=> array()
		);
		
		$extra = unserialize( $act['extra'] );
		$items = $extra['reward'];
		foreach( $items as $item )
		{
			$params['items'][] = array( $item['id'], $item['bind'], $item['num'] );
		}
		$params['interval'] = json_encode( $params['interval'] );
		$params['items'] = json_encode( $params['items'] );
		return interfaceRequest($api, $params);
	}
	return array('ret' => 999, 'msg' => 'act [' . $actId . '] not exist');
	
}

function delFestivalAct( $actId )
{
	$act = GFetchRowOne('SELECT * FROM ' . T_FESTIVAL_ACTIVITY . ' WHERE id = ' . $actId);
	if( !empty($act) )
	{
		$curTime = time();
		
		$api = 'del_festival';
		$params = array(
			'festivalid'	=> intval( $act['id'] )
		);
		return interfaceRequest($api, $params);
	}
	return array('ret' => 999, 'msg' => 'act [' . $actId . '] not exist');
	
}