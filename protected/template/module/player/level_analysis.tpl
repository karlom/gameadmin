<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script src="/static/js/highcharts/highcharts.js" type="text/javascript"></script>
<script type="text/javascript" src="/static/js/Highcharts/modules/exporting.js"></script>
<script language="javascript">
	$(document).ready(function(){
		$("#role_name").keydown(function(){
			$("#role_id").val('');
			$("#account_name").val('');
		});
		$("#account_name").keydown(function(){
			$("#role_id").val('');
			$("#role_name").val('');
		});
	});
</script>

<title><{$lang->menu->levelAnalyse}></title>
<{ if $avg_cost_per_level }>
<script type="text/javascript">
	var chart; 	
	$(document).ready(function() {
	    chart = new Highcharts.Chart({
	        chart: {
	            renderTo: 'container',
	            defaultSeriesType: 'spline',
		        type:'column'
	        },
	        title: {
	            text: '<{$lang->menu->levelAnalyse}>'
	        },
	        xAxis: {
	            categories: [<{foreach from=$avg_cost_per_level name=loop_level key=key item=item}>
								'<{$item.p_level}> -> <{$item.c_level}>'<{if !$smarty.foreach.loop_level.last}>,<{/if}>
							<{/foreach}>
					]
	        },	
	        yAxis: {
				title: {
					text: '<{$lang->page->avgTimeCost}> (<{$lang->time->hour2}>)'
				} ,
				min: 0,
			    endOnTick: false,
			    maxPadding: 0.02,
				labels: {
					formatter: function() {
						return this.value ;
					}
				}
			},
			tooltip: {
				formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+ 
					  this.x +'：'+ this.y +'<{$lang->time->hour2}>';
				},
				crosshairs: true
			},
			exporting: {
				enabled: true
			},
	        series: [{
		        name:'<{$lang->page->level}>',
	            data:  [ 
					<{foreach from=$avg_cost_per_level name=loop key=key item=item}>
						<{$item.cost/3600|string_format:'%.2f'}><{if !$smarty.foreach.loop.last}>,<{/if}>
					<{/foreach}>
			      ]  
	        }]
		});        
	});	
</script>
<{/if}>
</head>

<body>

<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->levelAnalyse}></div>

<!-- Start 成功信息提示 -->
<{if $successMsg}>
<div class="success_msg_box">
	<{$successMsg}>
</div>
<{/if}>
<!-- End 成功信息提示 -->

<!-- Start 错误信息提示 -->
<{if $errorMsg}>
<div class="error_msg_box">
	<{$errorMsg}>
</div>
<{/if}>
<!-- End 错误信息提示 -->
<!-- Start 账号和角色名搜索  -->

<form action="?action=search" id="frm" method="GET" >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="800">
		<tr>
			<td>
				<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
			</td>
			<td>
				<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
			</td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2"  /></td>
		</tr>
	</table>
</form>
<br />

<!-- End 账号和角色名搜索  -->
<{ if $avg_cost_per_level }>
<div id="container" style="width: 100%; height: 80%"></div>
	<div> 
		玩家等级分析数据表：
	</div>
	<!--  Start  等级分析信息-->
	<table class="DataGrid sortable table_list" cellspacing="0" style="margin-bottom:20px;">
		
		<tr>
			<th width="10%"><{$lang->page->prevlevel}></th>
			<th width="10%"><{$lang->page->level}></th>
			<th width="25%"><{$lang->page->avgTimeCost}> (<{$lang->time->hour2}>)</th>
	        <th width="25%"><{$lang->page->pepole}></th>
		</tr>
	
			<{foreach from=$avg_cost_per_level item=log name=avg_cost_per_level_loop }>
		    <tr align="center" <{ if $smarty.foreach.avg_cost_per_level_loop.index is odd }> class="odd"<{ /if }>>
		
				<td><{ $log.p_level}>&nbsp;</td>
				<td><{ $log.c_level}>&nbsp;</td>
				<td><{ $log.cost/3600|string_format:'%.2f'}>&nbsp;</td>
		        <td><{ $log.men_count}>&nbsp;</td>
			</tr>
			<{/foreach}>
	</table>
	<!--  End  等级分析信息-->
</div>
<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
</body>
</html>