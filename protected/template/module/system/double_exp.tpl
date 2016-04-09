<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<style type="text/css">
	.native{
		color:#F0F;
	}
</style>
<script type="text/javascript" src="/static/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#del").click(function(){
			if(confirm("确定删除吗?")){
				return true;
			}else{
				return false;
			}
		});
	});

</script>
<title>多倍经验设置</title>

</head>

<body>
<div id="position">系统管理：多倍经验设置</div>
<font color="#FF0000" size="+1">现在所在服务器是：<{$agent_name}>代理<{$server_id}>服</font>
<br />
<font color="#FF00FF" size="+1">Tip:添加/删除 成功后需刷新才能显示新添加的条目。。。O(∩_∩)O谢谢合作！！</font>
<form action="<{$URL_SELF}>?action=1" id="frm" method="POST"   >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="1000">
        <tr>
        	<td>#</td>
            <td>类型</td>
            <td>经验倍数</td>
            <td>开始日期</td>
            <td>结束日期</td>
            <td>从每天</td>
            <td>到每天</td>
            <td>等级上限</td>
            <td>等级下限</td>
            <td>操作</td>
        </tr>
        <tr>
        	<td>--</td>
            <td><select name="type"><{html_options values=$arrTypeKeys selected=$type output=$dictDoubleExp}></select></td>
            <td><select name="doubleSel"><{html_options values=$doubleIndex selected=$doubleSel output=$doubleExp}></select></td>
            <td><input name="dateStart" type="text" id="dateStart" size="12" class="Wdate" onfocus="WdatePicker();" value="<{$dateStart}>"></td>
            <td><input name="dateEnd" type="text" id="dateEnd" size="12" class="Wdate" onfocus="WdatePicker();" value="<{$dateEnd}>"></td>
            <td><input name="time1" type="text" id="time1" size="12" value="<{$time1}>"  class="Wdate" onfocus="WdatePicker({dateFmt:'HH:mm'});"></td>
            <td><input name="time2" type="text" id="time2" size="12" value="<{$time2}>"  class="Wdate" onfocus="WdatePicker({dateFmt:'HH:mm'});"></td>
            <td><input name="levelMin" type="text" id="levelMin" size="5" value="<{$levelMin}>"></td>
            <td><input name="levelMax" type="text" id="levelMax" size="5" value="<{$levelMax}>"></td>
            <td><input type="submit" value="添加" class="input2"  /></td>
        </tr>
        <tr>
        	<td colspan="12">
			星期选定：<{html_checkboxes name="chx" output=$arrWeek checked=$chx values=$arrKeys separator="&nbsp;&nbsp;"}><br />
			</td>
        </tr>
	</table>
</form>
<{if $strMsg}>
	<table class="SumDataGrid" width="1000" style="margin-top:10px;"><tr><td><font color="#FF0000"><{$strMsg}></font></td></tr></table>
<{/if}>
<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="1000" style="margin-top:50px;">
		<tr>
			<td colspan="12">历史记录</td>
		</tr>
        <tr>
        	<td>#</td>
            <td>类型</td>
            <td>经验倍数</td>
            <td>开始日期</td>
            <td>结束日期</td>
            <td>从每天</td>
            <td>到每天</td>
            <td>星期</td>
            <td>等级上限</td>
            <td>等级下限</td>
            <td>状态</td>
            <td>操作</td>
        </tr>
        <{if $result}>
        <{foreach from=$result key=key item=item}>
        <tr>
        	<td><{$item.id}></td>
            <td><{$item.type}></td>
            <td><{$item.expTimes}>倍</td>
            <td><{$item.startDay|date_format:"%Y-%m-%d"}></td>
            <td><{$item.endDay|date_format:"%Y-%m-%d"}></td>
            <td><{$item.startMinute}></td>
            <td><{$item.endMinute}></td>
            <td><{$item.weekFlag}></td>
            <td><{$item.minLevel}></td>
            <td><{$item.maxLevel}></td>
            <td id="<{$item.status}>"><{if $item.status == 1}><font color="#FF00FF">活动中</font><{else}><font color="#999999">已结束</font><{/if}></td>
            <td><{if $item.status == 1}><a id="del" href="?action=2&id=<{$item.id}>" >删除</a><{else}>----<{/if}></td>
        </tr>
        <{/foreach}>
        <{/if}>
	</table>
</body>
</html>