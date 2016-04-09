<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->jinghuandongtian}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
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
			<b><{$lang->menu->class->activityManage}>：<{$lang->menu->jinghuandongtian}><{$lang->menu->dataStatistics}></b>
		</div>
		
		<div><{$lang->page->serverOnlineDate}>: <{$minDate}> &nbsp; <{$lang->page->today}>: <{$maxDate}></div>
		<br />
		
		<div><h3>活动参与数据：</h3></div>
		
		<br />
		<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
			<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="startDay" id="startDay" onfocus="WdatePicker({el:'startDay',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDay\')}'})" value="<{$startDay}>"></td>
			<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="endDay" id="endDay" onfocus="WdatePicker({el:'endDay',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDay\')}',maxDate:'<{$maxDate}>'})" value="<{$endDay}>"></td>
			<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
		</form>
		<br />
		
		<div>&nbsp;&nbsp;活动开启时间：13:00 - 13:30、19:00 - 19:30</div>

		<table class="DataGrid" style="width:960px">
			<tr>
				<th rowspan="2">日期</th>
				<th colspan="3">第一场</th>
				<th colspan="3">第二场</th>
				<th colspan="3">第三场</th>
			</tr>
			<tr align="center">
				<th>可参与人数</th>
				<th>参与人数</th>
				<th>参与度</th>
				<th>可参与人数</th>
				<th>参与人数</th>
				<th>参与度</th>
				<th>可参与人数</th>
				<th>参与人数</th>
				<th>参与度</th>
			</tr>
				
		<{if $joinData}>
			<{foreach from=$joinData item=day name=day_data key=key}>
				<tr align="center">
					<td><{$day.mdate}></td>
					<td><{$day.act_count1}></td>
					<td><{$day.join_count1}></td>
					<td><{$day.joinRate1}>%</td>
					<td><{$day.act_count2}></td>
					<td><{$day.join_count2}></td>
					<td><{$day.joinRate2}>%</td>
					<td><{$day.act_count3}></td>
					<td><{$day.join_count3}></td>
					<td><{$day.joinRate3}>%</td>
				</tr>
			<{/foreach}>
		<{else}>		
			<tr><td colspan="5"><{$lang->page->noData}></td></tr>
		<{/if}>
		</table>

	<br />
	<div><h3>活动数据：</h3></div>
	<br />
	<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
		<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="selectDay" id="selectDay" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" value="<{$selectDay}>"></td>
		<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
	</form>

	<br />
	
	<{if $viewData}>
	
	<{foreach from=$viewData item=day name=day_data key=key}>
	<table style="width:960px;height:140px;" class="CopyDataGrid">
		<tr>
			<td style="width:180px;height:100%;">
				<table style="width:100%;height:100%;" class="CopyDataGrid">
					<tr><td  <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >日期</td></tr>
					<tr><td><{if $key == "thisWeek" }>本周<br /><{$thisWeek}><{ elseif $key == "lastWeek" }>上周<br /><{$lastWeek}><{else}><{$key}><{/if}></td></tr>
				</table>
			</td>
			<td style="width:780px;height:100%;">
				<table style="width:100%;height:100%;" class="CopyDataGrid">
					<tr>
						<td style="width:390px;height:70px;">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="4"  <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >队伍情况</td></tr>
								<tr>
									<th>参与人数</th>
									<th>队伍数</th>
									<th>平均人数</th>
									<th>最常用队伍人数</th>
								</tr>
								<tr>
									<td><{ if $day.joinCount}><{$day.joinCount}><{else}>0<{/if}></td>
									<td><{ if $day.joinTeamCount}><{$day.joinTeamCount}><{else}>0<{/if}></td>
									<td><{ if $day.avgMember}><{$day.avgMember}><{else}>0<{/if}></td>
									<td><{ if $day.comMember}><{$day.comMember}><{else}>0<{/if}></td>
								</tr>
							</table>
						</td>
						<td style="width:390px;height:70px;">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="4"  <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >通关信息</td></tr>
								<tr>
									<th>队员救助次数</th>
									<th>平均通关时间(s)</th>
									<th>最短通关时间(s)</th>
									<th>队伍信息</th>
								</tr>
								<tr>
									<td><{ if $day.avgHelpCount}><{$day.avgHelpCount}><{else}>0<{/if}></td>
									<td><{ if $day.avgClearedTime}><{$day.avgClearedTime}><{else}>0<{/if}></td>
									<td><{ if $day.minClearedTime}><{$day.minClearedTime}><{else}>-<{/if}></td>
									<td><a id="team-<{$key}>" href="javascript:showTeamMember('<{$key}>');">查看队伍成员</a></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width:780px;height:70px;" colspan="2">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="6"  <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >通关成功率(%)</td></tr>
								<tr>
									<th>1人</th>
									<th>2人</th>
									<th>3人</th>
									<th>4人</th>
									<th>5人</th>
									<th>总成功率</th>
								</tr>
								<tr>
									<td><{$day.clearedRate.1.rate}></td>
									<td><{$day.clearedRate.2.rate}></td>
									<td><{$day.clearedRate.3.rate}></td>
									<td><{$day.clearedRate.4.rate}></td>
									<td><{$day.clearedRate.5.rate}></td>
									<td><{$day.clearedRate.all.rate}></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br />
	<{/foreach}>
	
	<{else}>
	<div><b><{$lang->page->noData}></b></div>
	<{/if}>


		
<!-- 队伍成员信息 -->
<{foreach from=$viewData item=day name=day_data key=key}>

	<{if $day.minClearedTeam}>
<div id="teamList-<{$key}>" class="rank">
	<div class="rank_thead">
		<table>
			<tr >
				<th style="width:95px">队员1</th>
				<th style="width:95px">队员2</th>
				<th style="width:95px">队员3</th>
				<th style="width:95px">队员4</th>
				<th style="width:95px">队员5</th>
				<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
			</tr>
		</table>
	</div>
	<div class="rank_tbody">
		<table>
			<{foreach from=$day.minClearedTeam item=team key=key}>
			<tr class="rank_list" align="center">
				<td style="width:95px"><{ if $team.0}><{$team.0}><{else}>-<{/if}></td>
				<td style="width:95px"><{ if $team.1}><{$team.1}><{else}>-<{/if}></td>
				<td style="width:95px"><{ if $team.2}><{$team.2}><{else}>-<{/if}></td>
				<td style="width:95px"><{ if $team.3}><{$team.3}><{else}>-<{/if}></td>
				<td style="width:95px"><{ if $team.4}><{$team.4}><{else}>-<{/if}></td>
				<td style="width:45px"></td>
			</tr>
			<{/foreach}>
		</table>
	</div>
</div>
	<{/if}>

<{/foreach}>
<div id="no_data" class="rank"><{$lang->page->noData}></div>

	</body>
</html>