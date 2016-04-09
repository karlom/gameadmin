<?php
/**
 * 配置变量同步
 */
 
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
include_once SYSDIR_ADMIN_DICT . '/goldConfig.php';

$api = 'getallloginfo';

$successMsg = $errorMsg = array();
if( isset($_POST['sync']) )
{
	$server = isset($_POST['server']) ? SS($_POST['server']) : false;
	if( $server !== false )
	{
		$configRet = interfaceRequest($api, array(), null, null, $server);
	
		if( !isset( $configRet['result'] ) || ( isset( $configRet['result'] ) && $configRet['result'] > 0 ) )
		{
			$successMsg[] = '同步成功！';
			$variableList = array(
				array('var_name' => 'gold_type', 'divide' => true, 'prefix' => 'RMB_', 'variables' => array()),
				array('var_name' => 'money_type', 'divide' => true, 'prefix' => 'TB_', 'variables' => array()),
				array('var_name' => 'item_type', 'divide' => false, 'prefix' => 'ITEM_', 'variables' => array()),
				array('var_name' => 'level_up_type', 'divide' => false, 'prefix' => 'LEVELUP_', 'variables' => array()),
				);
			foreach( $configRet as $config )
			{
				foreach( $variableList as &$variable )
				{
					if( strpos($config['logName'], $variable['prefix']) === 0 )
					{
						$variable['variables'][$config['logId']] = $config['name'];
					}
				}
			}

			foreach( $variableList as $variable2  )
			{
				ksort( $variable2['variables'] );
				if( $variable2['divide'] )
				{
					$tmpVariables = $variable2['variables'];
					$variable2['variables'] = array();
					foreach( $tmpVariables as $id => $tmpVariable )
					{
						$key = intval( substr( (string)intval($id), 0, 1 ) ); 
						if( !is_array($variable2['variables'][ $key ] ) )
						{
							$variable2['variables'][ $key ] = array();
						}
						$variable2['variables'][ $key ][ $id ] = $tmpVariable;
						
					}
				}
				$successMsg[] = '[' . $variable2['var_name'] . '] ' . print_r($variable2['variables'] ,true) . '<br/>=======================================';
			//	echo $variable['var_name'].'<br/>';
				Variables::set($variable2['var_name'], serialize( $variable2['variables'] ));
			}
		}
		else
		{
			$errorMsg[] = '同步失败！' . print_r($configRet, true) ;
		}
		
	}
	else
	{
		$errorMsg[] = '请选择一个服务器再提交同步！';
	}
	
}

//dump($variableList);
$loadServerList = getAvailableServerList();
$smarty->assign( 'serverList', $loadServerList );
$smarty->assign( 'successMsg' , implode('<br/>', $successMsg));
$smarty->assign( 'errorMsg' , implode('<br/>', $errorMsg));
$smarty->assign( 'lang', $lang );
$smarty->assign( 'goldType', $goldType);
$smarty->display( 'module/variables/sync_config.tpl' );