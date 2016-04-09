<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->zlwzActivity}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
	</head>
	<body>
		<div id="position">
			<b><{$lang->menu->class->combineActivity}>：<{$lang->menu->zlwzActivity}></b>
		</div>
         <div><{$lang->page->serverOnlineDate}>: <{$onlineDate}> &nbsp; <{$lang->page->today}>: <{$today}></div>
		<br />
		<div><h3>全民战力礼包统计：</h3></div>
		
		<br />
		<table class="DataGrid" style="width:960px">  
		<{if $viewData}>  
            <tr align="center">
                <{foreach from=$viewData item=day name=day_data key=key}>  
					<th>第<{$key}>天<{$day.mtime}></th> 
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
        <br /><br />
        <div><h3>战力王者大奖信息:</h3></div>
      <table class="DataGrid" style="width:960px">  
		<{if $viewInfo}>   
            <tr align="center">
                <th>账号ID</th>
                <th>玩家名</th>
                <th>服务器ID</th>
                <th>战斗力</th>
			</tr>    
             <{foreach from=$viewInfo item=i name=day_data key=key}>   
				<tr align="center">                   
                    <td><{$i.uuid}></td>
                    <td><{$i.role_name}></td>
                    <td>S<{$i.server_id}>服</td>
                    <td><{$i.zhandouli}></td>
				</tr>   
                <{/foreach}>			
		<{else}>		
			<tr><td colspan="5"><{$lang->page->noData}></td></tr>
		<{/if}>
		</table>
<div id="no_data" class="rank"><{$lang->page->noData}></div>
	</body>
</html>