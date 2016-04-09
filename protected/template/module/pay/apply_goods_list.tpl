<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><{$lang->menu->applyGoldList}></title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script language="javascript">
	$(document).ready(function(){
		if ("<{$result_msg}>" != 0){
			alert("<{$result_msg}>");
			location.href = "<{$smarty.const.URL_SELF}>";
		}
	});
</script>
</head>
<body>
<!--  
<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->applyGoldList}></div>
-->
<form method="post" action="<{$URL_SELF}>?action=search">
    <{$lang->page->type}>: <select name="type"><{html_options selected=$type options=$typeArr}></select>
    <{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$dateStart}>' /> 
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$dateEnd}>' />
	<{$lang->page->applyID}>:<input id="applyID" name="applyID" value="<{$applyID}>" />
    <input type="hidden" name="page" value='1' />
    <!-- <input type="image" name='search' src="/static/images/search.gif" class="input2" /> -->
    <input type="submit" value="<{$lang->page->serach}>" />
</form>

<br />

<{include file='file:pager.tpl' pages=$pager }>
<font color="red"><{$msg}></font>
<table class="table_list">
	<tr class="table_list_head" align="center">
        <td style="width:50px"><{$lang->page->applyID}></td>
        <td style="width:50px"><{$lang->page->applyPeople}></td>
        <td style="width:80px"><{$lang->page->applyTime}></td>
        <td style="width:150px"><{$lang->page->applyReason}></td>
        <td style="width:100px"><{$lang->page->mailTitle}></td>
        <td style="width:250px"><{$lang->page->mailCon}></td>
        <td style="width:300px"><{$lang->page->playerList}></td>
        <td style="width:300px"><{$lang->page->itemDetails}></td>
        <td style="width:50px"><{$lang->page->verifyResult}></td>
        <td style="width:50px"><{$lang->page->verifyPerson}></td>
        <td style="width:80px"><{$lang->page->deal}></td>
	</tr>
	
	<{foreach from=$applyList item=list}>
		<tr class="<{cycle values="trEven,trOdd"}>" align="center" >
		<td><{$list.applyID}></td>
		<td><{$list.apply_person}></td>
		<td><{$list.apply_time}></td>
		<td><{$list.apply_reason}></td>
		<td><{$list.mailTitle}></td>
		<td style="background-color:#223A3D;"><{$list.mailContent}></td>
		<td><{$list.roleNameList}></td>
		<td align="left"><{$list.item}></td>
		<{if $list.verify_result eq $lang->verify->pass}><td style="color:green;"><{elseif $list.verify_result eq $lang->verify->reject}><td style="color:red";><{else}><td><{/if}><{$list.verify_result}></td>
		<td><{$list.verify_person}></td>
		<td>
			<!-- <a class="detail" href="apply_goods_detail.php?id=<{$list.apply_id}>"><{$lang->page->detailDeal}></a> --> 
        	<a class="yes" href="?action=yes&id=<{$list.applyID}>&verifyResult=<{$list.verify_result}>" onClick="return confirm('<{$lang->apply->sureToPass}>')"><{$lang->page->allowDeal}></a>
        	<a class="no" href="?action=no&id=<{$list.applyID}>&verifyResult=<{$list.verify_result}>" onClick="return confirm('<{$lang->apply->sureToReject}>')"><{$lang->page->deleteDeal}></a>
        	<a class="del" href="?action=del&id=<{$list.applyID}>" onClick="return confirm('id=【<{$list.applyID}>】<{$lang->apply->sureToDelete}>')"><{$lang->page->del}></a>
		</td>
		</tr>
	<{/foreach}>

</table>