<{if $pages.items }>
	<{if not $current_uri }>
		<{assign var=current_uri value=$smarty.server.REQUEST_URI|regex_replace:"/&page=\d*|page=\d*&?/":""}>
	<{/if}>
	<{assign var=pos value=$current_uri|@strpos:'?'}>
	<{if $pos == ''}>
		<{assign var=current_uri value=$current_uri|cat:'?'}>
	<{/if}>
	<form action="<{$current_uri}>" method="get" style="display:inline">
	<a href="<{$current_uri}>&page=<{$pages.first.num}>"><{$pages.first.label}></a> |
	<a href="<{$current_uri}>&page=<{$pages.prev.num}>"><{$pages.prev.label}></a> |
	<{foreach from=$pages.items key=text item=page name=page_log_loop}>
		<{if $page.current}>
			<font color="red"><{$page.num}></font> |
			<{assign var=current_page value=$page.num}>
		<{else}>
			<a href="<{$current_uri}>&page=<{$page.num}>"><{$page.num}></a> |
		<{/if}>
		
	<{/foreach}>
	<a href="<{$current_uri}>&page=<{$pages.next.num}>"><{$pages.next.label}></a> |
	<a href="<{$current_uri}>&page=<{$pages.last.num}>"><{$pages.last.label}></a> |
	<{$pages.recordCount.label}>: <{$pages.recordCount.num}> 
	<{$pages.pageCount.label}>: <{$pages.pageCount.num}> 
	<{* 暂时停止支持跳转和设置每页显示
	<{$pages.pageSize.label}>: 
	<input type="text" name="pageSize" value="<{$pages.pageSize.num}>" size="4" />
	<{$lang->page->goto}>:
	<input type="text" name="page" value="<{$current_page}>" size="4" />
	<input type="submit" name="submit" value="Go"/>
	 *}>
	</form>
<{/if}>

