<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script> 
<script type="text/javascript" >
$(document).ready(function(){
	$("#accountName").keydown(function(){
    	$("#roleName").val('');
    	$("#roleId").val('');
    });
    $("#roleName").keydown(function(){
    	$("#accountName").val('');
    	$("#roleId").val('');
    });
    $("#roleId").keydown(function(){
    	$("#accountName").val('');
    	$("#roleName").val('');
    });
    $("select[name=excel]").change(function(){
	if($("select[name=excel]").val() == 's'){
		return $("select[name=excel]").val('');
	} else {
		$("#myform").submit();
		$("select[name=excel]").val('');
	}
    });
});
function changeDate(dateStr,dateEnd){
	if(dateEnd==''){
		$("#starttime").val(dateStr);
		$("#endtime").val(dateStr);
	}else{
		$("#starttime").val(dateStr);
		$("#endtime").val(dateEnd);
	}
	$("#myform").submit();
}
function load_out(){
		$("#excel").val('true');
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
<title><{$lang->menu->copySceneData}></title>

<body>
<div id="position">
<b><{$lang->menu->class->activityManage}>：<{$lang->menu->copySceneData}></b>
</div>
<div class='divOperation'>
<!-- <form name="myform" id="myform" method="post" action="<{$smarty.const.URL_SELF}>"> -->
<form name="myform" id="myform" method="post" action="">
	<{$lang->page->roleName}>:<input type="text" id="roleName" name="role[roleName]" size="10" value="<{$role.roleName}>" />
	<{$lang->page->accountName}>:<input type="text" id="accountName" name="role[accountName]" size="10" value="<{$role.accountName}>" />
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' />
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> &nbsp;
	<{$lang->copyscene->copyType}>
	<select name="type">
		<{foreach from=$dictMapType item=item key=key}>
			<{if $item.isCopyScene==true}>
				<{html_options values=$item.id selected=$type output=$item.name}>
			<{/if}>
		<{/foreach}>
	</select>&nbsp;<br>
	<{$lang->page->sort}>:
	<select name="type2">
		<{html_options options=$arrType2 selected=$type2}>
	</select>&nbsp;
	<input id="search" name="search" type="hidden" value="search" />&nbsp;
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />&nbsp;
	<input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateStrToday}>','');">&nbsp;&nbsp;
	<input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="changeDate('<{$dateStrPrev}>','');">&nbsp;&nbsp;
	<input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="changeDate('<{$dateStrNext}>','');">&nbsp;&nbsp;
	<input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$dateOnline}>','<{$dateStrToday}>');"></br>
</div>
<script type="text/javascript">
        function changePage(page){
                $("#page").val(page);
                $("#myform").submit();
        }
</script>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
	<tr>
		<td height="30" class="even">
			<{foreach key=key item=item from=$pageList}>
				<a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>');"><{$key}></a><span style="width:5px;"></span>
			<{/foreach}>
			<{$lang->page->record}>(<{$recordCount}>)&nbsp;&nbsp;&nbsp;<{$lang->page->totalPage}>(<{if $pageCount}><{$pageCount}><{else}>1<{/if}>)
			<{$lang->page->everyPage}>
			<input type="text" id="pageLine" name="pageLine" size="4" style="text-align:center;" value="<{$pageLine}>">
			<{$lang->page->row}>
			<{$lang->page->dang}>
			<input id="page" name="page" type="text" class="text" size="3" style="text-align:center;" maxlength="6" value="<{$page}>">
			<{$lang->page->page}>&nbsp;
			<input type="submit" class="button" name="Submit" value="GO">&nbsp;
		<{if $startNum2}>
			<select name="excel" style="color:#ff0000;">
				<{html_options options=$startNum2 selected=s}>
			</select>
		<{else}>
	  		<input type="hidden" name="excel" id="excel" />
  			[ <a href="javascript:void(0);" onclick="load_out();"><{$lang->page->excel}></a> ]
		<{/if}>	
		</td>
	</tr>
</table>
<table class="DataGrid table_list no-resize" cellspacing="0" style="margin:5px;">
	<tr>
		<th><{$lang->sys->account}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->sys->playerLevel}></th>
		<th><{$lang->copyscene->inTime}></th>
		<th><{$lang->copyscene->outTime}></th>
		<th><{$lang->copyscene->mapId}></th>
		<th><{$lang->copyscene->into}></th>
		<th><{$lang->copyscene->level}></th>
		<th><{$lang->copyscene->enterTimes}></th>
		<th><{$lang->copyscene->isFinished}></th>
		<th><{$lang->copyscene->usedTime}></th>
		<th><{$lang->copyscene->isCaptain}></th>
		<th><{$lang->copyscene->isTeam}></th>
		<th><{$lang->copyscene->menCount}></th>
		<th><{$lang->copyscene->operation}></th>
	</tr>
	<{foreach name=loop from=$viewData item=item key=key}>
		<tr class='<{cycle values="trEven,trOdd"}>'>
			<td id='an_<{$key}>' class="cmenu" title="<{$item.account_name}>"><{$item.account_name}></td>
			<td id='rn_<{$key}>' class="cmenu" title="<{$item.role_name}>"><{$item.role_name}></td>
			<td><{$item.level}></td>
