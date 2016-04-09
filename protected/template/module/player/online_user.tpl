<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/flowtitle.js"></script>
<script type="text/javascript" src="/static/js/ip.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/highcharts/highcharts.js"></script>
<script type="text/javascript" src="/static/js/highcharts/modules/exporting.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<title><{$lang->menu->onlineUser}></title>
<script type="text/javascript">
$(document).ready(function(){
	$('.filter_display').click(function(){
		if($(this).attr('checked')){
			$('#list_' + $(this).attr('id')).show();
		}else{
			$('#list_' + $(this).attr('id')).hide();
		}
	});
	var menCountMapChart;

	menCountMapChart = new Highcharts.Chart({
	        chart: {
	            renderTo: 'list_map_online',
	            defaultSeriesType: 'spline',
		        type:'column'
	        },
	        title: {
	            text: '<strong><{$lang->player->onlineMap}></strong>'
	        },
	        xAxis: {
	            categories: [
							<{foreach from=$onlineCountByMap key=mapID item=count name=loop_mencount}>
								'<{$dictMap[$mapID].name}>'<{if !$smarty.foreach.loop_mencount.last}>,<{/if}>
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
					text: '<{$lang->player->menCount}>(<{$lang->player->percentage}>)'
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
					return '<b>“' + this.x + '”' + this.series.name +'：</b>'+  
					   this.y +'<{$lang->player->amount}><br/>(' + (this.y*100/<{$onlineList.data|@count}>).toFixed(2) + '%)';
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
		        name:'<{$lang->player->menCount}>',
	            data:  [ 
					<{foreach from=$onlineCountByMap key=mapID item=count name=loop_men_count}>
						{
//							dataLabels :{formatter : function(){ return '<strong><{$count.count}></strong>(<{$count.percentage}>)'} },
							dataLabels :{formatter : function(){ return '<strong><{$count.count}></strong>'} },
							y: <{ $count.count}>
						}
						<{if !$smarty.foreach.loop_men_count.last}>,<{/if}>
					<{/foreach}>
			      ]  
	        }]
		});        
	})
</script>
</head>
<body>



<div id="position"><{$lang->menu->class->onlineAndReg}>：<{$lang->menu->onlineUser}></div>

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
<!-- Start 操作表单  -->
<table>
<tr>
<td>
	<form action="?action=search" id="frm" method="post"  style="display:inline;">
		<table cellspacing="1" cellpadding="5" class="SumDataGrid">
			<tr>
				<td>
				<span class="red">
					<{$lang->player->lastUpdate}> :
					<{$onlineList.timestamp|date_format:'%Y-%m-%d %H:%M:%S'}>
				</span>
				</td>
				<td><input type="submit" name='update'  class="input2 submitbtn"  value="强制更新" /> * <{$lang->player->updateNotice}></td>
				<td>
					<label><input type="checkbox" id="map_online" name="filter_display" class="filter_display" checked="checked"/>地图列表</label>
					<label><input type="checkbox" id="player_online" name="filter_display" class="filter_display" checked="checked"/>玩家列表</label>
					<label><input type="checkbox" id="ip_online" name="filter_display" class="filter_display" checked="checked"/>IP列表</label>
				</td>
			</tr>
		</table>
	</form>
</td>

</tr>
</table>
<br />
<!-- End 操作表单  -->
 <{$lang->player->onlineUserCount}>：<font color="red"><{$onlineList.data|@count}></font>     
 <{$lang->player->onlinePayUserCount}>：<font color="red"><{$payUserCount}></font>
 <{$lang->player->onlineUniqueIPCount}>：<font color="red"><{$onlineListGrouped|@count}></font>
 <div id="list_map_online" style="width:100%; height: 400px;">
 <table class="DataGrid table_list" cellspacing="0" style="margin-bottom:20px;">
	<thead>
	<tr>
		<th width="80px"><{$lang->player->map}></th>
		<{foreach from=$onlineCountByMap key=mapID item=count}>
			<th><{ $dictMap[$mapID].name}></th>
		<{/foreach}>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<th align="center"><{$lang->player->onlineCount}></th>
		<{foreach from=$onlineCountByMap key=mapID item=count}>
			<td align="center"><{ $count.count}></td>
		<{/foreach}>
	</tr>
	<tr>
		<th align="center"><{$lang->player->onlineCountPercentage}></th>
		<{foreach from=$onlineCountByMap key=mapID item=count}>
			<td align="center"><{ $count.percentage}></td>
		<{/foreach}>
	</tr>
	</tfoot>
</table>
</div>
<{* 使用highchart显示地图分布

*}>
<br />
<{ if $onlineList.data }>

