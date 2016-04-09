<?php /* Smarty version 2.6.25, created on 2014-04-21 15:54:40
         compiled from top.html */ ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $this->_tpl_vars['lang']->sys->title; ?>
</title>
<link href="/static/css/base.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<style>
	body { margin:0; padding:0; }
	#ldd1 { float:left; position:absolute; left:0px; top:0px; }
	.bbg  { float:left; position:absolute; left:5px; top:5px; width:360px; font-size:30px; color:#ffffff;}
	.bbg1  { float:left; position:absolute; left:305px;top:5px;}
	#ldd2 { float:right; }
	#ldd2 dd{ float:right; }
	#ldd2 dl{ margin-right:10px }
	#sktop{ text-align:right; margin-right:5px;
  height:22; margin-top:4px; margin-bottom:3px; line-height:22px  }
	.bdd{ float:right; height:26px; padding-left:6px; padding-right:6px;
	     line-height:29px;
	     border-right:1px solid #2C6FA8;border-left:1px solid #efefef }
	.bdd2{ float:right; height:26px; padding-left:6px; padding-right:6px;
	     line-height:29px; color:#ffffff;background-image:url(/static/images/tn2.gif);
	     border-right:1px solid #2C6FA8;border-left:1px solid #efefef }
	#bdds{ float:right; height:26px; padding-left:3px; padding-right:6px;
	     line-height:29px;
	     border-right:1px solid #2C6FA8; }
	#bdde{ float:right; height:26px; padding-left:6px; padding-right:3px;
	     line-height:29px; color:red;background-image:url(/static/images/tn2.gif);
	     border-left:1px solid #efefef }
	#main{ margin:0px; padding:0px; width:100%; height:60px; background-image:url(/static/images/ntbg.gif);color:#ffffff; }
</style>
<script language='javascript'>
var selectServer = "<?php echo $this->_supers['session']['gameAdminServer']; ?>
";
$(document).ready(function(){
	$("div[class=servers]").click(function(){
		var server = $(this).attr("id");
		if(selectServer != server){
			ChangeServer(server);
		}
	});
});

function $Nav(){
	if(window.navigator.userAgent.indexOf("MSIE")>=1) return 'IE';
	else if(window.navigator.userAgent.indexOf("Firefox")>=1) return 'FF';
	else return "OT";
}

var preID = 0;

function OpenMenu(cid,lurl,rurl,bid){
	if($Nav()=='IE'){
		if(rurl!='') top.document.frames.main.location = rurl;
		if(cid > -1) top.document.frames.menu.location = 'index_menu.php?c='+cid;
		else if(lurl!='') top.document.frames.menu.location = lurl;
		if(bid>0) document.getElementById("d"+bid).className = 'bdd2';
		if(preID>0 && preID!=bid) document.getElementById("d"+preID).className = 'bdd';
		preID = bid;
	}else{
		if(rurl!='') top.document.getElementById("main").src = rurl;
		if(cid > -1) top.document.getElementById("menu").src = 'index_menu.php?c='+cid;
		else if(lurl!='') top.document.getElementById("menu").src = lurl;
		if(bid>0) document.getElementById("d"+bid).className = 'bdd2';
		if(preID>0 && preID!=bid) document.getElementById("d"+preID).className = 'bdd';
		preID = bid;
	}
}

var preFrameW = '160,*';
var FrameHide = 0;
function ChangeMenu(way){
	var addwidth = 10;
	var fcol = top.document.all.bodyFrame.cols;
	if(way==1) addwidth = 10;
	else if(way==-1) addwidth = -10;
	else if(way==0){
		if(FrameHide == 0){
			preFrameW = top.document.all.bodyFrame.cols;
			top.document.all.bodyFrame.cols = '0,*';
			FrameHide = 1;
			return;
		}else{
			top.document.all.bodyFrame.cols = preFrameW;
			FrameHide = 0;
			return;
		}
	}
	fcols = fcol.split(',');
	fcols[0] = parseInt(fcols[0]) + addwidth;
	top.document.all.bodyFrame.cols = fcols[0]+',*';
	
}

function resetBT(){
	if(preID>0) document.getElementById("d"+preID).className = 'bdd';
	preID = 0;
}
function ChangeServer(server){
//	var server = $("select[id=serverlist]").val();
	var frame_obj = $(parent.document.getElementsByTagName("frameset")[1]);
//	frame_obj.find("#menu").attr("src","/module/left.php?gameadmin_server="+server);
//	frame_obj.find("#main").attr("src","/module/main.php?gameadmin_server="+server);
	location.href = "?gameadmin_server="+server;
//	alert(frame_obj.find("#menu").html());
	
}
</script>
</head>
<body leftMargin='0' topMargin='0'>

<div id='ldd1'>
	<span class='bbg'>《<?php echo $this->_tpl_vars['GAME_ZH_NAME']; ?>
》<?php echo $this->_tpl_vars['lang']->sys->title; ?>
</span>
	<span class='bbg1'>	
		<select name="serverlist" id="serverlist" onchange="ChangeServer(this.options[this.options.selectedIndex].value)"> 
			<?php $_from = $this->_tpl_vars['server_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ser'] => $this->_tpl_vars['name']):
?>
				<option label="<?php echo $this->_tpl_vars['ser']; ?>
" value="<?php echo $this->_tpl_vars['ser']; ?>
" <?php if ($this->_tpl_vars['ser'] == $this->_supers['session']['gameAdminServer']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['name']; ?>
</option> 
			<?php endforeach; endif; unset($_from); ?>
		</select>
		<br />
		<?php if ($this->_tpl_vars['combine_server_list']): ?>
		<select name="combine_serverlist" id="combine_serverlist" onchange="ChangeServer(this.options[this.options.selectedIndex].value)"> 
			<?php $_from = $this->_tpl_vars['combine_server_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ser'] => $this->_tpl_vars['name']):
