<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->ipAnalyse}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/bigpipe/bigpipe.js"></script>
<script type="text/javascript" src="/static/js/ip.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#iplist').bigPipe({
				url: '/module/player/ip_analysis.php?chunked=1',
				onLoaded: function(json, bind){
					$.each(json, function(i){
						var cn = i % 2 == 0? 'trEven' : 'trOdd';
						bind.append('<tr class="' + cn + '">' + 
								 '<td><a href="javascript:void(0)" class="show-ip">' + this.ip + '</a></td>' +
								 '<td>' + this.cnt + '</td>' +
								 '<td>' + this.min_time + '</td>' +
								 '<td>' + this.max_time + '</td>' +
							  '</tr>');
					})
				},
				dataType: 'json'
			});
})
</script>
</head>

<body>
<!--  
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->ipAnalyse}></b>
</div>
-->
<font><{$lang->page->ipDes}></font>
<table id="iplist" class="DataGrid table_list" cellspacing="1" cellpadding="3" border="0" >
	<tr class='table_list_head'>
        <td><{$lang->player->loginIp}></td>
        <td><{$lang->page->pepole}></td>
        <td><{$lang->player->earlyTime}></td>
        <td><{$lang->player->lastTime}></td>
	</tr>
	
<{foreach name=loop from=$viewData item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><a href="javascript:void(0)" class="show-ip"><{$item.ip}></a></td>
		<td><{$item.cnt}></td>
		<td><{$item.min_time}></td>
		<td><{$item.max_time}></td>
	</tr>
<{foreachelse}>
<font color='red'><{$lang->page->noData}></font>
<{/foreach}>
</table>
</div>
</body>
</html>
