<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->playerPayData}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->payAndSpand}>：<{$lang->menu->playerPayData}></b>
</div> 
<div class='divOperation'>
<form id="myform" name="myform" method="get" action="" style="display: inline;">
<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="startDay" id="startDay" onfocus="WdatePicker({el:'startDay',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDay\')}'})" value="<{ $startDay }>">
<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="endDay" id="endDay" onfocus="WdatePicker({el:'endDay',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDay\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>">
&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role_name" size="10" value="<{$role_name}>" />
&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="account_name" size="10" value="<{$account_name}>" />
<{html_options options=$sortTypeArray selected=$selectOrder name='sortType'}>
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>
<form id="myform2" name="myform2" method="post" action="<{$current_uri}>" style="display: inline;">
<input type="submit" class="button" name="dateToday" value="<{$lang->page->today}>" >&nbsp;&nbsp;
				<input type="submit" <{if $currentDay and $currentDay <= $minDate }> disabled="disabled" <{/if}> class="button" name="datePrev" value="<{$lang->page->prevTime}>">&nbsp;&nbsp;
				<input type="submit" <{if $currentDay and $currentDay >= $maxDate }> disabled="disabled" <{/if}> class="button" name="dateNext" value="<{$lang->page->nextTime}>">&nbsp;&nbsp;
				<input type="submit" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" >
</form>
</div>
<{if $viewData.data}>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
  <tr>
    <td height="30" class="even">
	<{include file='file:pager.tpl' pages=$pager assign=pager_html}>
	<{$pager_html}>
  	<input type="hidden" name="excel" id="excel" />
  [ <a href="<{$excelUri}>" ><{$lang->page->excel}></a> ]
    </td>
  </tr>
</table>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
	<tr class='table_list_head'>
        <td width="6%"><{$lang->player->order}></td>
        <td width="6%"><{$lang->player->roleName}></td>
        <td width="6%"><{$lang->player->accountName}></td>
        <td width="5%"><{$lang->player->payTime}></td>
        <td width="8%"><{$lang->player->goldGet}></td>
        <td width="5%"><{$lang->player->moneyLost}></td>
	</tr>
	
<{foreach name=loop from=$viewData.data item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$item.order}></td>
		<td class="cmenu" title="<{$item.roleName}>"><{$item.roleName}></td>
		<td class="cmenu" title="<{$item.roleName}>"><{$item.accountName}></td>
		<td><{$item.payTime}></td>
		<td><{$item.goldGet}></td>
		<td><{$item.moneyLost}></td>
	</tr>
<{/foreach}>
</table>
<br />
<{$pager_html}>
<{else}>
<font color='red'><{$lang->page->noData}></font>
<{/if}>
</div>

</body>
</html>
