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
			text: '<{$lang->menu->registerAnalyseByHour}>',
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
				text: '<{$lang->page->pepole}>'
			}
		},
		tooltip: {
			crosshairs: true,
			formatter: function() {
	                return this.series.name+'<br/>'+'<{$lang->page->time}>:'+
					Highcharts.dateFormat('%H:%M', this.x) +'<br/><{$lang->page->pepole}>:'+ this.y;
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
							<{$item.c}><{if !$smarty.foreach.loop2.c}>,<{/if}>
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
<title><{$lang->menu->registerAnalyseByHour}></title>

<body>
<div id="position">
<b><{$lang->menu->class->onlineAndReg}>：<{$lang->menu->registerAnalyseByHour}></b>
</div>
<form name="myform" id="myform" method="post" action="">
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
	<input id="search" name="search" type="hidden" value="search" />
	<{$lang->sys->timeType}>:
	<select name="dateType">
		<{html_options options=$types selected=$dateType}>
	</select>
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />
</form>
<{if $type==1}>
<div id="container" style="width: 100%; height: 500px"></div>
<{/if}>

<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
	<tr class='trRollup'>
		<td colspan=6 >&nbsp;<{$lang->sys->allRegisterUsers}>：<{$reg_count}></td>
	</tr>
	<tr class='table_list_head'>
		<td colspan=6 >&nbsp;<{$lang->sys->betweenCountTime}>:<{$startDate}> 00:00:00 <{$lang->page->to}> <{$endDate}> 23:59:59</td>
	</tr>
	<{if 1==$dateType}>
	<tr>
		<td colspan="6"><div id="container" style="width: 100%; height: 500px"></div></td>
	</td>
	<{/if}>
	<tr class='table_list_head'>
    	<td></td>
		<td width="20%"><{$lang->time->year}></td>
		<td width="20%"><{$lang->time->month}></td>
        <td width="20%"><{$lang->time->day}></td>
        <td width="20%"><{$lang->time->hour}></td>
		<td width="20%"><{$lang->sys->registerUser}></td>
	</tr>
<form id="form1" name="form1" method="post" action="">
	<{section name=loop loop=$keywordlist}>
	
	<{if $keywordlist[loop].min==null && $keywordlist[loop].hour==null && $keywordlist[loop].day==null && $keywordlist[loop].month==null && $keywordlist[loop].year==null}>
	<tr class='trRollup'>
	<{else}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
	<{/if}>
		<td>
		</td><td>
		<{if $keywordlist[loop].year==null}><{$lang->sys->allResultSum}>
		<{else}>
		<{$keywordlist[loop].year}>
		<{/if}>
		</td><td>
		<{if $keywordlist[loop].min==null && $keywordlist[loop].hour==null && $keywordlist[loop].day==null && $keywordlist[loop].month==null && $keywordlist[loop].year!=null}>
		<{$lang->sys->yearSum}>
		<{else}>
		<{$keywordlist[loop].month}>
		<{/if}>
		</td><td>
		<{if $keywordlist[loop].min==null && $keywordlist[loop].hour==null && $keywordlist[loop].day==null && $keywordlist[loop].month!=null && $keywordlist[loop].year!=null}>
		<{$lang->sys->monthSum}>
		<{else}>
		<{$keywordlist[loop].day}>
		<{/if}>
		</td><td>
		<{if $keywordlist[loop].min==null && $keywordlist[loop].hour==null && $keywordlist[loop].day!=null && $keywordlist[loop].month!=null && $keywordlist[loop].year!=null}>
		<{$lang->sys->daySum}>
		<{else}>
		<{$keywordlist[loop].hour}>
		<{/if}>
		</td>
        <!--分统计显示
        <{*
        <{if 4 == $dateType }>
        <td>
		<{if $keywordlist[loop].min==null && $keywordlist[loop].hour!=null && $keywordlist[loop].day!=null && $keywordlist[loop].month!=null && $keywordlist[loop].year!=null}>时总计
		<{else}>
		<{$keywordlist[loop].min}>
		<{/if}>
		</td>
        <{/if}>*}>-->
        <td>
		<{$keywordlist[loop].c}>
		</td>
	</tr>
<{sectionelse}>

<{/section}>
<!-- SECTION  END -------------------------->

</form>
</table>
</body>
</html>