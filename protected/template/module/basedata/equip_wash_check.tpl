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
	.wash {
		width:20%;
	}
</style>
</head>
<title><{$lang->menu->paySort}></title>

<body>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->wash}></b>
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
<div style="color:#ff0000; font-weight:bolder;"><{$lang->wash->sort}></div>
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
                <th><{$lang->page->date}></th>
		<th><{$lang->sys->account}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->sys->playerLevel}></th>
		<th><{$lang->wash->equipUid}></th>
		<th><{$lang->wash->equipId}></th>
		<th><{$lang->wash->equipColor}></th>
		<th><{$lang->wash->stoneId}></th>
		<th><{$lang->wash->equipOldAttr}></th>
		<th><{$lang->wash->equipOldAttrStar}></th>
		<th><{$lang->wash->equipNewAttr}></th>
		<th><{$lang->wash->equipNewAttrStar}></th>
		<th><{$lang->wash->operate}></th>
	</tr>
	<{foreach name=loop from=$viewData item=item key=key}>
		<tr class='<{cycle values="trEven,trOdd"}>'>
                        <td class='close'><{$item.mtime|date_format:"%Y-%m-%d %H:%M:%S"}></td>
			<td class='close'><{$item.account_name}></td>
			<td class='close'><{$item.role_name}></td>
			<td class='close'><{$item.level}></td>
			<td class='close'><{$item.equip_uid}></td>
			<td class='close'><{$arrItemsAll[$item.equip_id].name}></td>
			<td class='close'><{$item.equip_color}></td>
			<td class='close'><{$arrItemsAll[$item.stone_id].name}></td>
			<td class='close'><{$item.equip_old_attr}></td>
			<td class='close'><{$item.equip_old_attr_star}></td>
			<td class='close'><{$item.equip_new_attr}></td>
			<td class='close'><{$item.equip_new_attr_star}></td>
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
									<td class='wash'><{$lang->wash->attr}></td>
									<td><{$lang->wash->power}></td>
									<td><{$lang->wash->phy}></td>
									<td><{$lang->wash->energy}></td>
									<td><{$lang->wash->steps}></td>
									<td><{$lang->wash->atk}></td>
									<td><{$lang->wash->def}></td>
									<td><{$lang->wash->maxHp}></td>
									<td><{$lang->wash->maxMp}></td>
								</tr>
								<tr class='color'>
									<td class='wash'><{$lang->wash->equipOldAttr}></td>
									<td><{$item.old.power}></td>
									<td><{$item.old.phy}></td>
									<td><{$item.old.energy}></td>
									<td><{$item.old.steps}></td>
									<td><{$item.old.atk}></td>
									<td><{$item.old.def}></td>
									<td><{$item.old.maxHp}></td>
									<td><{$item.old.maxMp}></td>
								</tr>
								<tr class='color'>
									<td class='wash'><{$lang->wash->equipOldAttrStar}></td>
									<td><{$item.oldStar.power}></td>
									<td><{$item.oldStar.phy}></td>
									<td><{$item.oldStar.energy}></td>
									<td><{$item.oldStar.steps}></td>
									<td><{$item.oldStar.atk}></td>
									<td><{$item.oldStar.def}></td>
									<td><{$item.oldStar.maxHp}></td>
									<td><{$item.oldStar.maxMp}></td>
								</tr>
								<tr class='color'>
									<td class='wash'><{$lang->wash->equipNewAttr}></td>
									<td><{$item.new.power}></td>
									<td><{$item.new.phy}></td>
									<td><{$item.new.energy}></td>
									<td><{$item.new.steps}></td>
									<td><{$item.new.atk}></td>
									<td><{$item.new.def}></td>
									<td><{$item.new.maxHp}></td>
									<td><{$item.new.maxMp}></td>
								</tr>
								<tr class='color'>
									<td class='wash'><{$lang->wash->equipNewAttrStar}></td>
									<td><{$item.newStar.power}></td>
									<td><{$item.newStar.phy}></td>
									<td><{$item.newStar.energy}></td>
									<td><{$item.newStar.steps}></td>
									<td><{$item.newStar.atk}></td>
									<td><{$item.newStar.def}></td>
									<td><{$item.newStar.maxHp}></td>
									<td><{$item.newStar.maxMp}></td>
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

