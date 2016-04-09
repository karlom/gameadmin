<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><{$lang->menu->refineShop}></title>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<style type="text/css">
	.hoverTd{
		background-color:#D7C8EA;
	}
	#list{
		position: fixed; width: 350px; height: 100%; background: none repeat scroll 0 0 #FFFFFF;
	}
	#detail{
		width: 70%; margin-left: 360px;
	}
	#list ul{
		width: 100%;
	}
	.li{
		padding: 5px 5px; margin-bottom: 2px;
	}
	.li:hover{
		background-color:#EDF2F7;
	}
	.trItem{
		background-color: #87CEEB;
	}
	.trItem2{
		background-color: #c0c0c0;
	}
	.timeOut{
		background-color:#EDF2F7;
	}
</style>
<body>
<div id="position">
<b><{$lang->menu->class->baseDataConfig}>：<{$lang->menu->refineShop}></b>
</div>
<{if $msg}>
<div style="margin: 5px; color: red; width: 60%;">
	<{foreach from=$msg item=item}>
	<div style="margin: 5px 0;"><{$item}></div>
	<{/foreach}>
</div>
<{/if}>

<div id="list">
	<ul>
		<li class="li trOdd">
			<a href="<{$smarty.const.URL_SELF}>?action=now">设置当前游戏促销的商品</a>
        	<span style="float: right;"><a href="<{$smarty.const.URL_SELF}>?action=new">新增活动</a></span>
		</li>
		<{foreach from=$cheapShopList item=item}>
    	<li class="li <{if $item.isTimeOut}>timeOut<{else}>trOdd<{/if}> <{if $item.id eq $existID}>conflict<{/if}>">
    		<span>#<{$item.id}></span>
    		<span><a href="<{$smarty.const.URL_SELF}>?action=view&id=<{$item.id}>"><{$item.title}></a> 
				当前状态：<font color="<{if $item.status eq 0}>red<{elseif $item.status eq 1}>green<{else}>gray<{/if}>" ><{$activityType[$item.status]}></font>
			</span>
        	<span style="float: right;">
				<{if $item.status eq 1 }>
				<a title="手动发送请确保活动时间的配置在有效范围内（即当前时间在活动时间范围），否则将有可能被其它配置所覆盖。" href="<{$smarty.const.URL_SELF}>?action=sendthis&id=<{$item.id}>" onclick="return confirm('该操作会覆盖游戏端当前的配置，确定发送这个设置?')">更新到游戏端</a> | 
				<{/if}>
				<a href="<{$smarty.const.URL_SELF}>?action=del&id=<{$item.id}>" onclick="return confirm('确定删除这个设置?')">删除</a>
			</span>
        	<br />
        	<a href="<{$smarty.const.URL_SELF}>?action=view&id=<{$item.id}>" title="对应确切日期：<{$item.start_date}> - <{$item.end_date}>">
				<{if $item.date_type == 0 }>
					<{*
						<{$item.start_time|date_format:"%Y-%m-%d %H:%M:%I"}> - <{$item.end_time|date_format:"%Y-%m-%d %H:%M:%I"}>
					*}>
						<{$item.start_date}> - <{$item.end_date}>
				<{else}>
					按开服日期： 
						<{$item.start_open_day}>日 <{$item.start_open_hour}>时 <{$item.start_open_minute}>分 - <{$item.end_open_day}>日 <{$item.end_open_hour}>时 <{$item.end_open_minute}>分 
				<{/if}>
			</a>
        	<br />
        	<{foreach name=loop from=$item.content item=list}>
        		<{$itemList[$list.itemID]}><{if !$smarty.foreach.loop.last}>,<{/if}>
        	<{/foreach}>
    	</li>
		<{/foreach}>
	</ul>
