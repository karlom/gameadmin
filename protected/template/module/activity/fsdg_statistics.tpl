<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->fengshidigong}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
        <script type="text/javascript" src="/static/js/jquery.min.js"></script>
        <style>
.table {
	border-color:SkyBlue;
	border-width:1px;
	border-style:solid;
	width:400px;
}
table.SumDataGrid
{
    background:white;
	border:SkyBlue solid 1px;
	border-collapse:collapse;
    
}

table.SumDataGrid th, table.SumDataGrid td
{
 	border:SkyBlue solid 1px;
	border-collapse:collapse;
}

table.SumDataGrid th
{
  background: #EBF9FC;
  text-align: center;
}

table.SumDataGrid tr.odd
{
  background: #E0F3F3;
}
</style>
		<script type="text/javascript">
			
			isShow = 0;
			showDay = "";
			
			function showTeamMember(day){
				var aid = "#"+"team-"+day;
				var rid = "#"+"teamList-"+day; 
			
				if( $(rid).length <= 0 ) {
					var rid = "#no_data";
				}
				
				if( isShow == 0 ){
										
					$(rid).show();
					
					isShow = 1;
					showDay = day;
					var offsetDayRank = $(aid).offset();
					$(rid).css("top",offsetDayRank.top+20).css("left",offsetDayRank.left);
				} else {
					if( showDay == day ) {
						$(rid).hide();
						isShow = 0;
					} else {
						$("div.rank").hide();
						$(rid).show();
						isShow = 1;
						showDay = day;
						var offsetDayRank = $(aid).offset();
						$(rid).css("top",offsetDayRank.top+20).css("left",offsetDayRank.left);
					}
				}
			}
			
			function hideRank() {
				$("div.rank").hide();
				$("div.score").hide();
				dayRankShow = 0;
			}
		
		</script>
		
	</head>
	<body>
		<div id="position">
			<b><{$lang->menu->class->activityManage}>：<{$lang->menu->fengshidigong}><{$lang->menu->dataStatistics}></b>
		</div>
		
		<div><{$lang->page->serverOnlineDate}>: <{$minDate}> &nbsp; <{$lang->page->today}>: <{$maxDate}></div>
		<br />
    <div><h3>每日捐献数据：</h3></div>
	<br />
	<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
		<td>&nbsp;<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="beginDay" id="beginDay" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" value="<{$beginDay}>"></td>
        <td>&nbsp;<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="overDay" id="overDay" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" value="<{$overDay}>"></td>
		<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
	</form>

	<br />
    		<table class="DataGrid" style="width:500px">
			<tr align="center">
                <th>日期</th>
				<th>捐献人数</th>
			</tr>
				
		<{if $res}>
			<{foreach from=$res item=day name=day_data key=key}>
				<tr align="center">
					<td><{$day.mtime}></td>
					<td><{$day.personCount}></td> 
				</tr>
			<{/foreach}>
		<{else}>		
			<tr><td colspan="5"><{$lang->page->noData}></td></tr>
		<{/if}>
		</table>
<div id="no_data" class="rank"><{$lang->page->noData}></div>
<br /><br />
<div><h3>捐献百分比：</h3></div>
<br />
<div>
  <div class='divOperation'>
<form id="myform" name="myform" method="post" action="" style="display: inline;">
&nbsp;<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="start_day" id="start_day" onfocus="WdatePicker({el:'start_day',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'end_day\')}'})" value="<{ $startTime }>">
&nbsp;<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="end_day" id="end_day" onfocus="WdatePicker({el:'end_day',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'start_day\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endTime }>">
&nbsp;
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" name="search"  />
&nbsp;&nbsp;
</form>
</div>
<br />
所有代理：<span style="text-align:center;"> <img src="/static/images/red.gif" width="10" height="5"/> 较好 <img src="/static/images/green.gif" width="10" height="5"/> 较差&nbsp;</span>
  <table class="SumDataGrid">
	<tr>
		<th height="150" width="10">捐献比例</th>
		<{foreach from=$result item=item key=key }>
				<td align="center" style="background-color:#FFF;" valign="bottom" title="<{$item.alert}>"><div style="width:40px;"><{$item.bfbRate}>%</div><img src="/static/images/<{$item.img_name}>.gif" width="10" height="<{$item.height}>"/></td>
        <{/foreach}>
	</tr>
	<tr align="center"><th width="10">次数</th>
		<{foreach from=$arr key=key item=item}>
		<td  style="table-layout: fixed;WORD-BREAK: break-all; WORD-WRAP: break-word; background-color:#C0C0C0; width:50px"><{$key}>次</td>
		<{/foreach}>
	</tr>
</table>
</div>
<br /><br />

<div><h3>地宫参与度数据：</h3></div>	
		<br />
		<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
			<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="startDay" id="startDay" onfocus="WdatePicker({el:'startDay',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDay\')}'})" value="<{$startDay}>"></td>
			<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="endDay" id="endDay" onfocus="WdatePicker({el:'endDay',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDay\')}',maxDate:'<{$maxDate}>'})" value="<{$endDay}>"></td>
			<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
		</form>
		<br />

		<table class="DataGrid" style="width:500px">
			<tr align="center">
                <th>日期</th>
				<th>可参与人数</th>
				<th>参与人数</th>
				<th>参与度</th>
			</tr>
				
		<{if $viewData}>
			<{foreach from=$viewData item=day name=day_data key=key}>
				<tr align="center">
					<td><{$day.mdate}></td>
					<td><{$day.act_count}></td>
					<td><{$day.join_count}></td>
					<td><{$day.joinRate}>%</td>
				</tr>
			<{/foreach}>
		<{else}>		
			<tr><td colspan="5"><{$lang->page->noData}></td></tr>
		<{/if}>
		</table>
<div id="no_data" class="rank"><{$lang->page->noData}></div>
	</body>
</html>