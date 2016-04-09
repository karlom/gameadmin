<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->qdscActivity}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
	</head>
	<body>
		<div id="position">
			<b><{$lang->menu->class->combineActivity}>：<{$lang->menu->qdscActivity}></b>
		</div>
            <div><{$lang->page->serverOnlineDate}>: <{$onlineDate}> &nbsp; <{$lang->page->today}>: <{$today}></div>
		<br />
		<div><h3>立即刷新消耗：</h3></div>
		
		<br />
		<table class="DataGrid" style="width:960px">  
		<{if $lzsxData}>  
            <tr align="center">
                <{foreach from=$lzsxData item=day name=day_data key=key}>  
					<th><{$day.mtime}></th> 
                    <{/foreach}>
				</tr>                            
				<tr align="center">  
                    <{foreach from=$lzsxData item=i name=day_data key=key}>  
                    <td><{$i.ljsx_count}></td>
                     <{/foreach}>	
				</tr>           		
		<{else}>		
			<tr><td colspan="5"><{$lang->page->noData}></td></tr>
		<{/if}>
		</table>
        <br /><br />
            
        <div><h3>购买道具消耗仙石:</h3></div>
      <table class="DataGrid" style="width:650px">  
         <tr align="center">
                <th></th>
                <th>消耗仙石（非绑定）</th>
                <th>人数</th>
                <th>次数</th>
		</tr>  
		<{if $xhxsData}>     
             <{foreach from=$xhxsData item=i name=day_data key=key}>   
				<tr align="center">                   
                    <td>第<{$key}>天<{$i.mtime}></td>
                    <td><{$i.xhxs_count}></td>
                    <td><{$i.person_count}></td>
                    <td><{$i.count}></td>
				</tr>   
                <{/foreach}>			
		<{else}>		
			<tr><td colspan="5"><{$lang->page->noData}></td></tr>
		<{/if}>
		</table>
<div id="no_data" class="rank"><{$lang->page->noData}></div>
        <br /><br />
            
        <div><h3>购买道具消耗铜币:</h3></div>
      <table class="DataGrid" style="width:650px">  
         <tr align="center">
                <th></th>
                <th>消耗铜币（非绑定）</th>
                <th>人数</th>
                <th>次数</th>
		</tr>  
		<{if $xhtbData}>     
             <{foreach from=$xhtbData item=i name=day_data key=key}>   
				<tr align="center">                   
                    <td>第<{$key}>天<{$i.mtime}></td>
                    <td><{$i.xhtb_count}></td>
                    <td><{$i.person_count}></td>
                    <td><{$i.count}></td>
				</tr>   
                <{/foreach}>			
		<{else}>		
			<tr><td colspan="5"><{$lang->page->noData}></td></tr>
		<{/if}>
		</table>
<div id="no_data" class="rank"><{$lang->page->noData}></div>
	</body>
</html>