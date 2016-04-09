<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->loginHistory}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/ip.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script type="text/javascript" >
	function changePage(page){
		$("#page").val(page);
		$("#myform").submit();
	}
	$(document).ready(function(){
		$("#account_name").keydown(function(){
			$("#role_name").val('');
	
		});
		$("#role_name").keydown(function(){
			$("#account_name").val('');
	
		});
	});
	
</script>
</head>

<body>
<!--  
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->loginHistory}></b>
</div>
-->
<form id="myform" name="myform" method="post" action="">
<div class='divOperation'>
<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$dateStart}>' /> 
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$dateEnd}>' /> 

&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="role[account_name]" size="10" value="<{$role.account_name}>" />
&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role[role_name]" size="10" value="<{$role.role_name}>" />
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />

</div>
<{if $viewData}>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
  <tr>
    <td height="30" class="even">
 <{foreach key=key item=item from=$pagelist}>
 <a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>');"><{$key}></a><span style="width:5px;"></span>
 <{/foreach}>
<{$lang->page->record}>(<{$counts}>)&nbsp;&nbsp;&nbsp;<{$lang->page->totalPage}>(<{$pageCount}>)
<{$lang->page->everyPage}><input type="text" id="record" name="record" size="4" style="text-align:center;" value="<{$pageNum}>"><{$lang->page->row}>
  <{$lang->page->dang}><input id="page" name="page" type="text" class="text" size="3" maxlength="6" style="text-align:center;" value="<{$pageno}>" ><{$lang->page->page}>&nbsp;<input id="btnGo" type="submit" class="button" name="Submit" value="GO">
    </td>
  </tr>
</table>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width: 60%" >
	<tr class='table_list_head'>
        <td width="5%"><{$lang->player->accountName}></td>
        <td width="6%"><{$lang->player->roleName}></td>
        <td width="8%"><{$lang->player->loginTime}></td>
        <td width="5%"><{$lang->player->loginIp}></td>
        <td width="5%"><{$lang->page->pf}></td>
	</tr>
	
<{foreach name=loop from=$viewData item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$item.account_name}></td>
		<td><{$item.role_name}></td>
		<td><{$item.mdate}></td>
		<td><a href="javascript:void(0)" class="show-ip"><{$item.ip}></a></td>
		<td><{$item.pf}></td>
	</tr>
<{foreachelse}>
<font color='red'><{$lang->page->noData}></font>
<{/foreach}>
</table>
<{/if}>
</div>
</form>
</body>
</html>
