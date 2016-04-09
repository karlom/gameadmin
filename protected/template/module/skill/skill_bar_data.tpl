<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->skillData}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/sorttable.js"></script>
		<script type="text/javascript">
			     
		</script>
	</head>
	<body>
		<div id="position">
			<b><{$lang->menu->class->baseData}>：<{$lang->menu->skillData}></b>
		</div>
		
	<{if $data}>
		<!-- 武尊 -->
		<div><b>【<{$lang->occupation->wuzun}><{$lang->page->job}>】<{$lang->page->totalNum}>：<{$counter.wuzun}><{$lang->page->ren}></b></div>
		<table class="DataGrid sortable" id="wuzun" >
			<!--caption class="table_list_head" align="center">
				<{$lang->menu->allRoleLog}>
			</caption-->
			<thead>
				<tr align="center">
					<th style="width:10%" ><{$lang->skill->skillName}></th>
			        <th style="width:10%" ><{$lang->skill->selectCount}></th>
			        <th style="width:10%"><{$lang->skill->percentage}></th>
			        <th style="width:10%"><{$lang->skill->noElement}></th>
			        <th style="width:10%"><{$lang->skill->feng}></th>
			        <th style="width:10%"><{$lang->skill->huo}></th>
			        <th style="width:10%"><{$lang->skill->shui}></th>
			        <th style="width:10%"><{$lang->skill->tu}></th>
				</tr>
			</thead>
			
			<{if $data.wuzun}>
			<tbody>
			<{foreach from=$data.wuzun item=logs name=loop}>
				<tr align="center" <{ if $smarty.foreach.loop.index is odd }> class="odd"<{ /if }> >
					<td><{$logs.name}></td>
					<td><{$logs.selectCnt }></td>
					<td><{$logs.perc}></td>
					<td><{$logs.nof}></td>
					<td><{$logs.ff}></td>
					<td><{$logs.hf}></td>
					<td><{$logs.sf}></td>
					<td><{$logs.tf}></td>
				</tr>
			<{/foreach}>
			</tbody>
			<{else}>
				<tr><td colspan="8"><{$lang->page->noData}></td></tr>
			<{/if}>
		</table>
		<!-- 武尊 -->
		<br />
		<!-- 灵修 -->
		<div><b>【<{$lang->occupation->lingxiu}><{$lang->page->job}>】<{$lang->page->totalNum}>：<{$counter.lingxiu}><{$lang->page->ren}></b></div>
		<table class="DataGrid sortable" id="lingxiu" >
			
			<thead>
				<tr align="center">
					<th style="width:10%" ><{$lang->skill->skillName}></th>
			        <th style="width:10%" ><{$lang->skill->selectCount}></th>
			        <th style="width:10%"><{$lang->skill->percentage}></th>
			        <th style="width:10%"><{$lang->skill->noElement}></th>
			        <th style="width:10%"><{$lang->skill->feng}></th>
			        <th style="width:10%"><{$lang->skill->huo}></th>
			        <th style="width:10%"><{$lang->skill->shui}></th>
			        <th style="width:10%"><{$lang->skill->tu}></th>
				</tr>
			</thead>
			
			<{if $data.lingxiu}>
			<tbody>
			<{foreach from=$data.lingxiu item=logs name=loop}>
				<tr align="center" <{ if $smarty.foreach.loop.index is odd }> class="odd"<{ /if }> >
					<td><{$logs.name}></td>
					<td><{$logs.selectCnt }></td>
					<td><{$logs.perc}></td>
					<td><{$logs.nof}></td>
					<td><{$logs.ff}></td>
					<td><{$logs.hf}></td>
					<td><{$logs.sf}></td>
					<td><{$logs.tf}></td>
				</tr>
			<{/foreach}>
			</tbody>
			<{else}>
				<tr><td colspan="8"><{$lang->page->noData}></td></tr>
			<{/if}>
		</table>
		<!-- 灵修 -->
		<br />
		<!-- 剑仙 -->
		<div><b>【<{$lang->occupation->jianxian}><{$lang->page->job}>】<{$lang->page->totalNum}>：<{$counter.jianxian}><{$lang->page->ren}></b></div>
		<table class="DataGrid sortable" id="jianxian" >
			<thead>
				<tr align="center">
					<th style="width:10%" ><{$lang->skill->skillName}></th>
			        <th style="width:10%" ><{$lang->skill->selectCount}></th>
			        <th style="width:10%"><{$lang->skill->percentage}></th>
			        <th style="width:10%"><{$lang->skill->noElement}></th>
			        <th style="width:10%"><{$lang->skill->feng}></th>
			        <th style="width:10%"><{$lang->skill->huo}></th>
			        <th style="width:10%"><{$lang->skill->shui}></th>
			        <th style="width:10%"><{$lang->skill->tu}></th>
				</tr>
			</thead>
			
			<{if $data.jianxian}>
			<tbody>
			<{foreach from=$data.jianxian item=logs name=loop}>
				<tr align="center" <{ if $smarty.foreach.loop.index is odd }> class="odd"<{ /if }> >
					<td><{$logs.name}></td>
					<td><{$logs.selectCnt }></td>
					<td><{$logs.perc}></td>
					<td><{$logs.nof}></td>
					<td><{$logs.ff}></td>
					<td><{$logs.hf}></td>
					<td><{$logs.sf}></td>
					<td><{$logs.tf}></td>
				</tr>
			<{/foreach}>
			</tbody>
			<{else}>
				<tr><td colspan="8"><{$lang->page->noData}></td></tr>
			<{/if}>
		</table>
		<!-- 剑仙 -->
	<{else}>
		<br /><b><{$lang->page->noData}></b>
	<{/if}>
	</body>
</html>