<?php
/*
 * 玩家信息类
 */
class UserClass {
	/**
	 * 按角色名、帐号名或ID查找玩家
	 *
	 * @param string $roleName
	 * @param string $accountName
	 * @param int $roleId
	 * @return array
	 */
	const STAUTS_OFF_LINE = 0; //离线
	const STAUTS_NOW_LOGIN = 1; //登录成功但未进入游戏
	const STAUTS_ON_LINE = 2; //在线
	public static $arrOnlineStatus = array(
		0=>'<font color="gray"><b>离线</b></font>',
		1=>'<font color="6B6BA6"><b>登录成功但未进入游戏</b></font>',//(主要给游客模式使用，可以不管)
		2=>'<font color="green"><b>在线</b></font>',
	);

	public static function getUser($roleName='',$accountName='',$roleId=false) {
		$roleId = intval($roleId);
		$roleName = SS(  $roleName  );
		$accountName = SS($accountName) ;
		$where = '';
		if ($roleId) {
			$where = " `id`={$roleId}";
		}elseif($roleName){
			$where = $roleName ?  " `role_name`='{$roleName}'" : '';
		}elseif ($accountName){
			$where = $accountName ?  " `account_name`='{$accountName}'" : '';
		}else {
			return false;
		}

		$sql = "select * from  ".T_LOG_REGISTER."  where ".$where;
		$rs = GFetchRowOne($sql);
		if (!isset($rs['account_name'])) {
			return false;
		}
		return $rs;
	}
	
	public static function getUserListByIP($ip)
	{
		if(!Validator::isIpv4($ip))
		{
			return false;
		}
		$where = " ip = '$ip' ";

		$sql = "select * from  ".T_LOG_REGISTER."  where ".$where;
		$rs = GFetchRowSet($sql);
		return $rs;
	}

    public static function getFamily($familyName='',$familyId=''){
    	$familyId_res = $familyId;
        $familyId=intval($familyId);
        $familyName = SS($familyName);
        $where = '';
        if($familyId || $familyId_res==='0'){
            $where = " `familyId`={$familyId}";
        }elseif($familyName){
            $where = $familyName ? " familyName = '{$familyName}' ":'';
        }else{
            return false;
        }
        $sql = "select familyId as family_id,familyName as family_name from ".T_FAMILY." where ".$where;
        $rs = GWFetchRowOne($sql);
        $rs['family_id'] = intval($rs['family_id']);
        return $rs;
    }

    public static function roleIntoFamily($role_id=''){
        $role_id = intval($role_id);
        $where = '';
        if($role_id){
            $where = " charguid = {$role_id} ";
        }else{
            return false;
        }
        $sql = " select * from t_familymember where {$where} ";
        $rs = GFetchRowOne($sql);
        return $rs;
    }
}
