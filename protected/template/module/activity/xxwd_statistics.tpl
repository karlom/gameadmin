<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->xianxiewending}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
		<script type="text/javascript">
			
			dayRankShow = 0;
			showDay = "";
			showType = "";
			
			function showKillRank(day,tp){
				var aid = "#"+tp+"-"+day;
				var rid = "#"+tp+"-rank-"+day; 
			
				if( $(rid).length <= 0 ) {
					var rid = "#no_data";
				}
				
				if( dayRankShow == 0 ){
										
					$(rid).show();
					
					dayRankShow = 1;
					showDay = day;
					showType = tp;
					var offsetDayRank = $(aid).offset();
					$(rid).css("top",offsetDayRank.top+20).css("left",offsetDayRank.left);
				} else {
					if( showDay == day && showType == tp) {
						$(rid).hide();
						dayRankShow = 0;
					} else {
						$("div.rank").hide();
						$("div.score").hide();
						$(rid).show();
						dayRankShow = 1;
						showDay = day;
						showType = tp;
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
			<b><{$lang->menu->class->activityManage}>：<{$lang->menu->xianxiewending}><{$lang->menu->dataStatistics}></b>
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
		
		<div>&nbsp;&nbsp;活动开启时间：20:00 - 20:15、20:25 - 20:40</div>

		<table class="DataGrid" style="width:960px">
				<tr align="center">
					<th rowspan="2">日期</th>
					<th colspan="4">第一场</th>
					<th colspan="4">第二场</th>
					<th rowspan="2">两场均参与人数</th>
				</tr>
				<tr>
					<th>可参与人数</th>
					<th>参与人数</th>
					<th>参与度</th>
					<th>房间数</th>
					<th>可参与人数</th>
					<th>参与人数</th>
					<th>参与度</th>
					<th>房间数</th>
				</tr>
				
		<{if $joinData}>
			<{foreach from=$joinData item=day name=day_data key=key}>
				<tr align="center">
					<td><{$day.mdate}></td>
					<td><{$day.act_count1}></td>
					<td><{$day.join_count1}></td>
					<td><{$day.joinRate1}>%</td>
					<td><{$day.room_count1}></td>
					<td><{$day.act_count2}></td>
					<td><{$day.join_count2}></td>
					<td><{$day.joinRate2}>%</td>
					<td><{$day.room_count2}></td>
					<td><{$day.both_join_count}></td>
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
								<tr><td colspan="3"   <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >大荒鼎</td></tr>
								<tr>
									<th>平均持鼎时间(s)</th>
									<th>最长持鼎时间(s)</th>
									<th>最高时间玩家</th>
								</tr>
								<tr>
									<td><{ if $day.avgKeepTime.1.avg_keep_time}><{$day.avgKeepTime.1.avg_keep_time}><{else}>0<{/if}></td>
									<td><{ if $day.maxKeepDingTime}><{$day.maxKeepDingTime}><{else}>0<{/if}></td>
									<td><{ if $day.maxKeepDingUser}><{$day.maxKeepDingUser}><{else}>-<{/if}></td>
								</tr>
							</table>
						</td>
						<td style="width:390px;height:70px;">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="4"   <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >平均持旗时间(s)</td></tr>
								<tr>
									<th>青龙旗</th>
									<th>朱雀旗</th>
									<th>白虎旗</th>
									<th>玄武旗</th>
								</tr>
								<tr>
									<td><{ if $day.avgKeepTime.2.avg_keep_time}><{$day.avgKeepTime.2.avg_keep_time}><{else}>0<{/if}></td>
									<td><{ if $day.avgKeepTime.3.avg_keep_time}><{$day.avgKeepTime.3.avg_keep_time}><{else}>0<{/if}></td>
									<td><{ if $day.avgKeepTime.4.avg_keep_time}><{$day.avgKeepTime.4.avg_keep_time}><{else}>0<{/if}></td>
									<td><{ if $day.avgKeepTime.5.avg_keep_time}><{$day.avgKeepTime.5.avg_keep_time}><{else}>0<{/if}></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width:780px;height:70px;" colspan="2">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="7"   <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >玩家相关</td></tr>
								<tr>
									<th>玩家击杀平均数</th>
									<th>玩家最高击杀数</th>
									<th>排名数据</th>
									<th>玩家死亡平均数</th>
									<th>玩家最高死亡数</th>
									<th>排名数据</th>
									<th>胜负得分</th>
								</tr>
								<tr>
									<td><{$day.avgKill}></td>
									<td><{$day.maxKill}></td>
									<td><a id="kill-<{$key}>" href="javascript:showKillRank('<{$key}>','kill');" style="color:#215868;text-decoration:underline;">查看</a></td>
									<td><{$day.avgDie}></td>
									<td><{$day.maxDie}></td>
									<td><a id="die-<{$key}>" href="javascript:showKillRank('<{$key}>','die');" style="color:#215868;text-decoration:underline;">查看</a></td>
									<td><a id="score-<{$key}>" href="javascript:showKillRank('<{$key}>','score');" style="color:#215868;text-decoration:underline;">查看</a></td>
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

		
<!-- 最大击杀次数所在房间排行榜 -->
<{foreach from=$viewData item=day name=day_data key=key}>
	<{if $day.maxKillRoomRank}>
	<div id="kill-rank-<{$key}>" class="rank">
		<div class="rank_thead">
			<table>
				<tr >
					<th style="width:45px">房号</th>
					<th style="width:45px">排名</th>
					<th style="width:80px">玩家名称</th>
					<th style="width:45px">职业</th>
					<th style="width:45px">击杀</th>
					<th style="width:45px">助攻</th>
					<th style="width:45px">死亡</th>
					<th style="width:80px">个人得分</th>
					<th style="width:45px">阵营</th>
					<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
				</tr>
			</table>
		</div>
		<div class="rank_tbody">
			<table>
				<{foreach from=$day.maxKillRoomRank item=rank name=rank_data key=rankKey}>
				<tr class="rank_list" align="center">
					<td style="width:45px"><{$rank.room_id}></td>
					<td style="width:45px"><{$rank.rank}></td>
					<td style="width:80px"><{$rank.name}></td>
					<td style="width:45px"><{$dictJobs[$rank.job]}></td>
					<td style="width:45px"><{$rank.kill_cnt}></td>
					<td style="width:45px"><{$rank.help_cnt}></td>
					<td style="width:45px"><{$rank.die_cnt}></td>
					<td style="width:80px"><{$rank.score}></td>
					<td style="width:45px"><{$dictCamp[$rank.camp]}></td>
					<td style="width:45px"></td>
				</tr>
				<{/foreach}>
			</table>
		</div>
	</div>
	<{/if}>
			
	<!-- 最高死亡次数所在房间排行榜 -->
	<{if $day.maxDieRoomRank}>
	<div id="die-rank-<{$key}>" class="rank">
		<div class="rank_thead">
			<table>
				<tr >
					<th style="width:45px">房号</th>
					<th style="width:45px">排名</th>
					<th style="width:80px">玩家名称</th>
					<th style="width:45px">职业</th>
					<th style="width:45px">击杀</th>
					<th style="width:45px">助攻</th>
					<th style="width:45px">死亡</th>
					<th style="width:80px">个人得分</th>
					<th style="width:45px">阵营</th>
					<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
				</tr>
			</table>
		</div>
		<div class="rank_tbody">
			<table>
				<{foreach from=$day.maxDieRoomRank item=rank name=rank_data key=rankKey}>
				<tr class="rank_list" align="center">
					<td style="width:45px"><{$rank.room_id}></td>
					<td style="width:45px"><{$rank.rank}></td>
					<td style="width:80px"><{$rank.name}></td>
					<td style="width:45px"><{$dictJobs[$rank.job]}></td>
					<td style="width:45px"><{$rank.kill_cnt}></td>
					<td style="width:45px"><{$rank.help_cnt}></td>
					<td style="width:45px"><{$rank.die_cnt}></td>
					<td style="width:80px"><{$rank.score}></td>
					<td style="width:45px"><{$dictCamp[$rank.camp]}></td>
					<td style="width:45px"></td>
				</tr>
				<{/foreach}>
			</table>
		</div>
	</div>
	<{/if}>
	

<!-- 各房间阵营胜负得分 -->
	<div id="score-rank-<{$key}>" class="score">	
		<div class="score_thead">
			<table>
				
				<tr>
					<th style="width:60px">房号</th>
					<th style="width:100px">仙宗得分</th>
					<th style="width:100px">邪宗得分</th>
					<th style="width:75px">结束时间</th>
					<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
				</tr>
			</table>
		</div>
		<div class="score_tbody">
			<table>
			<{foreach from=$day.score item=sc }>
				<tr align="center">
					<th style="width:60px"><{$sc.room_id}></th>
					<th style="width:100px"><{$sc.score1}></th>
					<th style="width:100px"><{$sc.score2}></th>
					<th style="width:75px"><{$sc.mdate}></th>
					<th style="width:10px"></th>
				</tr>
			<{/foreach}>
			</table>
		</div>
	</div>

<{/foreach}>
<div id="no_data" class="rank"><{$lang->page->noData}></div>

	</body>
</html>