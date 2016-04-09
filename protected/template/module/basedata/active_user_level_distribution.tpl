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
<b><{$lang->menu->class->baseData}>：<{$lang->menu->activeUserLevel}></b>
</div>

<form name="myform" id="myform" method="post">
        <table style="margin:5px;">
                <tr>    
                    <td><{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /></td>
                    <td><{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /></td>
                    <td><input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  />&nbsp;</td>
                    <td>
    <input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$today}>','');">&nbsp;&nbsp;
    <input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="changeDate('<{$prev}>','');">&nbsp;&nbsp;
    <input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="changeDate('<{$next}>','');">&nbsp;&nbsp;
    <input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$Online}>','<{$today}>');">
                    </td>
                </tr>   
        </table>    
</form>     

<{if $rs}>
<div>
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
		<tr class='table_list_head'>
			<td><{$lang->page->date}></td>
			<td><{$lang->active->activePlayer}></td>
		</tr>
		<{foreach from=$rs item=item key=key}>
				<tr class="<{cycle values='trOdd,trEven'}>">
					<td><{$item.date}></td>
					<td><{$item.total}></td>
				</tr>
		<{/foreach}>
	</table>
</div>
<{else}>
	<p style='color:#ff0000'><{$lang->active->noData}></p>
<{/if}>

<{foreach key=key from=$data item=daily}>
&nbsp;&nbsp;
<div class="tScroll frm" id="all" >
<table height="167" cellspacing="1" cellpadding="1" border="0" bgcolor="#CCCCCC" class="paystat">

<tr>
	<td width="70" height="120" align="center" bgcolor="#EBF9FC"><b><{$key}><br/><{$lang->active->activeNum}></b></td>
	<{foreach item=level from=$daily}>
    	<td width="23" bgcolor="#FFFFFF" align="center" valign="bottom">
      	<table width="23" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="center" valign="bottom" style="text-align:center" title="<{$lang->active->mdate}>：<{$item.date}>  <{$lang->active->total}>：<{$item.crid}>">
			<div><{$level.crid}></div>
		    	<img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="<{if $max.cid == 0}>0jjk<{else}><{$level.cid/$max.cid}><{/if}>px"/>           
		  </td>
		</tr>
      	</table>
	</td>
    	<{/foreach}>
</tr>

<tr>
	<td width="22" height="50px" align="center" bgcolor="#EBF9FC"><b><{$lang->active->level}></b></td>
	<{foreach item=level from=$daily}>
	<td width="22" bgcolor="#FFFFFF">
	<{$level.label}>
	</td>
	<{/foreach}>
</tr>

<tr>
</tr>
</table>

<{/foreach}>
<script>
	$('#prev').click(function(){
		window.location = 'active_user_level_distribution.php?start=<{$prev}>&end=<{$prev}>';		
	});
	
	$('#succ').click(function(){
		window.location = 'active_user_level_distribution.php?start=<{$succ}>&end=<{$succ}>';
	});

</script>
</body>
</html>
