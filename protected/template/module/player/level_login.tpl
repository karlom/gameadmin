<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><{$lang->menu->loginLevelDistributing}></title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
</head>



<body>
<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->loginLevelDistributing}></div>

<form action="#" method="post">
	<table style="margin:5px;">
		<tr>
			<td><{$lang->page->beginTime}>:<input class="Wdate" type="text" size="12" name="dateStart" id="dateStart" value="<{$dateStart}>" onfocus="WdatePicker({el:'dateStart',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'dateEnd\')}'})"></td>
			<td><{$lang->page->endTime}>:<input class="Wdate" type="text" size="12" name="dateEnd" id="dateEnd" value="<{$dateEnd}>" onfocus="WdatePicker({el:'dateEnd',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'dateStart\')}',maxDate:'<{$maxDate}>'})"></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  /></td>

			<td><input type="button" class="button" name="datePrev" value="<{$lang->page->today}>" onclick="javascript:location.href='<{$smarty.const.URL_SELF}>?dateStart=<{$dateStrToday}>&dateEnd=<{$dateStrToday}>';"></td>

			<td><input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="javascript:location.href='<{$smarty.const.URL_SELF}>?dateStart=<{$dateStrPrev}>&dateEnd=<{$dateStrPrev}>';"></td>

			<td><input type="button" class="button" name="datePrev" value="<{$lang->page->nextTime}>" onclick="javascript:location.href='<{$smarty.const.URL_SELF}>?dateStart=<{$dateStrNext}>&dateEnd=<{$dateStrNext}>';"></td>

			<td><input type="button" class="button" name="datePrev" value="<{$lang->page->allTime}>" onclick="javascript:location.href='<{$smarty.const.URL_SELF}>?dateStart=<{$dateStrOnline}>&dateEnd=<{$dateStrToday}>';"></td>
		</tr>
	</table>
</form>
		
<{$lang->player->loginTotal}>：<{$total}>&nbsp;&nbsp;&nbsp;&nbsp;<{$lang->player->topLevel}>：<{$top_level}><br/>

<div class="tScroll frm" id="all" >
<table height="167" cellspacing="1" cellpadding="1" border="0" bgcolor="#CCCCCC" class="paystat">
<tr>		
<td width="30" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->player->loginNumber}></b></td>
    <{foreach key=key item=item from=$result}>
    <td width="45" bgcolor="#FFFFFF" align="center" valign="bottom">
      <table width="33" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="bottom" style="text-align:center"
          	title="<{$lang->player->level}>：<{$key}>  <{$lang->player->number}>：<{$item.loginCount}>"
          	>
          	<div><{$item.loginCount}></div>
            <img src="/static/images/<{if $item.red}>red<{else}>green<{/if}>.gif" width="10" height="
			<{if $max == 0}>
	            0
            <{else}>
            	<{$item.loginCount/$max}>
            <{/if}>
 	       "/>
		  </td>
        </tr>
      </table></td>
    <{/foreach}>
</tr>
<tr>
    <td height="30" align="center" bgcolor="#EBF9FC"><b><{$lang->player->level}></b></td>
  <{foreach key=key item=item from=$result}>
		<td height="30" bgcolor="#C0C0C0" align="center"><{$key}></td>
  <{/foreach}>
</tr>
</table>
<div style="margin: 5px 0;"><{$lang->page->allLoginLevelDistribute}>:</div>
<table height="167" cellspacing="1" cellpadding="1" border="0" bgcolor="#CCCCCC" class="paystat">
<tr>		
<td width="30" height="120" align="center" bgcolor="#EBF9FC"><b><{$lang->player->loginNumber}></b></td>
    <{foreach key=key item=item from=$level_data}>
    <td width="45" bgcolor="#FFFFFF" align="center" valign="bottom">
      <table width="33" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="bottom" style="text-align:center"
          	title="<{$lang->player->level}>：<{$key}>  <{$lang->player->number}>：<{$item.loginCount}>"
          	>
          	<div><{$item.loginCount}></div>
            <img src="/static/images/<{if $item.red}>red<{else}>green<{/if}>.gif" width="10" height="
			<{if $max == 0}>
	            0
            <{else}>
            	<{$item.loginCount/$max}>
            <{/if}>
 	       "/>
		  </td>
        </tr>
      </table></td>
    <{/foreach}>
</tr>
<tr>
    <td height="30" align="center" bgcolor="#EBF9FC"><b><{$lang->player->level}></b></td>
  <{foreach key=key item=item from=$level_data}>
		<td height="30" bgcolor="#C0C0C0" align="center"><{$item.level}></td>
  <{/foreach}>
</tr>
</table>

</body>
</html>