</div>
<div id="detail">
	<{if $cheapShopShow}>
	<form action="<{$smarty.const.URL_SELF}>" method="get">
	<table class="table_list" >
		<{if "set" == $action}>
    	<tr>
    		<td align="right">标题：</td>
    		<td><input name="title" type="text" value="<{$cheapShopShow.title}>" style="width: 250px;" /></td>
    	</tr>
    	
		<tr>
			<td align="right">日期类型：</td>
			<td>
				<label><input type="radio" name="date_type" value="0" <{if $cheapShopShow.date_type eq 0}>checked=checked<{/if}>/>按确切日期</label>
				<label><input type="radio" name="date_type" value="1" <{if $cheapShopShow.date_type eq 1}>checked=checked<{/if}>/>按开服日期</label>
			</td>
		</tr>
		<{/if}>
    	<tr>
    		<td width="90" align="right">开始时间：</td>
    		<td class="date_type_0" <{if $cheapShopShow.date_type eq 1}>style="display:none"<{/if}> ><input id="beginTime" name="start_time" type="text" class="Wdate" onfocus="WdatePicker({el:'beginTime',dateFmt:'yyyy-MM-dd HH:mm:ss'})" size="22" value="<{if $cheapShopShow.start_time > 0}><{$cheapShopShow.start_time}><{/if}>" /></td>
			<td class="date_type_1" <{if $cheapShopShow.date_type eq 0}>style="display:none"<{/if}> >
				<input id="start_open_day" name="start_open_day" type="text" size="3" value="<{$cheapShopShow.start_open_day}>" />&nbsp;日
				<input id="start_open_hour" name="start_open_hour" type="text" size="3" value="<{$cheapShopShow.start_open_hour}>" />&nbsp;时
				<input id="start_open_minute" name="start_open_minute" type="text" size="4" value="<{$cheapShopShow.start_open_minute}>" />&nbsp;分
				<input class="convert_date start" type="button" value="对应确切日期" />
                （开服日从0开始）
			</td>
    	</tr>
    	<tr>
    		<td align="right">结束时间：</td>
    		<td class="date_type_0" <{if $cheapShopShow.date_type eq 1}>style="display:none"<{/if}> ><input id="endTime" name="end_time" type="text" class="Wdate" onfocus="WdatePicker({el:'endTime',dateFmt:'yyyy-MM-dd HH:mm:ss'})" size="22" value="<{if $cheapShopShow.end_time > 0}><{$cheapShopShow.end_time}><{/if}>" /></td>
			<td class="date_type_1" <{if $cheapShopShow.date_type eq 0}>style="display:none"<{/if}> >
				<input id="end_open_day" name="end_open_day" type="text" size="3" value="<{$cheapShopShow.end_open_day}>" />&nbsp;日
				<input id="end_open_hour" name="end_open_hour" type="text" size="3" value="<{$cheapShopShow.end_open_hour}>" />&nbsp;时
				<input id="end_open_minute" name="end_open_minute" type="text" size="4" value="<{$cheapShopShow.end_open_minute}>" />&nbsp;分
				<input class="convert_date end" type="button" value="对应确切日期" />
                （开服日从0开始）
			</td>
		</tr>
	</table>
    <{foreach name=loop from=$cheapShopShow.data item=item}>
    <table class="table_list" style="width: 50%; margin: 10px 0;">
    	<tr class="trEven">
    		<td width="90" align="right">名称：</td>
    		<td>
    			<input id='item_<{$smarty.foreach.loop.iteration}>' name='item[<{$smarty.foreach.loop.iteration}>]' type="text" size='30' value='<{if $item.itemID > 0}><{$item.itemID}> | <{$itemList[$item.itemID]}><{/if}>' pvalue="<{$smarty.foreach.loop.iteration}>" />
    			<input id="itemid_<{$smarty.foreach.loop.iteration}>" name="itemid[<{$smarty.foreach.loop.iteration}>]" type="hidden" value="<{$item.itemID}>" />
    			<a id="del_<{$smarty.foreach.loop.iteration}>" href="javascript: void(0);" style="text-align: right;">删除</a>
    		</td>
    	</tr>
    	<tr class="trOdd">
    		<td align="right">原价：</td>
    		<td><input id="old_price_<{$smarty.foreach.loop.iteration}>" name="old_price[<{$smarty.foreach.loop.iteration}>]" value="<{$item.priceOld}>" style="width: 50px;" />元宝</td>
    	</tr>
    	<tr class="trEven">
    		<td align="right">现价：</td>
    		<td><input name="new_price[<{$smarty.foreach.loop.iteration}>]" value="<{$item.priceNew}>" style="width: 50px;" />元宝</td>
    	</tr>
    	<tr class="trOdd">
    		<td align="right">剩余数量：</td>
    		<td><input name="cnt[<{$smarty.foreach.loop.iteration}>]" value="<{$item.cnt}>" style="width: 50px;" /></td>
    	</tr>
    	<tr class="trEven">
    		<td align="right">每人可买数量：</td>
    		<td><input name="buy_num[<{$smarty.foreach.loop.iteration}>]" value="<{$item.limitPerson}>" style="width: 50px;" /></td>
    	</tr>
        <tr class="trOdd">
            <td align="right">一次购买数量：</td>
            <td><input name="buy_limit_num[<{$smarty.foreach.loop.iteration}>]" value="<{$item.limitNum}>" style="width: 50px;" /></td>
        </tr>
    	<tr class="trEven">
    		<td align="right">是否绑定：</td>
    		<td>
    			<label><input name="isbind[<{$smarty.foreach.loop.iteration}>]" type="radio" value="0" <{if 0==$item.bind}>checked<{/if}> />不绑定</label>
    			<label><input name="isbind[<{$smarty.foreach.loop.iteration}>]" type="radio" value="1" <{if 1==$item.bind}>checked<{/if}> />绑定</label>
    		</td>
    	</tr>
    </table>
	<{/foreach}>
	<table>
    	<tr>
    		<td colspan="2">
    			<input name="id" type="hidden" value="<{$cheapShopShow.id}>" />
    			<input name="action" type="hidden" value="<{$action}>" />
    			<input name="addBtn" type="button" value="添加" />
    			<input name="submitBtn" type="submit" value="提交" />
    		</td>
    	</tr>
	</table>
	</form>
	<{/if}>
