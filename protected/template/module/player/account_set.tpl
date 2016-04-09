<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<title><{$lang->menu->accountSet}></title>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript">
function delGamerTitle(id,role_name,account_name){
	if (confirm("<{$lang->account->sureOrNot}>")){
		window.location.href = '?action=del&id='+id+'&role_name='+role_name+'&account_name='+account_name;
	}
}
$(document).ready(function(){
	$(".btnGetRole").click(function(){
//		if($("#role_name").text() ==''&& $("#account_name").text()) {
//			$("#tip").html("<{$lang->account->noNull}>").css({color:"#ff0000"});
//			return false;
//		}
		$("#myform").attr("action","?action=search");
		$("#myform").submit();
	});
	$("#btnSet").click(function(){
		var msg = "";
		if(""!=msg){
			alert(msg);
		}else{
			$("#myform").attr("action","?action=set");
			$("#myform").submit();
		}
	});
});
</script>
</head>
<body>
<{if $msg}>
	<p style="color:#ff0000; font-weight:border;"><{$msg}></p>
<{/if}>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->accountSet}></b>
</div>

<div style="border:2px solid #CCC;">
<p id='tip' style="color:#ff9900"><{$lang->account->suport}></p>
<table width="30%">
  <tr valign="bottom">
    <td>
    <form id="myform" action="<{$URL_SELF}>" method="post">
      <table class="DataGrid">
        <tr>
          <th colspan="2"><{$lang->account->findAndSet}></th>
        </tr>
          <td align="right"><{$lang->account->roleName}>：</td>
          <td><input type="text" name="role[role_name]" id="role_name" size="16" value="<{$role.role_name}>" onkeydown="document.getElementById('account_name').value ='';"/>&nbsp;<input type="button" class="btnGetRole" value="<{$lang->account->find}>" /></td>
        </tr>
        <tr>
          <td align="right"><{$lang->account->accountName}>：</td>
          <td><input type="text" name="role[account_name]" id="account_name" size="16" value="<{$role.account_name}>"  onkeydown="document.getElementById('role_name').value ='';"/>&nbsp;<input type="button" class="btnGetRole" value="<{$lang->account->find}>" /></td>
        </tr>
        <{if $set}>
        <tr>
          <td colspan="2" align="center" style="background:#0000ff;"><input type="button" id="btnSet" style="color:#ff0000;" value="<{$lang->account->set}>" /></td>
        </tr>
        <{/if}>
      </table>
    </form>
    </td>
	
<table class="DataGrid">
  <tr id="header">
    <th><{$lang->account->roleName}></th>
    <th><{$lang->account->accountName}></th>
    <th><{$lang->account->createTime}></th>
    <th><{$lang->account->effectiveDays}></th>
    <th><{$lang->account->operate}></th>
  </tr>
  <{foreach from=$rs item=item key=key}>
  <tr>
    <td><{$item.role_name}></td>
    <td><{$item.account_name}></td>
    <td><{$item.ctime|date_format:"%Y-%m-%d %H:%M:%S"}></td>
    <td><{$item.etime|date_format:"%Y-%m-%d %H:%M:%S"}></td>
    <td align="center"><{*<a href="?action=update&id=<{$item.id}>">编辑</a>*}> <a href="javascript:delGamerTitle(<{$item.id}>,'<{$item.role_name}>','<{$item.account_name}>');">删除</a> </td>
  </tr>
  <{/foreach}>
  <{if !$rs}>
 	<tr>
 		<td colspan="7" style="color:#ff0000;"><{$lang->account->noData}></td>
 	</tr>
  <{/if}>
</table>
</div>
</body>
</html>
