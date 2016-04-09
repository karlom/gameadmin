<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<title>密码修改</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">

<script language="javascript">

var ratingMsgs = ["太短","弱","一般","很好","极佳","未评级"];
var ratingMsgColors = ["#676767","#aa0033","#f5ac00","#6699cc","#008000","#676767"];
var barColors = ["#dddddd","#aa0033","#ffcc33","#6699cc","#008000","#676767"];

function CreateRatePasswdReq() {
	var pwd = document.getElementById("newpass1");
	if(!pwd) return false;
	passwd=pwd.value;
	var min_passwd_len = 6;
	if (passwd.length < min_passwd_len)  {
		if (passwd.length > 0) {
			DrawBar(0);
		} else {
			ResetBar();
		}
	} else {
		//We need to escape the password now so it won't mess up with length test
		rating = checkPasswdRate(passwd);
		DrawBar(rating);
	}
}

function DrawBar(rating) {
	var posbar = document.getElementById('posBar');
	var negbar = document.getElementById('negBar');
	var passwdRating = document.getElementById('passwdRating');
	var barLength = document.getElementById('passwdBar').width;
	if (rating >= 0 && rating <= 4) {  //We successfully got a rating
		posbar.style.width = barLength / 4 * rating + "px";
		negbar.style.width = barLength / 4 * (4 - rating) + "px";
	} else {
		posbar.style.width = "0px";
		negbar.style.width = barLength + "px";
		rating = 5; // Not rated Rating
	}
	posbar.style.background = barColors[rating];
	passwdRating.innerHTML = "<font color='" + ratingMsgColors[rating] + "'>" + ratingMsgs[rating] + "</font>";
}

//Resets the password strength bar back to its initial state without any message showing.
function ResetBar() {
	var posbar = document.getElementById('posBar');
	var negbar = document.getElementById('negBar');
	var passwdRating = document.getElementById('passwdRating');
	var barLength = document.getElementById('passwdBar').width;
	posbar.style.width = "0px";
	negbar.style.width = barLength + "px";
	passwdRating.innerHTML = "";
}


//CharMode函数
//测试某个字符是属于哪一类.
function CharMode(iN){
	if (iN>=48 && iN <=57) //数字
	return 1;
	if (iN>=65 && iN <=90) //大写字母
	return 2;
	if (iN>=97 && iN <=122) //小写
	return 4;
	else
	return 8; //特殊字符
}
//bitTotal函数
//计算出当前密码当中一共有多少种模式
function bitTotal(num){
	modes=0;
	for (i=0;i<4;i++){
		if (num & 1) modes++;
		num>>>=1;
	}
	return modes;
}
//checkStrong函数
//返回密码的强度级别
function checkPasswdRate(sPW){
	if (sPW.length < 8)
	return 0; //密码太短
	Modes=0;
	for (i=0;i<sPW.length;i++){
		//测试每一个字符的类别并统计一共有多少种模式.
		Modes|=CharMode(sPW.charCodeAt(i));
	}
	return bitTotal(Modes);
}
</script>
</HEAD>

<body>
<div id="position">系统管理：修改登录密码</div>
<div class="main">


  <div id="centerm"><div id="content">

  <form name='password' id='password' action='' method='post' onsubmit=''>
<input type='hidden' name='action' id='action' value='update' />
<{if !$changeOk}>
<table cellspacing="1" cellpadding="3" border="0" style="border-color:SkyBlue;border-width:1px;border-style:solid;width:auto;">
	<tr style="color:#232323;background-color:#D7E4F5;font-weight:bold;">
<td colspan='2' class='title' align="middle">密码修改: <{$username}></td></tr>

<tr style="background-color:#EDF2F7;"><td align="right">原密码</td><td>
<input type='password' class='text' name='oldpass' id='oldpass' size='25' maxlength='60' value='' />
</td></tr>
<tr style="background-color:#EDF2F7;"><td align="right">新密码</td><td>
<input type='password' class='text' name='newpass1' id='newpass1' size='25' maxlength='60' value='' onkeyup="CreateRatePasswdReq();" />
</td></tr>
<tr style="background-color:#EDF2F7;"><td align="right">再次输入新密码</td><td>
<input type='password' class='text' name='newpass2' id='newpass2' size='25' maxlength='60' value='' />
</td></tr>

<tr><td colspan="2" style="padding-left:20px;">
 	<table cellSpacing="0" cellPadding="0" border="0">
	    <tbody>
	        <tr>
	            <td vAlign="top" noWrap width="0"><font face="Arial, sans-serif" size="-1">密码强度： </font></td>
	            <td vAlign="top" noWrap><font face="Arial, sans-serif" color="#808080" size="-1"><strong>
	            <div id="passwdRating"></div>
	            </strong></font></td>
	        </tr>
	        <tr>
	            <td height="3"></td>
	        </tr>
	        <tr>
	            <td colSpan="2">
	            <table id="passwdBar" cellSpacing="0" cellPadding="0" width="180" bgColor="#ffffff" border="0">
	                <tbody>
	                    <tr>
	                        <td id="posBar" width="0%" bgColor="#e0e0e0" height="4"></td>
	                        <td id="negBar" width="100%" bgColor="#e0e0e0" height="4"></td>
	                    </tr>
	                </tbody>
	            </table>
	            </td>
	        </tr>
	    </tbody>
	</table>
</td>
</tr>

<tr style="color:#232323;background-color:#D7E4F5;font-weight:bold;">
<td align="right" colspan=2>
<input type='submit' class='button' name='submit'  id='submit' value='保 存' />
&nbsp;&nbsp;
<font color=red><{$message}></font>
</td></tr>
</table>

<{/if}>
<{if $errorMsg}>
<br />
<table class="SumDataGrid" width="600">
	<tr>
		<td style="color:red;">
		<b><{$errorMsg}></b>
		<{if $changeOk}>
		<a style="float:right;color:blue;text-decoration:underline;" href="/module/index.php">进入首页</a>
		<{else}>
		<br/>
		<a style="float:right;color:blue;text-decoration:underline;" href="/module/index.php">暂不修改</a>
		<{/if}>
		</td>
		</tr>
</table>
<{/if}>
</form>

</div></div>
</div>

</body>
</html>