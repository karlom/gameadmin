<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->kickAllPlayer}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#useroff").click(function(){
			if(confirm("<{$lang->page->useroffInfo}>?")){
				$("#countdown").show();
				return true;
//				$("#myform").submit();
			}else{
				return false;
			}
		});
	});
</script>
</head>
<body>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->kickAllPlayer}></b>
</div>
<{if $msg}>
<div class="red">!!<{$msg}>!!</div>
<{/if}>
<div style="padding: 5px;">
******<{$lang->page->useroffline}>
</div>
	<table cellspacing="1" class="table_list" width="100%">
		<tr>
			<td height="40"><span class="red" style="font-size: 30px;"><{$killAllPlayerDes}></span></td>
		</tr>
	</table>
	<br />
	<div><{$lang->player->onlineUserCount}>(<{$online.date}>): <font color="red"><{$online.online}></font>&nbsp;<{$lang->page->ren}></div>
	<br />

<form name="myform" id="myform" method="post" action="">

	<input type="submit" name="useroff" id="useroff" value="<{$lang->page->userofflineBtn}>" />
</form>
	<br />
	<div name="countdown" id="countdown" style="display:none;">**<{$lang->page->useroffTips}>**</div>
	
</body>
</html>
