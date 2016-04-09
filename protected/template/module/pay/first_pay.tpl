<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script language="javascript">
        $(document).ready(function(){
                $("#showType").change(function(){
                        $("#myform").submit();
                });
                $("#viewType").change(function(){
                        $("#myform").submit();
                });
        });
        function changeDate(dateStr,dateEnd){
                if(dateEnd==''){
                        $("#dateStart").val(dateStr);
                        $("#dateEnd").val(dateStr);
                }else{
                        $("#dateStart").val(dateStr);
                        $("#dateEnd").val(dateEnd);
                }
                $("#myform").submit();
        }
</script>
</head>

<body>
<div id="position"><{$lang->menu->class->payAndSpand}>：<{$lang->page->firstPayStat}></div>
	<form action="#" method="POST" id="myform">
	<table style="margin:5px;">
		<tr>
            <td><{$lang->page->beginTime}>:<input id='dateStart' name='dateStart' type="text" class="Wdate" onfocus="WdatePicker({el:'dateStart',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'dateEnd\')}'})" size='12' value='<{$dateStart}>' /></td>
            <td><{$lang->page->endTime}>:<input id='dateEnd' name='dateEnd' type="text" class="Wdate" onfocus="WdatePicker({el:'dateEnd',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'dateStart\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$dateEnd}>' /></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  /></td>
            <td>
                <input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateToday}>','');">
                <input type="button" class="button" name="datePrev" value="<{$lang->page->preday}>" onclick="changeDate('<{$datePrev}>','');">
                <input type="button" class="button" name="dateNext" value="<{$lang->page->afterday}>" onclick="changeDate('<{$dateNext}>','');">
                <input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$onlineDay }>','<{$dateToday}>');">
            </td>
		</tr>
	</table>
	</form>
	<div><{$lang->page->everyFirstPay}>：
	<{ if $resultFirstByDate }>
		<div><{$dateStart}> <{$lang->page->to}> <{$dateEnd}>，<{$lang->page->firstPayCount}>：￥<{$allMoney}> ，<{$lang->page->allPeople}>：<{$allPerson}> ；<{$lang->page->dayFirstMaxPay}>：￥<{$maxMoneyByDate}> ，<{$lang->page->dayFirstAvgPay}>：￥<{$avgMoneyByDate}> ；<{$lang->page->dayFirstMaxPayer}>：<{$maxPersonByDate}></div>
		<table class="SumDataGrid" cellspacing="0" style="margin:5px;">
			<tr>
				<th><div style="width:60px;text-align:center;clear:both; margin: 0px auto;"><{$lang->page->payCount}></div></th>
				<{ foreach from=$resultFirstByDate item=row }>
					<td align="center" height="120" valign="bottom">
					<{ $row.total_money }><hr class="<{if $row.total_money/$maxMoneyByDate > 0.75 }>hr_red<{else}>hr_green<{/if}>" title="￥<{$row.total_money}>" style="height:<{ $row.total_money*120/$maxMoneyByDate|round }>px;" />
					</td>
				<{ /foreach}>
			</tr>
			<tr>
				<th><{$lang->page->pepole}></th>
				<{ foreach from=$resultFirstByDate item=row }>
					<td align="center" height="120" valign="bottom">
					<{ $row.person }><hr class="<{if  $row.person/$maxPersonByDate > 0.75 }>hr_red<{else}>hr_green<{/if}>" title="<{$row.person}>人"  style="height:<{ $row.person*120/$maxPersonByDate|round }>px;" />
					</td>
				<{ /foreach}>
			</tr>
			<tr>
				<th><{$lang->page->date}></th>
				<{ foreach from=$resultFirstByDate item=row }>
					<th align="center" style="font-size:10px;"><{ if 0 == $row.date|date_format:"%w" }>
                    <font color="red"><{ $row.date|date_format:"%m.%d" }><br><{$lang->page->sunday}></font><{ else }><{ $row.date|date_format:"%m.%d" }><{ /if }></th>
				<{ /foreach }>
			</tr>
			<tr>
				<th><{$lang->page->onlineDays}></th>
				<{ foreach from=$resultFirstByDate item=row }>
					<th align="center"><b><{ $row.index }></b></th>
				<{ /foreach }>
			</tr>
		</table>
	<{ else }>
		<{$lang->sys->withoutData}>
	<{ /if }>
	</div>
	<br>
	<div><{$lang->page->dayFirstLevelSituation}>：
	<{ if $rsLevel }>

		<table class="SumDataGrid" cellspacing="0" style="margin:5px;">
			<tr>
				<th width="100"><{$lang->page->percentage}></th>
				<{ foreach from=$rsLevel item=row }>
					<td align="center" height="120" valign="bottom"><{ $row.rate }>%<hr class="<{if $row.rate > 75 }>hr_red<{else}>hr_green<{/if}>"  style="height:<{ $row.rate*2|round }>px;" /></td>
				<{ /foreach}>
			</tr>
			<tr>
				<th width="100"><{$lang->page->showType3}></th>
				<{ foreach from=$rsLevel item=row }>
					<td align="center" height="120" valign="bottom"><{ $row.cnt }><hr class="<{if $row.rate > 75 }>hr_red<{else}>hr_green<{/if}>"  style="height:<{ $row.rate*2|round }>px;" /></td>
				<{ /foreach}>
			</tr>
			<tr>
				<th width="100"><{$lang->page->level}></th>
				<{ foreach from=$rsLevel item=row }>
					<th align="center"><{ $row.role_level }></th>
				<{ /foreach }>
			</tr>
		</table>
	<{ else }>
		<{$lang->page->withoutData}>
	<{ /if }>
	</div>
</body>
</html>




