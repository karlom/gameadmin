<?php
/**
*	Description:返回所有的道具ID配置数组
*/

// include dirname(dirname(__FILE__)).'/central_api_auth.php';

include dirname(dirname(dirname(dirname(__FILE__)))).'/protected/dict/arrItemsAll.php';

echo(json_encode($arrItemsAll));
