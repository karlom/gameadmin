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
	   $("#back").click(function(){
	       document.location.href="apply_goods_list.php?dateStart=<{$dateStart}>&dateEnd=<{$dateEnd}>&type=<{$type}>&page=<{$page}>";
	   });
       $("#sub").submit(function(){
            if(confirm("<{$lang->page->applyPassSure}>")){
                return true;
            }
            else{
                return false;
            }
       });
    });
</script>
</head>
<body>
<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->applyGoldList}></div>

<input type="button" name="back" id="back" value="<{$lang->page->backList}>" /><br />

<font color="red"><{$msg}></font><br />

<{$lang->page->schema}>：
<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:60%">
	<tr class='table_list_head'>
        <td><{$lang->page->applyPeople}></td>
        <td><{$lang->currency->copper}></td>
        <td><{$lang->currency->bindCopper}></td>
        <td><{$lang->currency->yuanbao}></td>
        <td><{$lang->currency->bindYuanbao}></td>
        <td><{$lang->page->applyTime}></td>
        <td><{$lang->page->passCheck}></td>
        <td><{$lang->page->peopleCheck}></td>
	</tr>
    	<tr class='trEven'>
        <td><{$gift.admin_name}></td>
        <td><{$gift.copper}></td>
        <td><{$gift.bind_copper}></td>
        <td><{$gift.yuanbao}></td>
        <td><{$gift.bind_yuanbao}></td>
        <td><{$gift.date}></td>
        <td><{$gift.is_pass}></td>
        <td><{$gift.pass_admin}></td>
        </tr>
</table>
<br />
<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:60%">
	<tr class='table_list_head'>
        <td><{$lang->page->sendReason}></td>
        <td><{$lang->page->mailCon}></td>
	</tr>
    	<tr class='trEven'>
        <td><{$gift.reason}></td>
        <td><{$gift.content}></td>
        </tr>
</table>
<br />
<{$lang->player->itemsList}>：
<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:60%">

	<tr class='table_list_head'>
        <td width="20%"><{$lang->item->itemID}></td>
        <td width="20%"><{$lang->page->itemsName}></td>
        <td width="20%"><{$lang->page->itemsNum}></td>
        <td width="20"><{$lang->page->strLevel}></td>
        <td width="20"><{$lang->page->isBind}></td>
	</tr>
    
    <{foreach key=key item=item from=$gift.data name=items}>
       	<{if $smarty.foreach.items.rownum % 2 == 0}>
    	<tr class='trEven'>
    	<{else}>
    	<tr class='trOdd'>
    	<{/if}>
        <td><{$item.template_id}></td>
        <td><{$item.template_name}></td>
        <td><{$item.amount}></td>
        <td><{$item.strength_level}></td>
        <td><{if $item.is_bind eq 1 }><{$lang->verify->yes}><{else}><{$lang->verify->no}><{/if}></td>
        </tr>
    <{/foreach}>
</table>
<br />
<{$lang->page->playerList}>：
<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:60%">
	<tr class='table_list_head'>
        <td><{$lang->page->roleId}></td>
        <td><{$lang->page->roleName}></td>
        <td><{$lang->page->accountName}></td>
	</tr>
    
    <{foreach key=key item=item from=$gift.role name=rs}>
       	<{if $smarty.foreach.rs.index % 2 == 0}>
    	<tr class='trEven'>
    	<{else}>
    	<tr class='trOdd'>
    	<{/if}>
        <td><{$item.user_id}></td>
        <td><{$item.nick_name}></td>
        <td><{$item.user_name}></td>
    <{/foreach}>

</table>
<br />
<form name="sub" id="sub" action="" method="post" >
<input type="hidden" name="dateStart" value="<{$dateStart}>" />
<input type="hidden" name="dateEnd" value="<{$dateEnd}>" />
<input type="hidden" name="type" value="<{$type}>" />
<input type="hidden" name="id" value="<{$apply.id}>" />
<input type="hidden" name="action" value="pass" />
<input type="hidden" name="page" value="<{$page}>" />
<input type="hidden" name="is_pass" value="<{$apply.is_pass}>" />
<input type="submit" value="<{$lang->page->passCheck}>" style="width:100px;height:50px" />
</form>