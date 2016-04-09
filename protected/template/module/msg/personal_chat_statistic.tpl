<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
	$(document).ready(function(){
		$("#role_name").keydown(function(){
			$("#account_name").val('');
		});
		$("#account_name").keydown(function(){
			$("#role_name").val('');
		});

		$('#chatlog-container .log').hover(function(){
			$(this).css('background', '#fff5e1');
		}, 
		function(){
			$(this).css('background', '');
		});
	});
</script>

<style>
.main-header{
	font-weight: bold;
	font-size: 15px;
}
#chatlog-container{
	background:#c7e3cc;
	font-size: 150%;
}

#chatlog-container .log{
	margin-bottom: 2px; 
}

#chatlog-container .time, 
#chatlog-container .name
{

	font: 12px/1.5 tahoma,helvetica,clean,sans-serif;
	
}
</style>

<title><{$lang->menu->personalChatStatistic}></title>

</head>

<body>

<!-- Start 成功信息提示 -->
<{if $successMsg}>
<div class="success_msg_box">
	<{$successMsg}>
</div>
<{/if}>
<!-- End 成功信息提示 -->

<!-- Start 错误信息提示 -->
<{if $errorMsg}>
<div class="error_msg_box">
	<{$errorMsg}>
</div>
<{/if}>
<!-- End 错误信息提示 -->

<!-- Start 账号和角色名搜索  -->
<form action="?action=search" id="frm" method="GET" >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="auto">
		<tr>
			<td align="right"><{$lang->page->roleName}>:
				<input type="text" name="role_name" id="role_name" size="15" value="<{$roleName}>" />
			</td>
			<td><input type="image" name='search' src="/static/images/search.gif" /></td>
			
		</tr>
	</table>
</form>
<br />
<!-- End 账号和角色名搜索  -->
<{ if $viewData }>
	<div class="main-header">
		<{$lang->page->currentLooking}> 【<{$roleName}>】 <{$lang->page->chatStatisticsOf }>:
	</div>
	<br />
	
	<table class="SumDataGrid" width="800px">
		<thead>
			<tr>
			<th colspan="8">
				<{$lang->page->accountName}>:<font color="#EE22EE"><{$viewData.account_name}></font> <{$lang->page->roleName}>:<font color="#EE22EE"><{$viewData.role_name}></font><br />
				<{if $viewData.lastSpeakTime}>最后聊天时间：<font color="#0000EE"><{$viewData.lastSpeakTime|date_format:"%Y-%m-%d %H:%M:%S"}></font> 最后聊天频道：<font color="#0000EE"><{$viewData.lastSpeakChannel}></font><{/if}>
			</th>
			</tr>
		</thead>
    <tr >
        <!--th width="10%">时段</th-->
        <th width="10%">综合</th>
        <th width="10%">家族</th>
        <th width="10%">组队</th>
        <th width="10%">附近</th>
        <th width="10%">喇叭</th>
        <th width="10%">活动</th>
        <th width="10%">好友</th>
        <th width="10%">全部</th>
    </tr>
	
    <tr>
    	<{foreach from=$viewData.chat item=log}>
		<td align="center"><{$log.cnt}> <{ $log.perc }></td>
		<{/foreach}>
		<{*
		<td align="center"><{$viewData.chat.family}></td>
		<td align="center"><{$viewData.chat.team}></td>
		<td align="center"><{$viewData.chat.near}></td>
		<td align="center"><{$viewData.chat.laba}></td>
		<td align="center"><{$viewData.chat.activity}></td>
		<td align="center"><{$viewData.chat.friend}></td>
		<td align="center"><{$viewData.chat.all}></td>
		*}>
    </tr>

</table>


<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
</body>
</html>