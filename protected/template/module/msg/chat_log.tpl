<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
	$(document).ready(function(){
		$("#role_name").keydown(function(){
			$("#role_id").val('');
			$("#account_name").val('');
		});
		$("#account_name").keydown(function(){
			$("#role_id").val('');
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

<title><{$lang->menu->channelChat}></title>

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
		<{* 暂时不需要角色ID
			<td>
				<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
			</td>
			<td>
				<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
			</td>

			<td align="right"><{$lang->page->accountName}>：</td>
			<td><input type="text" name="role[account_name]" id="account_name" value="<{$role.account_name}>" /></td>
			<td align="right"><{$lang->page->roleName}>：</td>
			<td><input type="text" name="role[role_name]" id="role_name" value="<{$role.role_name}>" /></td>
			<td align="right"><{$lang->page->keyword}>：</td>
			<td><input type="text" name="keyword" id="keyword" value="<{$keyword}>" /></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2"  /></td>
	*}>
			<td>
				<{$lang->page->date}>:<input id='lookingday' name='lookingday' type="text" class="Wdate" onfocus="WdatePicker({el:'lookingday',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" size='12' value='<{$lookingDay}>' />
			</td>
			<td align="right"><{$lang->page->channel}>：</td>
			<td>
				<{html_options options=$channelArray selected=$channel name='channel'}>
				
				<td><input type="image" name='search' src="/static/images/search.gif" class="input2"  /></td>
			</td>
			<td>
				<input type="submit" name="today" id="today" value="<{$lang->page->today}>" />
				<input type="submit" name="preday" id="preday" value="<{$lang->page->preday}>" />
				<input type="submit" name="nextday" id="nextday" value="<{$lang->page->afterday}>" />
			</td>
			
		</tr>
	</table>
</form>
<br />
<!-- End 账号和角色名搜索  -->
<div class="main-header">
	<{$lang->page->currentLooking}>【<{$channelArray[$channel]}>】<{$lang->page->channel}> <{$lookingDay}> <{$lang->page->chatLogOf }>
</div>
<{ if $chat_log_list }>
	<!--  Start  聊天日志信息-->
	<div id="chatlog-container">
		<{foreach from=$chat_log_list item=chat_log name=chat_log_loop}>
			<div class="log">
				<span class="time">[<{$chat_log.mtime|date_format:'%H:%M:%S'}>]</span> <span class="name"><{ $chat_log.role_name}></span> : <{ $chat_log.content}><br />
			</div>
		<{/foreach}>
	</div>
	<!--  End  聊天日志信息-->
<{* 只显示聊天记录
	<table class="DataGrid sortable table_list" cellspacing="0" style="margin-bottom:20px;">
		
		<tr>
			<th width="10%"><{$lang->page->accountName}></th>
			<th width="10%"><{$lang->page->roleName}></th>
			<th width="5%"><{$lang->page->channel}></th>
			<th width="15%"><{$lang->page->time}></th>
			<th width="60%"><{$lang->page->content}></th>

		</tr>
	
			<{foreach from=$chat_log_list item=chat_log name=chat_log_loop}>
		    <tr align="center" <{ if $smarty.foreach.chat_log_loop.index is odd }> class="odd"<{ /if }>>
				<td><{ $chat_log.account_name}>&nbsp;</td>
				<td><{ $chat_log.role_name}>&nbsp;</td>
				<td><{ $channelArray[$chat_log.channel]}>&nbsp;</td>
				<td><{ $chat_log.mtime|date_format:'%Y-%m-%d %H:%M:%S'}>&nbsp;</td>
		        <td><{ $chat_log.txt }>&nbsp;</td>
			</tr>
			<{/foreach}>
	</table>
*}>


<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
</body>
</html>