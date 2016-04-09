<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><{$lang->menu->registerFrom}></title>
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
<b><{$lang->menu->class->onlineAndReg}>：<{$lang->menu->registerFrom}></b>
</div>
<form id="myform" name="myform" method="post" action="<{$URL_SELF}>">
	<{$lang->sys->countDate}>：
	<input type="text" size="12" name="starttime" id="starttime" class="Wdate" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' />
	<{$lang->page->to}>        
	<input type="text" size="12" name="endtime" id="endtime"  class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' />

	<input type="submit" name='search' value=" <{$lang->sys->search}> " />
</form>
<br />

日期范围内注册数据：
<br>
<{if $viewData}>
	<table id="list" class="table_list sortable" style="width:600px;">
		<tr align="center" class="table_list_head">
			<th width="35%">渠道</th>
			<th width="35%">pf</th>
			<th width="30%"><{$lang->page->number}></th>
		</tr>
		 <{foreach from=$viewData item=item}>                                   
			<tr align="center" class="<{cycle values="trEven,trOdd"}>">
				<td><{$dictAppCustom[$item.opf] }></td>
				<td><{$item.opf}></td>
				<td><{$item.cnt}></td>
			</tr>
		<{/foreach}>
	</table>
<{else}>
	<font color="red"><{$lang->sys->withoutData}></font>
<{/if}>
<br>
<br>

日期范围内充值数据：(单位：Q点)
<br>
<{if $viewDataPay}>
	<table id="list" class="table_list sortable" style="width:800px;">
		<tr align="center" class="table_list_head">
			<th width="35%">渠道</th>
			<th width="35%">pf</th>
			<th width="30%"><{$lang->sys->totalCost}></th>
		</tr>
		 <{foreach from=$viewDataPay item=item}>                                   
			<tr align="center" class="<{cycle values="trEven,trOdd"}>">
				<td><{$dictAppCustom[$item.opf] }></td>
				<td><{$item.opf}></td>
				<td><{$item.totalCost}></td>
			</tr>
		<{/foreach}>
	</table>
<{else}>
	<font color="red"><{$lang->sys->withoutData}></font>
<{/if}>
<br>
<br>

留存统计：
<br>
<{if $viewDataStay}>
	<table id="list" class="table_list sortable" style="width:800px;">
		<tr align="center" class="table_list_head">
			<th width="20%">渠道</th>
			<th width="20%">pf</th>
			<th width="20%">起始日注册数</th>
			<th width="20%">次日登录数/留存率%</th>
			<th width="20%">第7日登录数/留存率%</th>
		</tr>
		 <{foreach from=$viewDataStay item=item}>                                   
			<tr align="center" class="<{cycle values="trEven,trOdd"}>">
				<td><{$dictAppCustom[$item.opf] }></td>
				<td><{$item.opf}></td>
				<td><{$item.reg_cnt}></td>
				<td><{$item.login2}>&nbsp;/&nbsp;<{$item.rate2}></td>
				<td><{ if $item.login7}><{$item.login7}><{else}>0<{/if}>&nbsp;/&nbsp;<{ if $item.rate7}><{$item.rate7}><{else}>0<{/if}></td>
			</tr>
		<{/foreach}>
	</table>
<{else}>
	<font color="red"><{$lang->sys->withoutData}></font>
<{/if}>



</body>
</html>
