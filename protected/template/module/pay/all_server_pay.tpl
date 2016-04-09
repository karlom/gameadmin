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
<div id="position"><b><{$lang->menu->class->payAndSpand}>:<{$lang->menu->allServerPayData}></b></div>
<div class='divOperation'>
	<form name="myform" method="post" action="<{$URL_SELF}>">
	
	&nbsp;<{$lang->page->beginTime}>：<input type='text' name='dateStart' id='startDay' size='12' value='<{$dateStart}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
	<{*
	&nbsp;&nbsp;<{$lang->page->endTime}>：<input type='text' name='dateEnd' id='endDay' size='12' value='<{$dateEnd}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
	*}>
	&nbsp;&nbsp;
	
	<input type="image" name='search' align="absmiddle" src="/static/images/search.gif" class="input2"  />
	
	<{*
	&nbsp;&nbsp;&nbsp;&nbsp
	<input type="button" class="button" name="datePrev" value="<{$lang->page->today}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrToday}>&dateEnd=<{$dateStrToday}>';">
	&nbsp;&nbsp
	<input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrPrev}>&dateEnd=<{$dateStrPrev}>';">
	&nbsp;&nbsp
	<input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrNext}>&dateEnd=<{$dateStrNext}>';">
	&nbsp;&nbsp
	<input type="button" class="button" name="dateAll" value="<{$lang->page->allTime}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=ALL&dateEnd=ALL';">
	　*}>
	</form>
</div>

<br />

<{$lang->pay->allServerPay}>
<{if $viewData}>
<div>
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:960px;">
		<tr>
			<th width="8%"><{$lang->page->areaName}></th>
			<th width="10%"><{$lang->page->totalPayMoney }></th>
			<th width="8%"><{$lang->pay->payRoleCount}></th>
			<th width="8%"><{$lang->pay->payCount}></th>
			<th width="10%"><{$lang->sys->registerUser}></th>
			<th width="8%"><{$lang->page->creatRoleCount }></th>
			<th width="8%"><{$lang->active->activePlayer }></th>
			<th width="8%"><{$lang->pay->fromTask }></th>
			<th width="8%"><{$lang->pay->taskPayUser }></th>
			<th width="8%"><{$lang->pay->taskPay }></th>
			<th width="8%"><{$lang->player->onlineUserCount}></th>
			<th width="8%"><{$lang->pay->qqGamePayUser }></th>
		</tr>
		<tr align="center">
			<td>--<{$lang->page->summary}>--</td>
			<td><{$totalData.totalPay}></td>
			<td><{$totalData.totalPayUserCount}></td>
			<td><{$totalData.totalPayCount}></td>
			<td><{$totalData.totalRequest}></td>
			<td><{$totalData.totalRegister}></td>
			<td><{$totalData.totalLogin}></td>
			<td><{$totalData.totalFromTaskCount}></td>
			<td><{$totalData.totalTaskPayUser}></td>
			<td><{$totalData.totalTaskPay}></td>
			<td><{$totalData.totalOnline}></td>
			<td><{$totalData.totalFromQQgame}></td>
		</tr>
	<{foreach from=$viewData item=serv key=key}>
		<tr align="center">
			<td><{$serv.server}></td>
			<td><{$serv.pay}></td>
			<td><{$serv.payUserCount}></td>
			<td><{$serv.payCount}></td>
			<td><{$serv.totalRequest}></td>
			<td><{$serv.totalRegister}></td>
			<td><{$serv.totalLogin}></td>
			<td><{$serv.contract}></td>
			<td><{$serv.taskPayUser}></td>
			<td><{$serv.taskPay}></td>
			<td><{$serv.online}></td>
			<td><{$serv.qqgame}></td>
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
