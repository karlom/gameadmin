<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<{$lang->menu->createRoleLoseRate}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript">
function changeDate(startDate, endDate){
	document.myform2.starttime.value = startDate;
	document.myform2.endtime.value = endDate;
	document.myform2.submit();
	//$("#starttime").val(startDate);
	//$("#endtime").val(endDate);	//两种方式赋值和提交表单
	//$("#myform2").submit();	
}
</script>
</head>
<body>
<div id="position">
<b><{$lang->menu->class->baseData}>：<{$lang->menu->createRoleLoseRate}></b>
</div>
<{if '' == $action}>
<div class="clearfix" style="margin-bottom: 5px;">
	<span class="left">
	<form name="myform2" id="myform2" method="post" action="">
		<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
		<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
		<input id="search" name="search" type="hidden" value="search" />
		<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />
		
		<input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$dateOnline}>','<{$dateToday}>');" ></br>
	</form>
	</span>
	<span class="right" style="margin-right: 20px;"><a href="?action=set"><{$lang->page->set}></a></span>
</div>
<{if $viewData}>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width: 100%;">
    <tr class='table_list_head'>
    	<td width="10%">登录请求次数</td>
		<{foreach from=$viewData key=key item=item loop=loop}>
        <td width="10%"><{$item.des}><{$lang->page->pepole}></td>
		<{/foreach}>
	</tr>
    <tr class='trEven'>
    	<td><{$viewData.0.counts}></td>
		<{foreach from=$viewData key=key item=item loop=loop}>
        <td><{$item.user_num}></td>
		<{/foreach}>
    </tr>
</table>
<br />
<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width: 100%;">
    <tr class='table_list_head'>
        <td colspan="5" align="center"><{$lang->page->newCommerLossRate}></td>
	</tr>
</table>
<div style="font-size=12px">
<{foreach from=$viewData key=key item=item name=loop}>
<{if !$smarty.foreach.loop.last}>
<{assign value=$key+1 var="next"}>
<{$viewData[$next].des}><{$lang->page->loseRate}> = ( <{$item.des}><{$lang->page->pepole}> - <{$viewData[$next].des}><{$lang->page->pepole}> ) / <{$item.des}><{$lang->page->pepole}><br />
<{/if}>
<{/foreach}>
</div>
<br />
<{foreach from=$viewData key=key item=item name=loop}>
<{if !$smarty.foreach.loop.last}>
<{assign value=$key+1 var="next"}>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width: 100%;">
    <tr class='table_list_head'>
        <td colspan="5" align="center"><{$viewData[$next].des}><{$lang->page->loseRate}></td>
	</tr>
    <tr class='table_list_head'>
        <td width="20%"><{$item.des}><{$lang->page->pepole}></td>
        <td width="20%"><{$viewData[$next].des}><{$lang->page->pepole}></td>
        <td width="20%"><{$viewData[$next].des}><{$lang->page->loseRate}></td>
        <td width="20%"><{$item.des}><{$lang->page->independentIP}></td>
        <td width="20%"><{$viewData[$next].des}><{$lang->page->independentIP}></td>
	</tr>
    <tr class='trEven'>
        <td width="20%"><{$item.user_num}></td>
        <td width="20%"><{$viewData[$next].user_num}></td>
        <td width="20%"><{if 0 < $item.user_num && 0 < $item.user_num}><{math equation="(x-y)/x*100" x=$item.user_num y=$viewData[$next].user_num format="%.2f"}>%<{else}>N/A<{/if}></td>
        <td width="20%"><{$item.dist_ip_num}></td>
        <td width="20%"><{$viewData[$next].dist_ip_num}></td>
    </tr>
