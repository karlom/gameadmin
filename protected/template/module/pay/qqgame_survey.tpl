<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">                                    
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />          
<title><{$lang->menu->qqgameSurvey}></title>
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
<div id="position"><b><{$lang->menu->class->payAndSpand}>:<{$lang->menu->qqgameSurvey}></b></div>
<div class='divOperation'>
<form name="myform" method="post" action="<{$URL_SELF}>">

&nbsp;<{$lang->page->beginTime}>：<input type='text' name='dateStart' id='startDay' size='12' value='<{$dateStart}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />

&nbsp;&nbsp;<{$lang->page->endTime}>：<input type='text' name='dateEnd' id='endDay' size='12' value='<{$dateEnd}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />

&nbsp;&nbsp;

<input type="image" name='search' align="absmiddle" src="/static/images/search.gif" class="input2"  />

&nbsp;&nbsp;&nbsp;&nbsp
<input type="button" class="button" name="datePrev" value="<{$lang->page->today}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrToday}>&dateEnd=<{$dateStrToday}>';">
&nbsp;&nbsp
<input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrPrev}>&dateEnd=<{$dateStrPrev}>';">
&nbsp;&nbsp
<input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrNext}>&dateEnd=<{$dateStrNext}>';">
&nbsp;&nbsp
<input type="button" class="button" name="dateAll" value="<{$lang->page->allTime}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=ALL&dateEnd=ALL';">
　　
</form>

</div>
<br />
<div>
	<table height="" cellspacing="0" border="0" class="DataGrid">
		<tr>
			<td width="25%"><{$lang->page->proxy}>：<{$agent}></td>
			<td width="25%"><{$lang->page->proxyId}>：<{$agentId}></td>
			<td width="25%"><{$lang->page->areaName}>：<{$areaName}></td>
			<td ></td>
		</tr>
		<tr>
			<td width="25%"><{$lang->page->serverOnlineDate}>：<{$serverOnlineDay}></td>
			<td width="25%"><{$lang->page->havedOnlineDate}>：<{$hasOnlineDay}></td>
			<td colspan="2"><{$lang->page->curProgrammeVer}>：<{$version}></td>
		</tr>
		<tr>
			<td width="25%"><{$lang->page->totalRegisterAccount}>：<{$totalAccount}></td>
			<td width="25%"><{$lang->page->totalCreateRole}>：<{$totalRole}></td>
			<td colspan="2"><{$lang->page->roleMaxLevel}>:<a style="color:#F40"><{$roleMaxLevel}></a> <{$maxLevelRoleNames}></td>
		</tr>
		<tr>
			<td width="25%"><{$lang->page->arup}>：<{$allArpu}></td>
			<td width="25%"><{$lang->page->payRoleCount}>：<{ $payAccountCnt }></td>
			<td width="25%"><{$lang->page->payRate}>：<{$allPayRate}>%</td>
			<td colspan="1"></td>
		</tr>
		<tr>
			<td width="25%"><{$lang->page->totalConsumeMoney}>：<{ $allPayCount }></td>
			<td width="25%"><{$lang->page->secPayCount}>：<{ $allSecondPayCount }></td>
			<td width="25%"><{$lang->page->secPayRate}>：<{ $allSecondPayRate }>%</td>
			<td></td>
		</tr>
		
		<tr>
			<td width="25%"><{$lang->page->xsCostCount}>：<{$allXsCostCount}></td>
			<td width="25%"><{$lang->page->dayPayMore}>：<{ $allMaxPay.allMaxPay }> , <{ $allMaxPay.allMaxPayDate }></td>
			<td width="25%"><{$lang->page->dayMaxOnline}>：<{ $allMaxOnline.allMaxOnline }> , <{ $allMaxOnline.allMaxOnlineDate }></td>
			<td colspan="2">&nbsp;</td>
		</tr>
		
	</table>
	
	<br />
	<{$lang->menu->qqgameSurvey}>: &nbsp;
	<table height="" cellspacing="0" border="0" class="DataGrid">
		<tr>
			<td width="25%"><{$lang->active->activePlayer}>：<{$viewData.loginCount}></td>
			<td width="25%"><{$lang->page->creatRoleCount}>：<{$viewData.createRoleCount}></td>
			<td width="25%"><{$lang->page->consumeMoney}>：<{ if $viewData.totalCost}><{$viewData.totalCost}><{else }>0<{/if}></td>
			<td ></td>
		</tr>
		
		<tr>
			<td width="25%"><{$lang->page->arup}>：<{$viewData.arup}></td>
			<td width="25%"><{$lang->page->payRoleCount}>：<{$viewData.payRoleCount}></td>
			<td width="25%"><{$lang->page->payRate}>：<{$viewData.payRate}>%</td>
			<td colspan="1"></td>
		</tr>
		
		<tr>
			<td width="25%">起始日注册数：<{$viewData.registerCount}></td>
			<td width="25%">次日登录数：<{$viewData.secLoginCount}></td>
			<td width="25%">次日留存：<{$viewData.secStayRate}>%</td>
			<td></td>
		</tr>
		
		
	</table>
	
</div>
<br />

<div>&nbsp;&nbsp;<{$lang->player->onlineUserCount}>: <font color="red"><{$currentOnline.online}></font>, &nbsp;<{$lang->player->onlinePayUserCount}>: <font color="red"><{$payUserOnline}></font></div>


</body>
</html>
