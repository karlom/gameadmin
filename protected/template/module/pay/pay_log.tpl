<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
		<{$lang->menu->payLogs}>
	</title>
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/ip.js"></script>
	<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
	<script type="text/javascript" src="/static/js/global.js"></script>
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
	
	<div id="position">
	<b><{$lang->menu->class->payAndSpand}>：<{$lang->menu->payLogs}></b>
	</div>

	<form id="myform" name="myform" method="post" action="">
	<div class='divOperation'>
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$dateStart}>' /> 
		<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$dateEnd}>' /> 
	
	&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role_name" size="15" value="<{$role_name}>" />
	&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="account_name" size="20" value="<{$account_name}>" />
	&nbsp;<{$lang->player->order}>:<input type="text" id="billno" name="billno" size="15" value="<{$billno}>" />
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
	
	</div>
	<br />
	<{if $viewData}>
	
	<div><{$lang->pay->dateData}>：<{$lang->pay->payMoney}>(台币):<font color="red"><{$date_data.date_total}></font>, <{$lang->pay->payGold}>:<font color="red"><{$date_data.game_coin}></font>, <{$lang->pay->payRoleCount}>: <font color="red"><{$payRoleCount}></font>  </div>
	<br />
	<div><{$lang->pay->allData}>：<{$lang->pay->payMoney}>(台币):<font color="red"><{$all_data.all_total}></font>, <{$lang->pay->payGold}>:<font color="red"><{$all_data.game_coin}></font>, <{$lang->pay->payRoleCount}>: <font color="red"><{$allPayRoleCount}></font>  </div>
	<div> </div>
	
	<br />
	
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
	
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
		<tr align="center" class='table_list_head'>
	        <td width="15%"><{$lang->player->roleName}></td>
	        <td width="15%"><{$lang->player->accountName}></td>
	        <td width="5%"><{$lang->player->level}></td>
	        <td width="10%"><{$lang->pay->payMoney}></td>
	        <td width="10%"><{$lang->pay->payGold}></td>
	        <td width="15%"><{$lang->pay->buyTime}></td>
	        <td width="20%"><{$lang->pay->billno}></td>
		</tr>
		
	<{foreach name=loop from=$viewData item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td class="cmenu" title="<{$item.role_name}>"><{$item.role_name}></td>
			<td class="cmenu" title="<{$item.role_name}>"><{$item.account_name}></td>
			<td><{$item.level}></td>
			<td><{$item.amt}></td>
			<td><{$item.xianshiCnt}></td>
			<td><{$item.ts|date_format:'%Y-%m-%d %H:%M:%S'}></td>
			<td><{$item.billno}></td>
		</tr>
	<{foreachelse}>
		<font color='red'><{$lang->page->noData}></font>
	<{/foreach}>
	</table>
	<{else}>
		<div class="red"><{$lang->page->noData}></div>
	<{/if}>
	</div>
	</form>
	
</body>
</html>
