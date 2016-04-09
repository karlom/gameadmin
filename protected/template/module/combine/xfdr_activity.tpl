<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->xfdrActivity}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
	</head>
	<body>
		<div id="position">
			<b><{$lang->menu->class->combineActivity}>：<{$lang->menu->xfdrActivity}></b>
		</div>
         <div><{$lang->page->serverOnlineDate}>: <{$onlineDate}> &nbsp; <{$lang->page->today}>: <{$today}></div>
		<br />
		<div><h3>抽奖统计：</h3></div>
		
		<br />
		<table class="DataGrid" style="width:960px">
        <tr align="center">
            <th></th>
			<th>抽奖人数</th> 
            <th>抽奖次数</th>
		</tr>   
		<{if $viewData}>
             <{foreach from=$viewData item=day name=day_data key=key}>   
				<tr align="center">                   
					<td>第<{$key}>天<{$day.mtime}></td> 
                    <td><{$day.person_count}></td>
                    <td><{$day.cnt}></td>
				</tr>   
                <{/foreach}>			
		<{else}>		
			<tr><td colspan="5"><{$lang->page->noData}></td></tr>
		<{/if}>
		</table>
<div id="no_data" class="rank"><{$lang->page->noData}></div>
	</body>
</html>