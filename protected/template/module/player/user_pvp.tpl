<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->userPvp}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<style>
.table {
	border-color:SkyBlue;
	border-width:1px;
	border-style:solid;
	width:400px;
}
table.SumDataGrid
{
    background:white;
	border:SkyBlue solid 1px;
	border-collapse:collapse;
    
}

table.SumDataGrid th, table.SumDataGrid td
{
 	border:SkyBlue solid 1px;
	border-collapse:collapse;
}

table.SumDataGrid th
{
  background: #EBF9FC;
  text-align: center;
}

table.SumDataGrid tr.odd
{
  background: #E0F3F3;
}
</style>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->userPvp}></b>
</div> 
<div class='divOperation'>
<form id="myform" name="myform" method="get" action="" style="display: inline;">
<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="start_day" id="start_day" onfocus="WdatePicker({el:'start_day',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'end_day\')}'})" value="<{ $startDay }>">
<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="end_day" id="end_day" onfocus="WdatePicker({el:'end_day',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'start_day\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>">
&nbsp;
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" name="search"  />
&nbsp;&nbsp;
</form>
</div>
<br />
<div>
所有代理：<span style="text-align:center;"> <img src="/static/images/red.gif" width="10" height="5"/> 较好 <img src="/static/images/green.gif" width="10" height="5"/> 较差&nbsp;</span>
<table class="SumDataGrid">
	<tr>
		<th height="150" width="10">流失人数</th>
		<{foreach from=$arr item=item key=key }>
				<td align="center" style="background-color:#FFF;" valign="bottom" title="<{$item.alert}>"><div style="width:40px;"><{$item.count}></div><img src="/static/images/<{$item.img_name}>.gif" width="10" height="<{$item.height}>"/></td>
		<{/foreach}>
	</tr>
	<tr align="center"><th width="10">PVP地图</th>
		<{foreach from=$liushiList key=key item=item}>
		<td  style="table-layout: fixed;WORD-BREAK: break-all; WORD-WRAP: break-word; background-color:#C0C0C0; width:50px"><{$item.name}></td>
		<{/foreach}>
	</tr>
</table>
</div>
<br /><br />
<div>
<div style=" float:  left; width: 400px ; height: 98%" >
<table cellspacing="1" cellpadding="3" border="0" class='table' >
    <tr><th colspan="4" align="center">累计死亡数量</th></tr>
    <tr class='table_list_head'>
		<th align="center" width="100px">PVP地图</th>
		<th align="center" width="100px">累计死亡数量</th>
    </tr>
    <{foreach  from=$mapList item=list}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center"><{$list.name}></td>
		<td align="center" class="cmenu" ><{$list.die_count}></td>
	</tr>
    <{/foreach}>
</table>
</div>
<div style=" float:  left; width: 400px ; height: 98%">
<{if $dataList}>
<{foreach from=$dataList item=list key=key}>
<div style=" float:  left; margin-left: 10px">
<table cellspacing="1" cellpadding="3" border="0" class='table' >
    <tr><th colspan="4" align="center"><{$key}></th></tr>
    <tr class='table_list_head'>
		<th align="center" width="100px">PVP地图</th>
		<th align="center" width="100px">死亡数量</th>
    </tr>
    <{foreach from=$list item=temp}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center"><{$temp.name}></td>
		<td align="center" class="cmenu" ><{$temp.die_count}></td>
	</tr>
    <{/foreach}>
</table>
</div>
    <{/foreach}>
 <{/if}>
</div>
</div>
</body>
</html>