<!--
			<td><{if $item.status==0}><{$item.mtime|date_format:"%Y-%m-%d %H:%M:%S"}><{else}>0<{/if}>&nbsp;</td>
			<td><{if $item.status>0}><{$item.mtime|date_format:"%Y-%m-%d %H:%M:%S"}><{else}>0<{/if}></td>
-->
			<td id='st_<{$key}>' class='close'><{if $item.stime}><{$item.stime|date_format:"%Y-%m-%d %H:%M:%S"}><{else}>0<{/if}></td>
			<td id='et_<{$key}>' class='close'><{if $item.etime}><{$item.etime|date_format:"%Y-%m-%d %H:%M:%S"}><{else}>0<{/if}></td>
			<td id='mi_<{$key}>' class='close'><{$item.map_id}></td>
			<td id='mn_<{$key}>' class='close'><{$dictMapType[$item.map_id].name}></td>
			<td id='ml_<{$key}>' class='close'><{$dictMapType[$item.map_id].level}></td>
			<td id='er_<{$key}>' class='close'><{$item.enter_times}></td>
			<td id='cf_<{$key}>' class='close'><{if $item.status==1}><{$lang->copyscene->finish}><{else}><{$lang->copyscene->unfinish}><{/if}></td>
			<td id='se_<{$key}>' class='close'><{$item.time_used}></td>
			<td id='ct_<{$key}>' class='close'><{if $item.is_captain==1}><{$lang->player->yes}><{else}><{$lang->player->no}><{/if}></td>
			<td id='te_<{$key}>' class='close'><{if $item.is_team==1}><{$lang->player->yes}><{else}><{$lang->player->no}><{/if}></td>
			<td id='mc_<{$key}>' class='close'><{$item.men_count}></td>
			<td >
			<a id="stop_<{$key}>" style="text-decoration:underline;color:red;display:none;" href="javascript: void(0);"><{$lang->copyscene->close}></a> 
			<a id="start_<{$key}>" style="text-decoration:underline;color:blue;display:block;" href="javascript: void(0);"><{$lang->copyscene->look}></a>
			</td>

		</tr>

		<tr id='all_<{$key}>' class='all' style="display:none;">
			<td colspan="15">
						<table class="DataGrid" id='all2_<{$key}>' cellspacing="1" cellpadding="1" border="0"> 
							<tbody id="tbody_<{$key}>"></tbody>
						</table>
			</td>
		</tr>


	<{/foreach}>
</table>

<script language="javascript">
	$(document).ready(function(){
		$("a[id*=start_]").click(function(){
				var ids = $(this).attr("id").split("_");
				$.ajax({
					type : "POST",	
					url  : "<{$URL_SELF}>",
					data : "action="+ids[0]+"&an="+$("#an_"+ids[1]).text()+"&st="+$("#st_"+ids[1]).text()+"&et="+$("#et_"+ids[1]).text()+"&mi="+$("#mi_"+ids[1]).text(),
					dataType : "json",
					success: function(result) {
						var stat = result.stat;
						var msg  = result.msg;
						if(stat == 0){
							$("tbody[id=tbody_"+ids[1]+"]").empty();
							var html = '<tr>';
							html += '<td class="noData">'+msg+'</td>';
							html += '</tr>';
							$("tbody[id=tbody_"+ids[1]+"]").append(html);
							$("tbody[id=tbody_"+ids[1]+"]>tr").css({color:"#ff0000",background:"#fff",width:"50px"});
						} else {
							var tr = '<tr>';
							tr += '<td>'+"<{$lang->copyscene->time}>"+'</td>';
							tr += '<td>'+"<{$lang->copyscene->itemID}>"+'</td>';
							tr += '<td>'+"<{$lang->copyscene->item}>"+'</td>';
							tr += '<td>'+"<{$lang->copyscene->isBind}>"+'</td>';
							tr += '<td>'+"<{$lang->copyscene->num}>"+'</td>';
							tr += '<td>'+"<{$lang->copyscene->color}>"+'</td>';
							tr += '<td>'+"<{$lang->copyscene->type}>"+'</td>';
							tr += '<td>'+"<{$lang->copyscene->detail}>"+'</td>';
							tr += '</tr>';
							$("tbody[id=tbody_"+ids[1]+"]").empty();
							$("tbody[id=tbody_"+ids[1]+"]").append(tr);
							$.each(stat,function(i,v){
								var html = '<tr class="v">';
								html += '<td class="mdate">'+v.mdate+'</td>';
								html += '<td class="item_id">'+v.item_id+'</td>';
								html += '<td class="item_name">'+v.item_name+'</td>';
								html += '<td class="isbind">'+v.isbind+'</td>';
								html += '<td class="num">'+v.num+'</td>';
								html += '<td class="color">'+v.color+'</td>';
								html += '<td class="type">'+v.type+'</td>';
								html += '<td class="detail">'+v.detail+'</td>';
								html += '</tr>';
								$("tbody[id=tbody_"+ids[1]+"]").append(html);
								$("tbody[id=tbody_"+ids[1]+"]>tr").css({color:"#fff",background:"blue",width:"20px"});
							});		
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

</form>
</body>
</html>

