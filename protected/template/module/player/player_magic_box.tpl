<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->playerMagicBox}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $.autolist({
    	bind: "searchItem_widget",
    	options: <{$itemList|@json_encode}>,
    	onItemClick: function(key, item){
    		$('#searchItem_widget').val(item.text());
    		$('#item_id').val(key);
    	},
    	onReset: function(){
    		$('#item_id').val('');
    	}
    });
});
</script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->playerMagicBox}></b>
</div> 

<!-- Start 成功信息提示 -->
<{if $successMsg}>
<div class="success_msg_box">
	<{$successMsg}>
</div>
<{/if}>
<!-- End 成功信息提示 -->

<!-- Start 错误信息提示 -->
<{if $errorMsg}>
<div class="error_msg_box">
	<{$errorMsg}>
</div>
<{/if}>
<!-- End 错误信息提示 -->

<div class='divOperation' style="margin: 5px 0;">
<form id="myform" name="myform" method="get" action="" style="display: inline;">
&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role_name" size="10" value="<{$roleName}>" />
&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="account_name" size="10" value="<{$accountName}>" />
<{$lang->item->itemName}>:<input id='searchItem_widget' name='searchItem_widget' type="text" size='30' value='<{if $itemId > 0}><{$itemId}> | <{$itemList[$itemId]}><{/if}>' />
<input id="item_id" name="item_id" type="hidden" value="" />
<input type="hidden" id="action" name="action" value="search" />
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>
</div>
<{if $viewData}>
    <table style="width: 400px;" cellspacing="0" cellpadding="0" border="0" class="DataGrid table_list" >
    	<tr class='table_list_head' align="center">
            <td width="200"><{$lang->item->itemName}></td>
            <td><{$lang->item->itemCount}></td>
            <td><{$lang->page->isBind}></td>
    	</tr>
    	<{foreach name="loop" from=$viewData item=item}>
    	<tr class='<{cycle values="trEven,trOdd"}>'>
			<td><span style="color: <{$dictColorValue[$item.color]}>;"><{$item.id}> | <{$dictQuality[$item.quality]}><{$item.name}></span></td>
			<td><{$item.count}></td>
			<td><{$item.isBind}></td>
    	</tr>
    	<{/foreach}>
    </table>
<{/if}>
</body>
</html>
