<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->pataStatistics}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/flowtitle.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script src="/static/js/highcharts/highcharts.js" type="text/javascript"></script>
<script type="text/javascript" src="/static/js/Highcharts/modules/exporting.js"></script>
<script type="text/javascript">
	var menCountChart,symbolCountChart,timesCountChart; 	
	$(document).ready(function() {
		menCountChart = new Highcharts.Chart({
	        chart: {
	            renderTo: 'mencountcontainer',
	            defaultSeriesType: 'spline',
		        type:'column'
	        },
	        title: {
	            text: '<strong><{$lang->activity->pataMenCountStatistics}></strong>'
	        },
	        xAxis: {
	            categories: [<{foreach from=$viewData.data name=loop_mencount key=key item=item}>
								'<{$key}>'<{if !$smarty.foreach.loop_mencount.last}>,<{/if}>
							<{/foreach}>
					]
	        },	
	        yAxis: {
				title: {
					text: '<{$lang->activity->menCount}>(<{$lang->activity->percentage}>)'
				} ,
				min: 0,
			    endOnTick: false,
			    
				labels: {
					formatter: function() {
						return this.value ;
					}
				}
			},
			tooltip: {
				formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+ 
					   this.y +'<{$lang->pet->amount}>(' + (this.y*100/<{$viewData.sum_men_acount}>).toFixed(2) + '%)';
				},
				crosshairs: true
			},
			exporting: {
				enabled: true
			},
			plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
	        series: [{
		        name:'<{$lang->activity->menCount}>',
	            data:  [ 
					<{foreach from=$viewData.data name=loop_men_count key=key item=item}>
						<{$item.men_count}><{if !$smarty.foreach.loop_men_count.last}>,<{/if}>
					<{/foreach}>
			      ]  
	        }]
		});        

		symbolCountChart = new Highcharts.Chart({
	        chart: {
	            renderTo: 'symbolcountcontainer',
	            defaultSeriesType: 'spline',
		        type:'column'
	        },
	        title: {
	            text: '<strong><{$lang->activity->pataSymbolCountStatistics}></strong>'
	        },
	        xAxis: {
	            categories: [<{foreach from=$viewData.data name=loop_symbolcount key=key item=item}>
								'<{$key}>'<{if !$smarty.foreach.loop_symbolcount.last}>,<{/if}>
							<{/foreach}>
					]
	        },	
	        yAxis: {
				title: {
					text: '<{$lang->activity->symbolCount}>(<{$lang->activity->percentage}>)'
				} ,
				min: 0,
			    endOnTick: false,
			    
				labels: {
					formatter: function() {
						return this.value ;
					}
				},
				stackLabels: {
					enabled: true,
					style: {
						fontWeight: 'bold',
						color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
					}
				}
			},
			tooltip: {
				formatter: function() {
					return '<b>'+ this.x +'</b><br/>'+
	                    this.series.name +': '+ this.y +'<br/>'+
	                    '全部塔符: '+ this.point.stackTotal;
				},
				crosshairs: true
			},
			exporting: {
				enabled: true
			},
			plotOptions: {
                column: {
                	stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
	        series: [
	     	        <{*
	     	        {
		        name:'<{$lang->activity->symbolCount}>',
	            data:  [ 
					<{foreach from=$viewData.data name=loop_symbolcount key=key item=item}>
						<{$item.all_symbol_count}><{if !$smarty.foreach.loop_symbolcount.last}>,<{/if}>
					<{/foreach}>
			      ]  
	        }
			*}>
			<{foreach from=$symbolList name=loop_symbollist key=symbol_id item=item}>
	     	    {
		        name:'<{$item}>',
	            data:  [ 
					<{foreach from=$viewData.data name=loop_timescount key=key item=item}>
						<{$item.symbol_count[$symbol_id].count}><{if !$smarty.foreach.loop_timescount.last}>,<{/if}>
					<{/foreach}>
			      ]  
	        	}
		        <{if !$smarty.section.loop_symbollist.last}>,<{/if}>
        	<{/foreach}> 
	        ]
		});   

		timesCountChart = new Highcharts.Chart({
	        chart: {
	            renderTo: 'timescountcontainer',
	            defaultSeriesType: 'spline',
		        type:'column'
	        },
	        title: {
	            text: '<strong><{$lang->activity->pataTimesStatistics}></strong>'
	        },
	        xAxis: {
	            categories: [<{foreach from=$viewData.data name=loop_symbolcount key=key item=item}>
								'<{$key}>'<{if !$smarty.foreach.loop_symbolcount.last}>,<{/if}>
							<{/foreach}>
					]
	        },	
	        yAxis: {
				title: {
					text: '<{$lang->activity->symbolCount}>(<{$lang->activity->percentage}>)'
				} ,
				min: 0,
			    endOnTick: false,
			    
				labels: {
					formatter: function() {
						return this.value ;
					}
				}
			},
			tooltip: {
				formatter: function() {
					return '<b>爬塔'+ this.series.name +'</b><br/>'+ 
					   this.y +'<{$lang->pet->amount}>';
				},
				crosshairs: true
			},
			exporting: {
				enabled: true
			},
			plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
	        series: [
				<{foreach name=men_count_by_times_list from=$viewData.men_count_by_times_list item=times}>
		     	    {
			        name:'<{$times}><{$lang->activity->times}>',
		            data:  [ 
						<{foreach from=$viewData.data name=loop_timescount key=key item=item}>
							<{$item.men_count_by_times[$times]}><{if !$smarty.foreach.loop_timescount.last}>,<{/if}>
						<{/foreach}>
				      ]  
		        	}
			        <{if !$smarty.section.loop.last}>,<{/if}>
	        	<{/foreach}> 
			]
		});
	});	
</script>
</head>

<body>

<div id="position">
<b><{$lang->menu->class->activityManage}>：<{$lang->menu->pataStatistics }></b>
</div> 

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
<div class='divOperation'>
<form id="myform" name="myform" method="get" action="" style="display: inline;">
<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="start_day" id="start_day" onfocus="WdatePicker({el:'start_day',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'end_day\')}'})" value="<{ $startDay }>">
<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="end_day" id="end_day" onfocus="WdatePicker({el:'end_day',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'start_day\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>">
<input type="hidden" name="search" value="1"/>
<input type="hidden" name="pageSize" value="100"/>
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>
<form id="myform2" name="myform2" method="post" action="<{$current_uri}>" style="display: inline;">
	<input type="submit" class="button" name="dateToday" value="<{$lang->page->today}>" >&nbsp;&nbsp;
	<input type="submit" <{if $selectedDay and $selectedDay <= $minDate }> disabled="disabled" <{/if}> class="button" name="datePrev" value="<{$lang->page->prevTime}>">&nbsp;&nbsp;
	<input type="submit" <{if $selectedDay and $selectedDay >= $maxDate }> disabled="disabled" <{/if}> class="button" name="dateNext" value="<{$lang->page->nextTime}>">&nbsp;&nbsp;
	<input type="submit" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" >
	<input type="hidden" class="button" name="selectedDay" value="<{$selectedDay}>" >
	<input type="hidden" id="role_name" name="role_name" size="15" value="<{$roleName}>" />
	<input type="hidden" id="account_name" name="account_name" size="15" value="<{$accountName}>" />
</form>
</div>
<br class="clear" />

<{if $viewData.data}>
	<div id="mencountcontainer" style="width:<{if $viewData.count_of_days lt 8}>100%<{else}><{math equation="x*150" x=$viewData.count_of_days}>px<{/if}>; height: 80%"></div>
	<hr />
	<div id="symbolcountcontainer" style="width:<{if $viewData.count_of_days lt 8}>100%<{else}><{math equation="x*150" x=$viewData.count_of_days}>px<{/if}>; height: 80%"></div>
	<hr />
	<div id="timescountcontainer" style="width:<{if $viewData.count_of_days lt 8}>100%<{else}><{math equation="x*150" x=$viewData.count_of_days}>px<{/if}>; height: 80%"></div>
	<hr />
	<div id="participationcontainer" style="width: 100%; height: 80%">
		<table cellspacing="1" cellpadding="3" border="0" class="table_list sortable"  >
			<caption class='table_list_head'>
				<{$lang->activity->participation}>
			</caption>
			<tr class='table_list_head'>
		        <th width="25%"><{$lang->activity->date}></th>
		        <th width="25%"><{$lang->activity->pataMenCount}></th>
		        <th width="25%"><{$lang->activity->menCountOverForty}></th>
		        <th width="25%"><{$lang->activity->participationRate}></th>
			</tr>
			<{foreach name=loop from=$viewData.data key=date  item=item}>
			<tr class='<{cycle values="trEven,trOdd"}>'>
				<td><{$date}></td>
				<td><{$item.men_count}></td>
				<td><{$item.men_count_over_forty}></td>
				<td><{math equation="x/y*100" x=$item.men_count y=$item.men_count_over_forty format="%.2f"}>%</td>
			</tr>
			<{foreachelse}>
			<font color='red'><{$lang->page->noData}></font>
			<{/foreach}>
		</table>
	</div>
<{else}>
<{*<font color='red'><{$lang->page->noData}></font>*}>
<{/if}>

</body>
</html>
