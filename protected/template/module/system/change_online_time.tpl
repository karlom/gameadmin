<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><{$lang->menu->changeOnlineTime}></title>
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<script type="text/javascript">
		function showtime(){
			var now=new Date();
			var year=now.getFullYear();
			var month=now.getMonth()+1;
			var day=now.getDate();
			var hours=now.getHours();
			var minutes=now.getMinutes();
			var seconds=now.getSeconds();
			if(minutes < 10) minutes="0"+minutes;
			if(seconds < 10) seconds="0"+seconds;
			time=year+'-'+month+'-'+day +' '+hours+':'+minutes+':'+seconds;
			var timer=document.getElementById('timer');
			timer.innerHTML=time;
		}
		
		function letstart(){
			taskId=setInterval(showtime,500);
		}
		
		window.onload=function(){
			letstart();
		}
		
		function confirmSet(){
			var olDate = document.getElementById("onlinedate").value;
			if( confirm("<{$lang->sys->confirmSet}>"+olDate+" ?") ){
				document.getElementById("action").value = "settime";
				document.getElementById("myform").submit();
			} 
		}
		function confirmClean(){
			if( confirm("<{$lang->sys->confirmClean}>") ){
				document.getElementById("action").value = "cleantime";
				document.getElementById("myform").submit();
			} 
		}
</script>
</head>

<body>
	<{if $msg}>
	<div class="red">!!<{$msg}>!!</div>
	<{/if}>
	<div>***<{$lang->menu->changeOnlineTime}>***</div>
	<table cellspacing="1" class="table_list" width="100%">
		<tr>
			<td height="40"><span class="red" style="font-size: 30px;"><{$attention}></span></td>
		</tr>
	</table>
	<br />
	<{$lang->sys->currentTime}>: <div id="timer" name="timer"></div>
	<br />
	<{$lang->sys->currentOnlineTime}>: <span style="color:red;"><{$onlineDate}></span>
	<br />
	<br />
	<form id="myform" name="myform" action="" method="post">
		<input type="hidden" id="action" name="action" value=""/>
		&nbsp;<{$lang->sys->setOnlineTime}>：<input type="text" size="13" class="Wdate" name="onlinedate" id="onlinedate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<{if $onlineDate}><{$onlineDate}><{else}><{$today}><{/if}>">
		<input type="button" name="set_time" id="set_time" value="<{$lang->sys->set}>" onclick="confirmSet()"/>
		&nbsp;&nbsp;<input type="button" name="clean_time" id="clean_time" value="<{$lang->sys->cleanOnlineTime}>" onclick="confirmClean()"/>
	</form>
</body>

</html>