<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
	function changePage(page){
		$("#page").val(page);
		$("#searchform").submit();
	}
	$(document).ready(function(){
		$("#role_name").keydown(function(){
			$("#role_id").val('');
			$("#account_name").val('');
		});
		$("#account_name").keydown(function(){
			$("#role_id").val('');
			$("#role_name").val('');
		});

	});
</script>

<title><{$lang->menu->playerOpinion}></title>

</head>

<body>

<div id="position">
	<b><{$lang->menu->class->msgManage}>：<{$lang->menu->playerOpinion}></b>
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

<!-- Start 账号和角色名搜索  -->
<form action="?action=search" id="searchform" method="GET" >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="auto">
		<tr>
			<td>
				<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
			</td>
			<td>
				<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
			</td>

			<td align="right"><{$lang->page->accountName}>：</td>
			<td><input type="text" name="account_name" id="account_name" value="<{$account_name}>" /></td>
			<td align="right"><{$lang->page->roleName}>：</td>
			<td><input type="text" name="role_name" id="role_name" value="<{$role_name}>" /></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2"  /></td>
			
			<td>
				<input type="submit" name="today" id="today" value="<{$lang->page->today}>" />
				<{*
				<input type="submit" name="preday" id="preday" value="<{$lang->page->preday}>" />
				<input type="submit" name="nextday" id="nextday" value="<{$lang->page->afterday}>" />
				*}>
			</td>
			
		</tr>
	</table>
	<br />
	<!-- 分页显示 -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
        <tr>
            <td height="30" class="even">
                <{foreach key=key item=item from=$pagelist}><a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>');"><{$key}></a>
                <span style="width:5px;"></span>
                <{/foreach}><{$lang->page->record}>(<{$counts}>)&nbsp;&nbsp;&nbsp;<{$lang->page->totalPage}>(<{$pageCount}>)<{$lang->page->everyPage}><input type="text" id="record" name="record" size="4" style="text-align:center;" value="<{$pageNum}>"><{$lang->page->row}><{$lang->page->dang}><input id="page" name="page" type="text" class="text" size="3" maxlength="6" style="text-align:center;" value="<{$pageno}>"><{$lang->page->page}>&nbsp;<input id="btnGo" type="submit" class="button" name="Submit" value="GO">
            </td>
        </tr>
    </table>
	
</form>
<!-- End 账号和角色名搜索  -->

<{ if $opinion_list }>
	<table class="DataGrid sortable table_list" cellspacing="0" style="margin-bottom:20px;">
		
		<tr>
			<th width="10%"><{$lang->page->accountName}></th>
			<th width="10%"><{$lang->page->roleName}></th>
			<th width="10%"><{$lang->page->time}></th>
			<th width="55%"><{$lang->page->content}></th>

		</tr>
	
			<{foreach from=$opinion_list item=opinion_log name=opinion_log_loop}>
		    <tr align="center" <{ if $smarty.foreach.opinion_log_loop.index is odd }> class="odd"<{ /if }> >
				<td><{ $opinion_log.account_name}>&nbsp;</td>
				<td><{ $opinion_log.role_name}>&nbsp;</td>
				<td><{ $opinion_log.mtime|date_format:'%Y-%m-%d %H:%M:%S'}>&nbsp;</td>
		        <td><{ $opinion_log.content }>&nbsp;</td>
			</tr>
			<{/foreach}>
	</table>


<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
</body>
</html>