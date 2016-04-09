<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
			text: '<{$lang->menu->AllIncomeByHour}>',
			x: -20 //center
		},
		xAxis: {
			title: {
				text: '<{$lang->page->time}>'
			},
			type: 'datetime'
		},
		yAxis: {
			title: {
				text: '<{$lang->page->payCount}>'
			}
		},
		tooltip: {
			crosshairs: true,
			formatter: function() {
	                return this.series.name+'<br/>'+'<{$lang->page->time}>:'+
					Highcharts.dateFormat('%H:%M', this.x) +'<br/><{$lang->page->payCount}>:'+ this.y;
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
                                pointInterval: 60*60*1000, //1 hour
                                pointStart: Date.UTC(0, 0, 0, 0, 0, 0)
			}
		},
		series: [
				<{foreach from=$grap_data name=loop key=date item=data}>
				{
				name: '<{$date}>',
				data: [
					<{foreach from=$data name=loop2 key=key item=item}>
							<{$item}><{if !$smarty.foreach.loop2.last}>,<{/if}>
					<{/foreach}>
				]<{if !$smarty.foreach.loop.first}>,visible:false<{/if}>
				}<{if !$smarty.foreach.loop.last}>,<{/if}>
				<{/foreach}>
			],
		navigation: {
			menuItemStyle: {
				fontSize: '10px'
			}
		}
	});
});
</script> 

</head>
<title><{$lang->menu->AllIncomeByHour}></title>

<body>
<div id="position">
<b><{$lang->menu->class->spendData}>：<{$lang->menu->AllIncomeByHour}></b>
</div>
<form name="myform" id="myform" method="post" action="">
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" size='12' value='<{$startDate}>' />  
	<input id="search" name="search" type="hidden" value="search" />
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />
</form>
<{if $type==1}>
<div id="container" style="width: 100%; height: 500px"></div>
<{/if}>

<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
	<tr class='trRollup'>
		<td colspan=6 >&nbsp;<{$lang->sys->totalCost}>：<{$totalCost}></td>
	</tr>
	<tr class='table_list_head'>
		<td colspan=6 >&nbsp;<{$lang->sys->betweenCountTime}>:<{$startDate}> 00:00:00 <{$lang->page->to}> <{$endDate}> 23:59:59</td>
	</tr>
	<tr>
		<td colspan="6"><div id="container" style="width: 100%; height: 500px"></div></td>
	</td>
</table>
</body>
</html>