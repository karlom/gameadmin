<?php
/**
 * 玩家赠送申请详情
 * @author xieying
 * 
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
global $lang;
$dateStart = SS ( $_POST['dateStart'] );
$dateEnd = SS ( $_POST['dateEnd'] );
$type = $_POST['type'];
$action = $_POST['action'];
$id = $_POST['id'];
$page = $_POST['page'];
$is_pass = $_POST['is_pass'];
$ctx = stream_context_create( array(
   'http' => array(
       'timeout' => 2 //设置一个超时时间，单位为秒
       )
   )
);

$gift = array(
    'admin_name' => 'root',
    'copper' => 199,
    'bind_copper' => 100,
    'yuanbao' => 300,
    'bind_yuanbao' => 355,
    'date' => date('Y-m-d'),
    'is_pass' => '是',
    'pass_admin' => 'super_admin',
    'reason' => '法教科书减肥了撒减肥了快见',
    'content' => '数据的快房间撒了快减肥绿色空间飞',
    'role' => array(
        array(
            'user_id' => 111,
            'nick_name' => '挖哈哈',
            'user_name' => '呜嘿嘿',
        ),
        array(
            'user_id' => 111,
            'nick_name' => '挖哈哈',
            'user_name' => '呜嘿嘿',
        ),
        array(
            'user_id' => 111,
            'nick_name' => '挖哈哈',
            'user_name' => '呜嘿嘿',
        ),
        array(
            'user_id' => 111,
            'nick_name' => '挖哈哈',
            'user_name' => '呜嘿嘿',
        ),
    ),
    'data' => array(
        array(
            'template_id' => 22222,
            'template_name' => 'sjksd',
            'amount' => 2,
            'strength_level' => 4,
            'is_bind' => 2,
        ),
        array(
            'template_id' => 22222,
            'template_name' => 'sjksd',
            'amount' => 2,
            'strength_level' => 4,
            'is_bind' => 2,
        ),
        array(
            'template_id' => 22222,
            'template_name' => 'sjksd',
            'amount' => 2,
            'strength_level' => 4,
            'is_bind' => 2,
        ),
        array(
            'template_id' => 22222,
            'template_name' => 'sjksd',
            'amount' => 2,
            'strength_level' => 4,
            'is_bind' => 2,
        ),
    ),
);
$data = array(
    'lang' => $lang,
    'gift' => $gift,
    'dateStart' => $dateStart,
    'dateEnd' => $dateEnd,
);
$smarty->assign($data);
$smarty->display('module/pay/apply_goods_detail.tpl');
exit;