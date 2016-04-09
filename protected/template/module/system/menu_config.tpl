<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
	<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
	<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("input[name=submit]").click(function(){
				$flag = 1;
				$.each($("input[class=required]"), function(){
					if("" == $(this).val()){
						alert($(this).attr("des")+"<{$lang->verify->isNotNull}>");
						$flag = 0;
						return false;
					}
				});
				if(!$flag){
					return false;
				}
			});
			//检查是否全选
			$('input.isshow').each(function(){
				if(!$(this).attr('checked')){
					$('#checkall').attr('checked', false);
					return false;
				}
			})
			//全选和反选
			$('#checkall').click(function(){
				$('input.isshow').attr('checked', $(this).attr('checked'));
			})
		});
	</script>
	
	<style>
	#checkall{float:right}
	</style>
	<title><{$lang->menu->menuConfig}></title>
	</head>

	<body>
		<div id="position"><{$lang->menu->class->systemManage}>: <{$lang->menu->menuConfig}></div>
		
		<{if $msg}>
		<div style="margin: 5px; color: red; width: 60%;">
			<{foreach from=$msg item=item}>
			<div style="margin: 5px 0;"><{$item}></div>
			<{/foreach}>
		</div>
		<{/if}>
		
		<{if $serverStatus}>
		<form action="<{$smarty.const.URL_SELF}>" method="post">
			<table class="table_list" style="width: 60%; margin: 10px 0;">
				<tr class="trEven">
					<td width="25%" align="right"><{$lang->page->gameEntrance}></td>
					<td>
						<input type="radio" value="1" name="switch" <{if 1 == $serverStatus}>checked="checked"<{/if}> /><{$lang->page->open}> 
						<input type="radio" value="2" name="switch" <{if 2 == $serverStatus}>checked="checked"<{/if}>  /><{$lang->page->close}>
					</td>
				</tr>
				<tr class="trOdd">
					<td colspan="3" align="center">
						<input name="entranceUrl" type="hidden" value="<{$config.entranceUrl}>" />
						<input name="action" type="hidden" value="updateentrance" />
						<input name="entrancesumbit" type="submit" value="<{$lang->page->submit}>" />
					</td>
				</tr>
			</table>
		</form>
		<{/if}>
		<form action="<{$smarty.const.URL_SELF}>" method="post">
			<table class="table_list" style="width: 60%">
				<tr class="table_list_head">
					<th width="15%">ID</th>
					<th width="25%"><{$lang->page->menuName}></th>
					<th width="20%"><{$lang->page->interface}></th>
					<th width="20%"><{$lang->page->version}></th>
					<th width="20%"><{$lang->page->isShow}> <lable for"checkall"><input type="checkbox"  id="checkall" checked /></label></th>
				</tr>
				<{if $result}>
				<{foreach from=$result key=key item=item}>
				<tr class="<{cycle values="trEven,trOdd"}>">
					<td><{$key}></td>
					<td><{$item.name}></td>
					<td>
						<select name="interface[<{$key}>]">
							<option value="0"><{$lang->page->select}></option>
							<option value="http" <{if "http" == $item.interface}>selected<{/if}>>http</option>
							<option value="socket" <{if "socket" == $item.interface}>selected<{/if}>>socket</option>
						</select>
					</td>
					<td></td>
					<td align="center">
						<{*
						<select name="isshow[<{$key}>]">
							<option value="1" <{if "1" == $item.isshow}>selected<{/if}>><{$lang->page->show}></option>
							<option value="0" <{if "0" == $item.isshow}>selected<{/if}>><{$lang->page->hide}></option>
						</select>
						*}>
						<input type="checkbox" <{if "1" == $item.isshow}>checked<{/if}> name="isshow[<{$key}>]" class="isshow" />
					</td>
				</tr>
				<{/foreach}>
				<{/if}>
				<tr class="table_list_head">
					<td colspan="5" align="center">
						<input name="action" type="hidden" value="submit" />
						<input name="submit" type="submit" value="<{$lang->page->submit}>" />
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
