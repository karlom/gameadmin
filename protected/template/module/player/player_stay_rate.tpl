<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/ip.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>

<title><{$lang->menu->playerStay}></title>

</head>

<body>

<div id="position">
<b><{$lang->menu->class->onlineAndReg}>：<{$lang->menu->playerStay}></b>
</div>

<{if '' == $action}>
<div class="clearfix" style="margin-bottom: 5px;">
	<span class="left">
	<form name="myform2" id="myform2" method="post" action="">
		<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" size='12' value='<{$startDate}>' /> 
		<input id="search" name="search" type="hidden" value="search" />
		<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />
		开服日期：<{$minDate}>
	</form>
	</span>
</div>
<{/if}>
</br>

<{if $player }>
<table cellspacing="1" border="0" class="table_list" style="width: 100%;" >
	<tr align="center" class="table_list_head">
		<td width="10%">起始日注册数</td>
		<td width="10%">次日登录数/留存率%</td>
		<td width="10%">第3日登录数/留存率%</td>
		<td width="10%">第4日登录数/留存率%</td>
		<td width="10%">第5日登录数/留存率%</td>
		<td width="10%">第6日登录数/留存率%</td>
		<td width="10%">第7日登录数/留存率%</td>
		<td width="10%">第7-14天登录数/周留存率%</td>
		<td width="10%">第30-60天登录数/月留存率%</td>
	</tr>
	<tr align="center" class="trEven">
		<td style="color:#F00" ><{$player.day.reg}></td>
		<td style="color:#000" ><{$player.day.login}>&nbsp;/&nbsp;<{$player.day.stay_rate}></td>
		<td style="color:#000" ><{$player.day2.login}>&nbsp;/&nbsp;<{$player.day2.stay_rate}></td>
		<td style="color:#000" ><{$player.day3.login}>&nbsp;/&nbsp;<{$player.day3.stay_rate}></td>
		<td style="color:#000" ><{$player.day4.login}>&nbsp;/&nbsp;<{$player.day4.stay_rate}></td>
		<td style="color:#000" ><{$player.day5.login}>&nbsp;/&nbsp;<{$player.day5.stay_rate}></td>
		<td style="color:#000" ><{$player.day6.login}>&nbsp;/&nbsp;<{$player.day6.stay_rate}></td>
		<td style="color:#000" ><{$player.week.login}>&nbsp;/&nbsp;<{$player.week.stay_rate}></td>
		<td style="color:#000" ><{$player.month.login}>&nbsp;/&nbsp;<{$player.month.stay_rate}></td>
	</tr>
</table>
<{*
<br />
<table cellspacing="1" border="0" class="table_list" style="width: 100%;" >
	<tr class="table_list_head">
		<td width="10%">本周注册</td>
		<td width="10%">次周登录</td>
		<td width="10%">周留存率%</td>
	</tr>
	<tr class="trEven">
		<td><{$player.week.reg}></td>
		<td><{$player.week.login}></td>
		<td><{if $player.week.reg == 0 }>N/A<{else}><{math equation="(x/y)*100" x=$player.week.login y=$player.week.reg format="%.2f"}><{/if}></td>
	</tr>
</table>
<br />
<table cellspacing="1" border="0" class="table_list" style="width: 100%;" >
	<tr class="table_list_head">
		<td width="10%">本月注册</td>
		<td width="10%">次月登录</td>
		<td width="10%">月留存率%</td>
	</tr>
	<tr class="trEven">
		<td><{$player.month.reg}></td>
		<td><{$player.month.login}></td>
		<td><{if $player.month.reg == 0 }>N/A<{else}><{math equation="(x/y)*100" x=$player.month.login y=$player.month.reg format="%.2f"}><{/if}></td>
	</tr>
</table>
<br />
*}>

<{/if}>

<br>
游戏大厅留存数据：
<{if $qqgame }>
<table cellspacing="1" border="0" class="table_list" style="width: 100%;" >
	<tr align="center" class="table_list_head">
		<td width="10%">起始日注册数</td>
		<td width="10%">次日登录数/留存率%</td>
		<td width="10%">第3日登录数/留存率%</td>
		<td width="10%">第4日登录数/留存率%</td>
		<td width="10%">第5日登录数/留存率%</td>
		<td width="10%">第6日登录数/留存率%</td>
		<td width="10%">第7日登录数/留存率%</td>
		<td width="10%">第7-14天登录数/周留存率%</td>
		<td width="10%">第30-60天登录数/月留存率%</td>
	</tr>
	<tr align="center" class="trEven">
		<td style="color:#F00" ><{$qqgame.day.reg}></td>
		<td style="color:#000" ><{$qqgame.day.login}>&nbsp;/&nbsp;<{$qqgame.day.stay_rate}></td>
		<td style="color:#000" ><{$qqgame.day2.login}>&nbsp;/&nbsp;<{$qqgame.day2.stay_rate}></td>
		<td style="color:#000" ><{$qqgame.day3.login}>&nbsp;/&nbsp;<{$qqgame.day3.stay_rate}></td>
		<td style="color:#000" ><{$qqgame.day4.login}>&nbsp;/&nbsp;<{$qqgame.day4.stay_rate}></td>
		<td style="color:#000" ><{$qqgame.day5.login}>&nbsp;/&nbsp;<{$qqgame.day5.stay_rate}></td>
		<td style="colqqgame0" ><{$qqgame.day6.login}>&nbsp;/&nbsp;<{$qqgame.day6.stay_rate}></td>
		<td style="color:#000" ><{$qqgame.week.login}>&nbsp;/&nbsp;<{$qqgame.week.stay_rate}></td>
		<td style="color:#000" ><{$qqgame.month.login}>&nbsp;/&nbsp;<{$qqgame.month.stay_rate}></td>
	</tr>
</table>

<{/if}>

</body>
</html>