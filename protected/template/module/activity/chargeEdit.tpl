<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<title><{$lang->menu->chargeEdit}></title>
</head>

<body>
	<div id="position"><{$lang->menu->class->activity}>：<{$lang->menu->chargeEdit}></div>
	<a href="editor.php?action=add&title=<{$lang->menu->chargeEdit}>"><h1>新增活动</h1></a>
	<br/>
	
	<{if $live}>
    <table class="DataGrid">
        <tr class="table_list_head">
            <th colspan="12"><h3 style="color:green; height:20px;">活动进行中</h3></th> 
        </tr>
        <tr class="table_list_head">
        	<th>ID</th>
        	<th>活动类型</th>
            <th>活动名称</th>
            <th>活动描述</th>
            <th>开始可见时间</th>
            <th>结束可见时间</th>
            <th>活动开始时间</th>
            <th>活动结束时间</th>
            <th>领奖开始时间</th>
            <th>领奖结束时间</th>
            <th>领奖类型</th>
            <th>操作</th>
        </tr>
        <{ foreach from=$live item=item}>
        <tr class="<{cycle values="trEven,trOdd"}>" align="center" >
        	<td><{$item.id}></td>
            <td><{ if $item.cmd eq 'single_pay' }>单笔充值<{ elseif $item.cmd eq 'total_pay' }>累积充值<{ elseif $item.cmd eq 'consume' }>充值消费<{ /if }></td>
            <td><{$item.name}></td>
            <td style="background-color:#223A3D;"><{$item.desc}></td>
            <!-- <td><{$item.desc}></td> -->
            <td><{$item.showTimeBegin}></td>
            <td><{$item.showTimeEnd}></td>
            <td><{$item.actBegin}></td>
            <td><{$item.actEnd}></td>
            <td><{$item.timeAwardBegin}></td>
            <td><{$item.timeAwardEnd}></td>
             <td><{ if $item.awardType eq '1' }>整合<{ elseif $item.awardType eq '2' }>独立<{ elseif $item.awardType eq '3' }>无限<{ /if }></td>
            <td>
            	<a href="?action=cancel&id=<{$item.id}>" onClick="return confirm('<{$lang->activity->sureCancel}>')"> <{$lang->page->cancel}> </a>
            	<a href="editor.php?action=view&id=<{$item.id}>&title=<{$lang->menu->chargeEdit}>" >详情</a>
            	<a href="editor.php?action=update&id=<{$item.id}>&title=<{$lang->menu->chargeEdit}>" >修改</a>
            </td>
        </tr>
        <{ /foreach }>
    </table>
    <{/if}>

    <br />

    <{if $history}>
    <table class="DataGrid">
        <tr class="table_list_head">
            <th colspan="11"><h3 style="color:red; height:20px;">过期活动</h3></th> 
        </tr>
        <tr class="table_list_head">
        	<th>ID</th>
        	<th>活动类型</th>
            <th>活动名称</th>
            <th>活动描述</th>
            <th>开始可见时间</th>
            <th>结束可见时间</th>
            <th>活动开始时间</th>
            <th>活动结束时间</th>
            <th>领奖开始时间</th>
            <th>领奖结束时间</th>
            <th>领奖类型</th>
        </tr>
        <{ foreach from=$history item=item}>
        <tr class="history" align="center">
        	<td><{$item.id}></td>
            <td><{ if $item.cmd eq 'first_pay' }>首次充值<{ elseif $item.cmd eq 'total_pay' }>累积充值<{ elseif $item.cmd eq 'consume' }>充值消费<{ /if }></td>
            <td><{$item.name}></td>
            <td style="background-color:#223A3D;"><{$item.desc}></td>
            <td><{$item.showTimeBegin}></td>
            <td><{$item.showTimeEnd}></td>
            <td><{$item.actBegin}></td>
            <td><{$item.actEnd}></td>
            <td><{$item.timeAwardBegin}></td>
            <td><{$item.timeAwardEnd}></td>
             <td><{ if $item.awardType eq '1' }>整合<{ elseif $item.awardType eq '2' }>独立<{ elseif $item.awardType eq '3' }>无限<{ /if }></td>
        </tr>
        <{ /foreach }>
    </table>
    <{/if}>
    
</body>
</html>