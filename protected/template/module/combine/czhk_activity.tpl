<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->czhkActivity}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
	</head>
	<body>
		<div id="position">
			<b><{$lang->menu->class->combineActivity}>：<{$lang->menu->czhkActivity}></b>
		</div>
         <div><{$lang->page->serverOnlineDate}>: <{$onlineDate}> &nbsp; <{$lang->page->today}>: <{$today}></div>
		<br />
		<div><h3>各阶充值回馈礼包统计：</h3></div>
		
		<br />
		<table class="DataGrid" style="width:960px">
        <tr align="center">
            <th></th>
			<th>500仙石</th> 
            <th>1500仙石</th>
            <th>5000仙石</th> 
            <th>15000仙石</th> 
            <th>30000仙石</h> 
            <th>50000仙石</th>
		</tr>   
		<{if $viewData}>
             <{foreach from=$viewData item=day name=day_data key=key}>   
				<tr align="center">                   
					<td><{$key}></td> 
                    <{foreach from=$day item=item name=day_data key=key}>  
                    <{foreach from=$item item=i name=day_data key=key}>  
                    <td><{$i.count}></td>
                    <{/foreach}>	
                    <{/foreach}>	
				</tr>   
                <{/foreach}>			
		<{else}>		
			<tr><td colspan="5"><{$lang->page->noData}></td></tr>
		<{/if}>
		</table>
<div id="no_data" class="rank"><{$lang->page->noData}></div>
	</body>
</html>