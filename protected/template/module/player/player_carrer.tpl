<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><{$lang->menu->metierStat}></title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<div id="position"><{$lang->menu->class->baseData}>：<{$lang->menu->metierStat}></div>
<b><{$lang->career->remark}></b>
<div style="clear: both;width:100%">
<table cellspacing="1" cellpadding="3" border="0" class='table_list' width="200" style="width: 30%;float: left;">
    <tr class='table_list_head'>
        <td colspan="3" align="center"><{$lang->career->register}></td>
	</tr>
    <tr class='table_list_head'>
        <td width="23%"><{if $type neq 2}><{$lang->career->country}><{else}><{$lang->career->career}><{/if}></td>
        <td width="43%"><{$lang->career->player_count}></td>
        <td width="33%"><{$lang->career->player_rate}></td>
	</tr>
    
    <{foreach key=country item=item from=$rd name=all}>
       	<{if $smarty.foreach.all.index % 2 == 0}>
    	<tr class='trEven'>
    	<{else}>
    	<tr class='trOdd'>
    	<{/if}>
    	<{if $type eq 3}>
    	<td><{$country}></td>
    	<td>
    	<{foreach key=career item=item1 from=$item name=all1}>
    		<{if $career neq 'total' && $career neq 'percent'}>
    		<{$career}>&nbsp;:&nbsp;<{$item1.num}>/<{$item.total}>(<{$item1.percent}>%)<br/>
    		<{/if}>
    	<{/foreach}>
    	</td>
        <td><{$item.total}>/<{$rd_total}>(<{$item.percent}>%)</td>
        <{else}>
    	<td><{$country}></td>
    	<td>
    		<{$item.num}>/<{$rd_total}>
    	</td>
        <td><{$item.percent}>%</td>
        <{/if}>
        </tr>
    <{/foreach}>

</table>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' width="200" style="width: 30%;float: left;">
    <tr class='table_list_head'>
        <td colspan="3" align="center"><{$lang->career->activity}></td>
	</tr>
    <tr class='table_list_head'>
        <td width="23%"><{if $type neq 2}><{$lang->career->country}><{else}><{$lang->career->career}><{/if}></td>
        <td width="43%"><{$lang->career->player_count}></td>
        <td width="33%"><{$lang->career->player_rate}></td>
	</tr>
    
    <{foreach key=country item=item from=$ad name=all}>
       	<{if $smarty.foreach.all.index % 2 == 0}>
    	<tr class='trEven'>
    	<{else}>
    	<tr class='trOdd'>
    	<{/if}>
    	<{if $type eq 3}>
    	<td><{$country}></td>
    	<td>
    	<{foreach key=career item=item1 from=$item name=all1}>
    		<{if $career neq 'total' && $career neq 'percent'}>
    		<{$career}>&nbsp;:&nbsp;<{$item1.num}>/<{$item.total}>(<{$item1.percent}>%)<br/>
    		<{/if}>
    	<{/foreach}>
    	</td>
        <td><{$item.total}>/<{$ad_total}>(<{$item.percent}>%)</td>
		<{else}>
    	<td><{$country}></td>
    	<td>
    		<{$item.num}>/<{$ad_total}>
    	</td>
        <td><{$item.percent}>%</td>
		<{/if}>
        </tr>
    <{/foreach}>
</table></div>
<br />
<div style="clear: both;"></div>
<div><table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:60%; ">
    <tr class='table_list_head'>
        <td colspan="<{$c+2}>" align="center"><{$lang->career->activity_career}></td>
	</tr>
    <tr class='table_list_head'>
    <{foreach  key=key item=item from=$total_result.99 name=result}>
        <td width="10%"><{$item}></td>
    <{/foreach}>
	</tr>
    <{foreach key=key item=item from=$total_result name=result}>
      <{if $key neq '99'}>
       	<{if $smarty.foreach.result.index % 2 == 0}>
    	<tr class='trEven'>
    	<{else}>
    	<tr class='trOdd'>
    	<{/if}>
        <td><{$key*$level_range+1}>-<{$key*$level_range+$level_range}><{$lang->career->level}></td>
    	<{foreach key=key1 item=item1 from=$item name=result11}>
        	<td><{$item1}></td>
        <{/foreach}>
        </tr>
      <{/if}>
    <{/foreach}>
</table></div>