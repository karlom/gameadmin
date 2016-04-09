<?php
/**
 * check_and_restore.php
 * 查询历史玩家信息，并进行恢复
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
include_once SYSDIR_ADMIN_CLASS.'/user_class.php';
include_once SYSDIR_ADMIN_DICT.'/dict.php';
include_once SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
include_once SYSDIR_ADMIN_DICT.'/map.php';

global $lang,$dictMap;

$arrFcm = array(
	0=>$lang->verify->pass,
	1=>$lang->verify->notPass,
	2=>$lang->verify->notReg,
	3=>$lang->verify->use.GAME_ZH_NAME.$lang->verify->fcmSYS,
);
$action = $_POST['action'];
$role = isPost() ? $_POST['role'] : "";
$stones = array();
$itemsOrd = array();
$newUser = $_POST['newUser'];
$currentRoleName = $_POST['currentRoleName'];

$restoreArry = array(
//	'account',	//账号
//	'name',	//角色名
	
	'lv' => '人物等级',	//人物等级
	'yinliang' => '铜币',	//铜币
	'bind_yinliang' => '绑定铜币',	//绑定铜币
	'lingqi' => '灵气',	//灵气
	'yuanbao' => '仙石',	//仙石
	'liquan' => '绑定仙石',	//绑定仙石
	'tianchen' => '天城令',	//天城令
	'exp' => '经验值',	//经验值
	'bag' => '背包信息',	//背包信息
	'store' => '仓库',	//仓库
	'equip' => '身上装备',	//身上装备
	'pet_bag' => '宠物列表',	//宠物列表
	'pet_skill' => '宠物技能',	//宠物技能
	'craft' => '工匠信息',	//工匠信息
	'zhandouli' => '战斗力',	//战斗力
	'jingjie' => '境界信息',	//境界信息
	'talisman' => '法宝系统',	//法宝系统
	'qdUse' => '仙石历史使用记录',	//仙石历史使用记录
	'amtUse' => 'Q点历史使用记录',	//Q点历史使用记录
	'spirit' => '器灵系统',	//器灵系统
	'fashion' => '时装系统',	//时装系统
	'wing' => '仙羽系统',	//仙羽系统
	'vein' => '龙脉系统',	//龙脉系统
	'marryLv' => '仙缘等级',	//仙缘等级
	'fabao' => '新法宝系统',	//新法宝系统
	'huntlife' => '猎命',
	'sex' => '性别',
	'fazhenStar' => '灵兽法阵',
	'linggen' => '灵根系统',

);

$restoreArry2 = array(

	'map_id',
	'x',
	'y',
	'copyEnterPoint',
	'svrIndex',
	'job',
	'head',
	'skill',
	'taskRecord',
	'taskGroup',
	'guidePanel',
	'pata',
	'zhandouliDetail',
	'toolbar',
	'fcm',
	'fcmKickTime',
	'vip',
	'lvLibao',
	'fund',
	'fund2',
	'systemSets',
	'huntSets',
	'yellowDiamond',
	'yellowDiamondLv',
	'yellowDiamondYear',
	'yellowDiamondGift',
	'blue',
	'blueLv',
	'blueYear',
	'blueSuper',
	'blueGift',
	'blueIcon',
	'titleData',
//	'pubacctUse',	//坑货
	'yuanbaoSum',
	'yuanbaoDaily',
	'fristChargeGift',
	'sumChargeGift',
	'medalData',
	'wishStore',
	'secondKill',
	'secondKill3366',
	'secondKill3366UP',
	'secondKillPF',
	'appContract',
	'Vip2Lv',
	'Vip2Reward',
	'Vip2Exp',
	'jingji',
	'jingjiScore',
	'jingjiWeekJoinCnt',
	'activateHis',
	'consumptGift',
	'resouceRecover',
	'weaponGhost',
	'iwan',
	'jingjieID',
	'jingjieTime',
	'alchemy',
	'bible',
	'receFlowerSumCnt',
	'weiduan',
	'payReward',
	'fengshidigong',
	'openServer',
	'mergeServer',
	'mergeServerConsumePoint',
	'shengWenGamePoints',
	'iwanCreateGet',
	'createTime',
	'createPf',
	'yeyou',
	'wingLimit',
	'guanjia',
	'weekPayReward',
	'blueSuipian',
	'yellowSuipian',
	'happyReward',
	'interact',
	'vipBoss',
	'thankgiving',
	'openServer2',
	'payGift',
	'desktopSave',
	'saleDay',
	'guanjia2',
	'thankgiving2',
	'bugua',
);

$unRestoreArray = array(
	'name',
	'map_id',
	'x',
	'y',
	'copyEnterPoint',
	'cool',
	'buf',
	'bountyRecord',
	'black',
	'recent',
	'enemy',
	'friendRecommmenReject',
	'sign',
	'lastLogoutTime',
	'lastLoginTime',
	'ip',
	'pata',
	'copyTimes',
	'copyExit',
	'copySweep',
	'pataClear',
	'home',
	'miningEnergy',
	'familyUuid',
	'familyExitTime',
	'familyContribution',
	'familyRewardGetCnt',
	'familyRewardGetTime',
	'familySkill',
	'familyShopBuyCnt',
	'familyApplyList',
	'familyWarGetFlag',
	'familyMonsterQinmi',
	'familyMonsterCommonCnt',
	'familyMonsterHighLvCnt',
	'familyPkStartTime',
);

$serv = "s0";	//固定从s0取
if(!isset($serverList[$serv])){
	$msg[] = '没有找到中转服务器的配置，请先配置！';
}
		
//if($role['account_name'] || $role['role_name']){
if($role['account_name']){	//只支持账号查询

        if ('restoreData' == $action) {
        	        	
	        if($entranceUrl = $serverList[$serv]['url']){
				$timestamp = time();
				$key = urlencode(md5($timestamp.ADMIN_GAME_AUTH_KEY));
				
				$account_name = urlencode($role['account_name']);
				$params = "timestamp={$timestamp}&key={$key}&accountname={$account_name}";
				$apiUrl = $entranceUrl."api/getUserJsonData.php";
	
				$jsonData = decodeUnicode(curlPost($apiUrl, $params));
				$resultArray = json_decode($jsonData);	//这里必须用object，否则再转换成json格式时数组下标与lua解析的不一致
//				print_r($jsonData);
				if(empty($resultArray) || $resultArray->result){
					$msg[] = '获取玩家旧数据失败！<br>'.$jsonData;
				} else {
					$selectItem = $_POST['selectItem'];
					if(!empty($selectItem)) {
						if($newUser == 'yes') {
							$selects = array_merge($selectItem,$restoreArry2);
						} else {
							$selects = $selectItem;
						}
						foreach($resultArray as $k => $v){
							if(!in_array($k,$selects)){
								unset($resultArray->$k);
							} 
						}
						$newDataStr = json_encode($resultArray);
					} else {
						$msg[] = "请至少选择一项来进行恢复";
					}
					foreach($selectItem as $k ) {
						$restoreDesc .= $restoreArry[$k].",";
					}
					$restoreDesc = rtrim($restoreDesc, ",");

				}
			} else {
				$msg[] = "服务器地址配置错误";
			}
        	
        	if(empty($msg)) {
        		
        		//恢复旧数据前先保存玩家当前数据start
				$server = $_SESSION['gameAdminServer'];;
        		$currentUrl = $serverList[$server]['url'];
        		$timestamp = time();
				$key = urlencode(md5($timestamp.ADMIN_GAME_AUTH_KEY));
				$account_name = urlencode($role['account_name']);
				$params = "timestamp={$timestamp}&key={$key}&accountname={$account_name}";
				$apiUrl = $currentUrl."api/getUserJsonData.php";
	
				$backupData = decodeUnicode(curlPost($apiUrl, $params));
				$backupArray = json_decode($backupData);	//这里必须用object，否则再转换成json格式时数组下标与lua解析的不一致
				
				if(empty($backupArray) || $backupArray->result){
					$msg[] = '获取玩家当前数据失败！<br>'.$backupData;
				} else {
					$currentRoleName = $backupArray->data->player->roleName; 
					
					foreach($backupArray as $k => $v){
						if(!in_array($k,$selects)){
							unset($backupArray->$k);
						} 
					}
					$oldDataStr = json_encode($backupArray);
					global $auth;
					$insertArr = array(
						'mtime' => time(),
						'account_name' => $role['account_name'],
						'role_name' => '',
						'old_data' => $oldDataStr,
						'new_data' => $newDataStr,
						'add_person' => $auth->username(),
					);
					
					$sql = makeInsertSqlFromArray($insertArr, "t_restore_player_data");
					if(!@GQuery($sql)){
						$msg[] = '插入数据失败，请稍候再试！';
					}
				}
        		//恢复旧数据前先保存玩家当前数据end
        	}
        	
        	if(empty($msg)) {
        		
        		//开始恢复旧数据
	            $method = "resethumandb";
	            $params = array(
	                'roleName' => '',
	                'accountName' => $role['account_name'],
	                'list' => $selects,
	                'data' => $resultArray,
	            );
//	            print_r($params['list']);
//	            print_r($resultArray);
	            $viewData = interfaceRequest($method, $params);
	
	        	if (1 == $viewData['result']) {
	        		$msg[] = "操作成功！成功恢复玩家【{$role['account_name']}】数据：".$restoreDesc;
	                //写日志
	                $log = new AdminLogClass();
	                $log->Log(AdminLogClass::TYPE_RESTORE_PLAYER_DATA,$lang->page->accountName.":{$role['account_name']},".$lang->page->roleName.":{$currentRoleName}",'',$restoreDesc,'','');
	        	}else {
	        		$msg[] = "操作失败！恢复玩家【{$role['account_name']}】数据失败：".$viewData['errorMsg'];
	        	}
        	}
        } else if ('setPlayerOffLine' == $action) {
            $method = "useroffline";
            $params = array(
//                'roleName' => $role['role_name'],
                'roleName' => $currentRoleName ? $currentRoleName : $role['role_name'],
//                'accountName' => $role['account_name'],
            );
            $viewData = interfaceRequest($method, $params);

        	if (1 == $viewData['result']) {
        		$msg[] = $lang->page->opSuccess."{$currentRoleName}，".$lang->page->offLine;
                //写日志
                $log = new AdminLogClass();
                $log->Log(AdminLogClass::SET_PLAYER_OFF_LINE,$lang->page->accountName.":{$role['account_name']},".$lang->page->roleName.":{$currentRoleName}",'','','','');
        	}else {
        		$msg[] = $lang->page->opFailed."：{$viewData['errorMsg']} ";
        	}
        }
        
        $method = "getuserstatus";

		$params = array( 'accountName' => $role['account_name'],);
		/*
        $params = array();
        if($role['account_name']){
        	$params['accountName'] = $role['account_name'];
        }
        if($role['role_name']){
        	$params['roleName'] = $role['role_name'];
        }
        */
        
        //查询实时在线状态start
        $baseData = interfaceRequest("getuserbasestatus", $params );
