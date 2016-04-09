<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$current.name}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
</head>
<style>
body {
    font-family:verdana,arial,sans-serif,"宋体";
    font-size:12px;
    margin:0px;
    padding:0px;
}
 
a {
    color: #003499;
    text-decoration: none;
}
 
a:hover {
    color: #000000;
    text-decoration: underline;
}
 
#tabnav {
    background:#D7E4F5;
    border-bottom:1px solid SkyBlue;
    padding-bottom:3px;
    margin-top:-5px;
}
 
#tabnav ul {
    padding:15px 0px 3px 0px;
    margin:5px 0px 5px 0px;
    list-style:none;
    background:#f1f1f1;
    border-bottom:1px solid SkyBlue;
 
}
 
#tabnav ul li {
    display:inline;
    margin-left:10px;
}
 
#tabnav ul li a {
    background:#fff;
    padding:5px 10px 5px 10px;
    border:1px solid SkyBlue;
    border-bottom: none;
}
 
#tabnav ul li a:hover {
    background:#F5F5DC;
}
 
#tabnav ul li a.here {
	font-weight: bold;
    background:#D7E4F5;
    padding:5px 10px 5px 10px;
    border-top:1px solid SkyBlue;
    border-left:1px solid SkyBlue;
    border-right:1px solid SkyBlue;
    border-bottom:1px solid #D7E4F5;
}
 
#tabnav ul li a.here:hover {
    background:#D7E4F5;
}
#tabnav ul li a.refresh{
    background: #fff url(/static/images/arrow_refresh.png) 8px 4px no-repeat;

}
#tabnav ul li a.refresh:hover{

    text-decoration: none;
}
.tab-container{
	display:none;
	height:100%;
	width:100%;
}
#tab-panel{
	height:100%;
	width:100%;
}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tabnav .tab').click(function(){
			$('.tab').removeClass('here');
			$(this).addClass('here');
			$('.tab-container').css('display', 'none');
			if( $('#' + $(this).attr('rel')).length <= 0 ){//动态载入iframe，避免一打开就载入全部
				$('#tab-panel').append('<iframe id="' + $(this).attr('rel') + '"  name="' + $(this).attr('rel') + '" class="tab-container" src="' + $(this).attr('href') + '" frameborder="0" width="100%" onload="this.height=' + $(this).attr('rel') + '.document.body.scrollHeight"></iframe>');
			}
			$('#' + $(this).attr('rel')).css('display', 'block');
			return false;
		});
		$('#tabnav .refresh').click(function(){
			$('.tab-container').each(function(){
				if($(this).css('display') != 'none'){
					$(this).attr('src', $(this).attr('src'));
				}
			})
			return false;
		})
		$('#tab-panel').css('height', ($(window).height() - 88) + 'px')
		$($('.tab')[0]).trigger('click');//触发第一个tab的click事件
	})
</script>
<body>
<div id="position">
<b><{$current.class}>：<{$current.name }></b>
</div> 
<!-- Start 成功信息提示 -->
<{if $successMsg}>
<div class="success_msg_box">
	<{$successMsg}>
</div>
<{/if}>
<!-- End 成功信息提示 -->

<!-- Start 错误信息提示 -->
<{if $errorMsg}>
<div class="error_msg_box">
	<{$errorMsg}>
</div>
<{/if}>
<!-- End 错误信息提示 -->
<div id="tabnav">
<ul>
	<{foreach from=$menus name=loop_tabs key=m_id item=menu}>
		<li><a href="<{$menu.url}>" rel="tc_<{$m_id}>" class="tab"><{$menu.name}></a></li>
	<{/foreach}>
		<li><a href="<{$menu.url}>" rel="tc_<{$m_id}>" class="refresh">&nbsp;&nbsp;</a></li>
</ul>
</div>
<div id="tab-panel">
	
</div>
</body>
</html>
