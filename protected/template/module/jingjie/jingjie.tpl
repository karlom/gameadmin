<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<title><{$lang->menu->jingjie}></title>
</head>

<style type='text/css'>
.total, .gold, .bind_gold { color: #5D8AFF; font-weight:bolder; }
</style>

<script type="text/javascript">
var row_group = <{$rowGroupJson}>;

var update_summary = function(){
	$('.table_list').each(function(){
		var table = $(this);
		table.find('tfoot td').each(function(){
			if ($(this).attr('class') != ''){
				var sum = 0;
				table.find('tbody .' + $(this).attr('class')).each(function(){
					if( $(this).parents('tr').css('display') != 'none' ){
						sum += parseInt($(this).text());
					}
				});
				$(this).text(sum);
			}
		});
	});
}

var update_summary_pecentage = function(){
	$('.table_list').each(function(){
		var table = $(this);
		var total = 0;
		table.find('tfoot td.gold, tfoot td.bind_gold').each(function(){
			total += parseInt($(this).text());
		});
		if(total === 0){
			table.find('tfoot td.gold, tfoot td.bind_gold').each(function(){
				$(this).text( $(this).text() + '(0%)');
			});
		}else{
			table.find('tfoot td.gold, tfoot td.bind_gold').each(function(){
				$(this).text( $(this).text() + '(' + Math.round( parseFloat($(this).text()) * 100 / total ).toFixed(2) + '%)');
			});
		}
	})
}
$(document).ready(function(){
	$('table.table_list').css('width', '');
	$('input.filter_display').each(function(){
		$(this).click(function(){
			if($(this).attr('checked'))
				$('.' + $(this).attr('name')).show();
			else
				$('.' + $(this).attr('name')).hide();
		})
	})

	$('input.filter_row').each(function(){
		$(this).click(function(){
			if($(this).attr('checked')){
				var a = $(this).attr('id').split('_');
				if(a[1] == 'all'){
					$('.row').show();
				}else{
					var idList = row_group[ a[1] ].idList;
					$('.row').hide();
					$(idList).show();
				}
			}
			update_summary();
			update_summary_pecentage();
		})
	})
	update_summary_pecentage();
})
</script>
<body>

<div id="position"><{$lang->menu->class->jingjieMessage}>：<{$lang->menu->jingjie}></div>

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
<!-- Start 时间搜索  -->
<table>
<tr>
<td>
	<form action="?action=search" id="frm" method="GET"  style="display:inline;">
   		<{$lang->page->time}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" size='12' value='<{$startTime|date_format:'%Y-%m-%d' }>' />    
        <input type="submit" name='search' value="搜索" class="input2 submitbtn"  />
	</form>
</td>
<td>
	<form action="?action=search"  method="GET"  style="display:inline;">
		<input type="submit" name="today" id="today" class="submitbtn" value="<{$lang->page->today}>" />
		<input type="submit" name="preday" id="preday" class="submitbtn" value="<{$lang->page->preday}>" />
		<input type="hidden" name="lookingday" id="lookingday" class="submitbtn" value="<{$lookingDay}>" />
		<input type="submit" name="nextday" id="nextday" class="submitbtn" value="<{$lang->page->afterday}>" />
	</form>
</td>
</tr>
</table>
<!-- End 时间搜索  -->
</br>
<div class="main-container">

<div><{$lang->jingjie->jingjie}><{$lang->jingjie->systemData}>:</div>
<{if $data}>
<table class="DataGrid" cellspacing="0">
	
	<tr>
		<th><{$lang->jingjie->up}><{$lang->jingjie->allCount}></th>
		<td align="left"><{$data.jingjie_count}></td>
	</tr>
	<tr>
		<th><{$lang->jingjie->up}><{$lang->jingjie->failCount}></th>
		<td align="left"><{$data.fail_count}></td>
	</tr>
	<tr>
		<th><{$lang->jingjie->up}><{$lang->jingjie->failCostLingqi}></th>
		<td align="left"><{$data.fail_cost_lingqi}></td>
	</tr>
	<tr>
		<th><{$lang->jingjie->costItemCount}></th>
		<td align="left"><{$data.item_count}></td>
	</tr>
	<tr>
		<th><{$lang->jingjie->jingjie}><{$lang->jingjie->roleCount}></th>
		<td align="left"><{$data.role_count}></td>
	</tr>
	<tr>
		<th><{$lang->jingjie->maxLevel}></th>
		<td align="left"><{$data.max_jingjie_level}></td>
	</tr>
	<tr>
		<th><{$lang->jingjie->roleNameList}> (<{$data.max_jingjie_role_count}><{$lang->page->ren}>)</th>
		<td align="left" style="width:450px;">
			<div style="overflow-y:scroll;width:435px;height:60px;word-wrap:break-word;"><{$data.max_jingjie_rolename_list}></div>
		</td>
	</tr>
	
</table>

	<br />
	<div><{$lang->jingjie->maxSkillLevel}>:</div>
	<{if $data.skillData}>
	<table class="DataGrid">
		<tr>
			<th><{$lang->skill->skillName}></th>
			<th><{$lang->jingjie->skill}>ID</th>
			<th><{$lang->skill->skillLevel}></th>
			<th><{$lang->jingjie->roleNameList}></th>
		</tr>
		<{foreach from=$data.skillData item=skill key=key}>
		<tr>
			<td align="center"><{$skill.skillName}></td>
			<td align="center"><{$skill.skillID}></td>
			<td align="center"><{$skill.skillLevel}></td>
			<td align="center"><{$skill.roleNameList}></td>
		</tr>
		<{/foreach}>
		</table>
	<{/if}>

<{else}>
<div><h3><{$lang->page->noData}></h3></div>
<{/if}>
    
</div>
</body>
</html>
