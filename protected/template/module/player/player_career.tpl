<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><{$lang->menu->metierStat}></title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<div id="position"><{$lang->menu->class->baseData}>：<{$lang->menu->metierStat}></div>

<div><{$lang->page->onlineDate}>: <span style="color:#00F"><{$onlineDate}></span>&nbsp; <{$lang->page->onlineDays}>: <span style="color:#00F"><{$onlineDays}></span></div>
<br/>

<{ if $data }>
<div style="clear: both;width:100%">
<table cellspacing="1" cellpadding="3" border="0" class="table_list sortable" width="200" style="width: 30%;float: left;">
   <caption class='table_list_head'>
        <{$lang->career->register}>
	</caption>
	
	<thead>
    <tr class='table_list_head'>
        <th><{$lang->player->level}></th>
        <th><{$dictOccupationType.1}></th>
        <th><{$dictOccupationType.2}></th>
        <th><{$dictOccupationType.3}></th>
	</tr>
	</thead>
    
    <{assign var=all_wuzun value=0}>
    <{assign var=all_lingxiu value=0}>
    <{assign var=all_jianxian value=0}>

    <tbody>
    <{foreach from=$data item=level key=k}>
    <tr align="center" class='<{cycle values="trEven,trOdd"}>'>
    
    	<{assign var=all_wuzun value=$all_wuzun+$level.wuzun }>
    	<{assign var=all_lingxiu value=$all_lingxiu+$level.lingxiu }>
    	<{assign var=all_jianxian value=$all_jianxian+$level.jianxian }>
    	
    	<td><{$k}></td>
    	<td><{ $level.wuzun }></td>
    	<td><{ $level.lingxiu }></td>
    	<td><{ $level.jianxian }></td>
    </tr>
    <{/foreach}>
    </tbody>
    
    <{assign var=all value=$all_wuzun+$all_lingxiu+$all_jianxian}>
    
    <tfoot>
    <tr align="center" class='<{cycle values="trEven,trOdd"}>'>
    	<td>-- <{$lang->page->summary}> --</td>
    	<td><span style="color:#00F"><{ $all_wuzun }></span>&nbsp;(<{math equation="(x/y)*100" x=$all_wuzun y=$all format="%.2f"}>%)</td>
    	<td><span style="color:#00F"><{ $all_lingxiu }></span>&nbsp;(<{math equation="(x/y)*100" x=$all_lingxiu y=$all format="%.2f"}>%)</td>
    	<td><span style="color:#00F"><{ $all_jianxian }></span>&nbsp;(<{math equation="(x/y)*100" x=$all_jianxian y=$all format="%.2f"}>%)</td>
    </tr>
    </tfoot>
    
</table>
</div>

<{else}>
<{$lang->active->noData}>
<{/if}>
</body>
</html>