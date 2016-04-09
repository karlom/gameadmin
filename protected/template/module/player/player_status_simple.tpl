<{if $role}>
<table>
	<tr>
		<td><span class='label'><{$lang->page->accountName}>：</span></td>
		<td><{$roleInfo.account}></td>
	</tr>
	<tr>
		<td><span class='label'><{$lang->page->roleName}>：</span></td>
		<td><{$roleInfo.rolename}></td>
	</tr>
	<tr>
		<td><span class='label'><{$lang->page->sex}>：</span></td>
		<td><{$roleInfo.sex}></td>
	</tr>
	<tr>
		<td><span class='label'><{$lang->page->job}>：</span></td>
		<td><{$roleInfo.job}></td>
	</tr>
	<tr>
		<td><span class='label'><{$lang->page->allPay}>：</span></td>
		<td><{$roleInfo.total_pay_rmb}></td>
	</tr>
	<tr>
		<td><span class='label'><{$lang->page->onlineStatus}>：</span></td>
		<td><{if 1 == $roleInfo.is_online}><font color="green"><{$lang->page->online}></font><{else}><font color="red"><{$lang->page->offline}></font><{/if}></td>
	</tr>
	<tr>
		<td><span class='label'><{$lang->page->lastLoginTime}>：</span></td>
		<td><{$roleInfo.login_time|date_format:'%Y-%m-%d %H:%M:%S' }></td>
	</tr>
	<tr>
		<td><span class='label'>&nbsp;</span></td>
		<td><a href="/module/player/player_status.php?action=search&role[role_name]=<{$roleInfo.rolename}>">查看详情</a></td>
	</tr>
</table>
<{/if}>
