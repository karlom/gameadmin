<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->destoryFamily}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script language="javascript">
	$(document).ready(function(){
		$("#bt_destory").click(function(){
			var fn = $("#family_name").val();
			if(fn == "") {
				alert('<{$lang->page->inputFamilyName}>');
				return false;
			}
			if(confirm('<{$lang->page->sureDestoryFamily}>: ['+fn+']?')){
			//	$("#action").val("destory");
				$("#myform").submit();
			}
			
		});
	});
</script>

</head>
<body>

<div id="position">
	<b><{$lang->menu->class->msgManage}>：<{$lang->menu->destoryFamily}></b>
</div>

<br />
<div class="msg">
	<{foreach from=$msg item=item}>
	<div class="red"><{$item}></div>
	<{/foreach}>
</div>

<br />
<div>
	<form name="myform" id="myform" method="post" action="<{$smarty.const.URL_SELF}>">
		&nbsp;&nbsp;<{$lang->page->familyName}>: <input type="text" name="family_name" id="family_name" value="" />
		<input name="action" type="hidden" value="destory" />
		<input type="submit" class="button" name="bt_destory" id="bt_destory" value="GO" >
	</form>
	<br />
	<br />
	<div class="red">Warning: <{$lang->page->beCareful}></div>
</div>
</body>
</html>
