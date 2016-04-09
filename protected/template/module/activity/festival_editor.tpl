<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
    <link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />

	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
	<title><{$lang->menu->festivalActivity}></title>
</head>
<script type="text/javascript">
$(document).ready(function(){
    $('#addReward').click(function(){
        var index = $(this).attr('rel').substr(4);
        var html = '<input type="text" id="reward_' + index + '" class="reward" name="extra[reward][' + index + '][id]" value="" />&nbsp;' +
                        '<label>' +
                            '不绑定&nbsp;' +
                            '<input type="radio" name="extra[reward][' + index + '][bind]" value="0" checked="checked"/>' +
                        '</label>' +
                        '<label>' +
                            '绑定&nbsp;' +
                            '<input type="radio" name="extra[reward][' + index + '][bind]" value="1" checked="checked"/>' +
                        '</label>&nbsp;&nbsp;' +
                        '数量:<input type="text" class="reward" name="extra[reward][' + index + '][num]" value="" size="3"/>' +
                        '<br/>';
        $(this).before(html);
        $(this).attr('rel', 'max_' + (parseInt(index) + 1));

        var id = 'reward_' + index;
        $.autolist({
            bind: id,
            options: <{$itemList|@json_encode}>,
            onItemClick: function(key, item){
                $('#' + id).val(item.text());
            },
            onReset: function(){
                $('#' + id).val('');
            }
        });
    });
    $('input.reward').each(function(){
        var id = $(this).attr('id');
        $.autolist({
            bind: id,
            options: <{$itemList|@json_encode}>,
            onItemClick: function(key, item){
                $('#' + id).val(item.text());
            },
            onReset: function(){
                $('#' + id).val('');
            }
        });
    })
})
</script>

<body>
	<div id="position"><{$lang->menu->class->activity}>：<{$lang->menu->festivalActivity}></div>
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
	
	<{if $action == 'edit'}>
    <form action="/module/activity/festival_editor.php?action=edit" method="post">
        <table width="100%">
            <tr>
                <th width="10%">&nbsp;</th>
                <th width="90%">&nbsp;</th>
            </tr>
            <tr>
                <td>邮件标题</td>
                <td><input type="text" name="title" class="text" value="<{$act.title}>"/></td>
            </tr>
            <tr>
                <td>时间</td>
                <td>
                    <input type="text" size="22" class="Wdate" name="start" id="start_day" onfocus="WdatePicker({el:'start_day',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'end_day\')}'})" value="<{$act.start}>">
                    -
                    <input type="text" size="22" class="Wdate" name="end" id="end_day" onfocus="WdatePicker({el:'end_day',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'start_day\')}'})"  value="<{$act.end}>">
                </td>
            </tr>
            <tr>
                <td>类型</td>
                <td>
                    <label>
                        整个活动期间只发送一次
                        <input type="radio" name="mailtype" value="1" <{if $act.mailtype == 1}>checked="checked"<{/if}>/>
                    </label>
                    <label>
                        活动期间每天登录都发送一次
                        <input type="radio" name="mailtype" value="2" <{if $act.mailtype == 2}>checked="checked"<{/if}>/>
                    </label>
                </td>
            </tr>
            <tr>
                <td>邮件内容</td>
                <td><textarea name="content" class="text" rows="15"><{$act.content}></textarea></td>
            </tr>
            
            <tr>
                <td>奖励</td>
                <td>
                    <{foreach from=$act.extra.reward item=item name=rewardList}>
                        <input type="text" id="reward_<{$smarty.foreach.rewardList.index}>" class="reward" name="extra[reward][<{$smarty.foreach.rewardList.index}>][id]" value="<{$item.id}> | <{$itemList[$item.id]}>" />
                        <label>
                            不绑定
                            <input type="radio" name="extra[reward][<{$smarty.foreach.rewardList.index}>][bind]" value="0" <{if $item.bind == 0}>checked="checked"<{/if}>/>
                        </label>
                        <label>
                            绑定
                            <input type="radio" name="extra[reward][<{$smarty.foreach.rewardList.index}>][bind]" value="1" <{if $item.bind == 1}>checked="checked"<{/if}>/>
                        </label>
                        数量<input type="text" class="reward" name="extra[reward][<{$smarty.foreach.rewardList.index}>][num]" value="<{$item.num}>" size="3"/>
                        <br/>
                    <{/foreach}>
                    <input type="button" rel="max_<{$act.extra.reward|@count}>" id="addReward" name="addReward" value="增加奖励" />
                </td>
            </tr>
        </table>
        <input type="hidden" name="act_id" value="<{$act.id}>"/>
        <input type="submit" name="save" value="保存" />  
        <a href="/module/activity/festival_editor.php">返回</a>
    </form>
    <{else}>
    <a href="/module/activity/festival_editor.php?action=edit"><h1>新增活动</h1></a>
    <br/>
    <table class="DataGrid">
        <tr class="table_list_head">
            <th colspan="12"><h3 style="color:green; height:20px;">节日活动</h3></th> 
        </tr>
        <tr class="table_list_head">
        	<th>ID</th>
            <th>活动类型</th>
            <th>活动名称</th>
            <th>活动描述</th>
            <th>活动开始时间</th>
            <th>活动结束时间</th>
            <!-- <th>奖励物品</th> -->
            <th>操作</th>
        </tr>
        <{ foreach from=$actList item=act}>
        <tr class="<{cycle values="trEven,trOdd"}>" align="center" >
        	<td><{$act.id}></td>
            <td><{ $actType[$act.mailtype] }></td>
            <td><{$act.title}></td>
            <td style="background-color:#223A3D;"><{$act.content}></td>
            <!-- <td><{$item.desc}></td> -->
            <td><{$act.start}></td>
            <td><{$act.end}></td>
            <td>
            	<a href="?action=edit&act_id=<{$act.id}>" >修改</a> 
                <a href="?action=sync&act_id=<{$act.id}>" >同步</a>
                <a href="?action=del&act_id=<{$act.id}>" >删除</a>
            </td>
        </tr>
        <{ /foreach }>
    </table>
    <{/if}>
</body>
</html>