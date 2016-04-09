<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><{$lang->menu->veinLevelRank}></title>
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<script type="text/javascript">

	</script>
	
</head>
<body>
	<div id="position">
		<b><{$lang->menu->class->rankData}>：<{$lang->menu->veinLevelRank}></b>
	</div>
	
	<div><{$lang->page->serverOnlineDate}>: <{$minDate}> &nbsp; <{$lang->page->today}>: <{$maxDate}></div>
	
	<br />
	<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
		<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="selectDate" id="selectDate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" value="<{$selectDate}>"></td>
		<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
	</form>

	
	<br />
	
	<div><h3><{$lang->menu->veinLevelRank}>：</h3></div>
	<br />
	<{if $viewData}>
	<table class="DataGrid" style="width:960px">
			<tr >
				<th><{$lang->rank->rank}></th>
				<th><{$lang->page->veinLv}></th>
				<th><{$lang->player->roleName}></th>
			</tr>
			
		<{foreach from=$viewData item=item name=level key=key}>
			<tr align="center">
				<td><{$key+1}></td>
				<td><{$item.level}></td>
				<td><a target="_blank" href="../../module/player/player_status.php?action=search&role%5Brole_name%5D=<{$item.role_name}>"><u><{$item.role_name}></u></a></td>
			</tr>
		<{/foreach}>
	</table>
	<{else}>		
		<div><{$lang->page->noData}></div>
	<{/if}>
		
	<br />

</body>
</html>