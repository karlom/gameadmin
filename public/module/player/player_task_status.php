<?php
/**
 * 玩家任务状态查询
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';

global $lang;

// 任务类型映射
$taskType = array(
	'1' => $lang->player->majorTask,
	'2' => $lang->player->branchTask,
	'3' => $lang->player->repeatTask,
);
// 任务状态映射
$taskStatus = array(
	'1'	=> $lang->player->unfinishTask,
	'2'	=> $lang->player->finishTask,
);
// 错误信息
$errorMsg = $successMsg = array();

// 获取参数
$role = isset( $_GET['role'] )? $_GET['role'] : array();
if("" != $role['account_name'] || "" != $role['role_name']){
//    $where = 1;
//    $where .= $role['account_name'] ? " and account_name='".SS($role['account_name'])."'" : "";
//    $where .= $role['role_name'] ? " and role_name='".SS($role['role_name'])."'" : "";
//    $sql = "select account_name, role_name from ".T_LOG_REGISTER." where {$where}";
//    $result = GFetchRowOne($sql);
    $result = UserClass::getUser($role['role_name'], $role['account_name']);
    if(0 < count($result)){
        $accounName = $role['account_name'] = $result['account_name'];
        $roleName = $role['role_name'] = $result['role_name'];
    
        // 设置任务状态
        if( isPost() && isset( $_POST['finishtask'] ) ){
            // 设置任务状态的请求参数
            if ( isset( $_POST['task_id'] ) && $_POST['task_id'] > 0 ){
                $task_id 			= intval($_POST['task_id']);
                $param2['taskID'] 	= $task_id;
                $param2['status'] 	= 2;
                $param2['accountName'] 	= $accounName;
                $param2['roleName'] 	= $roleName;

                $ret2 = interfaceRequest( 'finishtask', $param2 );
                //	print_r($ret2);
                if ( $ret2['result'] == '1' ){
                    // 添加成功消息
                    $successMsg[] = $lang->player->setFinishTask;
                }else{
                    // 添加错误消息
                    $errorMsg[] = $lang->page->remoteError . ': ' . $ret2['errorMsg'];
                }
            }else{
                // 添加错误消息
                $erroeMsg[] = $lang->player->taskIDNotValid ;
            }
        }
    
        $sql = "SELECT
    				mission_id, mission_name, group_id, status, count(mission_id) mcount, mtime, role_level 
    			FROM " . T_LOG_MISSION . " 
    			WHERE 
    			account_name='{$accounName}' and status = 2
    			GROUP BY 
    				account_name, mission_id, role_level
    			ORDER BY 
    				mtime desc";
    			// 获取指定用户已领奖的任务列表
    			$task_list = GFetchRowSet( $sql );
    
    			// 通过接口获取未完成的任务列表
    			$param['accountName'] = $accounName;
    			$ret = interfaceRequest('getunfinishtask', $param);
            
    			if ( $ret['result'] == '1' ){
    			    // 用于转换键
    			    $array_key_map = array(
    						'taskID' => 'mission_id',
    						'taskName' => 'mission_name',
    						'taskGroup'	=> 'group_id',
    						'taskStatus' => 'status',
    						'taskCount'	=> 'mcount',
    						'playerLevel' => 'role_level'
    						);
    
    						$unfinish_task_list = $ret['data'];
    
    						// 合并列表
    						foreach ( $unfinish_task_list as $unfinish_task ){
    						    array_change_key_to( $unfinish_task, $array_key_map );
    						    $unfinish_task['status'] = 1;
    						    array_unshift($task_list, $unfinish_task);
    						}
    			}else{
    			    $errorMsg[] = $lang->page->remoteError . ': ' . $ret['errorMsg'];
    			}
    
    
    			$smarty->assign( 'task_list', $task_list );
    
    }else{
        $errorMsg[] = $lang->msg->userNotExists;
    }
}

// 设置smarty的变量
$smarty->assign( 'role', $role );
$smarty->assign( 'taskStatus', $taskStatus );
$smarty->assign( 'taskType', $taskType );
$smarty->assign( 'errorMsg', implode('<br/>', $errorMsg ) );
$smarty->assign( 'successMsg', implode('<br/>', $successMsg ) );
$smarty->assign( 'lang', $lang );
$smarty->display('module/player/player_task_status.tpl');

