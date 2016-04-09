<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>

<title><{$lang->menu->activeLoyaltyUser}></title>
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

        function changePage(page){
                $("#page").val(page);
                $("#myform").submit();
        }
</script>

</head>

<body>
<div id="position">
<b><{$lang->menu->class->baseData}>：<{$lang->menu->activeLoyaltyUser}></b>
</div>

<div class='divOperation'>
<form name="myform" id="myform" method="post">
	<table>
		<tr>
			<td>
    		<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' />
    		<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /></br>
			</td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2"  />&nbsp;</td>
			<td>
    <input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateStrToday}>','');">&nbsp;&nbsp;
    <input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="changeDate('<{$dateStrPrev}>','');">&nbsp;&nbsp;
    <input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="changeDate('<{$dateStrNext}>','');">&nbsp;&nbsp;
    <input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$dateOnline}>','<{$dateStrToday}>');">	
			</td>
		</tr>
	</table>
</div>
<div style='margin:5px 0px 5px 1px; padding:2px; border: 2px solid #CCC000;'>
	<b><{$lang->active->activer}></b>：<{$lang->active->activeLogin}>
	<br/>
	<b><{$lang->active->loyal}></b>：<{$lang->active->loyalLogin}>
	<br/>
	<b><{$lang->active->avgOnline}></b>：<{$lang->active->avgData}>
</div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
    <tr>
        <td height="30" class="even">
            <{foreach key=key item=item from=$pageList}>
                <a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>');"><{$key}></a><span style="width:5px;"></span>
            <{/foreach}>
            <{$lang->page->record}>(<{$recordCount}>)&nbsp;&nbsp;&nbsp;<{$lang->page->totalPage}>(<{if $pageCount}><{$pageCount}><{else}>1<{/if}>)
            <{$lang->page->everyPage}>
            <input type="text" id="pageLine" name="pageLine" size="4" style="text-align:center;" value="<{$pageLine}>">
            <{$lang->page->row}>
            <{$lang->page->dang}>
            <input id="page" name="page" type="text" class="text" size="3" style="text-align:center;" maxlength="6" value="<{$page}>">
            <{$lang->page->page}>&nbsp;
            <input type="submit" class="button" name="Submit" value="GO">&nbsp;
        </td>
    </tr>
</table>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
	<tr class='table_list_head'>
		<td><{$lang->page->date}></td>
		<td><{$lang->active->activePlayer}></td>
		<td><{$lang->active->loyalPlayer}></td>
		<td><{$lang->active->maxOnline}></td>
		<td><{$lang->active->avgOnline}></td>
		<td><{$lang->active->newRegister}></td>
		<td><{$lang->active->allRegister}></td>
	</tr>
	<{foreach from=$result item=item key=key}>
			<tr class="<{cycle values='trOdd,trEven'}>">
				<td><{$item.date}></td>
				<td><{$item.active}></td>
				<td><{$item.loyal}></td>
				<td><{$item.max_online}></td>
				<td><{$item.avg_online}></td>
				<td><{$item.new_user}></td>
				<td><{$item.total_user}></td>
			</tr>
	<{/foreach}>
</table>

<br/>
</form>
</div>


<div class="tScroll frm" id="all">
<table height="167" cellspacing="1" cellpadding="1" border="0" bgcolor="#CCCCCC" class="paystat">

<!-- 活跃用户 -->
<tr>
	<td width="18" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->active->activer}></b></td>
	<{foreach key=key item=item from=$result}>
		<td width="18" bgcolor="#FFFFFF" align="center" valign="bottom">
			<table width="23" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" valign="bottom" style="text-align:center" title="<{$lang->active->mdate}>：<{$item.date}>   <{$lang->active->activePlayer}>：<{$item.active}>">
					<div><{$item.active}></div>
					<img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="<{if $max.active == 0}>0<{else}><{$item.active/$max.active}><{/if}>"/>
					</td>
				</tr>
			</table>
		</td>
	<{/foreach}>
</tr>

