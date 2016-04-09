<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><{$lang->menu->paySort}></title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script language="javascript">
$(document).ready(function(){
	$("#account_name").keydown(function(){
    	$("#role_name").val('');
    	$("#role_id").val('');
    });
    $("#role_name").keydown(function(){
    	$("#account_name").val('');
    	$("#role_id").val('');
    });
    $("#role_id").keydown(function(){
    	$("#account_name").val('');
    	$("#role_name").val('');
    });
});
function load_out(){
	$("#excel").val(true);
	$("#myform").submit();
	$("#excel").val('');
}
</script>
<style type="text/css">
	.hr_red{
		background-color:red;
		width:6px;
	}
</style>
</head>

<body>
	<div id="position"><b><{$lang->menu->class->payAndSpand}>：<{$lang->menu->paySort}></b></div>
	<form id="myform" name="myform" method="post" action="<{$URL_SELF}>">
<div class='divOperation'>
<{$lang->page->roleName}>:<input type="text" id="role_name" name="role[role_name]" size="10" value="<{$role.role_name}>" />
<{$lang->page->accountName}>:<input type="text" id="account_name" name="role[account_name]" size="10" value="<{$role.account_name}>" />
<select name="type">
	<{html_options options=$arrType selected=$type}>
</select>
<input type="image" name='search' src="/static/images/search.gif" class="input2"  />

</div>
<div style="color:red; font-size:20px; font-weight:bolder; margin:10px 0px;">
	<{$lang->player->attention}>
</div>
<script type="text/javascript" >
	function changePage(page){
		$("#page").val(page);
		$("#myform").submit();
	}
</script>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
  <tr>
    <td height="30" class="even">
 	<{foreach key=key item=item from=$pageList}>
 		<a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>')"><{$key}></a><span style="width:5px;"></span>
 	<{/foreach}>
	<{$lang->page->totalPage}>(<{$pageCount}>)<{$lang->page->total}><{$rowCount}><{$lang->page->record}>
	<{$lang->page->everyPage}><input type="text" id="record" name="record" size="4" style="text-align:center;" value="<{if $record != ''}><{$record}><{/if}>"><{$lang->page->row}> <{$lang->page->dang}>
  	<input style="text-align:center;" id="page" name="page" type="text" class="text" size="3" maxlength="6" value="<{$pageNo}>" ><{$lang->page->page}><input type="submit" class="button" name="Submit" value="GO">
	<input type="hidden" name="excel" id="excel" />
        [ <a href="javascript:void(0);" onclick="load_out();"><{$lang->page->excel}></a> ]
    </td>
  </tr>
</table>
	<table class="DataGrid" cellspacing="0" style="margin:5px;">
		<tr>
			<th><{$lang->page->sort}></th>
	        	<th><{$lang->sys->account}></th>
			<th><{$lang->page->roleName}></th>
			<th><{$lang->page->level}></th>
			<th><{$lang->sys->totalCost}>(<{$lang->sys->rmb}>)</th>
			<th><{$lang->sys->singleMore}>(<{$lang->sys->rmb}>)</th>
			<th><{$lang->sys->singleLess}>(<{$lang->sys->rmb}>)</th>
			<th><{$lang->sys->avg}>(<{$lang->sys->rmb}>)</th>
			<th><{$lang->sys->totalCostTime}></th>
			<th><{$lang->sys->lastCostTime}></th>
			<th><{$lang->player->checkDetail}></th>
			<th><{$lang->sys->alarm}></th>
		</tr>
	<{ foreach from=$rankList item=row key=key }>
        <tr align="center"<{ if 0==$row.rank_no%2 }> class="odd"<{ /if }>>
            <td class="close"><{ $row.rank_no }></td>
            <td id='an_<{$row.rank_no}>' class="cmenu" title="<{ $row.role_name }>"><{ $row.account_name }></td>
            <td id='ro_<{$row.rank_no}>' class="cmenu" title="<{ $row.role_name }>"><{ $row.role_name }></td>
            <td class="close"><{ $row.role_level }></td>
            <td class="close"><{ $row.total_pay }></td>
            <td class="close"><{ $row.max_pay }></td>
            <td class="close"><{ $row.min_pay }></td>
            <td class="close"><{ $row.avg_pay }></td>
            <td class="close" align="center"><{ $row.times }></td>
            <td class="close"><{ $row.max_pay_time|date_format:"%Y-%m-%d %H:%M:%S" }></td>
            <{*<td style="color:blue; font-weight:bold;"><{if $row.diff_day >= 3 }><{$row.diff_day}><{$lang->page->dayNotLogin}><{/if}></td>*}>
            <td>
                <a id="stop_<{$row.rank_no}>" style="text-decoration:underline;color:red;display:none;" href="javascript: void(0);"><{$lang->player->checkClose}></a> 
                <a id="start_<{$row.rank_no}>" style="text-decoration:underline;color:blue;display:block;" href="javascript: void(0);"><{$lang->player->checkClick}></a>
			</td>

            <td style="color:red; font-weight:bold;"><{if $row.report_time >= 3 }><{$row.report_time}><{$lang->page->dayNotLogin}><{/if}></td>
        </tr>

		<tr id='all_<{$row.rank_no}>' class='all' style="display:none;">
			<td colspan="12">
						<table class="DataGrid" id='all2_<{$row.rank_no}>' cellspacing="1" cellpadding="1" border="0"> 
							<tbody id="tbody_<{$row.rank_no}>"></tbody>
						</table>
			</td>
		</tr>

	<{ /foreach}>
	</table>
    </form>

