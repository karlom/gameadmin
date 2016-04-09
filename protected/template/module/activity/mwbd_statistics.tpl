<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->mowubaodong}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
		<script type="text/javascript" src="/static/js/highcharts/highcharts.js"></script>
		
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/flowtitle.js"></script>
<script type="text/javascript" src="/static/js/ip.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/highcharts/highcharts.js"></script>
<script type="text/javascript" src="/static/js/Highcharts/modules/exporting.js"></script>
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
			
			$(document).ready(function(){
			var menCountMapChart;
		
			menCountMapChart = new Highcharts.Chart({
			        chart: {
			            renderTo: 'list_map_online',
			            defaultSeriesType: 'spline',
				        type:'column'
			        },
			        title: {
			            text: '<{$selectDay}> 各地图在线人数'
			         },
			         xAxis: {
			            categories: ['地图一', '地图二', '地图三']
			         },
			         yAxis: {
			            title: {
			               text: '在线人数'
			            }
			         },
			         series: [{
			            name: '峰值',
//			            data: [5, 7, 3]
						data:[
						<{foreach from=$viewData item=day key=key}>
							<{if $key==$selectDay}>
								<{foreach from=$day.maxCount item=item name=max_count_loop}>
									<{$item}>
									<{if !$smarty.foreach.max_count_loop.last}>,<{/if}>
								<{/foreach}>
							<{/if}>
						<{/foreach}>
						]
			         }, {
			            name: '平均人数',
//			            data: [1, 0.5, 4]
						data:[
						<{foreach from=$viewData item=day key=key}>
							<{if $key==$selectDay}>
								<{foreach from=$day.avgCount item=item name=avg_count_loop}>
									<{$item}>
									<{if !$smarty.foreach.avg_count_loop.last}>,<{/if}>
								<{/foreach}>
							<{/if}>
						<{/foreach}>
						]
			         }]
				});   
			});
		
		</script>

	</head>
	<body>
		<div id="position">
			<b><{$lang->menu->class->activityManage}>：<{$lang->menu->mowubaodong}><{$lang->menu->dataStatistics}></b>
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
		
		<div>&nbsp;&nbsp;活动开启时间：21:00 - 21:30</div>

		<table class="DataGrid" style="width:960px">
				<tr align="center">
					<th>日期</th>
					<th>可参与人数</th>
					<th>参与人数</th>
					<th>参与度</th>
				</tr>
				
		<{if $joinData}>
			<{foreach from=$joinData item=day name=day_data key=key}>
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

	<br />
	<div><h3>活动数据：</h3></div>
	<br />
	<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
		<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="selectDay" id="selectDay" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" value="<{$selectDay}>"></td>
		<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
	</form>

	<br />
	
	<{if $viewData}>
	
	<div id="list_map_online" style="width: 680px; height: 400px"></div>
	
	<br />
	
	<{foreach from=$viewData item=day name=day_data key=key}>
	<table style="width:960px;height:140px;" class="CopyDataGrid">
		<tr>
			<td style="width:180px;height:100%;">
				<table style="width:100%;height:100%;" class="CopyDataGrid">
					<tr><td  <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >日期</td></tr>
					<tr><td><{$key}></td></tr>
				</table>
			</td>
			<td style="width:780px;height:100%;">
				<table style="width:100%;height:100%;" class="CopyDataGrid">
					<tr>
						<td style="width:390px;height:70px;">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="3"  <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >基本信息</td></tr>
								<tr>
									<th>BOSS1死亡时间</th>
									<th>BOSS2死亡时间</th>
									<th>家族排名数据</th>
								</tr>
								<tr>
									<td><{ if $day.bossDieTime}><{$day.bossDieTime}><{else}>-<{/if}></td>
									<td>(预留)</td>
									<td><a id="family-<{$key}>" href="javascript:showRank('<{$key}>','family');" style="color:#215868;text-decoration:underline;">查看</a></td>
								</tr>
							</table>
						</td>
						<td style="width:390px;height:70px;">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="3"  <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >地图人数(平均,最高)</td></tr>
								<tr>
									<th>地图一</th>
									<th>地图二</th>
									<th>地图三</th>
								</tr>
								<tr>
									<td><{$day.avgCount.1}>, <{$day.maxCount.1}></td>
									<td><{$day.avgCount.2}>, <{$day.maxCount.2}></td>
									<td><{$day.avgCount.3}>, <{$day.maxCount.3}></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width:780px;height:70px;" colspan="2">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="8"  <{if $key==$selectDay }> class="TodayDataHead" <{else}> class="DataHead" <{/if}> >怪物死亡情况</td></tr>
								<tr>
									<th>PVP-特殊</th>
									<th>PVP-普通</th>
									<th>PVP-加强</th>
									<th>PVP-精英</th>
									<th>PVE-特殊</th>
									<th>PVE-普通</th>
									<th>PVE-加强</th>
									<th>PVE-精英</th>
								</tr>
								<tr>
									<{if $day.monsterDie}>
										<{foreach from=$day.monsterDie item=item key=key }>
									<td><{if $item}><{$item}><{else}>0<{/if}></td>
										<{/foreach}>
									<{else}>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<{/if}>
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


		
<!-- 家族排名 -->
<{foreach from=$viewData item=day name=day_data key=key}>

	<{if $day.familyRank}>
<div id="family-rank-<{$key}>" class="rank">
	<div class="rank_thead">
		<table>
			<tr >
				<th style="width:150px">名次</th>
				<th style="width:150px">家族名称</th>
				<th style="width:150px">家族积分</th>
				<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
			</tr>
		</table>
	</div>
	<div class="rank_tbody">
		<table>
			<{foreach from=$day.familyRank item=family key=key}>
			<tr class="rank_list" align="center">
				<td style="width:150px"><{ $family.rank}></td>
				<td style="width:150px"><{ $family.familyName}></td>
				<td style="width:150px"><{ $family.score}></td>
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