<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->yijixunbao}>
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
			<b><{$lang->menu->class->activityManage}>：<{$lang->menu->yijixunbao}><{$lang->menu->dataStatistics}></b>
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
		
		<div>&nbsp;&nbsp;活动开启时间：19:00 - 19:20</div>

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
	<table style="width:960px;height:210px;" class="CopyDataGrid">
		<tr>
			<td style="width:180px;height:100%;">
				<table style="width:100%;height:100%;" class="CopyDataGrid">
					<tr><td <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >日期</td></tr>
					<tr><td><{if $key == "thisWeek" }>本周<br /><{$thisWeek}><{ elseif $key == "lastWeek" }>上周<br /><{$lastWeek}><{else}><{$key}><{/if}></td></tr>
				</table>
			</td>
			<td style="width:780px;height:100%;">
				<table style="width:100%;height:100%;" class="CopyDataGrid">
					<tr>
						<td style="width:100%;height:70px;">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="5"  <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >基本信息</td></tr>
								<tr>
									<th>普通宝箱</th>
									<th>高级宝箱</th>
									<th>华丽宝箱</th>
									<th>玩家平均死亡次数</th>
									<th>死亡转移寻宝金币数</th>
								</tr>
								<tr>
									<td><{ if $day.commonBox}><{$day.commonBox}><{else}>0<{/if}></td>
									<td><{ if $day.advancedBox}><{$day.advancedBox}><{else}>0<{/if}></td>
									<td><{ if $day.gorgeousBox}><{$day.gorgeousBox}><{else}>0<{/if}></td>
									<td><{$day.avgDie}></td>
									<td><{$day.dieDivertJb}></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width:100%;height:70px;">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="5"  <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >技能使用情况</td></tr>
								<tr>
									<th>鞭炮</th>
									<th>缩小术</th>
									<th>跳跃</th>
									<th>笨重术</th>
									<th>痊愈</th>
								</tr>
								<tr>
									<td><{$day.skillUse.5006.count}>(<{$day.skillUse.5006.percent}>%)</td>
									<td><{$day.skillUse.5008.count}>(<{$day.skillUse.5008.percent}>%)</td>
									<td><{$day.skillUse.5009.count}>(<{$day.skillUse.5009.percent}>%)</td>
									<td><{$day.skillUse.5010.count}>(<{$day.skillUse.5010.percent}>%)</td>
									<td><{$day.skillUse.5011.count}>(<{$day.skillUse.5011.percent}>%)</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width:100%;height:70px;" colspan="2">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<{if $day.monsterKillRank}>
								<tr><td colspan="4"  <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}>  title="点击查看排行榜"><a id="<{$key}>" href="javascript:showMonsterKillRank('<{$key}>');" style="color:#215868;text-decoration:underline;">怪物击杀比率</a></td></tr>
								<{else}>
								<tr><td colspan="4"  <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >怪物击杀比率</td></tr>
								<{/if}>
								<tr>
									<th>巡逻</th>
									<th>定点蹲守</th>
									<th>机关类型</th>
									<th>BOSS</th>
								</tr>
								<tr>
									<td><{$day.monsterKill.xunluo.count}>(<{$day.monsterKill.xunluo.percent}>%)</td>
									<td><{$day.monsterKill.dingdian.count}>(<{$day.monsterKill.dingdian.percent}>%)</td>
									<td><{$day.monsterKill.jiguan.count}>(<{$day.monsterKill.jiguan.percent}>%)</td>
									<td><{$day.monsterKill.boss.count}>(<{$day.monsterKill.boss.percent}>%)</td>
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
	<{if $day.monsterKillRank}>
<div id="rank-<{$key}>" class="rank" style="width:365px" >
	<div class="rank_thead" style="width:365px" >
		<table>
			<tr >
				<th style="width:80px">排名</th>
				<th style="width:80px">怪物类型</th>
				<th style="width:80px">击杀数</th>
				<th style="width:80px">占比</th>
				<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
			</tr>
		</table>
	</div>
	<div class="rank_tbody" style="width:365px" >
		<table>
			<{foreach from=$day.monsterKillRank item=rank name=rank_data key=rankKey}>
			<tr class="rank_list" align="center">
				<td style="width:80px"><{$rank.rank}></td>
				<td style="width:80px"><{$rank.name}></td>
				<td style="width:80px"><{$rank.count}></td>
				<td style="width:80px"><{$rank.percent}></td>
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