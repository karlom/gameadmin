<?php /* Smarty version 2.6.25, created on 2014-04-21 15:54:40
         compiled from left_gen.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主菜单</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<style type="text/css">
html { overflow:-moz-scrollbars-vertical;overflow-y:scroll; }
body { margin:3px; padding:0px; font-size:12px; font-family:"Courier New", Courier, monospace; background:#e9eef5; margin:3 0 0 0;}
.tdborder {
	border-left: 1px solid #43938B;
	border-right: 1px solid #43938B;
	border-bottom: 1px solid #43938B;
}
.tdrl {
	border-left: 1px solid #788C47;
	border-right: 1px solid #788C47;
}
.topitem {
	cursor: hand;
	background-image:url(/static/images/mtbg2.gif);
	height:24px;
	width:98%;
	clear:left
}
.itemsct {
	background-color:#e9eef5;
/*	margin-bottom:6px; */
	width:98%;
}
.itemem {
	text-align:left;
	clear:left;
	height:21px;
}
.tdl {
	float:left;
	margin-top:2px;
	margin-left:6px;
	margin-right:5px
}
.tdr {
	float:left;
	margin-top:2px;
	height:20px;
}
.topl {
	float:left;
	margin-left:6px;
	margin-right:3px;
	padding-top: 4px;
	background:url(/static/image/home.png) no-repeat -133px -153px;
}
.topr {
	padding-top:4px;
	cursor:pointer;
	color:#FFFFFF;
}
.toprt {
	text-align:center;
	padding-top:3px
}
body {
	scrollbar-base-color:#8CC1FE;
	scrollbar-arrow-color:#FFFFFF;
	scrollbar-shadow-color:#6994C2
}
.red{
	background-color:#C591C5;
}
.sep{border-top:1px solid #cbcfd5;border-bottom:1px solid #fdfdfe;}

#menufilter{
	background: url("/static/images/magnifier.png") no-repeat scroll 3px 3px #fff;
    border: 1px solid #7AB5E0;
    height: 20px;
    margin-left: 3px;
    padding-left: 22px;
    width: 133px;
}
.gray{
	color:gray;
}
</style>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript">
showHide = function(objID) {	
	$('#' + objID).toggle();
}
var highLight = function(txt, kw, color){
	return txt.replace(kw, '<span style="background:' + color + '">' + kw + '</span>');
}
var stripTags = function(txt){
	return txt.replace(/(<([^>]+)>)/ig,"");
}
var tips = '搜索菜单...';
$(document).ready(function(){
	$(".itemem").click(function(){
		$(".itemem").removeClass("red");
		$(this).addClass("red");
	});
	
//	$('.topitem').click(function(){$('#menufilter').focus()})
	
	$('#menufilter').focusin(function(){
		if($(this).val() == tips){
			$(this).val('').removeClass('gray');
		}
	}).val(tips).addClass('gray');
	$('#menufilter').focusout(function(){
		if($(this).val() == ''){
			$(this).val(tips).addClass('gray');
		}
	})
	$('#menufilter').keyup(function(){
		var keyword = $.trim($(this).val());
		if(keyword == ''){ 
			$('.tdr').parent().show(); 
			$('.tdr > a').each(function(){
				$(this).text( stripTags($(this).text()) );
			})
		}else{
			$('.tdr > a').each(function(){
				if($(this).text().indexOf(keyword)>=0)
				{
				//	console.log(highLight($(this).text(), keyword, '#f0f'));
					$(this).html( highLight($(this).text(), keyword, 'yellow') );
					$(this).parent().parent().show();
				}else{ 
					$(this).parent().parent().hide();
					$(this).text( stripTags($(this).text()) );
				}
			});
		}
	})
});
</script>
</head>

<body style="margin: 0; padding: 0;">
   	<div class='topitem' align='left' style="position: fixed;background:#e9eef5; height:45px;">
   		<div align='center'><?php echo $this->_tpl_vars['GAME_ZH_NAME']; ?>
<?php echo $this->_tpl_vars['SERVER']; ?>
<?php echo $this->_tpl_vars['lang']->page->fu; ?>
</div>
   		<input type="text" id="menufilter"/>
 	</div>
	<div id="all" style="padding-top: 45px;">
  		
 <?php if ($this->_tpl_vars['COMMON_MENU']): ?>
 <?php $_from = $this->_tpl_vars['COMMON_MENU']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['catid'] => $this->_tpl_vars['catdata']):
?>
    	<div onClick='showHide("items_1000")' class='topitem' align='left'>
        	<div class='topl'><img src='/static/images/bigsmile.png' width='16' height='16' border='0' align="absmiddle"></div>
        	<div class='topr'><?php echo $this->_tpl_vars['catdata']['name']; ?>
</div>
      	</div>
      	<div style='clear:both'></div>
      	<div style='display:block' id='items_1000' class='itemsct'>
    <?php $_from = $this->_tpl_vars['catdata']['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pid'] => $this->_tpl_vars['page']):
?>
	<?php if (0 == $this->_supers['session']['uid'] || 1 == $this->_tpl_vars['page']['isshow']): ?>
            <dl class='itemem'>
              <dd class='tdl'><img src='/static/images/16-heart-silver-l.png' width='16' height='16' alt=''/></dd>
              <dd class='tdr'><a href='getMenuUrl.php?target=<?php echo $this->_tpl_vars['pid']; ?>
' target='main'><?php echo $this->_tpl_vars['page']['name']; ?>
</a></dd>
              <div class="sep"></div>
            </dl>
	<?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
      	</div>
<?php endforeach; endif; unset($_from); ?>
 <?php endif; ?>
  		
<?php $_from = $this->_tpl_vars['catalogue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['catid'] => $this->_tpl_vars['catdata']):
?>
    	<div onClick='showHide("items_<?php echo $this->_tpl_vars['catid']; ?>
")' class='topitem' align='left'>
        	<div class='topl'><img src='/static/images/toggle.png' width='16' height='16' border='0' align="middle"></div>
        	<div class='topr'><?php echo $this->_tpl_vars['catdata']['name']; ?>
</div>
        	
      	</div>
      	<div style='clear:both'></div>
      	<div style='display:block' id='items_<?php echo $this->_tpl_vars['catid']; ?>
' class='itemsct'>
    <?php $_from = $this->_tpl_vars['catdata']['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pid'] => $this->_tpl_vars['page']):
?>
	<?php if (0 == $this->_supers['session']['uid'] || 1 == $this->_tpl_vars['page']['isshow']): ?>
            <dl class='itemem'>
            <?php if ($this->_tpl_vars['lang']->menu->class->baseDataConfig == $this->_tpl_vars['page']['class'] || $this->_tpl_vars['lang']->menu->class->systemManage == $this->_tpl_vars['page']['class']): ?>
              <dd class='tdl'><img src='/static/images/setting.png' width='16' height='16' alt=''/></dd>
            <?php elseif (0 == $this->_supers['session']['uid'] || 1 == $this->_tpl_vars['page']['isshow']): ?>
            	<dd class='tdl'><img src='/static/images/graph.gif' width='16' height='16' alt=''/></dd>
            <?php endif; ?>
              <dd class='tdr'><a href='getMenuUrl.php?target=<?php echo $this->_tpl_vars['pid']; ?>
' target='main'><?php echo $this->_tpl_vars['page']['name']; ?>
</a></dd>
              <div class="sep"></div>
            </dl>
	<?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
      	</div>
<?php endforeach; endif; unset($_from); ?>
    </div>

</body>
</html>