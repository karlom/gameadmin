<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
	$("#accountName").keydown(function(){
    	$("#roleName").val('');
    	$("#roleId").val('');
    });
    $("#roleName").keydown(function(){
    	$("#accountName").val('');
    	$("#roleId").val('');
    });
    $("#roleId").keydown(function(){
    	$("#accountName").val('');
    	$("#roleName").val('');
    });
    $("a[id*=open_]").click(function(){
		var ids = $(this).attr("id").split("_");
		$('#all_'+ids[1]).show();				
		$('#open_'+ids[1]).hide();				
		$('#close_'+ids[1]).show();				
    });
    $("a[id*=close_]").click(function(){
		var ids = $(this).attr("id").split("_");
		$('#open_'+ids[1]).show();				
		$('#close_'+ids[1]).hide();				
		$('#all_'+ids[1]).hide();				
    });
	$(".close").click(function(){
			$('.all').hide();				
			$('a[id*=open_]').show();				
			$('a[id*=close_]').hide();				
	});

});
function changeDate(dateStr,dateEnd){
	if(dateEnd==''){
		$("#starttime").val(dateStr);
		$("#endtime").val(dateStr);
	}else{
		$("#starttime").val(dateStr);
		$("#endtime").val(dateEnd);
	}
	$("#myform").submit();
}
function load_out(){
		$("#excel").val('true');
		$("#myform").submit();
		$("#excel").val('');
}
</script>
<style type="text/css">
	.color{
		color:#0000ff;
	}
</style>
</head>
<title><{$lang->menu->paySort}></title>

<body>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->inherit}></b>
</div>
<div class='divOperation'>
<form name="myform" id="myform" method="post" action="<{$smarty.const.URL_SELF}>">
	<{$lang->page->roleName}>:<input type="text" id="roleName" name="role[roleName]" size="10" value="<{$role.roleName}>" />
	<{$lang->page->accountName}>:<input type="text" id="accountName" name="role[accountName]" size="10" value="<{$role.accountName}>" />
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' />
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> &nbsp;
	<label><{$lang->gold->dec_send_gold}><input type="checkbox" name="filter" <{if $filter}>checked<{/if}> /></label>
	<input id="search" name="search" type="hidden" value="search" />&nbsp;
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />&nbsp;
	<input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateStrToday}>','');">&nbsp;&nbsp;
	<input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="changeDate('<{$dateStrPrev}>','');">&nbsp;&nbsp;
	<input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="changeDate('<{$dateStrNext}>','');">&nbsp;&nbsp;
	<input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$dateOnline}>','<{$dateStrToday}>');"></br>
</div>
<script type="text/javascript">
        function changePage(page){
                $("#page").val(page);
                $("#myform").submit();
        }
</script>
<div style="color:#ff0000; font-weight:bolder;"><{$lang->inherit->sort}></div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
	<tr>
		<td height="30" class="even">
			<{foreach key=key item=item from=$pageList}>
				<a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>');"><{$key}></a><span style="width:5px;"></span>
			<{/foreach}>
			<{$lang->page->record}>(<{$recordCount}>)&nbsp;&nbsp;&nbsp;<{$lang->page->totalPage}>(<{if $pageCount}><{$pageCount}><{else}>1<{/if}>)
			<{$lang->page->everyPage}>
			<input type="text" id="pageLine" name="pageLine" size="4" style="text-align:center;" value="<{$pageLine}>">
			<{$lang->page->row}>
			<{$lang->page->dang}>
			<input id="page" name="page" type="text" class="text" size="3" style="text-align:center;" maxlength="6" value="<{$page}>">
			<{$lang->page->page}>&nbsp;
			<input type="submit" class="button" name="Submit" value="GO">&nbsp;
		</td>
	</tr>
