<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
global $lang;
$action = $_POST['action'];
$action = $action ? $action : '';

$accountName = autoAddPrefix(SS($_POST['account_name']));
$roleName = autoAddPrefix(SS($_POST['role_name']));

$paramsData = array();
$arrFcm = array(
	0=>$lang->verify->notPass,
	1=>$lang->verify->pass,
//	2=>$lang->verify->notReg,
//	3=>$lang->verify->use.GAME_ZH_NAME.$lang->verify->fcmSYS,
);
if($accountName || $roleName){
    if ($action) {
        $api = "modifyuserdata";
        $setParams['accountName'] = $accountName;
        $setParams['roleName'] = $roleName;
    	switch ($action) {
    		case 'setLoginDays':
    		    $day = intval($_POST['login_days']);
    			if ($day < 0 ) {
    				$msg[] = $lang->verify->outOfValue;
    			}else{
    		        $setParams['type'] = 1;
    			    $setParams['data'] = json_encode(array("day" => $day));
    			    $interResult = interfaceRequest($api, $setParams);
    			    if(1 == $interResult['result']){
    			        $msg[] = $lang->verify->changeDurLoginDays.$day;
    			    }else{
    			        $msg[] = $lang->verify->opfail.":".$interResult['errorMsg'];
    			    }
    			    $logType = AdminLogClass::SET_PLAYER_LOGIN_DAYS;
    			}
    			break;
    		case 'setFcm':
    		    $fcm = intval($_POST['fcm']);
    		    if(key_exists($fcm, $arrFcm)){
    		        $setParams['type'] = 2;
    		        $setParams['data'] = json_encode(array("fcm" => $fcm));
    			    $interResult = interfaceRequest($api, $setParams);
    			    if(1 == $interResult['result']){
    			        $msg[] = $lang->verify->changeFCMStatus.":".$arrFcm[$fcm];
    			    }else{
    			        $msg[] = $lang->verify->opfail.":".$interResult['errorMsg'];
    			    }
    			    $logType = AdminLogClass::SET_PLAYER_FCM;
    		    }
    			break;
    		case 'setTaskTime':
    		    $taskId = intval($_POST['task_id']);
    		    $times = intval($_POST['times']);
		        $setParams['type'] = 3;
		        $setParams['data'] = json_encode(array("taskId" => $taskId, "times" => $times));
			    $interResult = interfaceRequest($api, $setParams);
			    if(1 == $interResult['result']){
			        $desc = str_replace("::name::", $dictTaskType[$taskId]['name'], $lang->verify->changeStatus);
			        $desc .= ":".$times;
			        $msg[] = $desc;
			    }else{
			        $msg[] = $lang->verify->opfail.":".$interResult['errorMsg'];
			    }
			    $logType = AdminLogClass::SET_PLAYER_DATA;
    			break;
    		case 'setSceneTime':
    		    $sceneId = intval($_POST['scene_id']);
    		    $times = intval($_POST['times']);
		        $setParams['type'] = 4;
		        $setParams['data'] = json_encode(array("mapId" => $sceneId, "times" => $times));
			    $interResult = interfaceRequest($api, $setParams);
			    if(1 == $interResult['result']){
			        $desc = str_replace("::name::", $dictMapType[$sceneId]['name'], $lang->verify->changeStatus);
			        $desc .= ":".$times;
			        $msg[] = $desc;
			    }else{
			        $msg[] = $lang->verify->opfail.":".$interResult['errorMsg'];
			    }
			    $logType = AdminLogClass::SET_PLAYER_DATA;
    			break;
    		case 'setZCJB':
    		    $times = intval($_POST['zcjb']);
		        $setParams['type'] = 5;
		        $setParams['data'] = json_encode(array("dateTime" => NOW_TIMESTAMP, "times" => $times));
			    $interResult = interfaceRequest($api, $setParams);
			    if(1 == $interResult['result']){
			        $desc = $lang->verify->changeZCJBStatus.":{$times}";
			        $msg[] = $desc;
			    }else{
			        $msg[] = $lang->verify->opfail.":".$interResult['errorMsg'];
			    }
			    $logType = AdminLogClass::SET_PLAYER_ZCJB_TIMES;
    			break;
    		case 'setHunt':
    		    $hunt1Cnt = intval($_POST['hunt1Cnt']);
    		    $hunt2Cnt = intval($_POST['hunt2Cnt']);
    		    $hunt3Cnt = intval($_POST['hunt3Cnt']);
		        $setParams['type'] = 6;
		        $setParams['data'] = json_encode(array("dateTime" => NOW_TIMESTAMP, "hunt1Cnt" => $hunt1Cnt, "hunt2Cnt" => $hunt2Cnt, "hunt3Cnt" => $hunt3Cnt));
			    $interResult = interfaceRequest($api, $setParams);
			    if(1 == $interResult['result']){
			        $desc = $lang->verify->changeWuhunStatus.":{$lang->wuhun->hunt1Cnt}{$hunt1Cnt} {$lang->wuhun->hunt2Cnt}{$hunt2Cnt} {$lang->wuhun->hunt3Cnt}{$hunt3Cnt}";
			        $msg[] = $desc;
			    }else{
			        $msg[] = $lang->verify->opfail.":".$interResult['errorMsg'];
			    }
			    $logType = AdminLogClass::SET_PLAYER_WUHUN_TIMES;
    			break;
    		case 'setPKValue':
    		    $pkvalue = intval($_POST['pkvalue']);
		        $setParams['type'] = 7;
		        $setParams['data'] = json_encode(array("pkvalue" => $pkvalue));
			    $interResult = interfaceRequest($api, $setParams);
			    if(1 == $interResult['result']){
			        $desc = $lang->verify->changePKValueStatus.":{$pkvalue}";
			        $msg[] = $desc;
			    }else{
			        $msg[] = $lang->verify->opfail.":".$interResult['errorMsg'];
			    }
			    $logType = AdminLogClass::SET_PLAYER_PK_VALUE;
    			break;
    		case 'setJJCTimes':
    		    $jjctimes = intval($_POST['jjctimes']);
		        $setParams['type'] = 8;
		        $setParams['data'] = json_encode(array("times" => $jjctimes));
			    $interResult = interfaceRequest($api, $setParams);
			    if(1 == $interResult['result']){
			        $desc = $lang->verify->changeJJCTimesStatus.":{$jjctimes}";
			        $msg[] = $desc;
			    }else{
			        $msg[] = $lang->verify->opfail.":".$interResult['errorMsg'];
			    }
			    $logType = AdminLogClass::SET_PLAYER_JJC_TIMES;
    			break;
    		case 'setLevel':
    		    $level = intval($_POST['level']);
		        $setParams['type'] = 9;
		        $setParams['data'] = json_encode(array("level" => $level));
			    $interResult = interfaceRequest($api, $setParams);
			    if(1 == $interResult['result']){
			        $desc = $lang->verify->changeLevelStatus.":{$level}";
			        $msg[] = $desc;
			    }else{
			        $msg[] = $lang->verify->opfail.":".$interResult['errorMsg'];
			    }
			    $logType = AdminLogClass::SET_PLAYER_LEVEL;
    			break;
    		default:
    			$msg[] = $lang->verify->error;
    			break;
    	}
    	if(1 == $interResult['result']){
            //写日志
            $log = new AdminLogClass();
            $log->Log($logType,$lang->page->accountName.":{$accountName},".$lang->page->roleName.":{$roleName}",'',"{$desc}",'','');
    	}
    }
    $api = "getuserdata";
    $params['accountName'] = $accountName;
    $params['roleName'] = $roleName;
    $interResult = interfaceRequest($api, $params);
    if(1 == $interResult['result']){
        $accountName = $interResult['data']['accountName'];
        $roleName = $interResult['data']['roleName'];
        $data['onLineDay'] = $interResult['data']['onLineDay'];//连续登录天数
        $data['fcm'] = $interResult['data']['fcm'];//防沉迷
        if("" == $interResult['data']['zcjb']['time'] || date("Ymd") != date("Ymd", $interResult['data']['zcjb']['time'])){
            $data['zcjbCount'] = 0;//招财进宝次数
        }else{
            $data['zcjbCount'] = $interResult['data']['zcjb']['count'];//招财进宝次数
        }
        $data['wuhunDB'] = $interResult['data']['wuhunDB'];//猎魂次数
        if("" == $data['wuhunDB']['huntTime'] || date("Ymd") != date("Ymd", $data['wuhunDB']['huntTime'])){
            $data['wuhunDB']['hunt1Cnt'] = 0;
            $data['wuhunDB']['hunt2Cnt'] = 0;
            $data['wuhunDB']['hunt3Cnt'] = 0;
        }
        foreach($dictTaskType as $key => $value){
            if(0 < $value['maxTimes'] && 9999 > $value['maxTimes']){
                $data['taskTimes'][$key]['name'] = $value['name'];
                $data['taskTimes'][$key]['maxtime'] = $value['maxTimes'];
                if(is_array($interResult['data']['taskTimes']) && key_exists($key, $interResult['data']['taskTimes'])){
                    $dateTime = $interResult['data']['taskTimes'][$key][0];
                    $data['taskTimes'][$key]['times'] = ($dateTime == date("Ymd")) ? $interResult['data']['taskTimes'][$key][1] : 0;
                }else{
                    $data['taskTimes'][$key]['times'] = 0;
                }
            }
        }
        foreach($dictMapType as $key => $value){
            if(0 < $value['maxTimes'] && $value['isCopyScene']){
                $data['sceneTimes'][$key]['name'] = $value['name'];
                $data['sceneTimes'][$key]['maxtime'] = $value['maxTimes'];
                if(is_array($interResult['data']['sceneTimes']) && key_exists($key, $interResult['data']['sceneTimes'])){
                    $dateTime = $interResult['data']['sceneTimes'][$key][0];
                    $data['sceneTimes'][$key]['times'] = ($dateTime == date("Ymd")) ? $interResult['data']['sceneTimes'][$key][1] : 0;
                }else{
                    $data['sceneTimes'][$key]['times'] = 0;
                }
            }
        }
        $data['pkvalue'] = $interResult['data']['pkvalue'];//PK值
        $data['jjctimes'] = $interResult['data']['arenaCntLeft'];//JJC可挑战次数
        $data['level'] = $interResult['data']['level'];//等级
    }else{
        $msg[] = $interResult['errorMsg'];
    }
}
$strMsg = empty($msg) ? '' : implode('<br />', $msg);

$data = array(
    'lang' => $lang,
    'accountName' => $accountName,
    'roleName' => $roleName,
    'result' => $data,
    'arrFcm' => $arrFcm,
    'strMsg' => $strMsg,
    'paramsData' => $paramsData,
    'arrFcm'=>$arrFcm,
);
render("module/player/set_player_data.tpl",$data);