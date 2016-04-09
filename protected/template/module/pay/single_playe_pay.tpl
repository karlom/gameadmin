<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">                                    
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />          
<title><{$lang->menu->singlePlayePay}></title>
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/ip.js"></script>
	<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
	<script type="text/javascript" src="/static/js/global.js"></script>
<style type="text/css">                                                        
        .hr_red{                                                               
                background-color:red;                                          
                width:6px;                                                     
        }       
</style>        
</head> 

<body style="margin:0px;padding:20px;">
<div id="position"><b><{$lang->menu->class->payAndSpand}>:<{$lang->menu->singlePlayePay}></b></div>
<div class='divOperation'>	
    <form name="myform" id="myform" method="post" action="<{$URL_SELF}>">
	&nbsp;<{$lang->page->beginTime}>：<input type='text' name='dateStart' id='startDay' size='12' value='<{$dateStart}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
	&nbsp;&nbsp;<{$lang->page->endTime}>：<input type='text' name='dateEnd' id='endDay' size='12' value='<{$dateEnd}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
	&nbsp;&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role_name" size="15" value="<{$roleName}>" />
        &nbsp;&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="account_name" size="15" value="<{$accountName}>"  />
        &nbsp;&nbsp;
	<input type="image" name='search' align="absmiddle" src="/static/images/search.gif" class="input2"  />
	</form>
</div>
<br />
&nbsp;<{$lang->pay->singlePlayePay}>
<{if $data}>
<div>
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:760px;">
		<tr>      
			<th width="5%"><{$lang->page->accountName}></th>
			<th width="8%"><{$lang->page->roleName }></th>                       
            <th width="8%"><{$lang->page->pf}></th>
			<th width="8%"><{$lang->page->singlePlayeTotal}></th>                       
		</tr>
	<{foreach from=$data item=totalv key=key}>
		<tr align="center">                      
			<td><{$totalv.account_name}></td>
			<td><{$totalv.role_name}></td>                      
            <td><{$totalv.pf}></td>
			<td><{$totalv.total_pay}></td>                                                          
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
