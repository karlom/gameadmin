<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<{$lang->menu->createRoleLoseRate}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<div id="position">
<b><{$lang->menu->class->baseData}>：<{$lang->menu->mapLossRate}></b>
</div>
<div class="clearfix" style="margin-bottom: 5px;">
	<form name="myform2" id="myform2" method="post" action="">
		<div>
    		<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
    		<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
		</div>
		<div>
    		<{$lang->player->map}>:
    		<{foreach name=loop from=$mapArray key=key item=item}>
    			<input name="map_id[]" type="checkbox" value="<{$key}>" /><{$item}> 
    			<{if $smarty.foreach.loop.iteration eq 10}>
    			<br />
    			<{/if}>
    		<{/foreach}>
		</div>
		<div>
			<{$lang->page->level}>:
			<input name="level_min" value="1" maxlength="3" size="4" /> ~ <input name="level_max" value="<{$maxLevel}>" maxlength="3" size="4" />
			<input name="level_per_map" type="checkbox" value="1" /><{$lang->page->mapLossLevelPerMap}>
		</div>
		<div style="margin-left: 300px;">
			<input name="submit" type="submit" value="<{$lang->page->submit}>" />
		</div>
	</form>
	<{if $fileName}>
	<div class="red" style="font-weight: bold;"><{$lang->page->mapLossDes}><{$fileName}></div>
	<{/if}>
</div>
</body>
</html>