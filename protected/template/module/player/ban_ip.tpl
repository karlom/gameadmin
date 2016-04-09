<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->banIp}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/ip.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script language="javascript">
$(document).ready(function(){
	$("#ban_time_arr").change(function(){
		if(1 == $(this).val()){
			$("input[id=ban_time]").show();
		}else{
			$("input[id=ban_time]").hide();
		}
	});
	$("input[name=banButton]").click(function(){
		if("" == $("input[name=ban_ip]").val()){
			alert("IP<{$lang->verify->isNotNull}>");
			return false;
		}else if(!isIP($("input[name=ban_ip]").val())){
			return false;
		}else if(1 == $("select[name=ban_time_arr]").val() && 0 >= $("input[name=ban_time]").val()){
			alert("<{$lang->alert->banIpTimeError}>");
			return false;
		}
		if(!confirm("<{$lang->alert->banIpConfirm}>")){
			return false;
		}
	});

	$('#check_ip').click(function(){
		if(!isIP($("#ban_ip").val())){ return false;}
		$.ajax({
			type: "get",
			url: "?",
			data: "action=checkonlinebyip&ip=" + $("#ban_ip").val(),
			dataType: 'json',
			success: function(ret){
				
				$('#ip_result').text('IP：' + $("#ban_ip").val() +  ' <{$lang->page->onlineNum}> ' + ret['data'] +  ' 。');
			}		
		})
	});
	
});

function isIP(str) {
	var regIP = /^(\d+)\.(\d+)\.(\d+)\.(\d+)$/g;
	var result = regIP.test(str);
	//var result = str.match(regIP);
	if (result && RegExp.$1<256 && RegExp.$2<256 && RegExp.$3<256 && RegExp.$4<256) {
		return true;
	} else {
		alert("<{$lang->page->mustBeIP}>");
		return false;
	}
}
    function changePage(page){
	$("#page").val(page);
        $("#myform").submit();
    }
</script>
</head>
<body>
<!-- 
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->banIp}></b>
</div>
-->
<{*
<form name="myform2" id="myform2" method="post" action="<{$smarty.const.URL_SELF}>">
	<table cellspacing="1" class="table_list" width="100%">
		<tr class="trOdd">
			<td align="right" width="150">IP:</td>
			<td><input type="text" name="ban_ip" id="ban_ip" value="" /></td>
		</tr>
		<tr class="trEven">
			<td align="right"><{$lang->player->banTimeLength}>:</td>
			<td>
                <select name="ban_time_arr" id="ban_time_arr"><{html_options options=$banTime}></select>
                <input size="10" value="30" name="ban_time" id="ban_time"/>
            </td>
		</tr>
		<tr class="trOdd">
			<td colspan="2" >
				<input name="action" type="hidden" value="ban" />
				<input type="submit" class="button" name="banButton" value="<{$lang->player->ban}>" style=" margin-left:400px;height:30px">
			</td>
		</tr>
		<{if $msg}>
		<tr class="<{cycle values='trEven,trOdd'}>">
			<td colspan="2"><span style="color:red;"><{$msg}></span></td>
		</tr>
		<{/if}>
	</table>
</form>
<div class='divOperation' style="margin-top: 10px;">
	IP:<input type="text" id="search_ip" name="search_ip" size="15" value="<{if $keyWord.search_ip != ''}><{$keyWord.search_ip}><{/if}>" />
	<input type="image" src="/static/images/search.gif" class="input2"  align="absmiddle" />
</div>
*}>
<div id="ip_result" style="color:red;"></div>
<form id="myform" name="myform" method="POST" action="<{$smarty.const.URL_SELF}>">

<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
  <tr>
    <td height="30" class="even">
 <{foreach key=key item=item from=$pagelist}>
 <a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>')"><{$key}></a><span style="width:5px;"></span>
 <{/foreach}>
<{$lang->page->totalPage}>(<{$keyWord.page_count}>)&nbsp;&nbsp;<{$lang->page->record}>:<{$keyWord.record_count}>
<{$lang->page->everyPage}><input type="text" id="record" name="record" size="4" style="text-align:center;" value="<{$keyWord.record}>"><{$lang->page->row}>
  <{$lang->page->dang}><input id="page" name="page" type="text" class="text" size="3" maxlength="6" style="text-align:center;" value="<{$keyWord.page}>" ><{$lang->page->page}>&nbsp;<input id="btnGo" type="submit" class="button" name="Submit" value="GO">
    </td>
  </tr>
</table>
</form>

<form name="myform2" id="myform2" method="post" action="<{$smarty.const.URL_SELF}>">
<table cellspacing="1" cellpadding="3" border="0" class="table_list">
	<tr class='table_list_head'>
		<!--th width="4%">ID</th-->
		<th width="25%"><{$lang->page->IPAddr}></th>
		<th width="10%"><{$lang->player->status}></th>
<!--  	<th width="15%"><{$lang->page->opTime}></th> -->	
        <th width="20%"><{$lang->page->endTime}></th>
        <th width="20%"><{$lang->page->banReason}></th>
		<th width="12%"><{$lang->page->operator}></th>
        <th width="13%"><{$lang->page->op}></th>
	</tr>
	<tr align="center" class='trOdd'>
		<!--td><{$key+1}></td-->
		<td><input type="text" name="ban_ip" id="ban_ip" value="" />&nbsp;<input type="button" id="check_ip" name="check_ip" value="<{$lang->page->onlineCountByIP}>"/> </td>
		<td>&nbsp;</td>
        <td>
        	<select name="ban_time_arr" id="ban_time_arr"><{html_options options=$banTime}></select>
            <input size="10" value="30" name="ban_time" id="ban_time"/>
        </td>
        <td><input type="text" name="ban_reason" /></td>
		<td><input type="submit" name="banButton" value="<{$lang->player->ban}>"/></td>
        <td><input type="submit" id="remove_expire" name="remove_expire" value="<{$lang->page->removeExpireIP}>"/></td>
	</tr>
	<{ foreach from=$viewData item=row key=key }>
	<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
		<!--td><{$key+1}></td-->
		<td><a href="javascript:void(0)" class="show-ip"><{$row.ban_ip}></a></td>
		<td><span style="<{if 1 == $row.status}>color: red"><{$lang->player->ban}><{elseif 2 == $row.status}>color: green"><{$lang->player->unBanByHand}><{elseif 0 == $row.status}>color: green"><{$lang->player->unBan}><{/if}></span></span></td>
	<!--  	<td><{$row.ban_time}></td>-->	
        <td><{$row.end_time}></td>
        <td><{$row.reason}></td>
		<td><{$row.op_user}></td>
        <td><{if 0 == $row.status || 2 == $row.status}>已解封<{else}><a href="ban_ip.php?action=unban&amp;banTime=0&amp;id=<{$row.id}>&amp;ip=<{$row.ban_ip}>" class="link-button">解封</a><{/if}></td>
	</tr>
	<{/foreach}>
</table>
</form>
</body>
</html>
