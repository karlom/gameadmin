<?php
include_once '../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE."/functions.php";
@session_start();
session_regenerate_id();

if(!empty($_GET[username])){
    $msg       = $_GET['msg'];
    $flag      = $_GET['flag'];
    $username  = $_GET['username'];
    $uid       = $_GET['uid'];
    $overlord  = $_GET['overlord'];
    $last_op_time  = $_GET['last_op_time'];
    $userpower = $_GET['userpower'];

    //检测通信KEY是否合法
    $this_flag = md5($username.$userpower.$uid.$last_op_time.ADMIN_FLAG_KEY);
    if($flag!=$this_flag){
        $msg = "bad";
    }
   
    //检查是否登陆超时
    if(time() - $last_op_time > ADMIN_LOGIN_TIMEOUT){
        $msg = "timeout";
    }

    $json = json_encode(array('msg'=>$msg));

    //先把之前的session清空
    unset($_SESSION['username']);
    unset($_SESSION['uid']);
    unset($_SESSION['last_op_time']);
    unset($_SESSION['overlord']);
    unset($_SESSION['userpower']);

    $_SESSION['username']     = $username;
    $_SESSION['uid']          = $uid;
    $_SESSION['last_op_time'] = $last_op_time;
    $_SESSION['overlord']     = $userpower!='all'?false:true;
    $_SESSION['userpower']    = $userpower!='all'?explode("|",$userpower):$userpower;
    echo $_GET['callback'].'('.$json.')';
}

if(!empty($_GET[action])&&$_GET[action]=='out'){
    //退出登陆
    unset($_SESSION['username']);
    unset($_SESSION['uid']);
    unset($_SESSION['last_op_time']);
    unset($_SESSION['overlord']);
    unset($_SESSION['userpower']);
    $json = json_encode(array('msg'=>'loginout'));
    echo $_GET['callback'].'('.$json.')';
}