</div>
<script type="text/javascript">
function convertToActualDate(nS) {   
    return new Date( ( parseInt(nS) + <{$onlineDateTimestamp}> ) * 1000).toLocaleString().substr(0,17)
}  

function toInt(value,defaultValue){
	value = parseInt(value);
	if(value)
		return value
	else
		return defaultValue;
}

var num = parseInt(<{$smarty.foreach.loop.iteration}>) + 1;
$(document).ready(function(){
	bindInputItem();

	$("a[id*=del_]").bind("click", function(){
    	var obj = $(this).parent().parent().parent().parent();
    	delItem(obj);
    });
	
    $("input[name=addBtn]").click(function(){
        if(3 >= num){
        	$("div[id=detail]").find("table[class=table_list]:last").after('<table class="table_list" style="width: 50%; margin: 10px 0;">'+
        	    	'<tr class="trEven">'+
            		'<td width="90" align="right">名称：</td>'+
            		'<td>'+
            			'<input id="item_'+num+'" name="item['+num+']" type="text" size="30" value="" pvalue="'+num+'" />'+
            			'<input id="itemid_'+num+'" name="itemid['+num+']" type="hidden" value="" />'+
            			'<a id="del_'+num+'" href="javascript: void(0);" style="text-align: right;">删除</a>'+
            		'</td>'+
            	'</tr>'+
            	'<tr class="trEven">'+
            		'<td align="right">原价：</td>'+
            		'<td><input id="old_price_'+num+'" name="old_price['+num+']" value="" style="width: 50px;" />元宝</td>'+
            	'</tr>'+
            	'<tr class="trOdd">'+
            		'<td align="right">现价：</td>'+
            		'<td><input name="new_price['+num+']" value="" style="width: 50px;" />元宝</td>'+
            	'</tr>'+
            	'<tr class="trOdd">'+
            		'<td align="right">剩余数量：</td>'+
            		'<td><input name="cnt['+num+']" value="" style="width: 50px;" /></td>'+
            	'</tr>'+
            	'<tr class="trEven">'+
            		'<td align="right">每人可买数量：</td>'+
            		'<td><input name="buy_num['+num+']" value="1" style="width: 50px;" /></td>'+
            	'</tr>'+
                '<tr class="trOdd">'+
                    '<td align="right">一次购买数量：</td>'+
                    '<td><input name="buy_limit_num['+num+']" value="1" style="width: 50px;" /></td>'+
                '</tr>'+
            	'<tr class="trEven">'+
            		'<td align="right">是否绑定：</td>'+
            		'<td>'+
            			'<label><input name="isbind['+num+']" type="radio" value="0"  />不绑定</label>'+
            			'<label><input name="isbind['+num+']" type="radio" value="1" checked="checked" />绑定</label>'+
            		'</td>'+
            	'</tr>'+
            '</table>');
        	bindInputItem();
        	$("a[id*=del_]").bind("click", function(){
            	var obj = $(this).parent().parent().parent().parent();
            	delItem(obj);
            });
        	num++;
        }
    });
	
	$('input[name=date_type]').click(function(){
		$('.date_type_0, .date_type_1').css('display', 'none')
		$('.date_type_' + $(this).val()).fadeIn()
	});
	
	$('.convert_date').click(function(){
		var type = $(this).hasClass('start')?'start':'end';
		var nS = toInt( $('#' + type + '_open_day').val(), 0 ) * 86400;
		nS += toInt( $('#' + type + '_open_hour').val(), 0  ) * 3600;
		nS += toInt( $('#' + type + '_open_minute').val(), 0  ) * 60;
		alert(convertToActualDate(nS));
	})
});

function bindInputItem(){
    $("input[id*=item_]").each(function(){
    	var id = $(this).attr("id");
    	var pvalue = $(this).attr("pvalue");
    	var itemid = "itemid_" + pvalue;
    	$.autolist({
    		bind: id,
    		options: <{$itemList|@json_encode}>,
    		onItemClick: function(key, item){
    			$('#' + id).val(item.text());
    			$('#' + itemid).val(key);
    			$.ajax({
        			type: "GET",
        			data: "action=getItemPrice&item_id="+key,
        			dataType: "json",
        			success: function(data){
            			if(1 == data.result){
            				$("input[id=old_price_"+pvalue+"]").val(data.oldPrice);
            			}else{
            				$("input[id=old_price_"+pvalue+"]").val("");
            			}
            		}
        		});
    		},
    		onReset: function(){
    			$('#' + itemid).val("");
    		}
    	});
    });
}

function delItem(obj){
    if(confirm("确定要删除这个配置?")){
    	obj.remove();
        num--;
    }
}
</script>
</body>
</html>