<!-- 忠诚用户 -->
<tr>
	<td width="18" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->active->loyal}></b></td>
	<{foreach key=key item=item from=$result}>
	<td width="18" bgcolor="#FFFFFF" align="center" valign="bottom">
		<table width="18" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="bottom" style="text-align:center" title="<{$lang->active->mdate}>：<{$item.date}>  <{$lang->active->loyal}>：<{$item.loyal}>">
				<div><{$item.loyal}></div>
				<img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="<{if $max.loyal == 0}>0<{else}><{$item.loyal/$max.loyal}><{/if}>"/>
				</td>
			</tr>
		</table>
	</td>
	<{/foreach}>
</tr>

<!-- 最大在线 -->
<tr>
	<td width="18" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->active->maxOnline}></b></td>
	<{foreach key=key item=item from=$result}>
		<td width="18" bgcolor="#FFFFFF" align="center" valign="bottom">
			<table width="18" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" valign="bottom" style="text-align:center" title="<{$lang->active->mdate}>：<{$item.date}> <{$lang->active->maxOnline}>：<{$item.max_online}>">
					<div><{$item.max_online}></div>
					<img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="<{if $max.max_online ==0}>0<{else}><{$item.max_online/$max.max_online}><{/if}>"/>
					</td>
				</tr>
			</table>
		</td>
	<{/foreach}>
</tr>

<!-- 平均在线 -->
<tr>
	<td width="18" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->active->avgOnline}></b></td>
	<{foreach key=key item=item from=$result}>
		<td width="18" bgcolor="#FFFFFF" align="center" valign="bottom">
			<table width="18" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" valign="bottom" style="text-align:center" title="<{$lang->active->mdate}>：<{$item.date}> <{$lang->active->avgOnline}>：<{$item.avg_online}>">
					<div><{$item.avg_online}></div>
					<img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="<{if $max.avg_online ==0}>0<{else}><{$item.avg_online/$max.avg_online}><{/if}>"  />
					</td>
				</tr>
			</table>
		</td>
	<{/foreach}>
</tr>

<!-- 新注册 -->
<tr>
	<td width="18" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->active->register}></b></td>
	<{foreach key=key item=item from=$result}>
		<td width="18" bgcolor="#FFFFFF" align="center" valign="bottom">
			<table width="18" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" valign="bottom" style="text-align:center" title="<{$lang->active->mdate}>：<{$item.date}> <{$lang->active->maxOnline}>：<{$item.new_user}>">
					<div><{$item.new_user}></div>
					<img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="<{if $max.new_user ==0}>0<{else}><{$item.new_user/$max.new_user}><{/if}>"/>
					</td>
				</tr>
			</table>
		</td>
	<{/foreach}>
</tr>

<!-- 总共注册 -->
<tr>
	<td width="18" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->active->totalRegister}></b></td>
	<{foreach key=key item=item from=$result}>
	    	<td width="18" bgcolor="#FFFFFF" align="center" valign="bottom">
		      <table width="18" border="0" cellpadding="0" cellspacing="0">
				<tr>
					  <td align="center" valign="bottom" style="text-align:center" title="<{$lang->active->mdate}>：<{$item.date}> <{$lang->active->maxOnline}>：<{$item.total_user}>">
					  <div><{$item.total_user}></div>
					  <img src="/static/images/<{if $data_one.red}>red<{else}>green<{/if}>.gif" width="10" height="<{if $max.total_user ==0}>0<{else}><{$item.total_user/$max.total_user}><{/if}>"/>
					  </td>
				</tr>
		      </table>
		</td>
	<{/foreach}>
</tr>
  
<!-- 日期 -->
<tr>
	<td width="18" height="30" align="center" bgcolor="#EBF9FC"><b><{$lang->active->mdate}></b></td>
	<{foreach key=data item=item from=$result}>
		<{if $item.weekend==0}>
			<td height="30" bgcolor="#DD2020" align="center"><{$item.date}><br><{$lang->active->sunDay}><br><{$lang->active->opendServer}><{$item.server}><{$lang->active->day}></td>
		<{else}>
			<td height="30" bgcolor="#C0C0C0" align="center"><{$item.date}><br><{$lang->active->opendServer}><{$item.server}><{$lang->active->day}></td>
		<{/if}>
	<{/foreach}>
</tr>

</table>

<span style="text-align:center; margin-left:25px;">
	<{$lang->active->redDisplay}>
</span>
</div>

</body>
</html>
