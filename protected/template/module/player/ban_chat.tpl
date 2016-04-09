<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->setSilence}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/ip.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script language="javascript">
$(document).ready(function(){
	$("#reasonArr").change(function(){
		$("#ban_reason").val(<{$lang->player->banAccountAlert}>);
	});
	$("#role_name").keydown(function(){
		$("#account").val('');
	});
	$("#account").keydown(function(){
		$("#role_name").val('');
	});
	$("input[name=banButton]").click(function(){
		if("" == $("input[id=nick_name]").val()){
			alert("<{$lang->player->roleName}><{$lang->verify->isNotNull}>");
			return false;
		}else if("" == $("textarea[id=ban_reason]").val()){
			alert("<{$lang->alert->banReasonNull}>");
			return false;
		}
	});

});
</script>
</head>
<body>
<!-- 
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->setSilence}></b>
</div>
-->
<div style="padding: 5px;">
<{$lang->page->banChat}>
</div>
<form name="myform2" id="myform2" method="post" action="<{$smarty.const.URL_SELF}>">
	<table cellspacing="1" class="table_list" style="width: 50%;">
		<tr class="<{cycle values='trEven,trOdd'}>">
			<td align="right"><{$lang->page->roleName}>:</td>
			<td><input type="text" name="nick_name" id="nick_name" value="" /></td>
		</tr>
		<!--tr class="trOdd">
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
<script type="text/javascript">
    function changePage(page){
	$("#page").val(page);
        $("#myform").submit();
    }
</script>
<form id="myform" name="myform" method="POST" action="<{$smarty.const.URL_SELF}>">
<div class='divOperation' style="margin-top: 10px;">
	<{$lang->page->accountName}>:<input type="text" id="account" name="account" size="15" value="<{if $account_name_search}><{$keywordlist.0.account_name}><{/if}>" />
	<{$lang->page->roleName}>:<input type="text" id="role_name" name="role_name" size="10" value="<{if $role_name_search}><{$keywordlist.0.role_name}><{/if}>" />
	<input name="page" type="hidden" value="" />
	<input type="image" src="/static/images/search.gif" class="input2"  align="absmiddle" />
</div>
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
    	<th width="1%">ID</th>
		<th width="8%"><{$lang->page->roleName}></th>
		<th width="8%"><{$lang->page->accountName}></th>
		<th width="5%"><{$lang->page->IPAddr}></th>
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
		<td><{$row.ban_time}></td>
		<td><{$row.free_time}></td>
		<td><{$row.ban_reason}></td>
		<td><{$row.op_user}></td>
        <td><{if 0 == $row.status || 2 == $row.status}>已解封<{else}><a href="ban_chat.php?action=unban&amp;roleName=<{$row.role_name}>&amp;banTime=0&amp;id=<{$row.id}>">解封</a><{/if}> </td>
	</tr>
	<{/foreach}>
</table>
</body>
</html>
