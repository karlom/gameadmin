<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<title><{$lang->menu->class->baseData}></title>
</head>

<body style="margin:10px">
<div id="position"><b><{$lang->menu->class->baseData}>：<{$lang->menu->userKeep}></b></div>
<{$lang->login->daykeep}><br/>
<{$lang->login->payolduser}><br/>
<{$lang->login->paynewuser}><br/>
<table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#A5D0F1">
    <tr bgcolor="#FFFFFF">
        <td width="12%">
            <{$lang->page->onlineDate}>:<{$onlinedate}>
        </td>
        <form method="post" action="<{$URL_SELF}>">
        <td width="75%">
            &nbsp;<{$lang->page->beginTime}>：<input type='text' name='dateStart' id='startDay' size='12' value='<{$dateStart}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
            &nbsp;&nbsp;<{$lang->page->endTime}>：<input type='text' name='dateEnd' id='endDay' size='12' value='<{$dateEnd}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
            <input type="submit" id="sub" name="sub" value="<{$lang->usekeep->search}>"/>
        </td>
    </tr>
</table>
<br>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >

	<tr class='table_list_head'>
        <th></th>
        <th><{$lang->player->date}></th>
        <th><{$lang->usekeep->usercount}></th>
        <th><{$lang->usekeep->userpaycount}></th>
        <th><{$lang->usekeep->usermoneycount}></th>
        <th><{$lang->usekeep->newuserpaycount}></th>
        <th><{$lang->usekeep->olduserpaycount}></th>
	</tr>
        <{assign var="j" value=0}>
            <{foreach name=loop from=$results item=item key=key}>
                <tr class='<{cycle values="trEven,trOdd"}>'>
                        <td><{$lang->usekeep->di}><{$item.diff}><{$lang->usekeep->thedaykeep}></td>
                        <td align="center"><{$key}></td>
                        <td align="center"><{$item.chun}></td>
			<td align="center"><{$item.count}></td>
			<td align="center"><{$item.money}></td>
                        <td align="center"><{$item.xincount}></td>
                        <td align="center"><{$item.laocount}></td>
                  </tr>
            <{/foreach}>
            <tr class='trEven'>
                <td colspan="2"><{$lang->activity->summary}>:</td>
                <td align="center"><{$hzong.chun}></td>
                <td align="center"><{$hzong.count}></td>
                <td align="center"><{$hzong.money}></td>
                <td align="center"><{$hzong.xincount}></td>
                <td align="center"><{$hzong.laocount}></td>
            </tr>
        
</table>


</form>

</body>
</html>
