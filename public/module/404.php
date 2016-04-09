<?php
include_once '../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE."/global.php";
include_once SYSDIR_ADMIN_CLASS."/admin_group.class.php";
echo($lang->menu->class->userinfo);
$smarty->display("404.html");
exit();