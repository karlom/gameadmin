<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><{$lang->menu->huoyuedu}></title>
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<script type="text/javascript" src="/static/js/highcharts/highcharts.js"></script>
	<script type="text/javascript">
		
		$(document).ready(function(){
			
			var huoyuedu = new Highcharts.Chart({
		        chart: {
		            renderTo: 'huoyuedu',
		            defaultSeriesType: 'spline',
			        type:'column'
		        },
		        title: {
		            text: '<{$selectDay}> 玩家活跃度'
		         },
		         xAxis: {
		            categories: [
					<{foreach from=$viewData.huoyue item=it key=key name=hy}>
						'<{$key}>'<{if !$smarty.foreach.hy.last}>,<{/if}>
					<{/foreach}>
					]
		         },
		         yAxis: {
		            title: {
		               text: ''
		            }
		         },
				plotOptions: {
	                column: {
	                    dataLabels: {
	                        enabled: true
	                    }
	                }
	            },
		         series: [{
		            name: '人数',
					data:[
						<{foreach from=$viewData.huoyue item=it key=key name=hy}>
						{
							dataLabels :{formatter : function(){ return '<strong><{$it}></strong>'} },
							y: <{$it}>
						}
						<{if !$smarty.foreach.hy.last}>,<{/if}>
						<{/foreach}>
					]
		         }]
			});  
					
			var huoyueFinishRate = new Highcharts.Chart({
		        chart: {
		            renderTo: 'finishRate',
		            defaultSeriesType: 'spline',
			        type:'column'
		        },
		        title: {
		            text: '<{$selectDay}> 活跃行动完成率'
		         },
		         xAxis: {
		            categories: [
					<{foreach from=$viewData.finishRate item=it key=key name=hyr}>
						'<strong><{$it.name}></strong>'<{if !$smarty.foreach.hyr.last}>,<{/if}>
					<{/foreach}>
					],
					labels: {
						rotation: -45,
						align: 'right',
						style: {
							font: 'normal 13px Verdana, sans-serif'
						}
					}
		         },
		         yAxis: {
		            title: {
		               text: '百分比'
		            }
		         },
				plotOptions: {
	                column: {
	                    dataLabels: {
	                        enabled: true
	                    }
	                }
	            },
		         series: [{
		            name: '完成率',
					data:[
						<{foreach from=$viewData.finishRate item=it key=key name=hyr}>
						{
							dataLabels :{formatter : function(){ return '<strong><{$it.rate}></strong>'} },
							y: <{$it.rate}>
						}
						<{if !$smarty.foreach.hyr.last}>,<{/if}>
						<{/foreach}>
					]
		         }]
			});    
		});
	</script>
	
</head>
<body>
	<div id="position">
		<b><{$lang->menu->class->baseData}>：<{$lang->menu->huoyuedu}></b>
	</div>
	
	<div><{$lang->page->serverOnlineDate}>: <{$minDate}> &nbsp; <{$lang->page->today}>: <{$maxDate}></div>
	
	
	<br />
	<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
		<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="selectDate" id="selectDate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" value="<{$selectDate}>"></td>
		<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
	</form>

	<br />
	<div><h3>玩家活跃度：</h3></div>
	<{if $viewData.huoyue}>
	<div id="huoyuedu" style="width: 960px; height: 400px"></div>
	<{else}>
	<div><{$lang->page->noData}></div>
	<{/if}>
	
	<br />
	<div><h3>活跃行动完成率：</h3></div>
	<{if $viewData.finishRate}>
	<div id="finishRate" style="width: 960px; height: 400px"></div>
	<{else}>
	<div><{$lang->page->noData}></div>
	<{/if}>
	
	<br />
	
	<div><h3>活跃奖励礼包领取率：</h3></div>
	<br />
	<{if $viewData}>
	<table class="DataGrid" style="width:960px">
			<tr >
				<th>活跃礼包</th>
				<th>礼包ID</th>
				<th>可领取玩家数</th>
				<th>已领取玩家数</th>
				<th>领取率</th>
			</tr>
			
		<{foreach from=$viewData.rewardTakeRate item=item name=reward key=key}>
			<tr align="center">
				<td><{$item.name}></td>
				<td><{$item.item_id}></td>
				<td><{$item.all}></td>
				<td><{$item.taked}></td>
				<td><{$item.rate}>%</td>
			</tr>
		<{/foreach}>
	</table>
	<{else}>		
		<div><{$lang->page->noData}></div>
	<{/if}>
		
	<br />

</body>
</html>