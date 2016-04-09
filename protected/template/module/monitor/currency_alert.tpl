<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><{$lang->monitor->currencyAlert }></title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	</head>
	
	<body>
		<div id="position"><{$lang->menu->class->dataAlert}>：<{$lang->monitor->currencyAlert}></div>
		
		<table class="DataGrid" style="width:750px;">
			<tr>
				<th align="center" colspan="8"><{$lang->monitor->currencyAlert}>: </th>
			</tr>
		    <tr align="center" >
		        <td><{$lang->monitor->id}></td>
		        <td><{$lang->page->accountName}></td>
		        <td><{$lang->page->roleName}></td>
		        <td><{$lang->page->level}></td>
		        <td><{$lang->money->money}></td>
		        <td><{$lang->gold->gold}></td>
		        <td><{$lang->liquan->liquan}></td>
		        <td><{$lang->money->familyContribute}></td>
		    </tr>
			<{ if $data}>
				<{assign var="id" value=0}>
			    <{foreach from=$data item=log }>
			<{assign var="id" value=$id+1}>
			<!--	<{ $id = $id+1 }>	-->
			    <tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			        <td><{$id}></td>
			        <td><{$log.account_name}></td>
			        <td><{$log.role_name}></td>
			        <td><{$log.level}></td>
			        <td <{if $log.money > $moneyAlertValue}> style="color:#F00" <{/if}> ><{$log.money}></td>
			        <td <{if $log.gold > $goldAlertValue}> style="color:#F00" <{/if}> ><{$log.gold}></td>
			        <td <{if $log.liquan > $liquanAlertValue}> style="color:#F00" <{/if}> ><{$log.liquan}></td>
			        <td <{if $log.contribute > $contributeAlertValue}> style="color:#F00" <{/if}> ><{$log.contribute}></td>
			    </tr>
				<{/foreach}>
			<{else}>
				<tr><td colspan="8"><b><{$lang->page->noData}></b></td></tr>
			<{/if}>
		</table>
		<br />
		<div><b><{$lang->monitor->attention}>: </b><{$lang->monitor->notice}>,</div>
		<div>&nbsp;<{$lang->money->money}>: <{$moneyAlertValue}></div>
		<div>&nbsp;<{$lang->gold->gold}>: <{$goldAlertValue}></div>
		<div>&nbsp;<{$lang->liquan->liquan}>: <{$liquanAlertValue}></div>
		<div>&nbsp;<{$lang->money->familyContribute}>: <{$contributeAlertValue}></div>

	</body>
</html>