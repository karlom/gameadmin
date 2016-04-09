<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->activitySwitch}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
		<script type="text/javascript">

		</script>
		
	</head>
	<body>
		<div id="position">
			<b><{$lang->menu->class->activityManage}>：<{$lang->menu->activitySwitch}></b>
		</div>
		
		<div><{$lang->page->serverOnlineDate}>: <{$onlinedate}> &nbsp; <{$lang->page->today}>: <{$maxDate}></div>
		<br />
		
		<{if $strMsg}>
		<table cellspacing="1" cellpadding="5" class="DataGrid">
			<tr>
				<td><span style="color:red;"><{$strMsg}></span></td>
			</tr>
		</table>
		<br />
		<{/if}>
		
		<div style="color:red;font-size:1.5em;" >注意：如不清楚，请不要随便操作！</div>
		
		&nbsp;<input type="button" value="刷新" name="reflesh" onclick="javascript:window.location.href='activity_switch.php';" />
		
		<table class="DataGrid" style="width:960px">
			<tr>
				<th>活动ID</th>
				<th>活动名称</th>
				<th>开启时间</th>
				<th>当前状态</th>
				<th>操作</th>
			</tr>
			<{ foreach from=$activityStatus item=copy key=key }>
			<tr align="center">
				<td><{$copy.copy_id}></td>
				<td><{$copy.name}></td>
				<td><{$copy.start_time}></td>
				<td><{$dictStatus[$copy.status]}></td>
				<td>
					<form action="activity_switch.php" method="post">
						<input type="hidden" name="id" value="<{$key}>" />
						<input type="hidden" name="copy_id" value="<{$copy.id}>" />
						<label><input type="submit" name="open" value="开启" onclick="return confirm('确定要开启【<{$copy.name}>】活动？');" <{if $copy.status == 1}> disabled="true" <{/if}> /></label>
						&nbsp;
						<label><input type="submit" name="close" value="关闭" onclick="return confirm('确定要关闭【<{$copy.name}>】活动？');" <{if $copy.status == 0}> disabled="true" <{/if}> /></label>
					</form>
				</td>
			</tr>
			<{/foreach}>
		</table>
	
	</body>
</html>