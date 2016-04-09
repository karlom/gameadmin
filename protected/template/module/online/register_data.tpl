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
	            text: '<{$lang->menu->registerData}>'
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
			} ,
			min: 0,
		        endOnTick: false,
		        maxPadding: 0.02,
			labels: {
					formatter: function() {
						return this.value + '<{$lang->page->ren}>';
					}
				}
			},
			tooltip: {
				formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+ 
					Highcharts.dateFormat('%Y-%m-%d', this.x) +'：'+ this.y +'<{$lang->page->ren}>';
				},
				crosshairs: true
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
					pointInterval: 3600000*24, // one day
					pointStart: Date.UTC(<{$year}>, <{$month-1}>, <{$day}>, 00, 00, 00)	
					//pointInterval: 86400*1000, //one minute
					//pointStart: Date.UTC(<{$keywordlist.0.year}>, <{$keywordlist.0.month-1}>, <{$keywordlist.0.day}>, 0, 0, 0)
				}
			},	
			exporting: {
				enabled: false
			},
	        series: [{
		        name:'<{$lang->page->time}>',
	            data:  [ 
					<{foreach from=$viewPicData name=loop key=key item=item}>
						<{$item.register_count}><{if !$smarty.foreach.loop.last}>,<{/if}>
					<{/foreach}>
			      ]  
	        }]
		});        
	});	
	</script>
<title><{$lang->menu->registerData}></title>

</head>
<body>
<div id="position">
<b><{$lang->menu->class->onlineAndReg}>：<{$lang->menu->registerData}></b>
</div>
<div class='divOperation'>
<form name="myform2" id="myform2" method="post" action="">
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
	<input id="search" name="search" type="hidden" value="search" />
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />
</form>
</div>
<div id="container" style="width: 100%; height: 80%"></div>
<table width="100%" cellspacing="1" cellpadding="3" border="0" class='tableList' >
  <tr class='trRollup'>
    <td colspan=5 >&nbsp;<{$lang->sys->allRegisterUsers}>:<b><{$allRegisterUser}></b></td>
  </tr>
  <tr class='table_list_head'>
  <td colspan=5 >&nbsp;<{$lang->sys->betweenCountTime}>: <{$startDate}>&nbsp;<{$lang->page->to}> &nbsp;<{$endDate}></td>
  </tr>
  <tr class='table_list_head'>
    <td width="25%"><{$lang->time->year}></td>
    <td width="25%"><{$lang->time->month}></td>
    <td width="25%"><{$lang->time->day}></td>
    <td width="25%"><{$lang->sys->registerUser}></td>
  </tr>
<{foreach from=$viewData.data name=loop key=date item=data}>
	<tr class='<{cycle values="trEven, trOdd"}>'>
		<td width="25%"><{if $data.year}><{$data.year}><{else}>0<{/if}></td>
		<td width="25%"><{if $data.month}><{$data.month}><{else}>0<{/if}></td>
		<td width="25%"><{if $data.day}><{$data.day}><{else}>0<{/if}></td>
		<td width="25%"><{if $data.register_count}><{$data.register_count}><{else}>0<{/if}></td>
	</tr>	
<{/foreach}>
</table>
</body>
</html>



