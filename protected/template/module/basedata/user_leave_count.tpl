<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<style>
	td {text-align:center;}
</style>
<script type="text/javascript" >
                function changeDate(dateStr,dateEnd){
                        if(dateEnd==''){
                                $("#starttime").val(dateStr);
                                $("#endtime").val(dateStr);
                        }else{
                                $("#starttime").val(dateStr);
                                $("#endtime").val(dateEnd);
                        }
                        $("#myform").submit();
                }
</script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->baseData}>：<{$lang->menu->dayWeekUserLoginCount}></b>
</div>

<div class='divOperation'>
<form name="myform" id="myform" method="post">
        <table>
                <tr>
                        <td>
                <{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' />
                <{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /></br>
                        </td>
                        <td>&nbsp;<input type="image" name='search' src="/static/images/search.gif" class="input2"  />&nbsp;</td>
                        <td>
    <input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateStrToday}>','');">&nbsp;&nbsp;
    <input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="changeDate('<{$dateStrPrev}>','');">&nbsp;&nbsp;
    <input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="changeDate('<{$dateStrNext}>','');">&nbsp;&nbsp;
    <input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$dateOnline}>','<{$dateStrToday}>');">  
  
                        </td>
                </tr>
        </table>
</form>
</div>

<br/>
<{$lang->login->dayUserLogin}><br/>
<{$lang->login->dayHistoryUserLogin}><br/>
<div class="tScroll">
<table height="167" cellspacing="1" cellpadding="1" border="0" bgcolor="#CCCCCC" class="paystat">

<tr>
    <td width="50" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->login->dayUser}></b></td>
    <{foreach  item=item from=$ary}>
    <td width="50" bgcolor="#FFFFFF" align="center" valign="bottom">
      <table width="50" border="0" cellpadding="0" cellspacing="0">
        <tr>
		  <td align="center" valign="bottom" style="text-align:center" title="<{$lang->login->date2}>：<{$item.datestr}>  <{$lang->login->userLogin}>：<{$data_one.count}>">
		  <div><{$item.onlineNum}></div>
		  <img src="/static/images/green.gif" width="10" height="<{$item.onlineNum*$maxOnline}>"  />
		 </td>
        </tr>
      </table>
    </td>
    <{/foreach}>
</tr>

<tr>
    <td width="50" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->login->userPayLogin}></b></td>
    <{foreach item=item from=$ary}>
    <td width="50" bgcolor="#FFFFFF" align="center" valign="bottom">
      <table width="50" border="0" cellpadding="0" cellspacing="0">
          <tr>
	  	  <td align="center" valign="bottom" style="text-align:center"
	  		title="<{$lang->login->date2}>：<{$item.datestr}>  <{$lang->login->userPayLogin}>：<{$item.onlinePaid}>">
	  		<div><{$item.onlinePaid}></div>
	  	  <img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="<{$item.onlinePaid*$maxPaid}>"  />
	  	  </td>
          </tr>
      </table></td>
    <{/foreach}>
</tr>

<tr>

<tr>
<td width="50" align="center" bgcolor="#EBF9FC"><b><{$lang->login->date2}></b></td>
    <{foreach key=data_day item=item from=$ary}>
    <{if $item.weekend ==0 }>
    	<td height="50" bgcolor="#DD2020" align="center"><{$item.datestr}> <br/><{$lang->login->open}><{$item.serverOnlineDays}></><{$lang->login->day}><br><{$lang->login->sunday2}></td>
    <{else}>
    <td height="50" bgcolor="#C0C0C0" align="center"><{$item.datestr}>  <br/><{$lang->login->open}><{$item.serverOnlineDays}></><{$lang->login->day}><br></td>
    <{/if}>
    <{/foreach}>
  </tr>
<tr>

</table>
<span style="text-align:center; margin-left:25px;">
	<{$lang->login->dateColumn}>
</span>
<BR><BR>

<{$lang->login->weekLoginUserNum}><br/>
<{$lang->login->payUserLoginNum}><br/>

<table height="167" cellspacing="1" cellpadding="1" border="0" bgcolor="#CCCCCC" class="paystat">
<tr>
<td width="50" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->login->weekUserLogin}></b></td>
    <{foreach key=date_day item=item from=$aryWeek}>
    <td width="50" bgcolor="#FFFFFF" align="center" valign="bottom">
      <table width="50" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="bottom" style="text-align:center" title="<{$lang->login->rank}><{$data_week}><{$lang->login->week}>  <{$lang->login->userLogin}>：<{$data_one.count}>">
          	<div><{$item.onlineNum}></div>
                <img src="/static/images/green.gif" width="10" height="<{$item.onlineNum*$weekMaxOnline}>"  />
	  </td>
        </tr>
      </table></td>
    <{/foreach}>
  </tr>

<tr>
<td width="50" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->login->weekPayUserLogin}></b></td>
    <{foreach key=data_week item=item from=$aryWeek}>
    <td width="50" bgcolor="#FFFFFF" align="center" valign="bottom">
      <table width="50" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="bottom" style="text-align:center" title="<{$lang->login->rank}><{$data_week}><{$lang->login->week}>  <{$lang->login->payUserLogin}>：<{$data_one.onlinePaid}>">
          	<div><{$item.onlinePaid}></div>
            	<img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="<{$item.onlinePaid*$weekMaxPaid}>" />
	  </td>
        </tr>
      </table></td>
    <{/foreach}>
  </tr>

<tr>

<tr>
<td width="50" align="center" bgcolor="#EBF9FC"><b><{$lang->login->cycle}></b></td>
    <{foreach key=key item=item from=$aryWeek}>
    <td width="50" bgcolor="#999999" align="center" valign="bottom">
    <{$item.startStr}><BR><{$item.endStr}> <BR>
    <{$item.weekNo}><{$lang->login->week}> 
	</td>
    <{/foreach}>
  </tr>
</table>
<span style="text-align:center; margin-left:25px;">
	<{$lang->login->weekColumn}>
</span>
<BR><BR>

</div>

</body>
</html>
