<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<title><{$lang->menu->createGmRole}></title>
</head>

<body style="margin:10px">
<div id="position"><b><{$lang->menu->class->userInfo}>：<{$lang->menu->createGmRole}></b></div>
<div class="red"><{$msg}></div>
<form action="?action=do&type=gold" method="post">
<table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#A5D0F1">
    <tr bgcolor="#E5F9FF">
        <td colspan="2" background="/static/images/wbg.gif"><font
            color="#666600" class="STYLE2"><b>::<{$lang->menu->createGmRole}></b></font></td>
    </tr>

    <tr bgcolor="#FFFFFF">
        <td width="10%"><{$lang->create->gmRoleName}>：</td>
        <td width="90%"><input type="text" name="rolename" value="" /></td>
    </tr>


    <tr bgcolor="#FFFFFF">
        <td width="25%"><{$lang->create->job}>：</td>
        <td><select id="job" name="job">
			<{html_options options=$dictJobs }>
            <{* <option value="3"></option> *}>
        </select></td>
    </tr>


    <tr bgcolor="#FFFFFF">
        <td width="10%"><{$lang->create->sex}>：</td>
        <td><select id="sex" name="sex">
            <option value="2"><{$lang->create->woman}></option>
            <option value="1"><{$lang->create->man}></option>
        </select></td>
    </tr>
    
    <tr bgcolor="#FFFFFF">
        <td width="10%"><{$lang->create->privilege}>：</td>
        <td><select id="gm" name="gm">
            <option value="1"><{$lang->create->p1}></option>
            <option value="2"><{$lang->create->p2}></option>
        </select></td>
    </tr>	
	
    <tr bgcolor="#FFFFFF">
        <td width="12%">
        <input type='hidden' name='action' value='create' />
        </td>
        <td width="75%">
        <input type="submit" name="submit" value="<{$lang->create->create}>" />
        <input type="reset" name="reset" value="<{$lang->create->reset}>" /></td>
    </tr>
</table>
<br>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >

	<tr class='table_list_head'>
        <th><{$lang->create->gmAccountName}></th>
        <th><{$lang->create->gmRoleName}></th>
        <th><{$lang->create->sex}></th>
        <th><{$lang->create->job}></th>
        <th><{$lang->create->privilege}></th>
        <th><{$lang->create->mtime}></th>
        <th><{$lang->create->operator}></th>
	</tr>

	<{foreach name=loop from=$row item=item key=key}>
		<tr class='<{cycle values="trEven,trOdd"}>' align="center">
			<td><{$item.account_name}></td>
			<td><{$item.role_name}></td>
			<td><{if $item.sex==1}><{$lang->create->man}><{else}><{$lang->create->woman}><{/if}></td>
			<td><{$dictJobs[$item.job]}></td>
			<td><{if $item.gm==2}><{$lang->create->p2}><{else}><{$lang->create->p1}><{/if}></td>
			<td><{$item.mtime|date_format:"%Y-%m-%d %H:%M:%S"}></td>
			<td><{$item.add_person}></td>
		</tr>
	<{/foreach}>
</table>

</form>

<br/><br/>
<font color='red'><{$lang->create->takeCare}></font>

</body>
</html>
