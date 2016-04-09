var t = null;
var loaded = false;
var initContextMenu = function()
{
	if('function' == typeof($(document).contextMenu)){//判断是否载入指定插件
		$(document.body).append('<ul id="myRoleNameMenu" class="contextMenu">' +
				'<li class="status"><a href="#status">查看状态</a></li>' +
				'<li class="task_status separator"><a href="#task_status">查看任务状态</a></li>' +
				'<li class="pay separator"><a href="#pay">查看充值记录</a></li>' +
				'<li class="pay separator"><a href="#gold">查看元宝统计</a></li>' +
				'<li class="item separator"><a href="#item">查看道具记录</a></li>' +
			'</ul>');
		
		$(".cmenu").contextMenu({
			menu: 'myRoleNameMenu'
		},
		function(action, el, pos) {
			var url = '';
			switch(action){
				case 'status' : url = '/module/player/player_status.php?action=search&role[role_name]=';break;
				case 'task_status' : url = '/module/player/player_task_status.php?action=search&role[role_name]=';break;
				case 'pay' : url = '/module/pay/pay_player.php?role_name=';break;
				case 'gold' : url = '/module/gold/usage_statistics.php?role[role_name]=';break;
				case 'item' : url = '/module/item/item_follow.php?role_name=';break;
				default : url = '/module/player/player_status.php?action=search&role[role_name]=';break;
			}
			url += $.trim($(el).attr('title'));
	//		window.location.href = url;
			window.open(url,'_blank');
		});
		clearTimeout(t);
	}else{
		if(loaded == false){
			$(document.head).append('<link rel="stylesheet" href="/static/js/contextMenu/jquery.contextMenu.css" type="text/css" /><script type="text/javascript" src="/static/js/contextMenu/jquery.contextMenu.js"></script>');
			loaded = true;
		}
		t = setTimeout('initContextMenu();', 20);
	}
}

$(document).ready(function(){
	if('function' == typeof($(document).colResizable)){//判断是否载入指定插件
		$(".table_list, .DataGrid").each(function(){
			if(!$(this).hasClass('no-resize')){//有no-resize这个class则不添加
				$(this).colResizable({
					liveDrag:true,
					headerOnly:true
				}); 
			}
		})
	}
	
	if('function' == typeof(queryIP) ){ //判断是否载入指定插件
		$('.show-ip').live('click', function(){
			var ip = $(this).text();
			queryIP(ip);
		})
	}
	
	$('input[type=submit]').click(function(){
		if($(this).hasClass('submitbtn')){ 
			$(this).val('提交中...');
			return true;
		}
	})
	
	initContextMenu()
	
});	


