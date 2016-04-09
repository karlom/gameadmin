<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->banAccount}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/ip.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script language="javascript">

$(document).ready(function(){
	$("#account").keydown(function(){
			$("#rolename").val('');
		});
		$("#rolename").keydown(function(){
			$("#account").val('');

		});
	$(".ban_time_arr").change(function(){
		if(1 == $(this).val()){
			$(this).parent().find('.ban_time').show();
		}else{
			$(this).parent().find('.ban_time').hide();
		}
	});
	$("#reasonArr").change(function(){
		$("#ban_reason").val(<{$lang->player->banAccountAlert}>);
	});
	$("input[id=account]").change(function(){
		$("input[id=nick_name]").val("");
	});
	$("input[id=nick_name]").change(function(){
		$("input[id=account]").val("");
	});
	$("input[name=banButton]").click(function(){
		if("" == $("input[id=role_name]").val() && "" == $("input[id=account_name]").val()){
			alert("<{$lang->alert->needRoleNameOrAccName}>");
			return false;
		}else if("" == $("textarea[id=ban_reason]").val()){
			alert("<{$lang->alert->banReasonNull}>");
			return false;
		}
	});
	
	$("#loadFromServer").click(function(){
		return confirm('确定要从服务器同步禁封账号列表？');
	});
	
	$("#banAccount").click(function(){
		return confirm('玩家[ <{$userList.role_name}> ]将被踢下线并禁止登录！确定？');
	});
});

function changePage(page){
	$("#page").val(page);
        $("#myform").submit();
    }

</script>
</head>
<body>
<!-- 
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->banAccount}></b>
</div>
 -->
<{if $strMsg}><font color="#FF0000"><{$strMsg}></font><{/if}>
<div style="padding: 5px;">
<{$lang->page->banAccountDis}>
</div>
<{*
<form name="myform2" id="myform2" method="post" action="<{$smarty.const.URL_SELF}>">
	<table cellspacing="1" class="table_list" width="100%">
		<tr class="<{cycle values='trEven,trOdd'}>">
			<td align="right" width="150"><{$lang->page->accountName}>:</td>
			<td><input type="text" name="account_name" id="account_name" value="" /></td>
		</tr>
		<tr class="<{cycle values='trEven,trOdd'}>">
			<td align="right"><{$lang->page->roleName}>:</td>
			<td><input type="text" name="role_name" id="role_name" value="" /></td>
		</tr>
		<!--tr class="">
			<td align="right"><{$lang->player->serverID}>:</td>
			<td><input type="text" name="server_id" id="server_id" value="" /></td>
		</tr-->
		<tr class="<{cycle values='trEven,trOdd'}>">
			<td align="right"><{$lang->player->banTimeLength}>:</td>
			<td>
                <select name="ban_time_arr" id="ban_time_arr"><{html_options options=$banTime}></select>
                <input size="10" value="30" name="ban_time" id="ban_time"/>
            </td>
		</tr>
		<tr class="<{cycle values='trEven,trOdd'}>">
			<td align="right"><{$lang->player->quickTips}>:</td>
            <td>
                <select name="reasonArr" id="reasonArr">
                    <{html_options values=$banReason output=$banReason }>
                </select>
            </td>
        </tr>
        <tr class="<{cycle values='trEven,trOdd'}>">
        	<td></td>
            <td>
                <textarea rows="3" cols="60" name="ban_reason" id="ban_reason" style="height:50px"></textarea>
            </td>
        </tr>
		<tr class="<{cycle values='trEven,trOdd'}>">
			<td colspan="2" align="center">
				<input name="action" type="hidden" value="ban" />
				<input type="submit" class="button" name="banButton" value="<{$lang->player->ban}>" style="height:30px">
			</td>
		</tr>
		<{if $msg}>
		<tr class="<{cycle values='trEven,trOdd'}>">
			<td colspan="2"><span style="color:red;"><{$msg}></span></td>
		</tr>
		<{/if}>
	</table>
</form>
*}>

<form name="formSearchAccount" method="POST" action="<{$smarty.const.URL_SELF}>">
<div class='divOperation' style="margin-top: 10px;">
	<{$lang->player->roleName}>:<input type="text" id="term" name="term" size="15" value="<{if $term}><{$term}><{/if}>" />
	<input type="submit" name="searchAccount" value="<{$lang->sys->search}>"/>
</div>
</form>
<{if $userList}>
<div class="label">
	<{$lang->player->userInfo}>:
