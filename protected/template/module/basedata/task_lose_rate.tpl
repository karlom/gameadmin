<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><{$lang->menu->taskLoseRate}></title>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<style type="text/css">
	.hoverTd{
		background-color:#D7C8EA;
	}
</style>
<script type="text/javascript" src="/static/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<body>
<div id="position">
<b><{$lang->menu->class->onlineAndReg}>：<{$lang->menu->taskLoseRate}></b>
</div>
<form id="myform" name="myform" method="post" action="<{$URL_SELF}>">
	<{$lang->sys->countDate}>：
	<input type="text" size="12" name="starttime" id="starttime" class="Wdate" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' />
	<{$lang->page->to}>        
	<input type="text" size="12" name="endtime" id="endtime"  class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' />
	<!--
	<{$lang->sys->playerLevel}>: 
	<input type="text" name="min_level" size="5" value="<{if $minLevel}><{$minLevel}><{/if}>" />&nbsp;-&nbsp;
	<input type="text" name="max_level" size="5" value="<{if $maxLevel}><{$maxLevel}><{/if}>" />
	-->
	<input type="submit" name='search' value=" <{$lang->sys->search}> " />
</form>
<br />
<{if $viewData}>
	<table id="list" class="table_list sortable" >
	<tr align="center" class="table_list_head">
		<th><{$lang->sys->missionID}></th>
		<th><{$lang->sys->missionName}></th>
		<th><{$lang->sys->accept}></th>
		<th><{$lang->sys->finish}></th>
		<th><{$lang->sys->noFinish}></th>
		<th><{$lang->sys->finishRate}></th>
	</tr>
		 <{foreach from=$viewData item=item}>                                   
			<tr align="center" class="<{cycle values="trEven,trOdd"}>">
				<td width="8%"><{$item.task_id}></td>
				<td width="8%"><{$dictTask[$item.task_id].name}></td>
				<td width="8%" style="color:red;"><{$item.accept}></td>
				<td width="8%" style="color:red;"><{$item.finish}></td>
				<td width="8%" style="color:red;"><{$item.accept-$item.finish}></td>
				<td width="8%" style="color:green;"><{$item.finishRate}></td>
			</tr>
		<{/foreach}>
	</table>
<{else}>
	<font color="red"><{$lang->sys->withoutData}></font>
<{/if}>
</body>
</html>
