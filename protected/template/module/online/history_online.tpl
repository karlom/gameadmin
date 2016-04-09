<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script src="/static/js/jquery.min.js" type="text/javascript"></script>
<script src="/static/js/highcharts/highcharts.js" type="text/javascript"></script>
<script type="text/javascript" src="/static/js/Highcharts/modules/exporting.js"></script>
<script type="text/javascript">
var chart;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			defaultSeriesType: 'spline'
		},
		title: {
			text: '<{$lang->page->historyOnlineStat}>'
		},
		xAxis: {
			type: 'datetime'
		},
		yAxis: {
			title: {
				text: '<{$lang->page->pepole}>'
			},
			min: 0,
			minorGridLineWidth: 1, 
			gridLineWidth: 1,
			alternateGridColor: null,
		},
		tooltip: {
			formatter: function() {
	                return ''+
					this.series.name + Highcharts.dateFormat(' %H:%M ', this.x) + this.y +' <{$lang->page->ren}>';
			}
		},
		plotOptions: {
			spline: {
				lineWidth: 4,
				states: {
					hover: {
						lineWidth: 5
					}
				},
				marker: {
					enabled: false,
					states: {
						hover: {
							enabled: true,
							symbol: 'circle',
							radius: 5,
							lineWidth: 1
						}
					}	
				},
				pointInterval: <{$viewData.timeType}>*60*1000, // one hour
				pointStart: Date.UTC(0, 0, 0, 0, 0, 0)
			}
		},
		series: [
		<{foreach from=$viewData.data name=loop key=date item=data}>
		{
			name: '<{$date}>',
			data: [
			<{foreach from=$data name=loop2 item=item}>
				<{$item.num}><{if !$smarty.foreach.loop2.last}>,<{/if}>
			<{/foreach}>
			]<{if !$smarty.foreach.loop.first}>,visible:false<{/if}>
	
		}<{if !$smarty.foreach.loop.last}>,<{/if}>
		<{/foreach}>
		]
		,
		navigation: {
			menuItemStyle: {
				fontSize: '10px'
			}
		}
	});
	
	
});
</script>
<title><{$lang->page->historyOnlineStat}></title>

</head>
<body>
<div id="position">
<b><{$lang->menu->class->onlineAndReg}>：<{$lang->page->historyOnlineStat}></b>
</div>
<div class='divOperation'>
<form name="myform2" id="myform2" method="post" action="">
<div class="clearfix">
	<div class="float_left">
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$viewData.dataStart}>' /> 
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$viewData.dataEnd}>' /> 
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />
	</div>
	<div class="float_right">
	<{$lang->page->search}><{$lang->page->beginTime}>：<font color=red><{$viewData.dataStart}></font>
	&nbsp;<{$lang->page->search}><{$lang->page->endTime}>：<span class="red"><{$viewData.dataEnd}></span> &nbsp;&nbsp;<{$lang->page->total}><span class="red"><{$viewData.dataTotle}></span><{$lang->page->tian}>
	</div>
</div>
</form>
</div>
<div id="container" style="width: 100%; height: 80%"></div>
<{*
<script>//buildchart();</script>
*}>
</body>
</html>