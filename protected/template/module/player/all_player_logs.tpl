<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<{$lang->menu->allRoleLog}>
		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
				$("#selectAll").click(function(){
					//全选
					if($(this).attr("checked") == true) {
						$("input[name='checkbox[]']").each(function(){
							$(this).attr("checked",true);
						});
						$("input[name='selectType[]']").each(function(){
							$(this).attr("checked",true);
						});
					} else {
						//全不选
						$("input[name='checkbox[]']").each(function(){
							$(this).attr("checked",false);
						});	
						$("input[name='selectType[]']").each(function(){
							$(this).attr("checked",false);
						});	
					}
				});
				
				$("input[name='checkbox[]']").click(function(){
					$("input[name='checkbox[]']").each(function(){
						if($(this).attr("checked") == false) 
							$("#selectAll").attr("checked",false);
					});	
				});
				
				$("#accountName").keydown(function(){
					$("#roleName").val('');
				});
				$("#roleName").keydown(function(){
					$("#accountName").val('');
				});
			});
			
			function changePage(page) {
				$("#page").val(page);
				$("#searchform").submit();
			}
		</script>
	</head>
	<body>
		<div id="position">
			<b><{$lang->menu->class->userInfo}>：<{$lang->menu->allRoleLog}></b>
		</div>
		<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
			<td><{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="startDay" id="startDay" onfocus="WdatePicker({el:'startDay',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDay\')}'})" value="<{ $startDay }>"></td>
			<td><{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="endDay" id="endDay" onfocus="WdatePicker({el:'endDay',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDay\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>"></td>
			
			<td><{$lang->player->accountName}>: <input id="accountName" name="accountName" size="15" value="<{$accountName}>" 	/></td>
			<td><{$lang->player->roleName}>: <input id="roleName" name="roleName" size="15" value="<{$roleName}>" /></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  /></td>
			<br />
			<{$lang->page->selectLog}>
			<label><input type="checkbox" name="selectType[]" id="selectAll" value="all" <{if $selectType.all}> checked="checked" <{/if}>/><{$lang->page->all}></label>
			<!--
			<label><input type="checkbox" name="selectType[]" id="selectCurrency" value="currency" <{if $selectType.currency}> checked="checked" <{/if}>/><{$lang->page->aboutCurrency}></label>
			<label><input type="checkbox" name="selectType[]" id="selectPet" value="pet" <{if $selectType.pet}> checked="checked" <{/if}>/><{$lang->page->aboutPet}></label>
			<label><input type="checkbox" name="selectType[]" id="selectFamily" value="family" <{if $selectType.family}> checked="checked" <{/if}>/><{$lang->page->aboutFamily}></label>
			<label><input type="checkbox" name="selectType[]" id="selectHome" value="home" <{if $selectType.home}> checked="checked" <{/if}>/><{$lang->page->aboutHome}></label>
			<label><input type="checkbox" name="selectType[]" id="selectShenlu" value="shenlu" <{if $selectType.shenlu}> checked="checked" <{/if}>/><{$lang->page->aboutShenlu}></label>
			<label><input type="checkbox" name="selectType[]" id="selectOther" value="other" <{if $selectType.other}> checked="checked" <{/if}>/><{$lang->page->other}></label>
			-->
			<br />
			<{html_checkboxes options=$checkboxData checked=$checked separator="&nbsp;" }>
			
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
				<tr>
					<td height="30" class="even">
						<{foreach key=key item=item from=$pagelist}>
						<a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>');"><{$key}></a><span style="width:5px;"></span>
						<{/foreach}>
						<{$lang->page->record}>(<{$counts}>)&nbsp;&nbsp;&nbsp;<{$lang->page->totalPage}>(<{$pageCount}>)
						<{$lang->page->everyPage}><input type="text" id="pageSize" name="pageSize" size="4" style="text-align:center;" value="<{$pageSize}>"><{$lang->page->row}>
						<{$lang->page->dang}><input id="page" name="page" type="text" class="text" size="3" maxlength="6" style="text-align:center;" value="<{$page}>" ><{$lang->page->page}>&nbsp;<input id="btnGo" type="submit" class="button" name="Submit" value="GO">
					</td>
				</tr>
			</table>
		</form>
		
		<{*
		<{include file='file:pager.tpl' pages=$pager assign=pager_html }>
		<{$pager_html}>
		*}>
		
		<table class="DataGrid">
			<!--caption class="table_list_head" align="center">
				<{$lang->menu->allRoleLog}>
			</caption-->
			
			<tr align="center">
				<!--th style="width:10%"><{$lang->monitor->id}></th-->
				<th style="width:10%"><{$lang->page->time}></th>
		        <th style="width:10%"><{$lang->page->accountName}></th>
		        <th style="width:10%"><{$lang->page->roleName}></th>
		        <th style="width:5%"><{$lang->page->level}></th>
		        <th style="width:10%"><{$lang->page->keyword}></th>
		        <th style="width:40%"><{$lang->monitor->desc}></th>
			</tr>
			
			<{if $viewData}>
			<{foreach from=$viewData item=logs name=loop}>
			<tr align="center" <{ if $smarty.foreach.loop.index is odd }> class="odd"<{ /if }> >
				<td><{$logs.mdate}></td>
				<td><{$logs.account_name}></td>
				<td><{$logs.role_name}></td>
				<td><{$logs.level}></td>
				<td><{$logs.key}></td>
				<td><{$logs.desc}></td>
			</tr>
			<{/foreach}>
			<{ else }>
			<tr>
				<td colspan="6"><b><{$lang->page->noData}></b></td>
			</tr>
			<{/if}>
		</table>
		<{$pager_html}>
	</body>
</html>