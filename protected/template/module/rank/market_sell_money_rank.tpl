<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><{$lang->menu->marketSellMoneyRank}></title>
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<script type="text/javascript" >
		function changePage(page){
			$("#page").val(page);
			$("#myform").submit();
		}
		$(document).ready(function(){
			$("#account_name").keydown(function(){
				$("#role_name").val('');
		
			});
			$("#role_name").keydown(function(){
				$("#account_name").val('');
		
			});
	
		});
		
	</script>
	
</head>
<body>
	
	<div><{$lang->page->serverOnlineDate}>: <{$minDate}> &nbsp; <{$lang->page->today}>: <{$maxDate}></div>
	
	<br />
	<form id="myform" name="myform" action="" method="POST" accept-charset="utf-8">
	<!--	-->
		<td>&nbsp;<{$lang->page->date}>：<input type="text" size="13" class="Wdate" name="selectDate" id="selectDate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" value="<{$selectDate}>"></td>
		<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
		
		<input type="submit" name="today" id="today" class="submitbtn" value="<{$lang->page->today}>" />
		<input type="submit" name="preday" id="preday" class="submitbtn" value="<{$lang->page->preday}>" />
		<input type="hidden" name="lookingday" id="lookingday" class="submitbtn" value="<{$lookingday}>" />
		<input type="submit" name="nextday" id="nextday" class="submitbtn" value="<{$lang->page->afterday}>" />
	<br />
	<br />
	
	<div><h3><{$lang->page->marketDealGetMoneyRank}>: </h3></div>
	<br />
	<{if $viewData}>
	<!-- pageList start -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
	  <tr>
	    <td height="30" class="even">
			 <{foreach key=key item=item from=$pagelist}>
			 <a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>');"><{$key}></a><span style="width:5px;"></span>
			 <{/foreach}>
			<{$lang->page->record}>(<{$counts}>)&nbsp;&nbsp;&nbsp;<{$lang->page->totalPage}>(<{$pageCount}>)
			<{$lang->page->everyPage}><input type="text" id="record" name="record" size="4" style="text-align:center;" value="<{$record}>"><{$lang->page->row}>
			<{$lang->page->dang}><input id="page" name="page" type="text" class="text" size="3" maxlength="6" style="text-align:center;" value="<{$pageno}>" ><{$lang->page->page}>&nbsp;<input id="btnGo" type="submit" class="button" name="Submit" value="GO">
	    </td>
	  </tr>
	</table>
	<!-- pageList end -->
	
	<table class="DataGrid" style="width:960px">
			<tr >
				<th><{$lang->rank->rank}></th>
				<th><{$lang->rank->dealCount}></th>
				<th><{$lang->rank->playerName}></th>
				<th><{$lang->player->accountName}></th>
			</tr>
			
		<{foreach from=$viewData item=item name=level key=key}>
			<tr align="center">
				<td><{$item.rank}></td>
				<td><{$item.sum_money}></td>
				<td><{$item.role_name}></td>
				<td><{$item.account_name}></td>
			</tr>
		<{/foreach}>
	</table>
	<{else}>		
		<div><{$lang->page->noData}></div>
	<{/if}>
		
	<br />

	</form>
	
</body>
</html>