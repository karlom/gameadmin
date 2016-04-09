<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><{$lang->menu->economySystem}></title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	</head>
	<body>
		<div id="position"><{$lang->menu->class->economySystem}>：<{$lang->menu->goldDouble}></div>
		
		<form method="get">
			<{$lang->page->beginTime}>: <input type="text" id="startDate" name="startDate" class="Wdate" size="12" value="<{$startDate}>" onfocus="WdatePicker({el:'startDate',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDate\')}'})" />
			<{$lang->page->endTime}>: <input type="text" id="endDate" name="endDate" class="Wdate" size="12" value="<{$endDate}>" onfocus="WdatePicker({el:'endDate',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDate\')}',maxDate:'<{$maxDate}>'})" />
			<input type="submit" id="search" name="search" value="<{$lang->page->serach}>" />
		</form>
		<br />
		
		<table class="DataGrid" style="width:1000px;">	
            <{if $viewData}>
			<tr align="center" >
				<th>使用仙石翻倍人数 </th>
                <th>获得5倍人数/绑定仙石总数 </th>
				<th>获得10倍人数/绑定仙石总数 </th>
				<th>获得20倍人数/绑定仙石总数 </th>
				<th>获得30倍人数/绑定仙石总数 </th>
                <th>产出绑定仙石总数  </th>
			</tr>    
			<tr align="center" class='<{cycle values="trEven,trOdd"}>' >
				<td><{$viewData.goldTotal}></td>
				<td><{$viewData.five_person}>/<{$viewData.five}></td>
				<td><{$viewData.ten_person}>/<{$viewData.ten}></td>
				<td><{$viewData.twenty_person}>/<{$viewData.twenty}></td>
                <td><{$viewData.thirty_person}>/<{$viewData.thirty}></td>
                <td><{$viewData.liquanTotal}></td>
			</tr>
			<{else}>
			<tr><td colspan="5"><b><{$lang->page->noData}></b></td></tr>
			<{/if}>
		</table>
		<br />

	</body>
</html>