<script language="javascript">
	$(document).ready(function(){
		$("a[id*=start_]").click(function(){
				var ids = $(this).attr("id").split("_");
				$.ajax({
					type : "POST",	
					url  : "<{$URL_SELF}>",
					data : "action="+ids[0]+"&id="+$("#an_"+ids[1]).text()+"&roleName="+$("#ro_"+ids[1]).text(), 
					dataType : "json",
					success: function(result) {
//						console.log(result);
						var stat = result.stat;
						var msg  = result.msg;
						if(stat == 0){
							$("tbody[id=tbody_"+ids[1]+"]").empty();
							var html = '<tr>';
							html += '<td class="noData">'+msg+'</td>';
							html += '</tr>';
							$("tbody[id=tbody_"+ids[1]+"]").append(html);
							$("tbody[id=tbody_"+ids[1]+"]>tr").css({color:"#ff0000",background:"#fff",width:"20px"});
						} else {
							$("tbody[id=tbody_"+ids[1]+"]").empty();
								var htmlExplaint = '<tr class="explaint">';
								htmlExplaint += '<td class="pay">'+'<{$lang->player->totalPayRMB}>'+'</td>';
								htmlExplaint += '<td class="historyGold">'+'<{$lang->player->totalPayGold}>'+'</td>';
								htmlExplaint += '<td class="gold">'+'<{$lang->player->gold}>'+'</td>';
								htmlExplaint += '<td class="bindgold">'+'<{$lang->player->goldBind}>'+'</td>';
								htmlExplaint += '<td class="money">'+'<{$lang->player->money}>'+'</td>';
								htmlExplaint += '<td class="bindmoney">'+'<{$lang->player->moneyBind}>'+'</td>';
								htmlExplaint += '<td class="level">'+'<{$lang->player->level}>'+'</td>';
								htmlExplaint += '<td class="viplevel">'+'<{$lang->player->vipLevel}>'+'</td>';
								htmlExplaint += '</tr>';
								$("tbody[id=tbody_"+ids[1]+"]").append(htmlExplaint);
								$("tbody[id=tbody_"+ids[1]+"]>tr").css({color:"#fff",background:"#5D8AFF",width:"20px"});
//							$.each(stat,function(i,v){
								var html = '<tr class="v">';
								html += '<td class="pay">'+stat.totalPayRmb+'</td>';
								html += '<td class="historyGold">'+stat.totalPayGold+'</td>';
								html += '<td class="gold">'+stat.gold+'</td>';
								html += '<td class="bindgold">'+stat.goldBind+'</td>';
								html += '<td class="money">'+stat.money+'</td>';
								html += '<td class="bindmoney">'+stat.moneyBind+'</td>';
								html += '<td class="level">'+stat.level+'</td>';
								html += '<td class="viplevel">'+stat.vipLevel+'</td>';
								html += '</tr>';
								$("tbody[id=tbody_"+ids[1]+"]").append(html);
								$("tbody[id=tbody_"+ids[1]+"]>tr").css({color:"#fff",background:"#5D8AFF",width:"20px"});
//							});		
						}
					}
				})			
				$('#all_'+ids[1]).show();				
				$('#stop_'+ids[1]).show();				
				$('#start_'+ids[1]).hide();				
		});

		$("a[id*=stop_]").click(function(){
				var ids = $(this).attr("id").split("_");
				$('#all_'+ids[1]).hide();				
				$('#start_'+ids[1]).show();				
				$('#stop_'+ids[1]).hide();				
		});

		$(".close").click(function(){
				$('.all').hide();				
				$('a[id*=start_]').show();				
				$('a[id*=stop_]').hide();				
		});

	});

</script>

</body>
<br/>
</html>
