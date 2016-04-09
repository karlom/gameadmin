<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->goldConsumeSort}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>

<script type="text/javascript" >
$(document).ready(function(){
	$("a[class=sort_type]").click(function(){
		$("input[id=sort_type]").val($(this).attr("pvalue"));
		$("#myform").submit();
	});
});
	function changePage(page){
		$("#page").val(page);
		$("#myform").submit();
	}
</script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->spendData}>：<{$lang->menu->goldConsumeSort}></b>
</div>

<form id="myform" name="myform" method="post" action="">
<table style="margin:5px;">
	<tr>
		<td><{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="dateStart" id="dateStart" onfocus="WdatePicker({el:'dateStart',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'dateEnd\')}'})" value="<{$dateStart}>"></td>
		<td><{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="dateEnd" id="dateEnd" onfocus="WdatePicker({el:'dateEnd',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'dateStart\')}',maxDate:'<{$maxDate}>'})"  value="<{$dateEnd}>"></td>
		<td><input id="sort_type" name="sort_type" type="hidden" value="<{$sort_type}>" /><input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  /></td>
		<td><input type="button" class="button" name="datePrev" value="<{$lang->page->today}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrToday}>&dateEnd=<{$dateStrToday}>';"></td>
		<td><input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrPrev}>&dateEnd=<{$dateStrPrev}>';"></td>
		<td><input type="button" class="button" name="datePrev" value="<{$lang->page->nextTime}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrNext}>&dateEnd=<{$dateStrNext}>';"></td>
		<td><input type="button" class="button" name="datePrev" value="<{$lang->page->allTime}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrOnline}>&dateEnd=<{$dateStrToday}>';"></td>
	</tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
  <tr>
    <td height="30" class="even">
 <{foreach key=key item=item from=$pageList}>
 <a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>');"><{$key}></a><span style="width:5px;"></span>
 <{/foreach}>
<{$lang->page->record}>(<{$record}>)&nbsp;&nbsp;&nbsp;<{$lang->page->totalPage}>(<{$pageCount}>)
  <{$lang->page->dang}><input id="page" name="page" type="text" class="text" size="3" maxlength="6" style="text-align:center;" value="<{$pageNo}>" ><{$lang->page->page}>&nbsp;<input id="btnGo" type="submit" class="button" name="Submit" value="GO">
    </td>
  </tr>
</table>
<table cellspacing="1" cellpadding="3" border="0" class='table_list'>
	<tr class='table_list_head'>
        <th width="5%"><{$lang->gold->rank}></th>
        <th width="6%"><{$lang->player->roleName}></th>
        <th width="5%"><{$lang->player->accountName}></th>
        <th width="6%">
        	<{$lang->gold->gold_consume}><{$lang->gold->total}>
        	<a class="sort_type" href="javascript: void(0);" pvalue="total desc" title="升序排序"><span <{if 'total desc'==$sort_type}>class="red"<{/if}>>↑</span></a> 
        	<a class="sort_type" href="javascript: void(0);" pvalue="total" title="降序排序"><span <{if 'total'==$sort_type}>class="red"<{/if}>>↓</span></a>
        </th>
        <th width="5%"><{$lang->page->loginAlarm}></th>
        <th width="5%"><{$lang->page->payAlarm}></th>
	</tr>
	
<{foreach name=loop from=$result item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center"><{$item.rank}></td>
		<td align="center"><a href="../gold/gold_use_record.php?role[roleName]=<{$item.roleName}>"><{$item.roleName}></a></td>
		<td align="center"><a href="../gold/gold_use_record.php?role[accountName]=<{$item.accountName}>"><{$item.accountName}></a></td>
		<td align="center"><{$item.consumeTotal}></td>
		<{if $item.lastLoginTime}><td align="center" class="red"><{$item.lastLoginTime}><{else}><td align="center" >-<{/if}></td>
		<{if $item.lastPayTime}><td align="center" class="red"><{$item.lastPayTime}><{else}><td align="center" >-<{/if}></td>
	</tr>
<{foreachelse}>
	<font color='red'><{$lang->page->noData}></font>
<{/foreach}>
</table>
</div>
</form>
</body>
</html>
