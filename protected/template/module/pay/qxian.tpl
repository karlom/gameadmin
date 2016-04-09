<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">                                    
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />          
<title><{$lang->menu->allServerPayData}></title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">            
<link rel="stylesheet" href="/static/css/style.css" type="text/css">           
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<style type="text/css">                                                        
        .hr_red{                                                               
                background-color:red;                                          
                width:6px;                                                     
        }       
</style>        
</head> 

<body style="margin:0px;padding:20px;">
<div id="position"><b><{$lang->menu->class->payAndSpand}>:<{$lang->menu->qxian}></b></div>

<br />

<{$lang->pay->qxian}>
<{if $viewData}>
<div>
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:800px;">
		<tr>
			<th width="10%"><{$lang->rank->playerName}></th>
			<th width="10%"><{$lang->pay->buyTime }></th>
			<th width="10%"><{$lang->pay->day1}></th>
			<th width="10%"><{$lang->pay->day2}></th>
			<th width="10%"><{$lang->pay->day3}></th>
			<th width="10%"><{$lang->pay->day5}></th>
			<th width="10%"><{$lang->pay->day7}></th>
			<th width="10%"><{$lang->pay->day10}></th>
			<th width="10%"><{$lang->pay->day22}></th>
			<th width="10%"><{$lang->pay->day30}></th>
		</tr>
	<{foreach from=$viewData item=qx key=key}>
		<tr align="center">
			<td><{$qx.role_name}></td>
			<td> </td>
			<td><{if $qx.item_cnt>=2}>√<{else}> <{/if}></td>
			<td><{if $qx.item_cnt>=1}>√<{else}> <{/if}></td>
			<td><{if $qx.item_cnt>=2}>√<{else}> <{/if}></td>
			<td><{if $qx.item_cnt>=3}>√<{else}> <{/if}></td>
			<td><{if $qx.item_cnt>=5}>√<{else}> <{/if}></td>
			<td><{if $qx.item_cnt>=7}>√<{else}> <{/if}></td>
			<td><{if $qx.item_cnt>=10}>√<{else}> <{/if}></td>
			<td><{if $qx.item_cnt>=22}>√<{else}> <{/if}></td>
			<td><{if $qx.item_cnt>=30}>√<{else}> <{/if}></td>
		</tr>
	<{/foreach}>
	</table>	
</div>
<{else}>
<div class="red"><{$lang->page->noData}></div>
<{/if}>
<br />

</body>
</html>
