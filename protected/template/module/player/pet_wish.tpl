<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->petWish}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->petWish}></b>
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

<div class='divOperation'>
<form id="myform" name="myform" method="get" action="" style="display: inline;">
<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="start_day" id="start_day" onfocus="WdatePicker({el:'start_day',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'end_day\')}'})" value="<{ $startDay }>">
<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="end_day" id="end_day" onfocus="WdatePicker({el:'end_day',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'start_day\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>">
&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role_name" size="15" value="<{$roleName}>" />
&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="account_name" size="15" value="<{$accountName}>" />
&nbsp;<{$lang->pet->petUID}>:<input type="text" id="pet_uid" name="pet_uid" size="20" value="<{$petUID}>" />
<input type="submit" class="input2 submitbtn" align="absmiddle" value="搜索"  />
&nbsp;&nbsp;
<br />
</form>
</div>
<br class="clear"/>
<{if $viewData.data}>
<{include file='file:pager.tpl' pages=$pager assign=pager_html}>
<{$pager_html}>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
<thead>
	<tr class='table_list_head'>
		<th align="center" width="10%"><{$lang->pet->datetime}></th>
		<th align="center" width="10%"><{$lang->pet->accountName}></th>
		<th align="center" width="10%"><{$lang->pet->roleName}></th>
		<th align="center" width="5%"><{$lang->pet->playerLevel}></th>
		<th align="center" width="10%"><{$lang->pet->petType}></th>
		<th align="center" width="10%"><{$lang->pet->petUID}></th>
		<th align="center" width="5%"><{$lang->pet->petLevel}></th>
		<th align="center" width="10%"><{$lang->pet->color}></th>
		<th align="center" width="30%"><{$lang->pet->wishDetail}></th>
	</tr>
</thead>
<tbody>
	<{foreach name=loop from=$viewData.data item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center"><{$item.mtime|date_format:'%Y-%m-%d %H:%M:%S'}></td>
		<td align="center" class="cmenu" title="<{$item.role_name}>"><a href="?account_name=<{$item.account_name}>"><{$item.account_name}></a></td>
		<td align="center" class="cmenu" title="<{$item.role_name}>"><a href="?role_name=<{$item.role_name}>"><{$item.role_name}></a></td>
		<td align="center"><{$item.level}></td>
		<td align="center"><{$dictPet[$item.pet_id]}></td>
		<td align="center"><a href="?pet_uid=<{$item.pet_uid}>"><{$item.pet_uid}></a></td>
		<td align="center"><{$item.pet_level}></td>
		<td align="center" bgcolor="#223A3D">
			<font color="<{if $item.color eq 0}>white<{elseif $item.color eq 1}>green<{elseif $item.color eq 2}>skyblue<{elseif $item.color eq 3}>purple<{elseif $item.color eq 4}>orange<{else}>gold<{/if}>"><{$dictColor[$item.color]}></font>
		</td>

		<td align="center"><{$item.detail}></td>

	</tr>
	<{/foreach}>
</tbody>
</table>
<br />
<{$pager_html}>
<{else}>
<font color='red'><{$lang->page->noData}></font>
<{/if}>
</div>

</body>
</html>
