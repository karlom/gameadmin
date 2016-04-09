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
	.trEven, .trOdd{
		text-align:center;
	}
</style>
</head>
<title><{$lang->menu->paySort}></title>

<body>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->make}></b>
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
		<th><{$lang->make->materialOne}></th>
		<th><{$lang->make->materialOneNum}></th>
		<th><{$lang->make->materialTwo}></th>
		<th><{$lang->make->materialTwoNum}></th>
		<th><{$lang->make->materialThree}></th>
		<th><{$lang->make->materialThreeNum}></th>
		<th><{$lang->make->materialFour}></th>
		<th><{$lang->make->materialFourNum}></th>
		<th><{$lang->make->materialFive}></th>
		<th><{$lang->make->materialFiveNum}></th>
		<th><{$lang->make->materialSix}></th>
		<th><{$lang->make->materialSixNum}></th>
		<th><{$lang->make->productUid}></th>
		<th><{$lang->make->product}></th>
		<th><{$lang->make->productNum}></th>
		<th><{$lang->make->cost}></th>
	</tr>
	<{foreach name=loop from=$viewData item=item key=key}>
		<tr class='<{cycle values="trEven,trOdd"}>'>
			<td class='close'><{$item.account_name}></td>
			<td class='close'><{$item.role_name}></td>
			<td class='close'><{$item.level}></td>
			<td class='close'>
					<{if $arrItemsAll[$item.material_one]}><{$arrItemsAll[$item.material_one].name}>
					<{else}><{$item.material_one}><{/if}>
			</td>
			<td class='close'><{$item.material_count_one}></td>
			<td class='close'>
					<{if $arrItemsAll[$item.material_two]}><{$arrItemsAll[$item.material_two].name}>
					<{else}><{$item.material_two}><{/if}>
			</td>
			<td class='close'><{$item.material_count_two}></td>
			<td class='close'>
					<{if $arrItemsAll[$item.material_three]}><{$arrItemsAll[$item.material_three].name}><{else}><{$item.material_three}><{/if}>
			</td>
			<td class='close'><{$item.material_count_three}></td>
			<td class='close'>
					<{if $arrItemsAll[$item.material_four]}><{$arrItemsAll[$item.material_four].name}><{else}><{$item.material_four}><{/if}>
			</td>
			<td class='close'><{$item.material_count_four}></td>
			<td class='close'>
					<{if $arrItemsAll[$item.material_five]}><{$arrItemsAll[$item.material_five].name}><{else}><{$item.material_five}><{/if}></td>
			<td class='close'><{$item.material_count_five}></td>
			<td class='close'>
					<{if $arrItemsAll[$item.material_six]}><{$arrItemsAll[$item.material_six].name}><{else}><{$item.material_six}><{/if}></td>
			<td class='close'><{$item.material_count_six}></td>
			<td class='close'><{$item.product_uid}></td>
			<td class='close'><{$item.product}></td>
			<td class='close'><{$item.product_count}></td>
			<td class='close'><{$item.cost}></td>
		</tr>

	<{/foreach}>
</table>
</form>
</body>
</html>

