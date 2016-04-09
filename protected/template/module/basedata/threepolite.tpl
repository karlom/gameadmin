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

<title><{$lang->menu->threepolite}></title>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->baseData}>：<{$lang->menu->threepolite}></b>
</div>
<form name="myform" id="myform" method="post">
	<table style="margin:5px;">
		<tr>		
		    <td><{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd'})" size='12' value='<{$startDate}>' /></td>
		    <td><{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd'})" size='12' value='<{$endDate}>' /></td>
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
<table cellspacing="1" cellpadding="3" border="0" class='table_list'>
    <tr class='table_list_head'>
        <th><{$lang->threepolite->levelthan29}></th>
        <th><{$lang->threepolite->onedayget}></th>
        <th><{$lang->threepolite->twodayget}></th>
        <th><{$lang->threepolite->threedayget}></th>
    </tr>
   
<!-- 每日登录次数 -->
<tr>
        <td  align="center" valign="bottom"><{if $data.29}><{$data.29}><{else}>0<{/if}></td>
	<td  align="center" valign="bottom"><{if $data.1}><{$data.1}><{else}>0<{/if}></td>
	<td  align="center" valign="bottom"><{if $data.2}><{$data.2}><{else}>0<{/if}></td>
	<td  align="center" valign="bottom"><{if $data.3}><{$data.3}><{else}>0<{/if}></td>
</tr>

</table>
	
</body>
</html>
