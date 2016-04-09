<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">                                    
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />          
<title><{$lang->menu->saleDay}></title>
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
<div id="position"><b><{$lang->menu->class->payAndSpand}>:<{$lang->menu->saleDay}></b></div>
<div class='divOperation'>	
    <form name="myform" id="myform" method="post" action="<{$URL_SELF}>">
	&nbsp;<{$lang->page->beginTime}>：<input type='text' name='dateStart' id='startDay' size='12' value='<{$dateStart}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
	&nbsp;&nbsp;<{$lang->page->endTime}>：<input type='text' name='dateEnd' id='endDay' size='12' value='<{$dateEnd}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
        &nbsp;&nbsp;
	<input type="image" name='search' align="absmiddle" src="/static/images/search.gif" class="input2"  />
	</form>
</div>
<br />
&nbsp;<{$lang->pay->saleDay}>
<{if $viewData}>
<div>
    <{foreach from=$viewData item=totalv key=key}>
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:760px;">
        <tr>      
            <th colspan="3"><{$key}></th>                 
		</tr>
		<tr>      
			<th width="8%">道具ID</th>                       
            <th width="8%">道具名称</th>
			<th width="8%">购买人数</th>                       
		</tr>
        <{foreach from=$totalv item=date key=key}>
		<tr align="center">                      
			<td><{$date.item_id}></td>                      
            <td><{$date.item_name}></td>
			<td><{$date.total_person}></td>                                                          
		</tr>
        <{/foreach}>
	</table>	
       <br />
       <{/foreach}>  
</div>
<{else}>
<div class="red"><{$lang->page->noData}></div>
<{/if}>
<br />

</body>
</html>
