<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><{$lang->menu->vipInfo}></title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script language="javascript">

	$(document).ready(function(){
		$("#accountName").keydown(function(){
			$("#roleName").val('');
		});

		$("#roleName").keydown(function(){
			$("#accountName").val('');
		});

     });

     function changeDate(dateStr,endDay){
               if(endDay==''){
                        $("#startDay").val(dateStr);
                        $("#endDay").val(dateStr);
                }else{
                        $("#startDay").val(dateStr);
                        $("#endDay").val(endDay);
                }
                $("#myform").submit();
    }

</script>
</head>

<body>
<div id="position"><b><{$lang->menu->class->userInfo}>：<{$lang->menu->vipInfo}></b></div>
<form action="" method='post' id="myform" style='display:inline'>
            <{$lang->page->roleName}>:<input type="text" id="roleName" name="role[roleName]" size="10" value="<{$role.roleName}>" />
            <{$lang->page->accountName}>:<input type="text" id="accountName" name="role[accountName]" size="10" value="<{$role.accountName}>" />
	    <{$lang->page->beginTime}>:<input id='startDay' name='startDay' type="text" class="Wdate" onfocus="WdatePicker({el:'startDay',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDay\')}'})" size='12' value='<{$startDay}>' />
            <{$lang->page->endTime}>:<input id='endDay' name='endDay' type="text" class="Wdate" onfocus="WdatePicker({el:'endDay',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDay\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDay}>' /> &nbsp;

                		<input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  />
                                &nbsp;&nbsp;
                                <input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateToday}>','');"
>&nbsp;&nbsp;
                                <input type="button" class="button" name="datePrev" value="<{$lang->page->preday}>" onclick="changeDate('<{$datePrev}>','');">
&nbsp;&nbsp;
                                <input type="button" class="button" name="dateNext" value="<{$lang->page->afterday}>" onclick="changeDate('<{$dateNext}>','');
