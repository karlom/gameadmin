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
<div id="position"><{$lang->menu->class->onlineAndReg}>：<{$lang->menu->onlineCharts}></div>

<div class='divOperation'>
<form name="myform" method="post" action="">
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
	&nbsp;&nbsp;
	<{$lang->page->samplingUnit}>：
	<select id="viewtype" name="viewtype" >
		<{html_options options=$viewArr selected=$viewType }>
	</select>
	<input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  />
</form>
</div>

<br />
<div><{$lang->page->todayRegister}>: <{$todayRegister}></div>
<br />

<table style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid; BORDER-COLLAPSE: collapse; BACKGROUND-COLOR: white" cellSpacing=0 cellPadding=0 border=0>
<tbody>
	<tr>
		<td style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; FONT-WEIGHT: bold; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid" align="left" colSpan=33>
			<{$startDate}><{$lang->time->day}>~<{$endDate}><{$lang->time->day}>
			<FONT color=red><{$viewArr[$viewType]}></FONT>
			<{$lang->page->trends}>(<{$lang->page->totalAvg}>:<{$viewData.avgOnline}>&nbsp;&nbsp;&nbsp;&nbsp;<{$lang->page->maximum}>：<{$viewData.maxOnline}>)
		</td>
	</tr>
	<tr>
		<td style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid" vAlign="bottom" align="middle">
			<table cellpadding="0" cellspacing="1">
				<tr>
					<{foreach name=loop from=$viewData.data item=item}>
					<td valign="bottom" style="background-color: #D7E4F5;">
						<table cellSpacing=0 cellPadding=0 width=15 border=0 valign="bottom">
							<tbody>
								<tr>
									<td vAlign=bottom align=middle height=20><FONT color=red size=1><{$item.onlineNum}></FONT></td>
								</tr>
								<tr>
									<td vAlign=bottom align=middle><IMG title="<{$lang->page->onlineNum}>：<{$item.onlineNum}>" height="<{$item.height}>" src="/static/images/green.gif" width=10></td>
								</tr>
								<tr>
									<td style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; FONT-SIZE: 8pt; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid; WHITE-SPACE: nowrap; BACKGROUND-COLOR: whitesmoke" align=middle>
										<{if 1 == $viewType}>
										<{$item.mtime|date_format:"%H"}>
										<br/>
										<{/if}>
										<{$item.mtime|date_format:"%m"}>/<{$item.mtime|date_format:"%d"}>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
					<{/foreach}>	
				</tr>
			</table>
		</td>
	</tr>
</tbody>
</table>
</body>
</html>