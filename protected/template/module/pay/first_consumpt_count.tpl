<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">                                    
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />          
<title><{$lang->menu->firstConsumptCount}></title>
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
<div id="position"><b><{$lang->menu->class->payAndSpand}>:<{$lang->menu->firstConsumptCount}></b></div>
<div class='divOperation'>
	<form name="myform" method="post" action="<{$URL_SELF}>">
	<{*
	&nbsp;<{$lang->page->beginTime}>：<input type='text' name='dateStart' id='startDay' size='12' value='<{$dateStart}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
	
	&nbsp;&nbsp;<{$lang->page->endTime}>：<input type='text' name='dateEnd' id='endDay' size='12' value='<{$dateEnd}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
	*}>
	
	&nbsp;<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="dateStart" id="dateStart" onfocus="WdatePicker({el:'dateStart',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'dateEnd\')}'})" value="<{$dateStart}>">
	
	&nbsp;&nbsp;<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="dateEnd" id="dateEnd" onfocus="WdatePicker({el:'dateEnd',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'dateStart\')}',maxDate:'<{$maxDate}>'})"  value="<{$dateEnd}>">
	
	
	&nbsp;&nbsp;
	
	<input type="image" name='search' align="absmiddle" src="/static/images/search.gif" class="input2"  />
	　
	</form>
</div>

<br />

<{$lang->pay->allServerPay}>
<{if $viewData}>
<div>
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:960px;">
		<tr>
			<th width="20%"><{$lang->page->date}></th>
			<th width="20%"><{$lang->page->firstConsume1 }></th>
			<th width="20%"><{$lang->page->firstConsume2 }></th>
		</tr>
	<{foreach from=$viewData item=day key=key}>
		<tr align="center">
			<td><{$day.date}></td>
			<td><{$day.consumpt1}></td>
			<td><{$day.consumpt2}></td>
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