</table>
<table class="DataGrid" cellspacing="0" style="margin:5px;">
	<tr>
		<th><{$lang->sys->account}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->sys->playerLevel}></th>
		<th><{$lang->inherit->equipt}></th>
		<th><{$lang->inherit->quality}></th>
		<th><{$lang->inherit->main}></th>
		<th><{$lang->inherit->ass}></th>
		<th><{$lang->inherit->strenghthen}></th>
		<th><{$lang->inherit->washAttr}></th>
		<th><{$lang->inherit->washStar}></th>
		<th><{$lang->inherit->operate}></th>
	</tr>
	<{foreach name=loop from=$viewData item=item key=key}>
		<tr class='<{cycle values="trEven,trOdd"}>' style='text-align:center;'>
			<td class='close'><{$item.account_name}></td>
			<td class='close'><{$item.role_name}></td>
			<td class='close'><{$item.level}></td>
			<td class='close'><{$arrItemsAll[$item.high_id].name}></td>
			<td class='close'><{$item.high_quality}></td>
			<td class='close'><{$item.high_main_change}></td>
			<td class='close'><{$item.high_ass_change}></td>
			<td class='close'><{$item.after_strengthen}></td>
			<td class='close'><{$item.after_wash_attr_change}></td>
			<td class='close'><{$item.after_wash_star_change}></td>
			<td>
			<a id="open_<{$key}>" style="text-decoration:underline;color:red;display:block;" href="javascript: void(0);"><{$lang->wash->open}></a> 
			<a id="close_<{$key}>" style="text-decoration:underline;color:blue;display:none;" href="javascript: void(0);"><{$lang->wash->close}></a>
			</td>
		</tr>

		<tr id='all_<{$key}>' class='all' style="display:none;">
			<td colspan="15">
						<table class="DataGrid" id='all2_<{$key}>' cellspacing="1" cellpadding="1" border="0"> 
							<tbody id="tbody_<{$key}>">
								<tr class='color'>
									<td class='wash'><{$lang->inherit->attr}></td>
									<td><{$lang->inherit->equipId}></td>
									<td><{$lang->inherit->equipUid}></td>
									<td><{$lang->inherit->equipName}></td>
									<td><{$lang->inherit->quality}></td>
									<td><{$lang->inherit->strengthen}></td>
									<td><{$lang->inherit->main}></td>
									<td><{$lang->inherit->ass}></td>
									<td><{$lang->inherit->washAttr}></td>
									<td><{$lang->inherit->washStar}></td>
								</tr>
								<tr class='color'>
									<td class='wash'><{$lang->inherit->lowEquip}></td>
									<td><{$item.low_id}></td>
									<td><{$item.low_uid}></td>
									<td><{$arrItemsAll[$item.low_id].name}></td>
									<td><{$item.low_quality}></td>
									<td><{$item.low_strengthen}></td>
									<td>0</td>
									<td>0</td>
									<td><{$item.low_wash_attr_change}></td>
									<td><{$item.low_wash_star_change}></td>
								</tr>
								<tr class='color'>
									<td class='wash'><{$lang->inherit->highEquip}></td>
									<td><{$item.high_id}></td>
									<td><{$item.high_uid}></td>
									<td><{$arrItemsAll[$item.high_id].name}></td>
									<td><{$item.high_quality}></td>
									<td>0</td>
									<td><{$item.high_main_change}></td>
									<td><{$item.high_ass_change}></td>
									<td>0</td>
									<td>0</td>
								</tr>
								<tr class='color'>
									<td class='wash'><{$lang->inherit->afterHighEquip}></td>
									<td><{$item.high_id}></td>
									<td><{$item.high_uid}></td>
									<td><{$arrItemsAll[$item.high_id].name}></td>
									<td><{$item.high_quality}></td>
									<td><{$item.after_strengthen}></td>
									<td><{$item.high_main_change}></td>
									<td><{$item.high_ass_change}></td>
									<td><{$item.after_wash_attr_change}></td>
									<td><{$item.after_wash_star_change}></td>
								</tr>
	
							</tbody>
						</table>
			</td>
		</tr>
	<{/foreach}>
</table>
</form>
</body>
</html>