</table>
<br />
<{/if}>
<{/foreach}>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' width="200" style="width: 100%;">
    <tr class='table_list_head'>
        <td colspan="5" align="center"><{$lang->page->totalLoseRate}></td>
	</tr>
    <tr class='table_list_head'>
        <td width="20%"><{$viewData[0].des}><{$lang->page->pepole}></td>
        <td width="20%"><{$viewData[$next].des}><{$lang->page->pepole}></td>
        <td width="20%"><{$lang->page->totalLoseRate}></td>
        <td width="20%"><{$viewData[0].des}><{$lang->page->independentIP}></td>
        <td width="20%"><{$viewData[$next].des}><{$lang->page->independentIP}></td>
	</tr>
    <tr class='trEven'>
        <td width="20%"><{$viewData[0].user_num}></td>
        <td width="20%"><{$viewData[$next].user_num}></td>
        <td width="20%"><{if 0 < $viewData[0].user_num && 0 < $viewData[0].user_num}><{math equation="(x-y)/x*100" x=$viewData[0].user_num y=$viewData[$next].user_num format="%.2f"}>%<{else}>N/A<{/if}></td>
        <td width="20%"><{$viewData[0].dist_ip_num}></td>
        <td width="20%"><{$viewData[$next].dist_ip_num}></td>
    </tr>
</table>
<{/if}>
<{elseif "set" == $action}>
<form method="POST" action="<{$smarty.const.URL_SELF}>?action=submit">
<div style="text-align: right;"><input id="add" type="button" value="<{$lang->page->add}>" /> <input id="submit" type="submit" value="<{$lang->page->submit}>" /> <input id="back" type="button" value="<{$lang->page->back}>" /></div>
<table id="set_type_tbl" cellspacing="1" cellpadding="3" border="0" class='table_list' style="width: 100%;">
    <tr class='table_list_head'>
        <td width="20%">ID</td>
        <td width="20%"><{$lang->page->description}></td>
        <td width="20%"><{$lang->page->sort}></td>
        <td width="20%"><{$lang->player->operate}></td>
	</tr>
	<{if $steps}>
	<{foreach from=$steps item=item key=key}>
	<tr class='<{cycle values="trEven, trOdd"}>'>
		<td><input name="id[]" type="text" value="<{$item.id}>" /></td>
		<td><input name="des[]" type="text" value="<{$item.des}>" style="width: 250px;" /></td>
		<td><input name="sort[]" type="text" value="<{$item.sort}>" /></td>
		<td><a id="del_<{$key}>" href="javascript: void(0);" pvalue="<{$key}>"><{$lang->page->del}></a></td>
	</tr>
	<{/foreach}>
	<{else}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><input name="id[]" type="text" value="" /></td>
		<td><input name="des[]" type="text" value="" style="width: 250px;" /></td>
		<td><input name="sort[]" type="text" value="" /></td>
		<td><a id="del_1" href="javascript: void(0);" pvalue="1"><{$lang->page->del}></a></td>
	</tr>
	<{/if}>
</table>
</form>
<script type="text/javascript">
$(document).ready(function(){
	var key = <{if $steps}><{$key+1}><{else}>1<{/if}>;
	var str = '<td><input name="id[]" type="text" value="" /></td><td><input name="des[]" type="text" value="" style="width: 250px;" /></td><td><input name="sort[]" type="text" value="" /></td>';
	$("a[id*=del_]").click(function(){
		del($(this).attr("pvalue"));
	});
	$("input[id=add]").click(function(){
		var obj = $("table[id=set_type_tbl]").find("tr:last");
		var css_class = ("trEven" == obj.attr("class")) ? " trOdd" : "trEven";
		obj.after("<tr class='"+css_class+"'>" + str + '<td><a id="del_' + key + '" href="javascript: void(0);" pvalue="'+key+'"><{$lang->page->del}></a></td>' + "</tr>");
		$("a[id*=del_]").bind("click", function(){
			del($(this).attr("pvalue"));
		});
		key++;
	});
	$("input[id=back]").click(function(){
		location.href = "<{$smarty.const.URL_SELF}>";
	});
});
function del(key){
	var obj = $("a[id=del_"+key+"]");
	obj.parent().parent().remove();
}

</script>
<{/if}>
</body>
</html>