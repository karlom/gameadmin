<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->wealthStatistics}>
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
</head>

<body>
<div id="position">
<b><{$lang->menu->class->baseData}>：<{$lang->menu->wealthStatistics }></b>
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
<{$lang->basedata->chooseVersion}>: <{html_options options=$history selected=$selectedVersion name='selected_version'}>
<{$lang->basedata->chooseWealthType}>: <{html_options options=$dictWealthType selected=$selectedType name='selected_type'}>
<input type="hidden" name="search" value="1"/>
<input type="hidden" name="pageSize" value="100"/>
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>
</div>
<div class="main-container">
<{if $viewData.data}>
<table>
<{foreach name=loop from=$viewData.data item=recordSet key=type}>
<{ if $smarty.foreach.loop.index is even }> 
<tr>
<{ /if }>
<td valign="top">
<table cellspacing="1" cellpadding="3" border="0" class="table_list" style="table-layout:fixed; width:550px;" >
	<caption class='table_list_head'>
		<{$dictWealthType[$type] }><{$lang->basedata->statistics}>
	</caption>
	<tr class='table_list_head'>
		<th align="center" width="25%"><{$lang->basedata->range}></th>
		<th align="center" width="15%"><{$lang->basedata->menCount}></th>
		<th align="center" width="15%"><{$lang->basedata->menCountPercentage}></th>
		<th align="center" width="15%"><{$lang->basedata->total}></th>
		<th align="center" width="15%"><{$lang->basedata->totalPercentage}></th>
		<th align="center" width="15%"><{$lang->basedata->menAvg}></th>
	</tr>
	<{foreach from=$recordSet.data item=record}>
	<tr class='<{cycle name="inner" values="trEven,trOdd"}>'>
		<td align="center">
			<{if $record.begin eq $record.end}>
				<{$record.begin}>
			<{else}>
				<{if $record.begin >= 0}><{$record.begin}><{else}>∞<{/if}> - <{if $record.end >= 0}><{$record.end}><{else}>∞<{/if}>
			<{/if}>
		</td>
		<td align="center"><{$record.men_count}></td>
		<td align="center"><{$record.men_count_percentage}>%</td>
		<td align="center"><{$record.total_value}></td>
		<td align="center"><{$record.total_value_percentage}>%</td>
		<td align="center"><{$record.avg_value}></td>
	</tr>
	<{/foreach}>
	<tfoot>
	<tr class='table_list_head'>
		<td align="center"><{$lang->basedata->addUp}></td>
		<td align="center"><{$recordSet.total_men_count}></td>
		<td>&nbsp;</td>
		<td align="center"><{$recordSet.total_value_count}></td>
		<td>&nbsp;</td>
		<td align="center"><{math equation="x/y" x=$recordSet.total_value_count y=$recordSet.total_men_count format="%.2f"}></td>
	</tr>
	</tfoot>
</table>
</td>
<{ if $smarty.foreach.loop.index is odd or $smarty.foreach.loop.total eq 1}> 
</tr>
<{ /if }>
<{/foreach}>
</table>
<{else}>
<{*<font color='red'><{$lang->page->noData}></font>*}>
<{/if}>
</div>
</body>
</html>