</div>
<table cellspacing="1" cellpadding="3" border="0" class="table_list">
	<tr class='table_list_head'> 
    	
		<th width="6%"><{$lang->page->roleName}></th>
		<th width="15%"><{$lang->page->accountName}></th>
		<th width="6%"><{$lang->page->IPAddr}></th>
		<th width="3%"><{$lang->page->level}></th>
		<th width="5%"><{$lang->player->totalPay}></th>
		<th width="5%"><{$lang->player->status}></th>
		<th width="13%"><{$lang->player->banTime}></th>
		<th width="21%"><{$lang->player->unBanReason}></th>
        <th width="6%"><{$lang->page->op}></th>
	</tr>
	
	<form action="<{$smarty.const.URL_SELF}>" method="post">
	<tr align="center" class='<{cycle values="trEven,trOdd"}>'> 
    	
		<td class="cmenu" title="<{$userList.role_name}>"><{$userList.role_name}></td>
		<td class="cmenu" title="<{$userList.role_name}>"><{$userList.account_name}></td>
		<td><a href="javascript:void(0)" class="show-ip"><{$userList.ip}></a></td>
		<td align="center"><{$userList.level}></td>
		<td align="center"><{$userList.total_pay}></td>
		<td align="center"><span class="label" style="color: <{if 1 == $userList.online}>green<{else}>gray<{/if}>">
			<{if 1 == $userList.online}>
				<{$lang->player->online}> 
			<{else}> 
				<{$lang->player->offline}>
			<{/if}>
		</span></td>
		<td>
			<select name="ban_time_arr" class="ban_time_arr"><{html_options options=$banTime}></select>
			<input size="10" value="30" name="ban_time" class="ban_time"/>
		</td>
		<td>
			<select name="reasonArr" class="reasonArr">
                <{html_options values=$banReason output=$banReason }>
            </select>
        </td>
        <td align="center">
        	<input type="hidden" name="account_name" value="<{$userList.account_name}>" />
        	<input type="hidden" name="role_name" value="<{$userList.role_name}>" />
        	<input type="hidden" name="level" value="<{$userList.level}>" />
        	<input type="hidden" name="ip" value="<{$userList.ip}>" />
        	<input type="hidden" name="total_pay" value="<{$userList.total_pay}>" />
        	<input type="hidden" name="action" value="ban" />
        	<input type="hidden" name="kickuser" value="<{$userList.role_name}>" />
        	<input type="submit" id="banAccount" name="banAccount" value="<{$lang->player->ban}>" />
		</td>
	</tr>
	</form>
	
</table>
<{/if}>

<br />
<div class="label">
	<{$lang->player->banList}>:
</div>

<form id="lbform" name="lbform" method="POST" >
	<input type="hidden" name="loadList" value="1"/>
	<input type="submit" id="loadFromServer" name="loadFromServer" value="从服务器同步列表" />
</form>

<form id="myform" name="myform" method="POST" action="<{$smarty.const.URL_SELF}>">

<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
  <tr>
    <td height="30" class="even">
 <{foreach key=key item=item from=$pagelist}>
 <a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>')"><{$key}></a><span style="width:5px;"></span>
 <{/foreach}>
<{$lang->page->totalPage}>(<{$page_count}>)&nbsp;&nbsp;&nbsp;&nbsp;<{$lang->page->record}>:<{$count_result}>
<{$lang->page->everyPage}><input type="text" id="record" name="record" size="4" style="text-align:center;" value="<{if $record != ''}><{$record}><{/if}>"><{$lang->page->row}>
  <{$lang->page->dang}><input id="page" name="page" type="text" class="text" size="3" maxlength="6" style="text-align:center;" value="<{$pageno}>" ><{$lang->page->page}>&nbsp;<input id="btnGo" type="submit" class="button" name="Submit" value="GO">
    </td>
  </tr>
</table>
</form>
<table cellspacing="1" cellpadding="3" border="0" class="table_list">
	<tr class='table_list_head'> 
    	<th width="2%">ID</th>
		<th width="6%"><{$lang->page->roleName}></th>
		<th width="15%"><{$lang->page->accountName}></th>
		<th width="6%"><{$lang->page->IPAddr}></th>
		<th width="3%"><{$lang->page->level}></th>
		<th width="5%"><{$lang->player->status}></th>
		<th width="9%"><{$lang->player->banTime}></th>
		<th width="9%"><{$lang->player->unBanTime}></th>
		<th width="21%"><{$lang->player->unBanReason}></th>
		<th width="6%"><{$lang->player->operator}></th>
        <th width="6%"><{$lang->page->op}></th>
	</tr>
	
	<{ foreach from=$keywordlist item=row key=key }>
	<tr align="center" class='<{cycle values="trEven,trOdd"}>'> 
    	<td><{$key+1}></td>
		<td class="cmenu" title="<{$row.role_name}>"><{$row.role_name}></td>
		<td class="cmenu" title="<{$row.role_name}>"><{$row.account_name}></td>
		<td><a href="javascript:void(0)" class="show-ip"><{$row.ip}></a></td>
		<td><{$row.level}></td>
		<td><span style="<{if 1 == $row.status}>color: red"><{$lang->player->ban}><{elseif 2 == $row.status}>color: green"><{$lang->player->unBanByHand}><{elseif 0 == $row.status}>color: green"><{$lang->player->unBan}><{/if}></span></td>
		<td><{$row.ban_time|date_format:'%Y-%m-%d %H:%M:%S'}></td>
		<td><{$row.free_time|date_format:'%Y-%m-%d %H:%M:%S'}></td>
		<td><{$row.ban_reason}></td>
		<td><{$row.op_user}></td>
        <td><{if 0 == $row.status || 2 == $row.status}>已解封<{else}><a href="ban_account.php?action=unban&amp;account_name=<{$row.account_name}>&amp;banTime=0&amp;id=<{$row.id}>" class="link-button">解封</a><{/if}></td>
	</tr>
	<{/foreach}>
</table>
</body>
</html>
