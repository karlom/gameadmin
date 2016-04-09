<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
	<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
	<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".ajaxRequest").click(function(){
			var url = $(this).attr("url");
			var data = $(this).attr("data");
			if("" != url && "" != data){
				$.ajax({
					type: "POST",
					url: url,
					data: data,
					success: function(data){
						alert(data);
						$("form[id=myform2]").submit();
					}
				});
			}else{
				alert("URL OR DATA CANNOT NULL");
			}
		});
		$("input[id=reloadAll]").click(function(){
		});
	});
	</script>
	<title><{$lang->menu->checkErrorLog}></title>
	</head>

	<body>
		<div id="position"><{$lang->menu->class->serverInfo}>: <{$lang->menu->checkErrorLog}></div>
        <form name="myform2" id="myform2" method="post" action="">
        	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
        	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
        	<input id="search" name="search" type="hidden" value="search" />
        	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />
        	<{if $result}>
        	<input id="reloadAll" class="ajaxRequest" url="<{$smarty.const.URL_SELF}>" data="action=reloadAll&starttime=<{$startDate}>&endtime=<{$endDate}>" type="button" value="<{$lang->page->reload}><{$lang->page->allTime}>" />
        	<{/if}>
        </form>
        <{if $msg}><div class="red"><{$msg}></div><{/if}>
		<table class="table_list" style="width: 100%; margin: 10px 0;">
			<tr class="table_list_head">
				<td width="4%">ID</td>
				<td width="15%"><{$lang->page->directions}></td>
				<td width="25%"><{$lang->page->errorReason}></td>
				<td width="10%"><{$lang->page->time}></td>
				<td width="10%"><{$lang->page->lastReloadTime}></td>
				<td width="5%"><{$lang->page->reload}><{$lang->page->times}></td>
				<td width="10%"><{$lang->page->op}></td>
			</tr>
        	<{foreach from=$result item=item}>
			<tr class="<{cycle values="trEven,trOdd"}>">
				<td><{$item.id}></td>
				<td><{$item.desc}></td>
				<td><{$item.reason|truncate:100:"...":true}></td>
				<td><{$item.mtime|date_format:"%Y-%m-%d %H:%M:%S"}></td>
				<td><{$item.last_try_time|date_format:"%Y-%m-%d %H:%M:%S"}></td>
				<td><{$item.try_times}></td>
				<td><a href="javascript: void(0);" class="ajaxRequest" url="<{$smarty.const.URL_SELF}>" data="action=reloadOne&id=<{$item.id}>&starttime=<{$startDate}>&endtime=<{$endDate}>"><{$lang->page->reload}></a></a></td>
			</tr>
        	<{/foreach}>
		</table>
	</body>
</html>