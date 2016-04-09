<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/ip.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script language="javascript">
	$(document).ready(function(){

		//==========start  role form =====

		$("#role_name").keydown(function(){
			$("#account_name").val('');
		});
		$("#account_name").keydown(function(){
			$("#role_name").val('');
		});

		$('.show-ip').click(function(){
			var ip = $(this).text();
			queryIP(ip);
		})
		
		$("#update").click(function(){
			var num = $("#num").val();
			var money = $("input:radio[name=money]:checked").val();
			var op = $("input:radio[name=opera]:checked").val();
			var role = $("#myform input[name=role_name]").val();
			
			var moneyType = (money==1) ? ' 【<{$lang->currency->yuanbao}>】 ' : ' 【<{$lang->currency->bindYuanbao}>】 ';
			var opera = (op==1) ? ' <{$lang->page->add}> ' : ' <{$lang->page->minus}> ';
			
			if(confirm('确定给玩家 【' + role + '】 ' + opera + num  + '个' + moneyType + '?')){
				$("#myform").submit();
			} else {
				return false;
			}
		});
	});
</script>

<title><{$lang->menu->updatePlayerGold}></title>

</head>

<body>
<div id="position"><{$lang->menu->class->msgManage}>：<{$lang->menu->updatePlayerGold}></div>
<form action="?action=search" id="frm" method="post" >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="800">
		<tr>
			<input type="hidden" id="action" name="action" value="search"/>
			<td align="right"><{$lang->page->roleName}>：</td>
			<td><input type="text" name="role_name" id="role_name" value="<{$role.roleName}>" /></td>
			<td align="right"><{$lang->page->accountName}>：</td>
			<td><input type="text" name="account_name" id="account_name" value="<{$role.accountName}>" /></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2"  /></td>
		</tr>
	</table>
	<br />
<h1 class="red">注意：本功能会直接修改玩家仙石/绑定仙石数量，请慎用！</h1>
</form>
<br />
<{if $strMsg}>
<table cellspacing="1" cellpadding="5" class="DataGrid">
	<{foreach from=$strMsg item=item}>
	<tr><td><span style="color:red;"><{$item}></span></td></tr>
	<{/foreach}>
</table>
<br />
<{/if}>

<{if $role}>
当前用户仙石信息：
<br />
<table class="DataGrid" style="width:800px">
	<tr>
		<th><{$lang->page->accountName}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->page->level}></th>
		<th><{$lang->currency->yuanbao}></th>
		<th><{$lang->currency->bindYuanbao}></th>
	</tr>
	<tr align="center">
		<td><{$role.accountName}></td>
		<td><{$role.roleName}></td>
		<td><{$role.level}></td>
		<td><{$role.xianshi}></td>
		<td><{$role.bindXianshi}></td>
	</tr>
</table>
<br />

<form id="myform" method="post" >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="800">
		<tr>
			<input type="hidden" id="action" name="action" value="update"/>
			<input type="hidden" name="role_name" id="role_name" value="<{$role.roleName}>" />
			<input type="hidden" name="account_name" id="account_name" value="<{$role.accountName}>" />
			
			<td align="right"><{$lang->page->selectCurrency}>：</td>
			<td>
				<input type="radio" name="money" checked="checked" value="2"/><{$lang->currency->bindYuanbao}><br/>
				<input type="radio" name="money" value="1" /><{$lang->currency->yuanbao}>
			</td>
			<td align="right"><{$lang->page->selectOperation}>：</td>
			<td>
				<input type="radio" name="opera" checked="checked" value="2" /><{$lang->page->minus}><br/>
				<input type="radio" name="opera" value="1"/><{$lang->page->add}>
			</td>
			<td><{$lang->page->number}>：<input type="text" name="num" id="num" value="" /></td>
			<td><input type="submit" name='update' id="update" value="确定"  /></td>
		</tr>
	</table>
	<br />

</form>
<{/if}>

<{if $change}>
修改后用户仙石信息：
<br />
<table class="DataGrid" style="width:800px">
	<tr>
		<th><{$lang->page->accountName}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->page->level}></th>
		<th>修改前<{$lang->currency->yuanbao}></th>
		<th><{$lang->currency->yuanbao}></th>
		<th>修改前<{$lang->currency->bindYuanbao}></th>
		<th><{$lang->currency->bindYuanbao}></th>
	</tr>
	<tr align="center">
		<td><{$role.accountName}></td>
		<td><{$role.roleName}></td>
		<td><{$role.level}></td>
		<td><{$role.oldXianshi}></td>
		<td><{$role.xianshi}></td>
		<td><{$role.oldBindXianshi}></td>
		<td><{$role.bindXianshi}></td>
	</tr>
</table>
<{/if}>

</body>
</html>