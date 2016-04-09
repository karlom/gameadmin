<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
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
    $("select[name=excel]").change(function(){
	if($("select[name=excel]").val() == 's'){
		return $("select[name=excel]").val('');
	} else {
		$("#myform").submit();
		$("select[name=excel]").val('');
	}
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
	.hr_red{
		background-color:red;
		width:6px;
	}
</style>
</head>
<title><{$lang->menu->paySort}></title>

<body>
<div id="position">
<b><{$lang->menu->class->payAndSpand}>：<{$lang->menu->goldUserRecord}></b>
</div>
<div class='divOperation'>
<form name="myform" id="myform" method="post" action="<{$smarty.const.URL_SELF}>">
	<{$lang->page->roleName}>:<input type="text" id="roleName" name="role[roleName]" size="10" value="<{$role.roleName}>" />
	<{$lang->page->accountName}>:<input type="text" id="accountName" name="role[accountName]" size="10" value="<{$role.accountName}>" />
	<{$lang->page->strictMatch}>:<input type="checkbox" id="strict" name="strict" value="1" <{if $strictMatch==1}>checked<{/if}> />&nbsp;
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' />
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /></br>
	<{$lang->gold->op_type}>
	<select name="type">
		<{html_options options=$arrType selected=$type}>
	</select>&nbsp;
	<{$lang->page->sort}>:
	<select name="type2">
		<{html_options options=$arrType2 selected=$type2}>
	</select>&nbsp;
	<select name="type3">
		<{html_options options=$arrType2 selected=$type3}>
	</select>&nbsp;

<{*
	<select name="type2">
		<{foreach from=$arrType2 item=item key=key}>
			<option value="<{$key}>" <{if $key=="<{$key}>"}>selected="<{$type2}>"<{/if}>><{$item}></option>
		<{/foreach}>
	</select>
	<select name="type3">
		<{foreach from=$arrType2 item=item key=key}>
			<option value="<{$key}>" <{if $key=="<{$key}>"}>selected="<{$type3}>"<{/if}>><{$item}></option>
		<{/foreach}>
	</select><br>
*}>
	<input id="search" name="search" type="hidden" value="search" />&nbsp;
	<label><{$lang->gold->dec_send_gold}><input type="checkbox" name="filter" <{if $filter}>checked<{/if}> /></label>
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />&nbsp;
	<input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateStrToday}>','');">&nbsp;&nbsp;
	<input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="changeDate('<{$dateStrPrev}>','');">&nbsp;&nbsp;
	<input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="changeDate('<{$dateStrNext}>','');">&nbsp;&nbsp;
	<input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$dateOnline}>','<{$dateStrToday}>');"></br>
	<font color="red"><b><{$lang->gold->goldFlowCount}>: <{$flowGold}><{$lang->gold->gold}></b></font></br>
	<font color="blue"><b><{$lang->gold->attention}></b></font>
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
		<{if $startNum2}>
			<select name="excel" style="color:#ff0000;">
				<{html_options options=$startNum2 selected="请选择"}>
			</select>
		<{else}>
	  		<input type="hidden" name="excel" id="excel" />
  			[ <a href="javascript:void(0);" onclick="load_out();"><{$lang->page->excel}></a> ]
		<{/if}>	
		</td>
	</tr>
</table>
<table class="DataGrid" cellspacing="0" style="margin:5px;">
	<tr>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->sys->account}></th>
		<th><{$lang->sys->playerLevel}></th>
		<th><{$lang->gold->consume}><{$lang->currency->payYBUnbind}><{$lang->page->itemsNum}></th>
		<th><{$lang->gold->consume}><{$lang->currency->bindYuanbao}><{$lang->page->itemsNum}></th>
		<th><{$lang->gold->consume}><{$lang->page->time}></th>
		<th><{$lang->gold->op_type}></th>
		<th><{$lang->item->itemID}> | <{$lang->gold->item_name}></th>
		<th><{$lang->page->itemsNum}></th>
		<th><{$lang->gold->goldBalance}></th>
		<th><{$lang->gold->bind_goldBalance}></th>
	</tr>
	<{foreach name=loop from=$viewData item=item key=key}>
		<tr class='<{cycle values="trEven,trOdd"}>'>
			<td class="cmenu" title="<{$item.role_name}>"><{$item.role_name}>&nbsp;</td>
			<td class="cmenu" title="<{$item.role_name}>"><{$item.account_name}>&nbsp;</td>
			<td><{$item.level}>&nbsp;</td>
			<td <{if 2 == $item.mtype}>class="red"<{/if}>><{if 2 == $item.mtype}>-<{/if}><{$item.gold}>&nbsp;</td>
			<td <{if 2 == $item.mtype}>class="red"<{/if}>><{if 2 == $item.mtype}>-<{/if}><{$item.bind_gold}>&nbsp;</td>
			<td><{$item.mtime|date_format:"%Y-%m-%d %H:%M:%S"}>&nbsp;</td>
			<td>
				<{foreach from=$arrType item=i key=k}>
					<{$i[$item.type]}>
				<{/foreach}>&nbsp;
			</td>
			<td>	
				<{$item.item_id}> | <{$arrItemsAll[$item.item_id].name}>&nbsp;
			</td>
			<td><{$item.num}>&nbsp;</td>
			<td><{$item.remain_gold}>&nbsp;</td>
			<td><{$item.remain_bind_gold}>&nbsp;</td>
		</tr>
	<{/foreach}>
</table>
</form>
</body>
</html>

