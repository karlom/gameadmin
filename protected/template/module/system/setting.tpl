<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<title>游戏开关</title>
<script type="text/javascript" src="/static/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
	$("#submit_button").click(function(){
		if(!confirm('确认要保存修改<{$AGENT_NAME}>代理<{$SERVER_ID}>服游戏前端变量？')){
			return false;
		}
		else{
			$("#myform").submit();
		}
	});
});


</script>
</head>

<body>
<div id="position">系统管理：游戏前端全局变量 </div>
	<font color="Red">警告：如果你不清楚这里的内容，请勿进行任何操作。</font>
	<table cellspacing="1" cellpadding="3" border="1" class="SumDataGrid">
		<tbody>
		<tr><th colspan="3">可用变量</th></tr>
		<tr><th>变量名</th><th>可填值</th><th>说明</th></tr>
		<tr><td>GAME_NAME</td><td>mcjh</td><td>&nbsp;</td></tr>
		<tr><td>AGENT_ID</td><td><{$AGENT_ID}></td><td>&nbsp;</td></tr>
		<tr><td>AGENT_NAME</td><td><{$AGENT_NAME}></td><td>&nbsp;</td></tr>
		<tr><td>SERVER_ID</td><td><{$SERVER_ID}></td><td>&nbsp;</td></tr>
		<tr><td>SERVER_NAME</td><td><{$SERVER_NAME}></td><td>&nbsp;</td></tr>
		<tr><td>ACCNAME</td><td>ACCNAME</td><td>此项值，会被自动替换为对应的帐号名</td></tr>
		</tbody>
	</table>
	<br />
<{if $strMsg}>
<table cellspacing="1" cellpadding="5" class="DataGrid">
	<tr>
		<td><span style="color:red;"><{$strMsg}></span></td>
	</tr>
