<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->balanceSort}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script> 
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->spendData}>：<{$lang->menu->balanceSort}></b>
</div>
<form id="myform" name="myform" method="get" action="" style="display: inline;">
<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="date" id="date" onfocus="WdatePicker({el:'date',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})"  value="<{$date}>">
<label><{$lang->gold->dec_send_gold}><input type="checkbox" name="filter" <{if $filter}>checked<{/if}> /></label>
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
</form>
<div>
	<{$lang->page->remark}>：<font color='red'><{$lang->gold->balance_remark}></font>
</div>
<{include file='file:pager.tpl' pages=$pages curren_uri=$curren_uri assign=page_html}>
<{$page_html}>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
	<tr class='table_list_head'>
        <td width="6%"><{$lang->gold->rank}></td>
        <td width="6%"><{$lang->player->roleName}></td>
        <td width="5%"><{$lang->player->accountName}></td>
        <td width="8%">
        	<{$lang->gold->total_goldBalance}>
        	<a href="<{$smarty.const.URL_SELF}>?page=<{$pageNo}>&sort_type=total_gold" title="升序排序"><span <{if 'total_gold'==$sort_type}>class="red"<{/if}>>↑</span></a> 
        	<a href="<{$smarty.const.URL_SELF}>?page=<{$pageNo}>&sort_type=total_gold desc" title="降序排序"><span <{if 'total_gold desc'==$sort_type}>class="red"<{/if}>>↓</span></a>
        </td>
        <td width="5%">
        	<{$lang->gold->goldBalance}>
        	<a class="sort_type" href="<{$smarty.const.URL_SELF}>?page=<{$pageNo}>&sort_type=remain_gold" title="升序排序"><span <{if 'remain_gold'==$sort_type}>class="red"<{/if}>>↑</span></a> 
        	<a class="sort_type" href="<{$smarty.const.URL_SELF}>?page=<{$pageNo}>&sort_type=remain_gold desc" title="降序排序"><span <{if 'remain_gold desc'==$sort_type}>class="red"<{/if}>>↓</span></a>
        </td>
        <td width="5%">
        	<{$lang->gold->bind_goldBalance}>
        	<a href="<{$smarty.const.URL_SELF}>?page=<{$pageNo}>&sort_type=remain_bind_gold" title="升序排序"><span <{if 'remain_bind_gold'==$sort_type}>class="red"<{/if}>>↑</span></a> 
        	<a href="<{$smarty.const.URL_SELF}>?page=<{$pageNo}>&sort_type=remain_bind_gold desc" title="降序排序"><span <{if 'remain_bind_gold desc'==$sort_type}>class="red"<{/if}>>↓</span></a>
        </td>
	</tr>
	<{foreach name=loop from=$result item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$item.rank}></td>
		<td><a href="../pay/gold_user_record.php?role[roleName]=<{$item.roleName}>"><{$item.roleName}></a></td>
		<td><a href="../pay/gold_user_record.php?role[accountName]=<{$item.accountName}>"><{$item.accountName}></a></td>
		<td><{$item.balanceTotal}></td>
		<td><{$item.goldBalance}></td>
		<td><{$item.bindGoldBalance}></td>
	</tr>
	<{foreachelse}>
<font color='red'><{$lang->page->noData}></font>
<{/foreach}>
</table>
<{$page_html}>
</div>
</form>
</body>
</html>
