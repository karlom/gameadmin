<?php
/**
 * IP统计
 */
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';

global $lang;
$page = $_GET['page'] && Validator::isInt($_GET['page'])? intval( SS($_GET['page']) ) : 1;
$viewData = getIPAnalysisData($page);
foreach ( $viewData as &$value ){
    $value ['max_time'] = date ( 'Y-m-d H:i:s',$value ['max_time'] );
    $value ['min_time'] = date ( 'Y-m-d H:i:s',$value ['min_time'] );
}
if($_GET['chunked'] !== null){
	echo json_encode($viewData);
	ob_flush();
	flush();
	exit();
}
$data = array(
    'lang' => $lang,
    'viewData' => $viewData,
);
$smarty->assign ($data);
$smarty->display ( 'module/player/ip_analysis.tpl' );

function getIPAnalysisData($page = 1, $pageSize = 50){
	$offset = ($page - 1) * $pageSize;
	$sql = "SELECT ip, COUNT(distinct account_name) AS cnt,MAX(mtime) AS max_time,MIN(mtime) AS min_time FROM ".T_LOG_LOGIN." GROUP BY ip order by cnt desc,max_time desc LIMIT $offset, $pageSize";
        $rs = GFetchRowSet($sql);

        return $rs;
}