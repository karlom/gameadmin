<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->tongjiling}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
		<script type="text/javascript">
			
			isShow = 0;
			showDay = "";
			
			function showMonsterKillRank(day){
				var aid = "#"+day;
				var rid = "#"+"rank-"+day; 
			
				if( $(rid).length <= 0 ) {
					var rid = "#no_data";
				}
				
				if( isShow == 0 ){
										
					$(rid).show();
					
					isShow = 1;
					showDay = day;
					var offsetRank = $(aid).offset();
					$(rid).css("top",offsetRank.top+20).css("left",offsetRank.left);
				} else {
					if( showDay == day ) {
						$(rid).hide();
						isShow = 0;
					} else {
						$("div.rank").hide();
						$(rid).show();
						isShow = 1;
						showDay = day;
						var offsetRank = $(aid).offset();
						$(rid).css("top",offsetRank.top+20).css("left",offsetRank.left);
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
			<b><{$lang->menu->class->activityManage}>：<{$lang->menu->tongjiling}><{$lang->menu->dataStatistics}></b>
		</div>
		
		<div><{$lang->page->serverOnlineDate}>: <{$minDate}> &nbsp; <{$lang->page->today}>: <{$maxDate}></div>
		
		<br />
		
		<div>&nbsp;&nbsp;活动开启时间：全天</div>
		<br />
		<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
			<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="startDay" id="startDay" onfocus="WdatePicker({el:'startDay',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDay\')}'})" value="<{$startDay}>"></td>
			<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="endDay" id="endDay" onfocus="WdatePicker({el:'endDay',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDay\')}',maxDate:'<{$maxDate}>'})" value="<{$endDay}>"></td>
			<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
		</form>

		<br />
		
		<div><h3>活动参与数据：</h3></div>
		<br />
		<table class="DataGrid" style="width:960px">
				<tr align="center">
					<th>日期</th>
					<th>可参与人数</th>
					<th>参与人数</th>
					<th>参与度</th>
					<th>刷新次数</th>
					<th>消耗金额</th>
				</tr>
				
		<{if $joinData}>
			<{foreach from=$joinData item=day name=day_data key=key}>
				<tr align="center">
					<td><{$day.mdate}></td>
					<td><{$day.act_count}></td>
					<td><{$day.join_count}></td>
					<td><{$day.joinRate}>%</td>
					<td><{if $day.refresh.opCount}><{$day.refresh.opCount}><{else}>0<{/if}></td>
					<td><{if $day.refresh.sumGold}><{$day.refresh.sumGold}><{else}>0<{/if}></td>
				</tr>
			<{/foreach}>
		<{else}>		
			<tr><td colspan="5"><{$lang->page->noData}></td></tr>
		<{/if}>
		</table>
			

	<br />
	<div><h3>活动数据：</h3></div>
	<!--
	<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
		<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="selectDay" id="selectDay" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" value="<{$selectDay}>"></td>
		<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
	</form>
-->
	<br />
	
	<{if $viewData}>
	
	<{foreach from=$viewData item=day name=day_data key=key}>
	
	<div><h3>放弃数据：</h3></div>
	<table class="DataGrid" style="width:320px;">
		<tr style="height:25px;" ><td colspan="2" align="center">日期：<{$key}></td></tr>
		<{if $day.abortRate}>
		<tr>
			<th>放弃次数</th>
			<th>分布率</th>
		</tr>
			<{foreach from=$day.abortRate key=k item=ab name=abr}>
			<tr>
				<td align="center"><{$ab.abort}></td>
				<td align="center"><{$ab.rate}>%</td>
			</tr>
			<{/foreach}>
		<{else}>
		<tr><td colspan="2"><{$lang->page->noData}></td></tr>
		<{/if}>
	</table>
	
	<div><h3>通关数据：</h3></div>
	<table style="width:960px;" class="CopyDataGrid">
		<tr style="height:25px;" ><td colspan="5" <{if $key==$today }> class="TodayDataHead" <{else}> class="DataHead" <{/if}>>日期：<{$key}></td></tr>
		<{if $day.cleanRate}>
		<tr style="height:30px;">
			<th style="width:15%">热度</th>
			<th style="width:25%">BOSS名称</th>
			<th style="width:20%">累积挑战人次</th>
			<th style="width:20%">失败次数</th>
			<th style="width:20%">成功率</th>
		</tr>
		<{foreach from=$day.cleanRate key=k item=cl name=clr}>
			<{foreach from=$cl key=j item=mon name=monster}>
		<tr>
				<{if $smarty.foreach.monster.index == 0 }>
			<td rowspan="<{$cl|@count}>" ><{$k}></td>
				<{/if}>
			<td style="height:30px;"><{$mon.monsterName}></td>
			<td style="height:30px;"><{$mon.cnt}></td>
			<td style="height:30px;"><{$mon.fail}></td>
			<td style="height:30px;"><{$mon.cleanRate}></td>
		</tr>
			<{/foreach}>
		<{/foreach}>
		<{else}>
		<tr><td colspan="5"><{$lang->page->noData}></td></tr>
		<{/if}>
	</table>
	<br />
	<{/foreach}>
	
	<{else}>
	<div><b><{$lang->page->noData}></b></div>
	<{/if}>

<div id="no_data" class="rank"><{$lang->page->noData}></div>

	</body>
</html>