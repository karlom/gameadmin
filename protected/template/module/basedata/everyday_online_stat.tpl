<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
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

<title><{$lang->menu->everydayOnlineCount}></title>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->baseData}>：<{$lang->menu->everydayOnlineCount}></b>
</div>
<pre>
<{$lang->login->dayLossPayPlayer}>
<{$lang->login->dayPayPlayerLogin}>
<{$lang->login->dayLoginNums}>
<{$lang->login->dayLoginRoleNums}>
</pre>

<form name="myform" id="myform" method="post">
	<table style="margin:5px;">
		<tr>		
		    <td><{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /></td>
		    <td><{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /></td>
		    <td><input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  />&nbsp;</td>
                    <td>
    <input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateStrToday}>','');">&nbsp;&nbsp;
    <input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="changeDate('<{$dateStrPrev}>','');">&nbsp;&nbsp;
    <input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="changeDate('<{$dateStrNext}>','');">&nbsp;&nbsp;
    <input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$dateOnline}>','<{$dateStrToday}>');">
                    </td>
		</tr>
	</table>
</form>
<br/>
		
<table  cellspacing="1" cellpadding="1" border="0" bgcolor="#CCCCCC" >
<tr><td bgcolor="#FFFFFF">
</table>

<div class="tScroll frm" id="all" >
<table height="167" cellspacing="1" cellpadding="1" border="0" bgcolor="#CCCCCC" class="paystat">

<!-- 每日登录次数 -->
<tr>
	<td width="22" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->login->loginTimes}></b></td>
	<{foreach key=key item=item from=$data}>
	<td width="23" bgcolor="#FFFFFF" align="center" valign="bottom">
		<table width="23" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="bottom" style="text-align:center" title="<{$lang->login->date}>：<{$item.date}>  <{$lang->login->total}>：<{$item.cid}>">
				<div><{$item.cid}></div>
				<img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="<{if $max.cid == 0 }>0<{else}><{$item.cid/$max.cid}><{/if}>"/>
				</td>
			</tr>
		</table>
	</td>
	<{/foreach}>
</tr>

<!-- 每日登录角色数 -->
<tr>
	<td width="22" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->login->dayLoginRole}></b></td>
	<{foreach key=key item=item from=$data}>
	<td width="23" bgcolor="#FFFFFF" align="center" valign="bottom">
		<table width="23" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="bottom" style="text-align:center" title="<{$lang->login->date}>：<{$item.date}>  <{$lang->login->total}>：<{$item.crid}>">
				<div><{$item.crid}></div>
				<img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="<{if $max.crid == 0}>0<{else}><{$item.crid/$max.crid}><{/if}>"/>            
				</td>
			</tr>
		</table>
	</td>
	<{/foreach}>
	</tr>
<tr>
		
<!-- 每日登录IP -->
<td width="22" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->login->dayLoginIp}></b></td>
    <{foreach key=key item=item from=$data}>
    <td width="23" bgcolor="#FFFFFF" align="center" valign="bottom">
      <table width="23" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="bottom" style="text-align:center"
          	title="<{$lang->login->date}>：<{$item.date}>  <{$lang->login->total}>：<{$item.cip}>"
          	>
          	<div><{$item.cip}></div>
            <img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="
			<{if $max.cip == 0}>
	            0
            <{else}>
            	<{$item.cip/$max.cip}>
            <{/if}>
 	       "/>            
		  </td>
        </tr>
      </table></td>
    <{/foreach}>
  </tr>
<tr>
		
<!-- 每日流失付费用户数 -->
<td width="22" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->login->dayLossPayCount}></b></td>
    <{foreach key=key item=item from=$data}>
    <td width="23" bgcolor="#FFFFFF" align="center" valign="bottom">
      <table width="23" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="bottom" style="text-align:center"
          	title="<{$lang->login->date}>：<{$item.date}>  <{$lang->login->total}>：<{$item.loss}>"
          	>
          	<div><{$item.loss}></div>
            <img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="
			<{if $max.loss == 0}>
	            0
            <{else}>
            	<{$item.loss/$max.loss}>
            <{/if}>
 	       "/>            
		  </td>
        </tr>
      </table></td>
    <{/foreach}>
  </tr>
<tr>
		
<!-- 三日内付费用户登录数 -->
<td width="22" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->login->dayPayLoginCount}></b></td>
    <{foreach key=key item=item from=$data}>
    <td width="23" bgcolor="#FFFFFF" align="center" valign="bottom">
      <table width="23" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="bottom" style="text-align:center"
          	title="<{$lang->login->date}>：<{$item.date}>  <{$lang->login->total}>：<{$item.login}>"
          	>
          	<div><{$item.login}></div>
            <img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="
			<{if $max.login == 0}>
	            0
            <{else}>
            	<{$item.login/$max.login}>
            <{/if}>
 	       "/>            
		  </td>
        </tr>
      </table></td>
    <{/foreach}>
  </tr>
<tr>
		
<!-- 日期 -->
<tr>
	<td width="23" height="30" align="center" bgcolor="#EBF9FC"><b><{$lang->login->date}></b></td>
	<{foreach key=data item=item from=$data}>
		<{if $item.weekend==0 }>
			<td height="30" bgcolor="#DD2020" align="center"><{$item.date}><br><{$lang->login->sunday}></td>
		<{else}>
			<td height="30" bgcolor="#C0C0C0" align="center"><{$item.date}></td>
		<{/if}>
	<{/foreach}>
</tr>
	
</body>
</html>
