<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<title><{$lang->menu->moneySaveAndConsume}></title>
<script type="text/javascript">
$(document).ready(function(){
	$('#display_all').click(function(){
		$('#statistics_table tr').show();
	})

	$('#btn_all').click(function(){
		$('#statistics_table tr[class!="alwaysdisplay"]').hide();
		$('#statistics_table tr.all').show();
	})
	
	$('#btn_all_money').click(function(){
		$('#statistics_table tr[class!="alwaysdisplay"]').hide();
		$('#statistics_table tr.all_money').show();
	})
	
	$('#btn_all_bind_money').click(function(){
		$('#statistics_table tr[class!="alwaysdisplay"]').hide();
		$('#statistics_table tr.all_bind_money').show();
	})
})
</script>
</head>
<body>



<div id="position"><{$lang->menu->class->spendData}>：<{$lang->menu->moneySaveAndConsume}></div>

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
<table>
<tr>
<td>
	<form action="?action=search" id="frm" method="get"  style="display:inline;">
		<table cellspacing="1" cellpadding="5" class="SumDataGrid" >
			<tr>
				<td>
					<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startTime|date_format:'%Y-%m-%d' }>' /> 
				</td>
				<td>
					<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endTime|date_format:'%Y-%m-%d'}>' /> 
				</td>
				<td width="100px"><input type="submit" name='search' value="搜索" class="input2 submitbtn"  /></td>
			</tr>
		</table>
	</form>
</td>

</tr>
</table>
<br />
<!-- End 账号和角色名搜索  -->

<{if $statistics}>
<input type="button" id="display_all" value="<{$lang->money->displayAll}>"/>
<input type="button" id="btn_all" value="<{$lang->money->all_money}>"/>
<input type="button" id="btn_all_money" value="<{$lang->money->money}>"/>
<input type="button" id="btn_all_bind_money" value="<{$lang->money->bind_money}>"/>
<br />
<br />
<div>
	<span class="hr_red" style=" height:10px" >&nbsp;</span> <{$lang->page->gt}><{$highlightPercentage*100}>%
	<span class="hr_green" style=" height:10px" >&nbsp;</span> <{$lang->page->lt}><{$highlightPercentage*100}>%
</div>

<!-- Start 银子统计  -->
<table id="statistics_table" class="SumDataGrid" style="min-width: 800px;">
	<tr align="center" class="alwaysdisplay">
		<th colspan="<{math equation="x+1" x=$countOfDays}>">
			<{$startTime|date_format:"%Y-%m-%d"}> - <{$endTime|date_format:"%Y-%m-%d"}>  
		</th>
	</tr>
<{assign var=labelWidth value=120}>
	
<{capture assign=sinceOpenDaysHTML}>
	<tr align="center" class="alwaysdisplay">
		<th width="<{$labelWidth}>px"><{$lang->page->date}><br/><{$lang->page->onlineDays}></th>
		<{foreach from=$statistics item=log key=key name=statistics_loop_2}>
		<td>
			<{if $log.weekday == 0 }>
				<{assign var=class value='red'}>
			<{else}>
				<{assign var=class value=''}>
			<{/if}>
			<span class="<{$class}>"><{$log.mtime|date_format:"%m-%d"}>
				<{if $log.weekday == 0 }><br /><{$lang->page->sunday}> <{/if}>
			<br/>(<{$key}>)
			</span>
		</td>
		<{/foreach}>	
	</tr>
<{/capture}>

<{$sinceOpenDaysHTML}>

<{foreach from=$keyMap item=map name=keymap_loop key=type}>
	<!-- Start 总银子 -->
	<{assign var=division value=$map.top_all*$highlightPercentage}>
	<{assign var=key_all value=$map.key_all}>
	<tr align="center" valign="bottom" class="all" height="148">
		<th valign="middle" width="<{$labelWidth}>px"><{$map.label_all}></th>
		<{foreach from=$statistics item=log}>
		<td>
			<{$log.$type.$key_all}>
			<{if $log.$type.$key_all >= $division }>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$log.$type.$key_all y=$map.top_all}>px;" />
		</td>
		<{/foreach}>
	</tr>
	<!-- End 总银子-->
	
	<!-- Start 总不绑定银子 -->
	<{assign var=division value=$map.top_all_money*$highlightPercentage}>
	<{assign var=key_all_money value=$map.key_all_money}>
	<tr align="center" valign="bottom" class="all_money"  height="148">
		<th valign="middle" width="<{$labelWidth}>px"><{$map.label_all_money}></th>
		<{foreach from=$statistics item=log}>
		<td>
			<{$log.$type.$key_all_money}>
			<{if $log.$type.$key_all_money >= $division }>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$log.$type.$key_all_money y=$map.top_all_money}>px;" />
		</td>
		<{/foreach}>
	</tr>
	<!-- End 总不绑定银子 -->
	
	<!-- Start 总绑定银子 -->
	<{assign var=division value=$map.top_all_bind_money*$highlightPercentage}>
	<{assign var=key_all_bind_money value=$map.key_all_bind_money}>
	<tr align="center" valign="bottom" class="all_bind_money" height="148" >
		<th valign="middle" width="<{$labelWidth}>px"><{$map.label_all_bind_money}></th>
		<{foreach from=$statistics item=log}>
		<td>
			<{$log.$type.$key_all_bind_money}>
			<{if $log.$type.$key_all_bind_money >= $division }>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$log.$type.$key_all_bind_money y=$map.top_all_bind_money}>px;" />
		</td>
		<{/foreach}>
	</tr>
	<!-- End 总绑定银子-->
<{/foreach}>	

<{$sinceOpenDaysHTML}>

</table>
<!-- End 银子统计 -->
<{/if}>
</body>
</html>