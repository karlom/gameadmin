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
var chart2;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			defaultSeriesType: 'spline'
			<{if $ajaxLoad}>,
			events: {
				load: function() {
					// set up the updating of the chart each second
					var series = this.series[0];
					setInterval(function() {
						$.ajax({
							type: "POST",
							url: "<{$smarty.const.URL_SELF}>",
							data: "action=ajax_online",
							dataType: "json",
							success: function(data){
								//if(parseInt(data.maxonline) > parseInt($("span[id=maxonline]").html()) || '' == $("span[id=maxonline]").html()){
								//	$("span[id=maxonline]").html(data.maxonline);
								//}
								//$("span[id=avgonline]").html(data.avgnum);
								series.addPoint(parseInt(data.avgnum), true, false);
							}
						});
					}, <{$viewData.timeType}>*60*1000);
				}
			}
			<{/if}>
		},
		title: {
			text: '<{$lang->page->checkOnline1}>'
		},
		xAxis: {
			title: {
				text: '<{$lang->page->time}>'
			},
			type: 'datetime'
		},
		yAxis: {
			title: {
				text: '<{$lang->page->pepole}>'
			},
			min: 0,
			minorGridLineWidth: 1, 
			gridLineWidth: 1,
			alternateGridColor: null
		},
		tooltip: {
			crosshairs: true,
			formatter: function() {
	                return ''+
					this.series.name + Highcharts.dateFormat(' %H:%M', this.x) +': '+ this.y +' <{$lang->page->ren}>';
			}
		},
		plotOptions: {
			spline: {
				lineWidth: 1.6,
				states: {
					hover: {
						lineWidth: 2.5
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
				pointInterval: <{$viewData.timeType}>*60*1000, //5分钟
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
	chart2 = new Highcharts.Chart({
		chart: {
			renderTo: 'container2',
			defaultSeriesType: 'spline'
		},
		title: {
			text: '<{$lang->page->checkOnline2}>'
		},
		xAxis: {
			title: {
				text: '<{$lang->page->time}>'
			},
			type: 'datetime'
		},
		yAxis: {
			title: {
				text: '<{$lang->page->pepole}>'
			},
			min: 0,
			minorGridLineWidth: 1, 
			gridLineWidth: 1,
			alternateGridColor: null
		},
		tooltip: {
			crosshairs: true,
			formatter: function() {
	                return ''+
					Highcharts.dateFormat('%Y-%m-%d %H:%M', this.x) +': '+ this.y +' <{$lang->page->ren}>';
			}
		},
		plotOptions: {
			spline: {
				lineWidth: 1.6,
				states: {
					hover: {
						lineWidth: 2.5
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
				pointInterval: <{$viewData2.timeType}>*60*1000, //5分钟
				pointStart: Date.UTC(<{$viewData2.year}>, <{$viewData2.month}>-1, <{$viewData2.day}>, 0, 0, 0)
			}
		},
		series: [
		{
			name: '<{$viewData2.chartName}>',
			data: [
			<{foreach from=$viewData2.data name=loop2 item=item}>
				<{$item.num}><{if !$smarty.foreach.loop2.last}>,<{/if}>
			<{/foreach}>
			]
	
		}
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
<title><{$lang->page->checkOnline}></title>

</head>
<body>
<div id="position">
<b><{$lang->menu->class->onlineAndReg}>：<{$lang->menu->checkOnline}></b>
</div>
<form name="myform2" id="myform2" method="post" action="">
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
	<input id="search" name="search" type="hidden" value="search" />
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />
</form>
<{$lang->page->onlineDesc}>
<div id="container" style="width: 100%; height: 500px"></div>
<div id="container2" style="width: 100%; height: 500px"></div>
</body>
</html>