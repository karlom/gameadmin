<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->qmkhActivity}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
	</head>
	<body>
		<div id="position">
			<b><{$lang->menu->class->combineActivity}>：<{$lang->menu->qmkhActivity}></b>
		</div>
         <div><{$lang->page->serverOnlineDate}>: <{$onlineDate}> &nbsp; <{$lang->page->today}>: <{$today}></div>
		<br />
		<div><h3>领取礼包统计：</h3></div>
		
		<br />
		<table class="DataGrid" style="width:960px">	
		<{if $viewData}>			
				<tr align="center">
                    <{foreach from=$viewData item=day name=day_data key=key}>   
					<th><{$day.mtime}></th>
                    <{/foreach}>
				</tr>         
				<tr align="center">
                    <{foreach from=$viewData item=i name=day_data key=key}>
					<td><{$i.count}></td>
                    <{/foreach}>
				</tr>				
		<{else}>		
			<tr><td colspan="5"><{$lang->page->noData}></td></tr>
		<{/if}>
		</table>
<div id="no_data" class="rank"><{$lang->page->noData}></div>
	</body>
</html>