?>
				<option label="<?php echo $this->_tpl_vars['ser']; ?>
" value="<?php echo $this->_tpl_vars['ser']; ?>
" <?php if ($this->_tpl_vars['ser'] == $this->_supers['session']['gameAdminServer']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['name']; ?>
</option> 
			<?php endforeach; endif; unset($_from); ?>
		</select>
		<?php endif; ?>
	</span>
	<div style="margin-left: 380px; margin-top: 2px;margin-right: 160px;">
		<?php $_from = $this->_tpl_vars['server_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ser'] => $this->_tpl_vars['name']):
?>
			<div id="<?php echo $this->_tpl_vars['ser']; ?>
" class="servers" style="float: left; height: 16px; padding: 2px; 
				<?php if ($this->_tpl_vars['ser'] == $this->_supers['session']['gameAdminServer']): ?>
					background:#61A8DB;color:#FFFFFF;
				<?php else: ?>
					background: #FFFFFF; cursor: pointer;
				<?php endif; ?> 
					border: 1px solid #ccc; margin: 2px; text-align: center;">
				<?php if ("" != $this->_tpl_vars['name']): ?><?php echo $this->_tpl_vars['name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['ser']; ?>
<?php endif; ?>
			</div>
		<?php endforeach; endif; unset($_from); ?>
	</div>
</div>
<div id='main'>
	<div id='ldd2'>
    <div id='sktop'>
		<?php echo $this->_tpl_vars['lang']->sys->welcome; ?>
<?php echo $this->_tpl_vars['username']; ?>
&nbsp;.&nbsp;
	</div>
    <dl>
	  <dd style="float:right; height:26px; padding-left:6px; padding-right:6px;line-height:29px; " >
		<a href="javascript:ChangeMenu(-1)">
    		<img src='/static/images/left.png' border='0' alt="减小左框架"></a>
		<a href="javascript:ChangeMenu(0)">
			<img src='/static/images/frame_on.gif' border='0' alt="隐藏/显示左框架"></a>
		<a href="javascript:ChangeMenu(1)">
			<img src='/static/images/right.png' border='0' alt="增大左框架"></a>
	  </dd>
      <dd><img src='/static/images/ttn3.gif' width='7' height='26'></dd>
      <dd id='bdde'><a href='logout.php' target='_parent' style="color:#000000;"><?php echo $this->_tpl_vars['lang']->sys->logout; ?>
</a></dd>
      <dd class='bdd2' ><a style="color:#000000;" href="javascript:OpenMenu(-1,'left.php','main.php',0)"><?php echo $this->_tpl_vars['lang']->sys->main; ?>
</a></dd>
      <dd><img src='/static/images/ttn1.gif' width='20' height='26'></dd>
    </dl>
  </div>
</div>
</div>
</body>
</html>