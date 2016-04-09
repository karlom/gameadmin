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
<script language="javascript">

    $(document).ready(function(){
        $("#showType").change(function(){
            $("#myform").submit();
        });
    });

	function changeDate(dateStr,dateEnd){
		if(dateEnd==''){
			$("#start").val(dateStr);
			$("#end").val(dateStr);
		}else{
			$("#start").val(dateStr);
			$("#end").val(dateEnd);
		}
		$("#myform").submit();
	}

</script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->activityManage}>：<{$lang->menu->copySceneDataCount}></b>
</div>
    <form action="#" method="POST" id="myform">
    <table style="width:600px; margin-right:15px; float:left; display:inline;">
        <tr>
        <{$lang->copyscene->copyType}>：       
            <select name="fb_sel" id="fb_sel">
                <{html_options options=$fb_list  selected=$fb_type}>
            </select>
        <{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="start" id="start" onfocus="WdatePicker({el:'start',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'end\')}'})" value="<{ $start }>">
        <{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="end" id="end" onfocus="WdatePicker({el:'end',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'start\')}',maxDate:'<{$maxDate}>'})"  value="<{ $end }>"> &nbsp;
        <input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  /> &nbsp;
        <input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateStrToday}>','');">&nbsp;&nbsp;
        <input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="changeDate('<{$dateStrPrev}>','');">&nbsp;&nbsp;
        <input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="changeDate('<{$dateStrNext}>','');">&nbsp;&nbsp;
        <input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$dateOnline}>','<{$dateStrToday}>');">
        </tr>
    </table>
    </form>
	<div class="clear"></div>
    <hr style="color:#D7E4F5;"/>
    <div style="width:10%;float:left; margin-right:10px; ">
    <div><{$lang->copyscene->enterNumTimes}></div>
    <table class="DataGrid" cellspacing="0" style="margin:5px;">
        <tr>
            <th><{$lang->page->times}></th>
            <th><{$lang->player->number}></th>
        </tr>
    <{foreach key=key item=item from=$PeopleTimes}>
        <tr>
            <td><{$item.enter_times}></td>
            <td><{$item.num}></td>
        </tr>
    <{/foreach}>
    </table>
    </div>
    <div style="width:10%;float:left; margin-right:10px; ">
    <div><{$lang->copyscene->troopsNum}>(<font color='red'>队伍相关暂无法统计</font>)</div>
    <table class="DataGrid" cellspacing="0" style="margin:5px;">
        <tr>
            <th><{$lang->player->number}></th>
            <th><{$lang->page->times}></th>
        </tr>
        <tr>
            <td><{$SingleTimes.out_number}></td>
            <td><{$SingleTimes.num}></td>
        </tr>
    <{foreach key=key item=item from=$TeamTimes}>
        <tr>
            <td><{$item.out_number}></td>
            <td><{$item.num}></td>
        </tr>
    <{/foreach}>
    </table>
    </div>
    
    
    <div style="width:10%;float:left; margin-right:10px; ">
    <div><{$lang->copyscene->longTimeNumDis}></div>
    <table class="DataGrid" cellspacing="0" style="margin:5px;">
        <tr>
            <th><{$lang->copyscene->longTime}></th>
            <th><{$lang->page->ren}><{$lang->page->times}></th>
        </tr>
    <{foreach key=key item=item from=$ContinueTime}>
        <tr>
            <td><{$item.contime}></td>
            <td><{$item.num}></td>
        </tr>
    <{/foreach}>
    </table>
    </div>
    
    <div style="width:15%;float:left; margin-right:10px; ">
    <div><{$lang->copyscene->playerLevelDis}></div>
    <table class="DataGrid" cellspacing="0" style="margin:5px;">
        <tr>
            <th><{$lang->page->level}></th>
            <th><{$lang->page->ren}><{$lang->page->times}></th>
        </tr>
    <{foreach key=key item=item from=$GamerLevel}>
        <tr>
            <td><{$item.level}></td>
            <td><{$item.num}></td>
        </tr>
    <{/foreach}>
    </table>
    </div>
    

    <div style="width:18%;float:left; margin-right:10px; ">
    <div><{$lang->copyscene->enterDisTime}></div>
    <table class="DataGrid" cellspacing="0" style="margin:5px;">
        <tr>
            <th style="width:80%"><{$lang->copyscene->intoTime}></th>
            <th><{$lang->page->ren}><{$lang->page->times}></th>
        </tr>
    <{foreach key=key item=item from=$StartTime}>
        <tr>
            <td><{$item.start_from}><{$lang->copyscene->pointAfter}></td>
            <td><{$item.num}></td>
        </tr>
    <{/foreach}>
    </table>
    </div>

    <div style="width:30%; float:left; margin-right:10px;">
    <div><{$lang->copyscene->joinMenCount}></div>
    <table class="DataGrid" cellspacing="0" style="margin:5px;">
        <tr>
            <th style="width:20%"><{$lang->page->time}></th>
            <th style="width:25%"><{$lang->copyscene->joinTotalMen}></th>
            <th style="width:40%">≥<{$level}></th>
            <th><{$lang->copyscene->participation}></th>
        </tr>
        <{if $joinList}>
				<{foreach from=$joinList item=item key=key}>
						<tr class='<{cycle values="trEven,trOdd"}>'>
							<td><{$item.date}></td>
							<td><{$item.total}></td>
							<td><{$item.active_level}></td>
							<td><{$item.rate}>%</td>
						</tr>
				<{/foreach}>
       <{else}>
				<tr>
					<td colspan="6" align="center"><{$lang->copyscene->noData}></td>
				</tr>
       <{/if}>
    </table>
    </div>

	<{if $fb_type==206}>
    <div style="width:30%; float:left; margin-right:10px;">
    <div><{$lang->copyscene->totalNumCount}></div>
    <table class="DataGrid" cellspacing="0" style="margin:5px;">
        <tr>
            <th style="width:20%"><{$lang->copyscene->floorNum}></th>
            <th style="width:25%"><{$lang->copyscene->outTotalNum}></th>
        </tr>
        <{if $mgRs}>
				<{foreach from=$mgRs item=item key=key}>
						<tr class='<{cycle values="trEven,trOdd"}>'>
							<td><{$item.floor}></td>
							<td><{$item.total}></td>
						</tr>
				<{/foreach}>
       <{else}>
				<tr>
					<td colspan="6" align="center"><{$lang->copyscene->noData}></td>
				</tr>
       <{/if}>
    </table>
    </div>
	<{/if}>

	<{if $fb_type==210}>
    <div style="width:30%; float:left; margin-right:10px;">
    <div><{$lang->copyscene->enterTimesCount}></div>
    <table class="DataGrid" cellspacing="0" style="margin:5px;">
        <tr>
            <th style="width:20%"><{$lang->copyscene->enterNum}></th>
            <th style="width:25%"><{$lang->copyscene->ordinary}></th>
            <th style="width:25%"><{$lang->copyscene->elite}></th>
        </tr>
        <{if $tombRsArr1}>
				<{foreach from=$tombRsArr1 item=item key=key}>
						<tr class='<{cycle values="trEven,trOdd"}>'>
							<td><{$item.times}></td>
							<td><{$item.ordinary}></td>
							<td><{$item.elite}></td>
						</tr>
				<{/foreach}>
       <{else}>
				<tr>
					<td colspan="6" align="center"><{$lang->copyscene->noData}></td>
				</tr>
       <{/if}>
    </table>
    </div>
	<{/if}>

	<{if $fb_type==210}>
    <div style="width:30%; float:left; margin-right:10px;">
    <div><{$lang->copyscene->enterFloorCount}></div>
    <table class="DataGrid" cellspacing="0" style="margin:5px;">
        <tr>
            <th style="width:25%"><{$lang->copyscene->floorNum}></th>
            <th style="width:25%"><{$lang->copyscene->enterTotalRole}></th>
        </tr>
        <{if $floorRs}>
				<{foreach from=$floorRs item=item key=key}>
						<tr class='<{cycle values="trEven,trOdd"}>'>
							<td><{$item.cur_floor}></td>
							<td><{$item.total}></td>
						</tr>
				<{/foreach}>
       <{else}>
				<tr>
					<td colspan="6" align="center"><{$lang->copyscene->noData}></td>
				</tr>
       <{/if}>
    </table>
    </div>
	<{/if}>

</body>
</html>