<!--  Start  在线列表-->
<table id="list_player_online" class="DataGrid sortable table_list no-resize" cellspacing="0" style="margin-bottom:20px;">

	 <tr class="flowtitle">
		<th width="15%"><{$lang->player->roleName}></th>
		<th width="15%"><{$lang->player->accountName}></th>
		<th width="5%"><{$lang->player->level}></th>
		<th width="10%"><{$lang->player->alreadyOnlineMinute}></th>
		<th width="10%"><{$lang->player->occupation}></th>
		<th width="15%"><{$lang->player->ip}></th>
        <th width="10%"><{$lang->player->map}></th>
        <th width="10%"><{$lang->player->lastCG}></th>

	</tr>


	<{capture name=tableHeader}>
		<tr class="table_list_head" align="center">
			<td width="15%"><{$lang->player->roleName}></td>
			<td width="15%"><{$lang->player->accountName}></td>
			<td width="5%"><{$lang->player->level}></td>
			<td width="10%"><{$lang->player->alreadyOnlineMinute}></td>
			<td width="10%"><{$lang->player->occupation}></td>
			<td width="15%"><{$lang->player->ip}></td>
	        <td width="10%"><{$lang->player->map}></td>
	        <td width="10%"><{$lang->player->lastCG}></td>
		</tr>
	<{/capture}>

		<{foreach from=$onlineList.data item=log key=key name=onlineList_loop}>
	    <tr align="center" class="<{cycle values="trEven,trOdd"}>">
	    
			<td width="15%" class="cmenu" title="<{$log.roleName}>">
			<{if $log.isPay}>
			<!-- 付费玩家添加颜色以区别 -->
				<font color="#ff8800"><{ $log.roleName}>[<{$lang->player->pay}>]</font>
			<{else}>
				<{ $log.roleName}>
			<{/if}>
			&nbsp;</td>
			<td width="15%" class="cmenu" title="<{$log.roleName}>"><{ $log.accountName}>&nbsp;</td>
			<td width="5%"><{ $log.level     }>&nbsp;</td>
	        <td width="10%"><{math equation="x/60" x=$log.onlineTime format="%.1f"}>&nbsp;</td>
			<td width="10%" ><{ $dictOccupationType[$log.occupation] }>&nbsp;</td> 
	        <td width="15%"><a href="javascript:void(0)" class="show-ip"><{ $log.ip}></a>&nbsp;</td>
	        <td width="10%"><{ $dictMap[$log.mapID].name}><font color="blue"><{if $dictMap[$log.mapID].isCopyScene }>[<{ $lang->copyscene->copy }>]<{/if}></font>&nbsp;</td>
	        <td width="10%"><{ $log.lastCG }>&nbsp;</td>
	        <!-- 副本地图添加副本标识 -->
		</tr>

<{*		<{if $smarty.foreach.onlineList_loop.index mod 20 eq 0 and $smarty.foreach.onlineList_loop.index gt 0}>
			<{$smarty.capture.tableHeader}>
		<{/if}>
		*}>
		<{/foreach}>

  

</table>
<!--  End 在线列表-->
<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
 
<{ if $onlineListGrouped }>
<!--  Start  在线列表 IP分组-->
<table id="list_ip_online" class="DataGrid sortable table_list no-resize" cellspacing="0" style="margin-bottom:20px;">

	<tr class="flowtitle">
		<th width="10%"><{$lang->player->ip}></th>
		<th width="10%"><{$lang->player->amountOfSameIP}></th>
		<th width="30%"><{$lang->player->roleName}></th>
        <th width="30%"><{$lang->player->accountName}></th>
	<{*		<th width="20%">&nbsp;</th>*}>

	</tr>

	<{capture name=tableHeader}>
		<tr class="table_list_head" align="center">
		<td width="10%"><{$lang->player->ip}></td>
		<td width="10%"><{$lang->player->amountOfSameIP}></td>
		<td width="30%"><{$lang->player->roleName}></td>
        <td width="30%"><{$lang->player->accountName}></td>
	<{*	<td width="20%">&npsp;</td>*}>
		</tr>
	<{/capture}>

		<{foreach from=$onlineListGrouped item=log key=key name=onlineListGrouped_loop}>
 	    <tr align="center" class="<{cycle values="trEven,trOdd"}>">

			<td width="10%"><a href="javascript:void(0)" class="show-ip" ><{$key}></a>&nbsp;</td>
			<td width="10%"><{ $log.count    }>&nbsp;</td>
	        <td width="30%"><{ $log.roleNameStr }>&nbsp;</td>
			<td width="30%"><{ $log.accountNameStr }>&nbsp;</td>
	<{*		<td width="20%"><a target="_blank" href="http://www.ip138.com/ips.asp?ip=<{$key}>"><{$lang->player->geoIP}></a></td>*}>
	   
		</tr>

	<{*	<{if $smarty.foreach.onlineList_loop.index mod 20 eq 0 and $smarty.foreach.onlineList_loop.index gt 0}>
			<{$smarty.capture.tableHeader}>
		<{/if}>
		*}>
		<{/foreach}>

  

</table>
<!--  End 在线列表 IP分组-->
<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
</body>
</html>