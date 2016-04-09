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
		$("#role_id").keydown(function(){
			$("#role_name").val('');
			$("#account_name").val('');
		});
		$("#role_name").keydown(function(){
			$("#role_id").val('');
			$("#account_name").val('');
		});
		$("#account_name").keydown(function(){
			$("#role_id").val('');
			$("#role_name").val('');
		});
		//===============end role form =================

		$("#btnRestore").click(function(){
			if($("#newFamilyName").val() == '' || $("#role_name").val() == '' || $("#account_name").val() == ''  ){
				alert("请输入目标家族名和族长信息");
			} else {
				if(confirm('<{$lang->page->restorePlayerData}>?')){
					$("#action").val("restoreData");
					$("#frm").submit();
				} else {
					alert("No!");
				}
			}
		});
		$(".lbCheckbox").click(function(){
			if($("input:checkbox[name='selectItem[]']:checked").size() == <{ $restoreArry|@count }> ){
				$("#selectAll").attr("checked",true);
			} else {
				$("#selectAll").attr("checked",false);
			}
			
		});
		$("#selectAll").click(function(){
			if($("#selectAll").attr("checked") == true ) {
				$("input:checkbox[name='selectItem[]']").attr("checked",true);
				$("input:checkbox[name='newUser']").attr("checked",true);
			} else {
				$("input:checkbox[name='selectItem[]']").attr("checked",false);
				$("input:checkbox[name='newUser']").attr("checked",false);
			}
		});
		
		$("#search").click(function(){
			if( $("#account_name").val() == "" && $("#role_name").val() == "" ){
				alert("<{$lang->msg->requireAccAndRoleName}>");
				return false;
			}
			$("#selectAll").attr("checked",false) ;
			$("input:checkbox[name='selectItem[]']").attr("checked",false);
		});
		
		$('.show-ip').click(function(){
			var ip = $(this).text();
			queryIP(ip);
		})
	});
</script>


<title><{$lang->menu->familyStatus}></title>

</head>

<body>

<form action="?action=search" id="frm" method="post" >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="880">
		<tr>
			<input type="hidden" id="action" name="action" value="search"/>
			<td align="right"><{$lang->page->familyName}>：</td>
			<td><input type="text" name="familyName" id="familyName" size="24" value="<{$familyName}>" /></td>
			<{*
			<td align="right">族长<{$lang->page->roleName}>：</td>
			<td><input type="text" name="role[role_name]" id="role_name" value="<{$role.role_name}>" /></td>
			<td align="right">族长<{$lang->page->accountName}>：</td>
			<td><input type="text" name="role[account_name]" id="account_name" size="40" value="<{$role.account_name}>" /></td>
			*}>
			<td><input type="image" name='search' id="search" src="/static/images/search.gif" class="input2"  /></td>
		</tr>
	</table>
	<br />
	<div class="red">&nbsp;&nbsp;查询当前家族数据</div>
	<br />

</form>
<{if $strMsg}>
<table cellspacing="1" cellpadding="5" class="DataGrid">
	<tr>
		<td><span style="color:red;"><{$strMsg}></span></td>
	</tr>
</table>
<br />
<{/if}>

<{if $family}>
<!--  Start  家族信息-->
<table class="DataGrid" cellspacing="0" style="margin-bottom:20px;">
	<tr><th colspan="14" style="font-size:14px; color:#F00;"><b>家族信息</b></th></tr>
	<{ if $family }>
	<tr>
		<th><{$lang->page->familyName}></th>
		<th>族长</th>
		<th>家族等级</th>
		<th>战斗力</th>
		<th>家族资金</th>
		<th>家族经验</th>
		<th>创建时间</th>

	</tr>
    <tr align="center" <{ if 0==$smarty.section.i.index %2 }> class="odd"<{ /if }>>

		<td><{$family.familyName}></td>
		<td><{$account}></td>
		<td><{$family.familyLv}></td>
		<td><{$family.zhandouli}></td>
		<td><{$family.familyMoney}></td>
		<td><{$family.familyExp}></td>
		<td><{$family.createTime|date_format:'%Y-%m-%d %H:%M:%S' }></td>
	</tr>

	<{ else }>
    <tr><td colspan="11"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<!--  End  家族信息-->

<br>
<!-- start 家族神兽信息 -->
<table class="DataGrid" cellspacing="0">
	<tr><th colspan="7" style="font-size:14px; color:#F00;">家族神兽信息</th></tr>
	<{ if $family.monster }>
	<tr>
		<th>等级</th>
		<th>经验</th>
		<th>战斗力</th>
	</tr>
	<tr align="center">
		<td><{ $family.monster.lv}></td>
		<td><{ $family.monster.pkExp}></td>
		<td><{ $family.monster.zhandouli}></td>
	</tr>
	<{ else }>
    <tr><td colspan="7"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<!-- end 家族神兽信息 -->

<br>
<!-- start 家族成员列表 -->
<table class="DataGrid" cellspacing="0">
	<tr><th colspan="9" style="font-size:14px; color:#F00;">家族成员列表</th></tr>
	<{ if $family.memberList }>
	<tr>
		<th>角色名</th>
		<th>等级</th>
		<th>性别</th>
		<th>职业</th>
		<th>职位</th>
		<th>战斗力</th>
		<th>个人贡献</th>
		<th>历史总贡献</th>
		<th>最后登录时间</th>
	</tr>
	<{foreach from=$family.memberList item=mem key=key}>
	<tr align="center"<{ if $mem.official ==1 }> class="red"<{ /if }>>
		<td><{ $mem.name}></td>
		<td><{ $mem.lv}></td>
		<td><{ $dictSex[$mem.sex]}></td>
		<td><{ $dictJobs[$mem.job]}></td>
		<td><{ $dictFamilyOffical[$mem.official]}></td>
		<td><{ $mem.zhandouli}></td>
		<td><{ $mem.familyContribution}></td>
		<td><{ $mem.familyContributionSum}></td>
		<td><{ $mem.lastLoginTime|date_format:'%Y-%m-%d %H:%M:%S'}></td>
	</tr>
	<{ /foreach }>
	<{ else }>
    <tr><td colspan="9"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<!-- end 家族成员列表 -->

<br>
<!-- start 家族物品列表 -->
<table class="DataGrid" cellspacing="0">
	<tr><th colspan="7" style="font-size:14px; color:#F00;">家族物品列表</th></tr>
	<{ if $family.store }>
	<tr>
		<th><{$lang->item->itemID}></th>
		<th><{$lang->item->itemName}></th>
		<th><{$lang->page->itemsNum}></th>
	</tr>
	<{foreach from=$family.store item=item key=key}>
	<tr align="center"<{ if 0==$smarty.section.i.index %2 }> class="odd"<{ /if }>>
		<td><{ $item.id}></td>
		<td><{ $arrItemsAll[$item.id].name  }></td>
		<td><{ $item.cnt}></td>
	</tr>
	<{ /foreach }>
	<{ else }>
    <tr><td colspan="7"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<!-- end 家族物品列表 -->

<{/if}>
</body>
</html>