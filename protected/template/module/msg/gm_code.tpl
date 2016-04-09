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
			
			if(!$("#value").val()) {
				alert('请填写设置值');
				return false;
			}
			
			var sv=$("#selectCode").val();
			
			var codeDesc=$("#selectCode option[value="+sv+"]").html();
			
			if(confirm('确定对玩家 【' + role + '】 ' + '使用指令【' + codeDesc + '】?')){
				$("#myform").submit();
			} else {
				return false;
			}
		});
		
		$("#selectCode").change(function(){
			var v=$("#selectCode").val();

			$("div.code").hide();
			$("div.input").hide();
			$("div[name="+v+"]").show();
		});
	});
</script>

<title><{$lang->menu->adminGmCode}></title>

</head>

<body>
<div id="position"><{$lang->menu->class->msgManage}>：<{$lang->menu->adminGmCode}></div>
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
<div >注意：本功能只对在线玩家使用有效</div>
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
角色信息：
<br />
<table class="DataGrid" style="width:800px">
	<tr>
		<th><{$lang->page->accountName}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->page->level}></th>
		<th>IP</th>
		<th><{$lang->page->onlineStatus}></th>
	</tr>
	<tr align="center">
		<td><{$role.accountName}></td>
		<td><{$role.roleName}></td>
		<td><{$role.level}></td>
		<td><{$role.ip}></td>
		<td><{if 1 == $role.isOnline}><font color="green"><{$lang->page->online}></font><{else}><font color="red"><{$lang->page->offline}></font><{/if}></td>
	</tr>
</table>
<br />

<{if $role.isOnline == 1 }>
<form id="myform" method="post" >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="800">
		<tr>
			<input type="hidden" id="action" name="action" value="update"/>
			<input type="hidden" name="role_name" id="role_name" value="<{$role.roleName}>" />
			<input type="hidden" name="account_name" id="account_name" value="<{$role.accountName}>" />
			
			<td align="right"><{$lang->page->gmCode}>：</td>
			<td>
				<{ if $dictGmCode }>
				<select name="selectCode" id="selectCode">
					<option value="0"><{$lang->page->select}></option>
					<{foreach from=$dictGmCode item=code key=key}>
					<option value="<{$code.code}>"><{$code.desc}></option>
					<{/foreach}>
				</select>
				
					<{foreach from=$dictGmCode item=code key=key}>
				<div class="code" name='<{$code.code}>'  style="display:none"><{$code.code}></div>
					<{/foreach}>
				
				<{else}>
					No GM code available.
				<{/if}>				
			</td>
			<td align="right"><{$lang->page->value}>：</td>
			<td>
				<input type="text" name="value" id="value" value="" />
				
				<{ if $dictGmCode }>
					<{foreach from=$dictGmCode item=code key=key}>
				<div class="input" name='<{$code.code}>' style="display:none"><{$lang->page->input}>: <{$code.input}></div>
					<{/foreach}>
				<{/if}>	
			</td>
			<td><input type="submit" name='update' id="update" value="确定"  /></td>
		</tr>
	</table>
	<br />

</form>

<{else}>
<div class="red">当前玩家不在线，暂不能使用GM指令</div>
<{/if}>

<{/if}>


</body>
</html>