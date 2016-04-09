<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/tr/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><{$lang->menu->onlineCharts}></title>
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<div id="position"><{$lang->menu->class->spendData}>：<{$lang->menu->goldConsumeChartsByLevel}></div>

<div class='divOperation'>
<form name="myform" method="post" action="">
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
	&nbsp;&nbsp;
	<{$lang->page->type}>：
	<select id="is_bind" name="is_bind" >
		<{html_options options=$isBindArray selected=$isBind }>
	</select>
	<{$lang->page->consumeType}>：
	<select id="view_type" name="view_type" >
		<option value="all"><{$lang->page->showType1}></option>
		<{html_options options=$goldType selected=$viewType }>
	</select>
	<label><{$lang->gold->dec_send_gold}><input type="checkbox" name="filter" <{if $filter}>checked<{/if}> /></label>
	<input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  />
</form>
</div>
<div style="margin-top: 15px;"><{$lang->page->goldConsumeLevelDis}>
<table style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid; BORDER-COLLAPSE: collapse; BACKGROUND-COLOR: white; width:<{$smarty.const.GAME_MAXLEVEL*25}>px" cellSpacing=0 cellPadding=0 border=0>
<tbody>
	<tr class="trEven">
		<th style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid;width: 25px;"><{$lang->page->allGoldConsume}></th>
		<{foreach name=loop from=$viewData.all_gold item=item}>
		<{if 0 < $viewData.max_gold}>
		<{assign var=height value=$item/$viewData.max_gold*120}>
		<{else}>
		<{assign var=height value=0}>
		<{/if}>
		<td valign="bottom" style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid;width: 25px;" align="middle">
			<{$item}><br />
			<hr style="height: <{$height}>px" class="<{if $height>120*0.8}>hr_red<{else}>hr_green<{/if}>"></hr>
		</td>
		<{/foreach}>	
	</tr>
	<tr class="trOdd">
		<th style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid;width: 25px;"><{$lang->page->allAmount}></th>
		<{foreach name=loop from=$viewData.num item=item}>
		<{if 0 < $viewData.max_num}>
		<{assign var=height value=$item/$viewData.max_num*120}>
		<{else}>
		<{assign var=height value=0}>
		<{/if}>
		<td valign="bottom" style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid;width: 25px;" align="middle">
			<{$item}><br />
			<hr style="height: <{$height}>px" class="<{if $height>120*0.8}>hr_red<{else}>hr_green<{/if}>"></hr>
		</td>
		<{/foreach}>	
	</tr>
	<tr class="trEven">
		<th style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid;width: 25px;"><{$lang->page->opTimes}></th>
		<{foreach name=loop from=$viewData.times item=item}>
		<{if 0 < $viewData.max_times}>
		<{assign var=height value=$item/$viewData.max_times*120}>
		<{else}>
		<{assign var=height value=0}>
		<{/if}>
		<td valign="bottom" style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid;width: 25px;" align="middle">
			<{$item}><br />
			<hr style="height: <{$height}>px" class="<{if $height>120*0.8}>hr_red<{else}>hr_green<{/if}>"></hr>
		</td>
		<{/foreach}>	
	</tr>
	<tr class="trOdd">
		<th style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid;width: 25px;"><{$lang->page->level}></th>
		<{foreach name=loop from=$viewData.level item=item}>
		<td style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid;width: 25px;" align="middle">
			<{$item}>
		</td>
		<{/foreach}>	
	</tr>
</tbody>
</table>
</div>
</body>
</html>