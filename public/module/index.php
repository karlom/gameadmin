<?php
include_once '../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE.'/global.php';
if($auth->assertModuleIDAccess(12, false)){
	$main = "./pay/survey.php";
} else {
	$main = "./main.php";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo PROXY."《".GAME_ZH_NAME."》"."管理后台"; ?></title>
<style>
body {

}
</style>
</head>
<frameset rows="55,*" cols="*" frameborder="no" border="0" framespacing="0">
  <frame src="./top.php" name="topFrame" id="topFrame" scrolling="no">
  <frameset cols="180,*" name="bodyFrame" id="bodyFrame" frameborder="NO" border="0" framespacing="0">
    <frame src="./left.php" name="menu" id="menu" scrolling="yes">
    <frame src="<?php echo $main; ?>" name="main" id="main" scrolling="yes">
  </frameset>
</frameset>
<noframes>
	<body>你的浏览器不支持框架！</body>
</noframes>
</html>