">&nbsp;&nbsp;
                                <input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$minDate }>','<{$dateToday}>');">

	<table class="DataGrid" cellspacing="0" style="margin:5px;">
		<tr>
		    <th style="width:175px;"><{$lang->vip->vipTotal}></th>
		    <td style="width:330px;"><{$effectiveCount}>&nbsp;<{$lang->vip->vipTotalTips}></td>
		    <th style="width:145px;"><{$lang->vip->exTime}></th>
		    <td><{$exTotal}>&nbsp;<{$lang->vip->exTimeTips}></td>
		</tr>
	</table>
	<table class="DataGrid" cellspacing="0" style="margin:5px;">
		<tr>
		    <th><{$lang->vip->vipType}></th>
		    <th><{$lang->vip->lastEffectiveNum}></th>
		    <th><{$lang->vip->itemEffectiveNum}></th>
		    <th><{$lang->vip->payEffectiveNum}></th>
		</tr>
		<tr>
		    <th><{$lang->vip->exCarNum}></td>
		    <td><{if $lastEf.ex.num}><{$lastEf.ex.num}><{else}>0<{/if}></td>
		    <td><{if $lastEf.ex.itemNum}><{$lastEf.ex.itemNum}><{else}>0<{/if}></td>
		    <td><{if $lastEf.ex.moneyNum}><{$lastEf.ex.moneyNum}><{else}>0<{/if}></td>
		</tr>

		<tr>
		    <th><{$lang->vip->threeCarNum}></td>
		    <td><{if $lastEf.three.num}><{$lastEf.three.num}><{else}>0<{/if}></td>
		    <td><{if $lastEf.three.itemNum}><{$lastEf.three.itemNum}><{else}>0<{/if}></td>
		    <td><{if $lastEf.three.moneyNum}><{$lastEf.three.moneyNum}><{else}>0<{/if}></td>
		</tr>

		<tr>
		    <th><{$lang->vip->monthCarNum}></td>
		    <td><{if $lastEf.month.num}><{$lastEf.month.num}><{else}>0<{/if}></td>
		    <td><{if $lastEf.month.itemNum}><{$lastEf.month.itemNum}><{else}>0<{/if}></td>
		    <td><{if $lastEf.month.moneyNum}><{$lastEf.month.moneyNum}><{else}>0<{/if}></td>
		</tr>

		<tr>
		    <th><{$lang->vip->yearCarNum}></td>
		    <td><{if $lastEf.year.num}><{$lastEf.year.num}><{else}>0<{/if}></td>
		    <td><{if $lastEf.year.itemNum}><{$lastEf.year.itemNum}><{else}>0<{/if}></td>
		    <td><{if $lastEf.year.moneyNum}><{$lastEf.year.moneyNum}><{else}>0<{/if}></td>
		</tr>
	</table>

	<table class="DataGrid" cellspacing="0" style="margin:5px; text-align:center;">
		<tr>
		    <th><{$lang->sys->account}></th>
		    <th><{$lang->page->roleName}></th>
		    <th><{$lang->vip->stime}></th>
		    <th><{$lang->vip->itemid }></th>
		    <th><{$lang->vip->ctime}></th>
		    <th><{$lang->vip->ttime}></th>
		    <th><{$lang->vip->vipLevel}></th>
		    <th><{$lang->vip->etime}></th>
		    <th><{$lang->vip->operate}></th>
		</tr>
		<{foreach key=key item=item from=$viewData}>
			<tr id='tr_<{$item.id}>' class='<{cycle values="trEven,trOdd"}>'>
			    <td	id='an_<{$item.id}>' class='close'><{$item.account_name}></td>
			    <td	id='rn_<{$item.id}>' class='close'><{$item.role_name}></td>
			    <td	id='st_<{$item.id}>' class='close'><{$item.stime|date_format:"%Y-%m-%d %H:%M:%S"}></td>
			    <td	id='in_<{$item.id}>' class='close'><{$item.item_name}></td>
			    <td	id='at_<{$item.id}>' class='close'><{$item.add_time}></td>
			    <td	id='tt_<{$item.id}>' class='close'><{$item.ttime/3600}></td>
			    <td	id='vl_<{$item.id}>' class='close'><{$item.vip_level}></td>
			    <td	id='et_<{$item.id}>' class='close'>
			    <{if $item.etime <= $nowTime}>
			    <font color = "#f53f3c" ><{$item.etime|date_format:"%Y-%m-%d %H:%M:%S"}></font>
			    <{else}>
			    <{$item.etime|date_format:"%Y-%m-%d %H:%M:%S"}>
			    <{/if}>
			    </td>
			    <td>
                <a id="stop_<{$item.id}>" style="text-decoration:underline;color:red;display:none;" href="javascript: void(0);"><{$lang->vip->close}></a> 
                <a id="start_<{$item.id}>" style="text-decoration:underline;color:blue;display:block;" href="javascript: void(0);"><{$lang->vip->look}></a>
				</td>
			</tr>

			<tr id='all_<{$item.id}>' class='all' style="display:none;">
				<td colspan="9">
							<table class="DataGrid" id='all2_<{$item.id}>' cellspacing="1" cellpadding="1" border="0"> 
								<tbody id="tbody_<{$item.id}>"></tbody>
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
					data : "action="+ids[0]+"&id="+$("#an_"+ids[1]).text(), 
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
							$("tbody[id=tbody_"+ids[1]+"]>tr").css({color:"#ff0000",background:"#fff",width:"20px"});
						} else {
							$("tbody[id=tbody_"+ids[1]+"]").empty();
							$.each(stat,function(i,v){
								var html = '<tr class="v">';
								html += '<td class="account_name">'+v.account_name+'</td>';
								html += '<td class="role_name">'+v.role_name+'</td>';
								html += '<td class="stime">'+v.stime+'</td>';
								html += '<td class="item_name">'+v.item_name+'</td>';
								html += '<td class="add_time">'+v.add_time+'</td>';
								html += '<td class="ttime">'+v.ttime+'</td>';
								html += '<td class="vip_level">'+v.vip_level+'</td>';
								html += '<td class="etime">'+v.etime+'</td>';
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

</body>
</form>
</html>
