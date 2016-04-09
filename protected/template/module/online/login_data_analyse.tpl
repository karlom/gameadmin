<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script src="/static/js/jquery.min.js" type="text/javascript"></script>
<script src="/static/js/highcharts/highcharts.js" type="text/javascript"></script>
<script type="text/javascript" src="/static/js/highcharts/modules/exporting.js"></script>
		<script type="text/javascript">
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container',
						defaultSeriesType: 'column'
					},
					title: {
						text: '<{$lang->sys->betweenCountTime}>'
					},
					subtitle: {
						text: '<{$startDate}> <{$lang->page->to}> <{$endDate}>'
					},
					xAxis: {
						min: 0,
						categories: [
							<{foreach name=loop from=$viewData item=item}>
								"<{$item.desc}>"<{if !$smarty.foreach.loop.last}>,<{/if}>
							<{/foreach}>
						],
						title: {
							text: '<{$lang->sys->loginTimes}>'
						}
					},
					yAxis: {
						min: 0,
						title: {
							text: '<{$lang->page->pepole}>'
						}
					},
					tooltip: {
						formatter: function() {
							return this.x + '(<{$lang->sys->loginTimes}>)'+':' + this.y + '(<{$lang->page->pepole}>)';
						}
					},
					plotOptions: {
						column: {
							stacking: 'normal'
						}
					},
					credits: {
						enabled: false
					},
				        series: [{
						name: '<{$lang->sys->totalCount}>：<{$totalCount}>',
						data: [
							<{foreach from=$viewData name=loop key=date item=item}>
								<{$item.num}><{if !$smarty.foreach.loop.last}>,<{/if}>
							<{/foreach}>
						],
						dataLabels: {
							enabled: true,
							align: 'right',
							formatter: function() {
								return this.y;
							},
							style: {
								font: 'normal 13px Verdana, sans-serif'
							}
						}			
					}]
				});
				
				
			});

			function changeDate(dateStr,dateEnd){
				if(dateEnd==''){
					$("#starttime").val(dateStr);
					$("#endtime").val(dateStr);
				}else{
					$("#starttime").val(dateStr);
					$("#endtime").val(dateEnd);
				}
				$("#myform2").submit();
			}
				
		</script>
<title><{$lang->page->loginDataAnalyse}></title>

</head>
<body>
<div id="position">
<b><{$lang->menu->class->baseData}>：<{$lang->menu->loginDataAnalyse}></b>
</div>
<form name="myform" id="myform2" method="post" action="">
	<{$lang->page->beginTime}>:
	<input type="text" size="12" name="starttime" id="starttime" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
	<{$lang->page->endTime}>:
	<input type="text" size="12" name="endtime" id="endtime"  class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
	<input id="search" name="search" type="hidden" value="search" />
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />&nbsp;
<{*        <input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateStrToday}>','');">&nbsp;&nbsp;
        <input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="changeDate('<{$dateStrPrev}>','');">&nbsp;&nbsp;
        <input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="changeDate('<{$dateStrNext}>','');">&nbsp;&nbsp;
*}>
        <input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$dateOnline}>','<{$dateToday}>');
"></br>
</form>
<div id="container" style="width: 100%; height: 500px"></div>
<p style='font-size:18px;'><b> <{$lang->sys->betweenCountTime}>：<font color="#FF0000"><{ $startDate}> 00:00:00 </font><{$lang->page->to}> <font color="#FF0000"><{ $endDate}> 23:59:59</font></b></p>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <tr class='table_list_head' align="left">
        <td></td>
        <td><{$lang->sys->loginTimes}></td>
        <td><{$lang->page->pepole}> (<{$lang->page->userLoginTimes}>) </td>
    </tr>
    <{foreach name=loop from=$viewData item=item}>
	<tr class='<{cycle values="trEven,trEven"}>' align="left">
        	<td></td>
		<td><{$item.desc}></td>
		<td><{$item.num}></td>
    	</tr>
    <{/foreach}>
    <tr class='table_list_head' align="left">
		<td></td>
		<td><{$lang->sys->totalCount}></td>
		<td><{$totalCount}></td>
    </tr>
</table>
</body>
</html>



