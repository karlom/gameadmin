<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->bumieshilian}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
		<script type="text/javascript" src="/static/js/sorttable.js"></script>
		<script type="text/javascript">
			
			rankIsShow = 0;
			showDay = "";
			showType = "";
			
			function showRank(day,tp){
				var aid = "#"+tp+"-"+day;
				var rid = "#"+tp+"-rank-"+day; 
			
				if( $(rid).length <= 0 ) {
					var rid = "#no_data";
				}
				
				if( rankIsShow == 0 ){
										
					$(rid).show();
					
					rankIsShow = 1;
					showDay = day;
					showType = tp;
					var offsetDayRank = $(aid).offset();
					$(rid).css("top",offsetDayRank.top+20).css("left",offsetDayRank.left);
				} else {
					if( showDay == day && showType == tp) {
						$(rid).hide();
						rankIsShow = 0;
					} else {
						$("div.rank").hide();
						$(rid).show();
						rankIsShow = 1;
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
			<b><{$lang->menu->class->activityManage}>：<{$lang->menu->bumieshilian}><{$lang->menu->dataStatistics}></b>
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
		
		<div>&nbsp;&nbsp;活动开启时间：15:00 - 15:30</div>

		<table class="DataGrid" style="width:960px">
				<tr align="center">
					<th>日期</th>
					<th>可参与人数</th>
					<th>参与人数</th>
					<th>参与度</th>
					<th>房间数</th>
				</tr>
				
		<{if $joinData}>
			<{foreach from=$joinData item=day name=day_data key=key}>
				<tr align="center">
					<td><{$day.mdate}></td>
					<td><{$day.act_count}></td>
					<td><{$day.join_count}></td>
					<td><{$day.joinRate}>%</td>
					<td><{$day.room_count}></td>
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
						<td style="width:780px;height:70px;">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="8"   <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >基本信息</td></tr>
								<tr>
									<th>平均怪物强度</th>
									<th>最高怪物强度</th>
									<th>排名数据</th>
									<th>平均存活人数</th>
									<th>存活最高人数</th>
									<th>排名数据</th>
									<th>所有存活列表</th>
									<th>平均救助次数</th>
								</tr>
								<tr>
									<td><{ if $day.avgMonsterStrength}><{$day.avgMonsterStrength}><{else}>0<{/if}></td>
									<td><{ if $day.maxMonsterStrength}><{$day.maxMonsterStrength}><{else}>0<{/if}></td>
									<td><a id="strength-<{$key}>" href="javascript:showRank('<{$key}>','strength');" style="color:#215868;text-decoration:underline;">查看</a></td>
									<td><{$day.avgAlive}></td>
									<td><{$day.maxAlive.aliveCount}></td>
									<td title="点击查看排名"><a id="alive-<{$key}>" href="javascript:showRank('<{$key}>','alive');" style="color:#215868;text-decoration:underline;">查看</a></td>
									<td title="点击查看名单"><a id="all_alive-<{$key}>" href="javascript:showRank('<{$key}>','all_alive');" style="color:#215868;text-decoration:underline;">查看</a></td>
									<td><{$day.avgHelpCount}></td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td style="width:780px;height:70px;" colspan="2">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="7"   <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >记忆之石</td></tr>
								<tr>
									<th>加强攻击</th>
									<th>加强防御</th>
									<th>加强气力恢复</th>
									<th>复活</th>
									<th>消耗总量</th>
									<th>购买总量</th>
									<th>生成总量</th>
								</tr>
								<tr>
									<td><{$day.stoneUseWay.attack}></td>
									<td><{$day.stoneUseWay.defense}></td>
									<td><{$day.stoneUseWay.restore}></td>
									<td><{$day.stoneUseWay.relive}></td>
									<td><{ if $day.stoneAllUse }><{$day.stoneAllUse}><{else}>0<{/if}></td>
									<td><{ if $day.stoneAllBuy }><{$day.stoneAllBuy}><{else}>0<{/if}></td>
									<td><{ if $day.stoneAllOutput }><{$day.stoneAllOutput}><{else}>0<{/if}></td>
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

	
	
<{foreach from=$viewData item=day name=day_data key=key}>
	<!-- 最高怪物强度所在房间排行榜 -->
	<{if $day.maxMonsterStrengthRank}>
	<div id="strength-rank-<{$key}>" class="rank">
		<div class="rank_thead">
			<table>
				<tr >
					<th style="width:40px">房号</th>
					<th style="width:40px">排名</th>
					<th style="width:100px">玩家名称</th>
					<th style="width:40px">职业</th>
					<th style="width:80px">生存时间(s)</th>
					<th style="width:90px">拯救队友次数</th>
					<th style="width:80px">个人得分</th>
					<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
				</tr>
			</table>
		</div>
		<div class="rank_tbody">
			<table>
				<{foreach from=$day.maxMonsterStrengthRank item=rank name=rank_data key=rankKey}>
				<tr class="rank_list" align="center">
					<td style="width:40px"><{$rank.scene_id}></td>
					<td style="width:40px"><{$rank.rank}></td>
					<td style="width:100px"><{$rank.role_name}></td>
					<td style="width:40px"><{$dictJobs[$rank.job]}></td>
					<td style="width:80px"><{$rank.live_sec}></td>
					<td style="width:90px"><{$rank.save_cnt}></td>
					<td style="width:80px"><{$rank.score_all}></td>
					<td style="width:45px"></td>
				</tr>
				<{/foreach}>
			</table>
		</div>
	</div>
	<{/if}>

	<!-- 最高存活人数所在房间排行榜 -->
	<{if $day.maxAliveRank}>
	<div id="alive-rank-<{$key}>" class="rank">
		<div class="rank_thead">
			<table>
				<tr >
					<th style="width:40px">房号</th>
					<th style="width:40px">排名</th>
					<th style="width:100px">玩家名称</th>
					<th style="width:40px">职业</th>
					<th style="width:80px">生存时间(s)</th>
					<th style="width:90px">拯救队友次数</th>
					<th style="width:80px">个人得分</th>
					<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
				</tr>
			</table>
		</div>
		<div class="rank_tbody">
			<table>
				<{foreach from=$day.maxAliveRank item=rank name=rank_data key=rankKey}>
				<tr class="rank_list" align="center">
					<td style="width:40px"><{$rank.scene_id}></td>
					<td style="width:40px"><{$rank.rank}></td>
					<td style="width:100px"><{$rank.role_name}></td>
					<td style="width:40px"><{$dictJobs[$rank.job]}></td>
					<td style="width:80px"><{$rank.live_sec}></td>
					<td style="width:90px"><{$rank.save_cnt}></td>
					<td style="width:80px"><{$rank.score_all}></td>
					<td style="width:45px"></td>
				</tr>
				<{/foreach}>
			</table>
		</div>
	</div>
	<{/if}>

	<!-- 所有存活玩家名单 -->
	<div id="all_alive-rank-<{$key}>" class="rank">
		<{if $day.allAliveList}>
		<div class="rank_thead">
			<table>
				<tr>
					<th style="width:40px">房号</th>
					<th style="width:40px">排名</th>
					<th style="width:100px">玩家名称</th>
					<th style="width:40px">职业</th>
					<th style="width:80px">生存时间(s)</th>
					<th style="width:90px">拯救队友次数</th>
					<th style="width:80px">个人得分</th>
					<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
				</tr>
			</table>
		</div>
		<div class="rank_tbody">
			<table>
				<{foreach from=$day.allAliveList item=rank name=rank_data key=rankKey}>
				<tr class="rank_list" align="center">
					<td style="width:40px"><{$rank.scene_id}></td>
					<td style="width:40px"><{$rank.rank}></td>
					<td style="width:100px"><{$rank.role_name}></td>
					<td style="width:40px"><{$dictJobs[$rank.job]}></td>
					<td style="width:80px"><{$rank.live_sec}></td>
					<td style="width:90px"><{$rank.save_cnt}></td>
					<td style="width:80px"><{$rank.score_all}></td>
					<td style="width:45px"></td>
				</tr>
				<{/foreach}>
			</table>
		</div>
		<{else}>
			<div><{$lang->page->noData}></div>
		<{/if}>
	</div>
<{/foreach}>

<div id="no_data" class="rank" ><{$lang->page->noData}></div>

	</body>
</html>