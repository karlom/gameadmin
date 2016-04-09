<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->zhumoweidao}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
		<script type="text/javascript">
			
			isShow = 0;
			showDay = "";
			
			function showHuntRank(day){
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
					$(rid).css("top",offsetRank.top+20).css("left",offsetRank.left-425);
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
						$(rid).css("top",offsetRank.top+20).css("left",offsetRank.left-425);
					}
				}
			}
			
			function hideRank() {
				$("div.rank").hide();
				dayRankShow = 0;
			}
		
		</script>
		
	</head>
	<body>
		<div id="position">
			<b><{$lang->menu->class->activityManage}>：<{$lang->menu->zhumoweidao}><{$lang->menu->dataStatistics}></b>
		</div>
		
		<div><{$lang->page->serverOnlineDate}>: <{$minDate}> &nbsp; <{$lang->page->today}>: <{$maxDate}></div>
		
		<br />
		
		<div>&nbsp;&nbsp;活动开启时间：每天12:30 - 12:45</div>
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
<!--	
	<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
		<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="selectDay" id="selectDay" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" value="<{$selectDay}>"></td>
		<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
	</form>
-->
	<br />
	
	<{if $viewData}>
	
	<table class="DataGrid" style="width:960px;">

		<tr>
			<th>日期</th>
			<th>结果</th>
			<th>连续成功次数</th>
			<th>连续失败次数</th>
			<th>boss等级</th>
			<th>伤害排行</th>
		</tr>
		<{foreach from=$viewData item=day name=day_data key=key}>
			<{if $day.result}>
			<tr align="center">
				<td><{$key}></td>
				<td><{ if $day.result.result==1}> 成功 <{else}> 失败 <{/if}></td>
				<td><{$day.result.succeed}></td>
				<td><{$day.result.fail}></td>
				<td><{$day.result.lv}></td>
				<td><a id="<{$key}>" href="javascript:showHuntRank('<{$key}>');">点击查看</a></td>
			</tr>
			<{else}>
			<tr align="center">
				<td><{$key}></td>
				<td colspan="5"><{$lang->page->noData}></td>
			</tr>
			<{/if}>
		<{/foreach}>
	</table>
	
	
	<{else}>
	<div><b><{$lang->page->noData}></b></div>
	<{/if}>

<!-- 伤害排行榜 -->
<{foreach from=$viewData item=day name=day_data key=key}>
	<{if $day.rank}>
	<div id="rank-<{$key}>" class="rank">
		<div class="rank_thead">
			<table>
				<tr >
					<th style="width:45px"><{$lang->rank->rank}></th>
					<th style="width:120px"><{$lang->page->roleName}></th>
					<th style="width:95px"><{$lang->page->job}></th>
					<th style="width:95px"><{$lang->page->hunt}></th>
					<th style="width:95px"><{$lang->rank->atk}></th>
					<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
				</tr>
			</table>
		</div>
		<div class="rank_tbody">
			<table>
				<{foreach from=$day.rank item=rank name=rank_data key=rankKey}>
				<tr class="rank_list" align="center">
					<td style="width:45px"><{$rank.rank}></td>
					<td style="width:120px"><{$rank.role_name}></td>
					<td style="width:95px"><{ $dictJobs[$rank.job] }></td>
					<td style="width:95px"><{$rank.hurt}></td>
					<td style="width:95px"><{$rank.zhandouli}></td>
					<td style="width:45px"></td>
				</tr>
				<{/foreach}>
			</table>
		</div>
	</div>
	<{/if}>
<{/foreach}>
<div id="no_data" class="rank"><{$lang->page->noData}></div>

<br/>
<br/>
	</body>
</html>