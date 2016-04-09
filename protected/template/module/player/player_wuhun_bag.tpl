<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->playerWunhunBag}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
</head>

<body>
<!-- 
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->playerWunhunBag}></b>
</div> 
-->
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
<input type="hidden" id="action" name="action" value="search" />
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>
</div>
<{if $viewData}>
<div style="width: 450px; float: left;">
	<{if $viewData.bagTian}>
    <table style="width: 420px;" cellspacing="0" cellpadding="0" border="0" class="DataGrid table_list" >
    	<tr class='table_list_head' align="center" height="30">
            <td colspan="8"><{$numUper[$viewData.tianLv]}><{$lang->page->jie}><{$lang->wuhun->tianZhen}><{if 1==$viewData.nowUse}>(<{$lang->wuhun->nowUse}>)<{/if}></td>
    	</tr>
    	<tr class='<{cycle values="trEven,trOdd"}>'>
    		<{foreach name="loop" from=$viewData.bagTian item=item}>
			<td width="100" height="30" align="center">
				<{if $item.itemId}>
				<span style="color: <{$dictColorValue[$item.color]}>"><{$item.name}></span> Lv.<{$item.lv}>
				<{elseif 0 == $item.isOpen}>
				<img src="/static/images/gridNoUse.png" />
				<{else}>
				&nbsp;
				<{/if}>
			</td>
			<{if 0 == $smarty.foreach.loop.iteration%4}>
		</tr>
		<tr class='<{cycle values="trEven,trOdd"}>'>
			<{/if}>
    		<{/foreach}>
    	</tr>
    </table>
    <br />
    <{/if}>
	<{if $viewData.bagDi}>
    <table style="width: 420px;" cellspacing="0" cellpadding="0" border="0" class="DataGrid table_list" >
    	<tr class='table_list_head' align="center" height="30">
            <td colspan="8"><{$numUper[$viewData.diLv]}><{$lang->page->jie}><{$lang->wuhun->diZhen}><{if 2==$viewData.nowUse}>(<{$lang->wuhun->nowUse}>)<{/if}></td>
    	</tr>
    	<tr class='<{cycle values="trEven,trOdd"}>'>
    		<{foreach name="loop" from=$viewData.bagDi item=item}>
			<td width="100" height="30" align="center">
				<{if $item.itemId}>
				<span style="color: <{$dictColorValue[$item.color]}>"><{$item.name}></span> Lv.<{$item.lv}>
				<{elseif 0 == $item.isOpen}>
				<img src="/static/images/gridNoUse.png" />
				<{else}>
				&nbsp;
				<{/if}>
			</td>
			<{if 0 == $smarty.foreach.loop.iteration%4}>
		</tr>
		<tr class='<{cycle values="trEven,trOdd"}>'>
			<{/if}>
    		<{/foreach}>
    	</tr>
    </table>
    <br />
    <{/if}>
	<{if $viewData.bagRen}>
    <table style="width: 420px;" cellspacing="0" cellpadding="0" border="0" class="DataGrid table_list" >
    	<tr class='table_list_head' align="center" height="30">
            <td colspan="8"><{$numUper[$viewData.renLv]}><{$lang->page->jie}><{$lang->wuhun->renZhen}><{if 3==$viewData.nowUse}>(<{$lang->wuhun->nowUse}>)<{/if}></td>
    	</tr>
    	<tr class='<{cycle values="trEven,trOdd"}>'>
    		<{foreach name="loop" from=$viewData.bagRen item=item}>
			<td width="100" height="30" align="center">
				<{if $item.itemId}>
				<span style="color: <{$dictColorValue[$item.color]}>"><{$item.name}></span> Lv.<{$item.lv}>
				<{elseif 0 == $item.isOpen}>
				<img src="/static/images/gridNoUse.png" />
				<{else}>
				&nbsp;
				<{/if}>
			</td>
			<{if 0 == $smarty.foreach.loop.iteration%4}>
		</tr>
		<tr class='<{cycle values="trEven,trOdd"}>'>
			<{/if}>
    		<{/foreach}>
    	</tr>
    </table>
    <br />
    <{/if}>
</div>
<div style="width: 650px; float: left;">
    <table style="width: 620px;" cellspacing="0" cellpadding="0" border="0" class="DataGrid table_list" >
    	<tr class='<{cycle values="trEven,trOdd"}>'>
			<td width="80" height="30" align="center"><{$lang->wuhun->point}></td>
			<td width="120" height="30" align="center"><{$lang->wuhun->hunt1Cnt}></td>
			<td width="120" height="30" align="center"><{$lang->wuhun->hunt2Cnt}></td>
			<td width="100" height="30" align="center"><{$lang->wuhun->hunt3Cnt}></td>
			<td width="120" height="30" align="center"><{$lang->wuhun->huntTime}></td>
    	</tr>
    	<tr class='<{cycle values="trEven,trOdd"}>'>
			<td height="30" align="center"><{$viewData.point}></td>
			<td height="30" align="center"><{$viewData.hunt1Cnt}></td>
			<td height="30" align="center"><{$viewData.hunt2Cnt}></td>
			<td height="30" align="center"><{$viewData.hunt3Cnt}></td>
			<td height="30" align="center"><{$viewData.huntTime|date_format:"%Y-%m-%d %H:%I:%S"}></td>
		</tr>
    </table>
    <br />
	<{if $viewData.bag2}>
    <table style="width: 620px;" cellspacing="0" cellpadding="0" border="0" class="DataGrid table_list" >
    	<tr class='table_list_head' align="center" height="30">
            <td colspan="8"><{$lang->wuhun->wuhunBag}></td>
    	</tr>
    	<tr class='<{cycle values="trEven,trOdd"}>'>
    		<{foreach name="loop" from=$viewData.bag2 item=item}>
			<td width="100" height="30" align="center">
				<{if $item.itemId}>
				<span style="color: <{$dictColorValue[$item.color]}>"><{$item.name}></span> Lv.<{$item.lv}>
				<{elseif 0 == $item.isOpen}>
				<img src="/static/images/gridNoUse.png" />
				<{else}>
				&nbsp;
				<{/if}>
			</td>
			<{if 0 == $smarty.foreach.loop.iteration%4}>
		</tr>
		<tr class='<{cycle values="trEven,trOdd"}>'>
			<{/if}>
    		<{/foreach}>
    	</tr>
    </table>
    <br />
    <{/if}>
	<{if $viewData.bag3}>
    <table style="width: 620px;" cellspacing="0" cellpadding="0" border="0" class="DataGrid table_list" >
    	<tr class='table_list_head' align="center" height="30">
            <td colspan="8"><{$lang->wuhun->tempBag}></td>
    	</tr>
    	<tr class='<{cycle values="trEven,trOdd"}>'>
    		<{foreach name="loop" from=$viewData.bag3 item=item}>
			<td width="100" height="30" align="center">
				<{if $item.itemId}>
				<span style="color: <{$dictColorValue[$item.color]}>"><{$item.name}></span> Lv.<{$item.lv}>
				<{elseif 0 == $item.isOpen}>
				<img src="/static/images/gridNoUse.png" />
				<{else}>
				&nbsp;
				<{/if}>
			</td>
			<{if 0 == $smarty.foreach.loop.iteration%6}>
		</tr>
		<tr class='<{cycle values="trEven,trOdd"}>'>
			<{/if}>
    		<{/foreach}>
    	</tr>
    </table>
    <br />
    <{/if}>
</div>
<{/if}>
</div>

</body>
</html>