</table>
<br />
<{/if}>
<form id="myform" name="myform" action="setting.php" method="POST">
<table cellspacing="1" cellpadding="5" class="SumDataGrid">
	<tr>
		<th>KEY NAME</th>
		<th>说明</th>
		<th>当前设置值</th>
		<th>参考取值</th>
	</tr>
	<tr>
		<td>activateCodeUrl</td>
		<td>领取激活码的URL</td>
		<td><input size="40" name="conf[activateCodeUrl]" value="<{$conf.activateCodeUrl}>" /></td>
		<td>http://www..com/activecode/index.php?game=mcjh</td>
	</tr>
	<tr>
		<td>newPlayerActivateCodeUrl</td>
		<td>领取新手激活码的URL地址</td>
		<td><input size="40" name="conf[newPlayerActivateCodeUrl]" value="<{$conf.newPlayerActivateCodeUrl}>" /></td>
		<td>http://www..com/xsk/index.php?game=mcjh</td>
	</tr>
	<tr>
		<td>bbsUrl</td>
		<td>BBS地址</td>
		<td><input size="40" name="conf[bbsUrl]" value="<{$conf.bbsUrl}>" /></td>
		<td>http://bbs..com/index.php?gid=7</td>
	</tr>
	<tr>
		<td>fcmApiUrl</td>
		<td>平台填写防沉迷的地址</td>
		<td><input size="40" name="conf[fcmApiUrl]" value="<{$conf.fcmApiUrl}>" /></td>
		<td>http://web..com/user/userinfo.php?type=fangCM</td>
	</tr>
	<tr>
		<td>firstPayTitle</td>
		<td>首充活动的标题</td>
		<td><input size="40" name="conf[firstPayTitle]" value="<{$conf.firstPayTitle}>" /></td>
		<td>首次充值就送大礼包,价值3888元宝!</td>
	</tr>
	<tr>
		<td>firstPayUrl</td>
		<td>首充礼包的网址</td>
		<td><input size="40" name="conf[firstPayUrl]" value="<{$conf.firstPayUrl}>" /></td>
		<td>http://web..com/mccq/xinwengonggao/xinwen/201102/24-42557.html</td>
	</tr>
	<tr>
		<td>gmOnline</td>
		<td>GM面板联系客服链接</td>
		<td><input size="40" name="conf[gmOnline]" value="<{$conf.gmOnline}>" /></td>
		<td>http://web..com/kefu/online/mccq.html</td>
	</tr>
	<tr>
		<td>gonglueURL</td>
		<td>游戏攻略的url地址</td>
		<td><input size="40" name="conf[gonglueURL]" value="<{$conf.gonglueURL}>" /></td>
		<td>http://web..com/mccq/youxigonglue/</td>
	</tr>
	<tr>
		<td>officialWebsite</td>
		<td>官网地址</td>
		<td><input size="40" name="conf[officialWebsite]" value="<{$conf.officialWebsite}>" /></td>
		<td>http://web..com/mccq/</td>
	</tr>
	<tr>
		<td>website</td>
		<td>游戏前端入口地址</td>
		<td><input size="40" name="conf[website]" value="<{$conf.website}>" /></td>
		<td>http://s1.mcjh.my.com/</td>
	</tr>

	<tr>
		<td>websiteTitle</td>
		<td>游戏前端入口页面标题</td>
		<td><input size="40" name="conf[websiteTitle]" value="<{$conf.websiteTitle}>" /></td>
		<td>明朝江湖  双线1服</td>
	</tr>


	<tr>
		<td>resourceHost</td>
		<td>玩家在哪里登陆游戏</td>
		<td><input size="40" name="conf[resourceHost]" value="<{$conf.resourceHost}>" /></td>
		<td>http://mcjh.static..com/</td>
	</tr>
	<tr>
		<td>payUrl</td>
		<td>充值地址</td>
		<td><input size="40" name="conf[payUrl]" value="<{$conf.payUrl}>" /></td>
		<td>http://pay..com/?type=3&gamename=mccq&gameserver=SERVER_NAME|username=ACCNAME</td>
	</tr>
	<tr>
		<td>serverListUrl</td>
		<td>平台选服页</td>
		<td><input size="40" name="conf[serverListUrl]" value="<{$conf.serverListUrl}>" /></td>
		<td>http://web..com/mccq/select_server.html</td>
	</tr>
	<tr>
		<td>showException</td>
		<td>是否显示异常</td>
		<td><input type="radio" value="1" name="conf[showException]"  <{if $conf.showException}>checked="checked"<{/if}> />是 &nbsp;&nbsp; <input type="radio" value="0" name="conf[showException]" <{if !$conf.showException}>checked="checked"<{/if}>  />否</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>toGameUrl</td>
		<td>游戏跳转页</td>
		<td><input size="40" name="conf[toGameUrl]"  value="<{$conf.toGameUrl}>"  /></td>
		<td>http://web..com/stat/togame.php</td>
	</tr>
	<tr>
		<td>fullScreen</td>
		<td>是否默认开启全屏</td>
		<td><input type="radio" value="1" name="conf[fullScreen]" <{if $conf.fullScreen}>checked="checked"<{/if}>  />是 &nbsp;&nbsp; <input value="0" type="radio" name="conf[fullScreen]" <{if !$conf.fullScreen}>checked="checked"<{/if}> />否</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>resourceHost</td>
		<td>游戏前端资源地址</td>
		<td><input size="40" name="conf[resourceHost]"  value="<{$conf.resourceHost}>"  /></td>
		<td>http://mcjh.static..com/</td>
	</tr>
	<tr>
		<td>ip</td>
		<td>游戏服务端所在机ip或域名</td>
		<td><input size="40" name="conf[ip]"  value="<{$conf.ip}>"  /></td>
		<td>server1.mcjh.my.com</td>
	</tr>
	<tr>
		<td>port</td>
		<td>游戏服务端所在机连接端口</td>
		<td><input size="40" name="conf[port]" value="<{$conf.port}>" /></td>
		<td>80</td>
	</tr>
	<tr>
		<td>bgpHost</td>
		<td>bgpHost</td>
		<td><input size="40" name="conf[bgpHost]"  value="<{$conf.bgpHost}>" /></td>
		<td>mccqbgp..com</td>
	</tr>
	<tr>
		<td>bgpPort</td>
		<td>bgpPort</td>
		<td><input size="40" name="conf[bgpPort]" value="<{$conf.bgpPort}>"  /></td>
		<td>443</td>
	</tr>
	<tr>
		<td>directlyUseBgp</td>
		<td>是否直接使用BGP</td>
		<td><input type="radio" value="1" name="conf[directlyUseBgp]" <{if $conf.directlyUseBgp}>checked="checked"<{/if}> />是 &nbsp;&nbsp; <input value="0" type="radio" name="conf[directlyUseBgp]" <{if !$conf.directlyUseBgp}>checked="checked"<{/if}> />否</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>playerQQGroup</td>
		<td>玩家QQ群列表(以英文逗号分隔)</td>
		<td><input size="40" name="conf[playerQQGroup]"  value="<{$conf.playerQQGroup}>"  /></td>
		<td>122345678,2345678,3345678</td>
	</tr>
	<tr>
		<td>version</td>
		<td>版本号</td>
		<td><input size="40" name="conf[version]" value="<{$conf.version}>"  /></td>
		<td>B1.0-20110707.3944.4470</td>
	</tr>
	<tr>
		<td>pkTip</td>
		<td>是否开启pk提示</td>
		<td><input type="radio" value="1" name="conf[pkTip]" <{if $conf.pkTip}>checked="checked"<{/if}>  />开启 &nbsp;&nbsp; <input value="0" type="radio" name="conf[pkTip]"  <{if !$conf.pkTip}>checked="checked"<{/if}>/>关闭</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="center">
			<input type="button" id="submit_button" name='submit_button' value="立即保存修改" />
		</td>
	</tr>
</table>
</form>
</body>
</html>