//        print_r($baseData);
        if($baseData['result'] == 1) {
        	$onlineStatus = $baseData['data']['isOnline'];
        	$currentRoleName = $baseData['data']['roleName'];
        	if( $onlineStatus != 0 ) {
        		$msg[] = ($onlineStatus == 1) ? '玩家当前【在线】，若要恢复其数据，请先踢他下线':'玩家当前【跨服在线】，若要恢复其数据，请先踢他下线';
        	}
        } else {
        	$msg[] = '查询玩家当前在线状态失败！'.$baseData['errorMsg'];
        }
        //查询实时在线状态end

		//从旧数据备份里查询玩家数据信息
//        $interResult = interfaceRequest($method, $params);
        $interResult = socketRequestResult($serv, $method, $params);
        
		//print_r($interResult);
//		var_dump(decodeUnicode(json_encode($interResult)));
		if(1 == $interResult['result']){
            //装备
            $equipsRet = array();
            $i = 0;
            foreach ($interResult['data']['equipment'] as $equip){//装备
                $equipsRet[$i]['itemindex'] = $equip['id'];
                $equipsRet[$i]['uid'] = $equip['uid'];
//                $equipsRet[$i]['EquipName'] = $dictQuality[$equip['quality']].$equip['name']."(".$equip['weaponLv'].$lang->page->jie.")";
                $equipsRet[$i]['EquipName'] = $arrItemsAll[$equip['id']]['name'];
                $equipsRet[$i]['isBind'] = (0 == $equip['isBind']) ? $lang->page->unbind : $lang->page->bind;
                $equipsRet[$i]['EquipColorValue'] = $dictColorValue[$equip['color']];
                $equipsRet[$i]['quality'] = $equip['quality'];
                $equipsRet[$i]['pos'] = $dictGoodsPos[$equip['position']];
//                $equipsRet[$i]['holeCount'] = $equip['holes'];
                $equipsRet[$i]['GemCount'] = 0;
                foreach($equip['gem'] as $key => $value){
                    $equipsRet[$i]['GemCount'] += 1;
                    $equipsRet[$i]['GemName'] .= $dictHole[($key+1)].": ".$arrItemsAll[$value]['name'].", <br>";
                }
                $equipsRet[$i]['GemName'] = rtrim($equipsRet[$i]['GemName'], ", ");
                $equipsRet[$i]['strengthen'] = $equip['strengthen']; //强化等级
//                $equipsRet[$i]['refineCnt'] = $equip['refineCnt']; //精炼次数

                $equipsRet[$i]['craftLv'] = $equip['craftLv']; //打造工匠等级
                $equipsRet[$i]['randAttrStar'] = $equip['randAttrStar']; //附加属性星级
                $equipsRet[$i]['vipAttrStar'] = $equip['vipAttrStar']; //vip属性星级
                $equipsRet[$i]['xilianRandCnt'] = $equip['xilianRandCnt']; //随机属性洗炼次数
                $equipsRet[$i]['xilianVipCnt'] = $equip['xilianVipCnt']; //vip属性洗炼次数
                $equipsRet[$i]['refineCaiCnt'] = $equip['refineCaiCnt']; //精炼彩星个数
                $equipsRet[$i]['refineJingCnt'] = $equip['refineJingCnt']; //精炼金星个数
                $equipsRet[$i]['refineCnt'] = $equip['refineCnt']; //精炼银星个数
                $equipsRet[$i]['refineTongCnt'] = $equip['refineTongCnt']; //精炼铜星个数
                $equipsRet[$i]['gem2ID'] = $equip['gem2ID']; //镶嵌圣纹ID
                
                //附加属性
                if (!empty($equip['randAttr'])) {
                	$equipsRet[$i]['randAttrCnt'] = 0;
	                foreach($equip['randAttr'] as $key => $value) {
	                	
		            	if($dictRoleAttrPerc[$key]){
		            		$value['value'] =  intval($value['value']*100)."%";
		            	} else {
		            		$value['value'] = intval($value['value']);
		            	}
		            	
	                	$equipsRet[$i]['randAttrCnt'] ++;
	                	$equipsRet[$i]['randAttr'] .= $dictRoleAttribute[$key].": +".($value['value']).", " ;
	                	$equipsRet[$i]['randAttr'] .= $lang->item->refine.": +".$value['refinePercent']."%;<br> ";
	                }
                }
                $i++;
            }
            if(0 < count($equipsRet)){
                ksort($equipsRet);
            }

            //宝石
            $stones = array();
            foreach($interResult['data']['gem'] as $gem){//宝石
                $stones[$gem['id'].$gem['isBind']]['itemindex'] = $gem['id'];
                $stones[$gem['id'].$gem['isBind']]['name'] = $arrItemsAll[$gem['id']]['name'];
                $stones[$gem['id'].$gem['isBind']]['pos'] = $dictGoodsPos[$gem['position']];
                $stones[$gem['id'].$gem['isBind']]['isbind'] = (0 == $gem['isBind']) ? $lang->page->unbind : $lang->page->bind;
                $stones[$gem['id'].$gem['isBind']]['itemcount'] += $gem['count'];
            }
            if(0 < count($stones)){
                ksort($stones);
            }
            //普通物品
            $oitems = array();
            foreach($interResult['data']['material'] as $item){//普通物品
                $oitems[$item['id'].$item['isBind']]['itemindex'] = $item['id'];
                $oitems[$item['id'].$item['isBind']]['name'] = $arrItemsAll[$item['id']]['name'];
                $oitems[$item['id'].$item['isBind']]['pos'] = $dictGoodsPos[$item['position']];
                $oitems[$item['id'].$item['isBind']]['isbind'] = (0 == $item['isBind']) ? $lang->page->unbind : $lang->page->bind;
                $oitems[$item['id'].$item['isBind']]['itemcount'] += $item['count'];
            }
            if(0 < count($oitems)){
                ksort($oitems);
            }
        
            //BUFF
            $buffers = array();
            foreach ($interResult['data']['buff'] as $buff){
            	//游戏服务端传过来的时间是13位数，需要处理
                $buffers[$buff['id']]['id'] = $buff['id'];
                $buffers[$buff['id']]['name'] = $buff['name'];
                $buffers[$buff['id']]['starttime'] = date("Y-m-d H:i:s", $buff['starttime']/1000);
                $buffers[$buff['id']]['keeptime'] = $buff['keeptime']/1000;
                $buffers[$buff['id']]['endtime'] = date("Y-m-d H:i:s", ($buff['starttime'] + $buff['keeptime'])/1000);
                $buffers[$buff['id']]['timer'] = floor(time()*1000 - $buff['starttime'])/1000;
            }
            if(0 < count($buffers)){
                ksort($buffers);
            }
            //角色属性
            $attr = array();
            foreach($interResult['data']['attr'] as $key => $value){
            	$attr[$key]['id'] =  $key;
            	$attr[$key]['name'] =  $dictRoleAttribute[$key];
            	if($dictRoleAttrPerc[$key]){
            		$attr[$key]['value'] =  ($value*100)."%";
            	} else {
            		$attr[$key]['value'] =  $value;
            	}
            	//特别处理体力值6和气力值7，显示最大值（对应502，503）而不是当前值（6，7）
            	if($key == 502){
		            $attr['6']['value'] = $interResult['data']['attr'][$key];
		            $attr['6']['name'] = $dictRoleAttribute[$key];
		            unset($attr['502']);
            	}
            	if($key == 503){
		            $attr['7']['value'] = $interResult['data']['attr'][$key];
		            $attr['7']['name'] = $dictRoleAttribute[$key];
		            unset($attr['503']);
            	}
            }
//            unset($attr['0']);
//            print_r($attr);
            
            //寄卖信息
//            $market = $interResult['data']['market'];
            $market = array();
            foreach($interResult['data']['market'] as $key => $value){
            	$market[$key]['id'] =  $value['id'];
            	$market[$key]['name'] =  $value['name'];
            	$market[$key]['count'] =  $value['count'];
            	$market[$key]['leftTime'] =  $value['left_time'];
            	$market[$key]['price'] =  $value['yuanbao'] or $market[$key]['price'] = $value['yinliang'];
            	$market[$key]['currencyType'] =  ($value['yuanbao'] >0) ? $lang->currency->yuanbao : $lang->currency->gameCurrency;
            }
//            echo "market:<br/>";print_r($market);
            
            // 境界信息
            $jingjie['id'] = $interResult['data']['jingjie']['id'];
            $jingjie['skills'] = $interResult['data']['jingjie']['skills'];
            
            
            //技能快捷栏信息
            $skillBar = array();
			if($interResult['data']['mainmenuskill']) {
				foreach($interResult['data']['mainmenuskill'] as $key => $value) {
					$tmpArr = array();
					if( is_array($value) && !empty($value) ){
						$tmpArr['name'] = $dictSkill[$value[0]];
						$tmpArr['level'] = $value[1];
						$tmpArr['element'] = $dictSkillElement[$value[2]];
					}
					$skillBar[$key+1] = $tmpArr;
				} 
			}
			
			//法宝信息
			$talisman = array(
				'level' => 0,
				'list' => "",
			);
			if($interResult['data']['talisman']){
				$talisman['level'] = $interResult['data']['talisman']['lv'];
				if(is_array($interResult['data']['talisman']['list'])){
					$talisman['list'] = implode(', ',$interResult['data']['talisman']['list']);
				}
			}
            
            //宠物信息
            $pets = array();
            if(is_array($interResult['data']['pet'])){
            	$pets = $interResult['data']['pet'];
            }
            $petSkill = array();
            if(is_array($interResult['data']['petSkill'])) {
            	$petSkill = $interResult['data']['petSkill'];
            }
            
            //
//            $roleInfo['total_pay_rmb'] = $interResult['data']['money']['totalPay'];//总充值金额
//            $roleInfo['total_pay_gold'] = $interResult['data']['money']['totalMoney'];//总充值元宝
			$uuid = $interResult['data']['player']['uuid'];
			//总消费Q点，总消费抵金券
			$sql = "select sum(`total_cost`) as `qd`, sum(`pubacct`) as `tk` from " . T_LOG_BUY_GOODS . " where uuid='{$uuid}' ";
			$ret = GFetchRowOne($sql);
			
			$roleInfo['total_pay_rmb'] = $ret['qd'] ? $ret['qd'] : 0 ;	//总消费Q点
			$roleInfo['total_use_pubacct'] = $ret['pubacct'] ? $ret['pubacct'] : 0 ;	//总消耗抵金券
			
			//总购买仙石
			$totalBuyXianshi = 0;
			$sql = "select item_id, sum(item_cnt) as `item_cnt` from " . T_LOG_BUY_GOODS . " where uuid='{$uuid}' group by item_id ";
			$ret = GFetchRowSet($sql);
			if(!empty($ret)){
				foreach($ret as $v){
					if($v['item_id'] == 10033) {	//10颗仙石
						$totalBuyXianshi += $v['item_cnt']*10;
					} else if($v['item_id'] == 10034) {	//1000颗仙石
						$totalBuyXianshi += $v['item_cnt']*1000;
					}
				}
			} 
			
			$roleInfo['total_buy_xianshi'] = $totalBuyXianshi;
			
            $roleInfo['money'] = $interResult['data']['money']['yuanbao'];//元宝
            $roleInfo['liquan'] = $interResult['data']['money']['liquan'];//礼券
            $roleInfo['silver'] = $interResult['data']['money']['yinliang'];//银子
            $roleInfo['lingqi'] = $interResult['data']['money']['lingqi'];//灵气
            $roleInfo['tiancheng'] = $interResult['data']['money']['tianchen'];//天城令
            
//            $roleInfo['fcm_verified'] = $arrFcm[$roleInfo['fcm_verified']];
            $roleInfo['sex'] = (1 == $interResult['data']['player']['sex']) ? $lang->player->male : $lang->player->female;
            $roleInfo['is_online'] = $interResult['data']['player']['isOnline'];//是否在线
            $roleInfo['camp'] = $countryArray[$interResult['data']['player']['camp']];
            $roleInfo['job'] = (0 < $interResult['data']['player']['job']) ? $dictOccupationType[$interResult['data']['player']['job']] : $lang->page->null;
            $roleInfo['level'] = $interResult['data']['player']['level'];
            $roleInfo['vipLevel'] = $interResult['data']['player']['vipLevel'];
			$roleInfo['x'] = $interResult['data']['player']['x'];
			$roleInfo['y'] = $interResult['data']['player']['y'];
			$roleInfo['mapid'] = $interResult['data']['player']['mapid'];
			
			$roleInfo['sign'] = $interResult['data']['player']['sign'];	//个性签名
			$roleInfo['mateName'] = $interResult['data']['marry']['targetName'];	//伴侣名字
			$roleInfo['uuid'] = $interResult['data']['player']['uuid'];	//uuid
			
            //最近登录IP
            $roleInfo['login_ip'] = $interResult['data']['player']['ip'];
            $roleInfo['account'] = $interResult['data']['player']['accountName'];
            $roleInfo['rolename'] = $interResult['data']['player']['roleName'];
            $roleInfo['onlineDays'] = $interResult['data']['player']['onLineDay'];
            $roleInfo['login_time'] = $interResult['data']['player']['lastLogin'];
            $roleInfo['logout_time'] = $interResult['data']['player']['lastLogout'];
            
            $role['account_name'] = $roleInfo['account'];
            $role['role_name'] = $roleInfo['rolename'];

			//跨服信息
//			$middleFlag = $interResult['data']['middleFlag'];
//			$svrIndex = $interResult['data']['svrIndex'];
			$roleInfo['in_middle'] = $interResult['data']['middleFlag']; 
			$roleInfo['svrIndex'] = $interResult['data']['svrIndex']; 
			
            //命点和龙脉信息
            $roleInfo['alchemyLv'] = $interResult['data']['player']['alchemyLv'];	//命点等级
            $roleInfo['subLv'] = $interResult['data']['player']['subLv'];	//激活命点
            $roleInfo['veinLv'] = $interResult['data']['player']['veinLv'];	//龙脉等级
            //命符信息
            $roleInfo['huntlife'] = $interResult['data']['huntlife'];	//命符
            
            //仙羽信息
            $wing = $interResult['data']['wing'];	//命符
        
            //查询最近7天在线时长
            $sql = "SELECT `year`,`month`,`day`, sum(online_time)/60 online_time FROM ".T_LOG_LOGOUT." where reason<>7 AND account_name='".$roleInfo['account']."' group by `year`,`month`,`day` order by `year` desc,`month` desc,`day` desc limit 7";
            $result = GFetchRowSet($sql);
            if(0 < count($result)){
                foreach ($result as $key => $value) {
                    $onlineDate = $value['year']."-".$value['month']."-".$value['day'];
                    $arrOnlineTime[$onlineDate] = $value['online_time'];
                    $roleInfo['online_time'] += $value['online_time'];
                }
            }
            if(0 < count($arrOnlineTime)){
                ksort($arrOnlineTime);
            }
            
            $where = " account_name='{$roleInfo['account']}' ";
            $where = $roleInfo['uuid']? " uuid='{$roleInfo['uuid']}' ": $where ;
            //查询总在线时长
            $sql = "SELECT sum(online_time)/60 all_online_time FROM ".T_LOG_LOGOUT." where {$where}";
            $result = GFetchRowOne($sql);
            $roleInfo['all_online_time'] = (0 < $result['all_online_time']) ? $result['all_online_time'] : 0;
            //查询角色创建时间
            $sql = "select * from ".T_LOG_REGISTER." where {$where}";
            $result = GFetchRowOne($sql);
            $roleInfo['register_time'] = (0 < $result['mtime']) ? $result['mtime'] : 0;
            //查询元宝、礼券消费情况
            $sql = "Select sum(gold) as cnt from ". T_LOG_GOLD ." where {$where} and gold<0 ";
            $result = GFetchRowOne($sql);
            $roleInfo['total_use_gold'] = $result['cnt'] ? $result['cnt'] : 0;
            //查询礼券获得、消费情况
            $sql = "Select sum(liquan) as cnt from ". T_LOG_LIQUAN ." where {$where} and liquan>0 ";
            $result = GFetchRowOne($sql);
            $roleInfo['total_get_liquan'] = $result['cnt'] ? $result['cnt'] : 0;
            $sql = "Select sum(liquan) as cnt from ". T_LOG_LIQUAN ." where {$where} and liquan<0 ";
            $roleInfo['total_use_liquan'] = $result['cnt'] ? $result['cnt'] : 0;
            
            //查询仙尊经验
            $sql = "select account_name, role_name, max(yuanbaosum) as xianzunExp from t_log_yuanbao_sum where {$where} ";
            $result = GFetchRowOne($sql);
            $roleInfo['xianzunExp'] = $result['xianzunExp'] ? $result['xianzunExp'] : 0;
            
        }else{
            $msg[] = $interResult['errorMsg'];
        }
        
        $strMsg = empty($msg) ? '' : implode('<br />', $msg);
        $data = array(
            'playerInfoRet' => $playerInfoRet,
            'pets' => $pets,
            'petSkill' => $petSkill,
            'arrAction' => $arrAction,
            'arrOnlineTime' => $arrOnlineTime,
            'rsSeven' => $rsSeven,
            'rsOnlineTime' => $rsOnlineTime,
            'roleFamily' => $roleFamily,
            'roleInfo' => $roleInfo,
            'strMsg'  =>  $strMsg,
            'equips'  =>  $equipsRet,
            'stones' => $stones,
            'oitems' => $oitems,
            'buffdata'  => $data,
            'count' => ($count-1),
            'role' => $role,
            'buffers' => $buffers,
            'attribute' => $attr,
            'market' => $market,
            'jingjie' => $jingjie,
            'skillBar' => $skillBar,
            'talisman' => $talisman,
            'wing' => $wing,
            'dictPetTrend' => $dictPetTrend,
            'dictWingShentong' => $dictWingShentong,
            'arrItemsAll' => $arrItemsAll,
            'restoreArry' => $restoreArry,
            'selectItem' => $selectItem,
            'selectAll' => $_POST['selectAll'],
            'onlineStatus' => $onlineStatus,
            'currentRoleName' => $currentRoleName,
//            'newUser' => $newUser,
        );
//    }else{
//        $strMsg = $lang->msg->userNotExists;
//    }
}

$data['lang'] = $lang;
$data['strMsg'] = $strMsg;
$data['dictMap'] = $dictMap;
$smarty->assign($data);
$smarty->display("module/manager/check_and_restore.tpl");