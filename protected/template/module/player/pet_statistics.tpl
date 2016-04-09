<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->petStatistics}>
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
	var chartbylevel,chartbypet; 	
	$(document).ready(function() {
		chartbylevel = new Highcharts.Chart({
	        chart: {
	            renderTo: 'bylevelcontainer',
	            defaultSeriesType: 'spline',
		        type:'column'
	        },
	        title: {
	            text: '<strong><{$lang->pet->petFirstStatistics}></strong>'
	        },
	        xAxis: {
	            categories: [<{foreach from=$viewData.data.byLevel name=loop_level key=key item=item}>
								'<{$key}>'<{if !$smarty.foreach.loop_level.last}>,<{/if}>
							<{/foreach}>
					]
	        },	
	        yAxis: {
				title: {
					text: '<{$lang->pet->quantity}>(<{$lang->pet->percentage}>)'
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
					   this.y +'<{$lang->pet->amount}>(' + (this.y*100/<{$viewData.all_men_acount}>).toFixed(2) + '%)';
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
		        name:'<{$lang->pet->playerLevel}>',
	            data:  [ 
					<{foreach from=$viewData.data.byLevel name=loop_men_count key=key item=item}>
						<{$item}><{if !$smarty.foreach.loop_men_count.last}>,<{/if}>
					<{/foreach}>
			      ]  
	        }]
		});        

		
		chartbypet = new Highcharts.Chart({
	        chart: {
	            renderTo: 'bypetcontainer',
	            defaultSeriesType: 'spline',
		        type:'column'
	        },
	        title: {
	            text: '<strong><{$lang->pet->petSymbolUseStatistics}></strong>'
	        },
	        xAxis: {
	            categories: [<{foreach from=$viewData.data.byPet name=loop_pet_name key=key item=item}>
								'<{$dictPet[$key]}>'<{if !$smarty.foreach.loop_pet_name.last}>,<{/if}>
							<{/foreach}>
					]
	        },	
	        yAxis: {
				title: {
					text: '<{$lang->pet->quantity}>(<{$lang->pet->percentage}>)'
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
					  this.x +'：'+ this.y +'<{$lang->pet->amount}>(' + (this.y*100/<{$viewData.all_pet_acount}>).toFixed(2) + '%)';
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
		        name:'<{$lang->pet->petName}>',
	            data:  [ 
					<{foreach from=$viewData.data.byPet name=loop_pet_count key=key item=item}>
						<{$item}><{if !$smarty.foreach.loop_pet_count.last}>,<{/if}>
					<{/foreach}>
			      ]  
	        }]
		});        
	});	
</script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->petStatistics }></b>
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
	<div id="bylevelcontainer" style="width: 100%; height: 80%"></div>
	<div id="bypetcontainer" style="width: 100%; height: 80%"></div>
<{else}>
<{*<font color='red'><{$lang->page->noData}></font>*}>
<{/if}>

</body>
</html>
