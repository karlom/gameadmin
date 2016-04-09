<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
	function changePage(page){
		$("#page").val(page);
		$("#searchform").submit();
//		$("#myform").submit();
	}
	
	$(document).ready(function(){
		$("#role_name").keydown(function(){
			$("#account_name").val('');
		});
		$("#account_name").keydown(function(){
			$("#role_name").val('');
		});
		
		if($("#select_role").attr("checked") ==true) {
			$("#role_search").show();
			$("#label_search").hide();
			$(".table_page_num").hide();
		} else {
			$("#role_search").hide();
			$("#label_search").show();
		}
		
		/* */
		$("#select_role").click(function(){
			$("#role_search").show();
			$("#label_search").hide();
		});
		
		$("#select_label").click(function(){
			$("#role_search").hide();
			$("#label_search").show();
		});
		
		$("input.multi_line").click(function(){
			if($(this).attr("checked") == false) {
				$(this).parent().children("input[type=radio]").each(function(){
					$(this).attr("checked",false);
				});
			} else {
				$(this).parent().children("input[type=radio]:first").attr("checked",true);
			}
			
		});	
		
		$(".child_label").click(function(){
			$(this).parent().children("input[type=checkbox]").attr("checked",true);
		});
		
		$("#up").click(function(){
			$(this).hide();
			$("#down").show();
			$("li.inline").hide();
		});
		$("#down").click(function(){
			$(this).hide();
			$("#up").show();
			$("li.inline").show();
		});
		
		$("#search").click(function(){
			if( $("#select_role").attr("checked") && $("#account_name").val() == "" && $("#role_name").val() == "" ) {
				alert("<{$lang->verify->recRoleNameOrAccount}>");
				return false;
			}
			if( $("#select_label").attr("checked") && !$("#label_search input[type=checkbox]").is(":checked") ) {
				alert("请选择要查询的标签！");
				return false;
			}
		});
	});
</script>

<title><{$lang->menu->roleLabel}></title>

</head>

<body>

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
<div id="position"><{$lang->menu->class->baseData}>：<{$lang->menu->roleLabel}></div>
<!-- Start 账号和角色名搜索  -->
<form action="?action=search" id="searchform" method="POST" >
	<span>
	<label><input type="radio" id="select_role" name="search_type" value="1" <{if $search_type==1 }> checked="checked" <{/if}>/>按角色查询</label>
	<label><input type="radio" id="select_label" name="search_type" value="2" <{if $search_type==2 }> checked="checked" <{/if}>/>按数据标签查询</label>
	</span>
	<br />
	<table id="role_search" cellspacing="1" cellpadding="5" class="SumDataGrid" width="auto">
		<tr>
			<td><{$lang->page->accountName}>:
				<input type="text" name="account_name" id="account_name" size="15" value="<{$accountName}>" />
			</td>
			<td align="right"><{$lang->page->roleName}>:
				<input type="text" name="role_name" id="role_name" size="15" value="<{$roleName}>" />
			</td>
		</tr>
	</table>
	<ul id="label_search" style="display:none"> <{* class="actionTypes" *}> 
	<fieldset>
		<legend><{$lang->page->label}> <a id="up">↑</a><a id="down" style="display:none">↓</a> </legend>
		<{foreach from=$dictRoleLabel item=labelList key=k}>
		<{if @!is_array($labelList) }>
			<li class="inline"><label><input type="checkbox" name="label[]" value="<{$k}>" <{if @array_key_exists($k,$selectLabel) }> checked="checked" <{/if}> /><{$labelList}></label></li>
		<{else}>
			<li class="inline">
				<input class="multi_line" type="checkbox" name="label[]" value="<{$k}>"  <{if @array_key_exists($k,$selectLabel) }> checked="checked" <{/if}> /><{$labelList.name}>
			<{foreach from=$labelList item=log key=l}>
				<{ if $l ne "name"}>
					<input class="child_label" type="radio" name="<{$k}>" value="<{$l}>"  <{if $selectLabel[$k] == $l }> checked="checked" <{/if}> /> <{$log}>
				<{/if}>
			<{/foreach}>
			</li>
		<{/if}>
		<{/foreach}>
	</fieldset>
	</ul>
	<br />
	&nbsp;<input id="search" type="image" name='search' src="/static/images/search.gif" />
	
	<!-- 分页显示 -->
	
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
        <tr>
            <td height="30" class="even">
                <{foreach key=key item=item from=$pagelist}><a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>');"><{$key}></a>
                <span style="width:5px;"></span>
                <{/foreach}><{$lang->page->record}>(<{$counts}>)&nbsp;&nbsp;&nbsp;<{$lang->page->totalPage}>(<{$pageCount}>)<{$lang->page->everyPage}><input type="text" id="record" name="record" size="4" style="text-align:center;" value="<{$pageNum}>"><{$lang->page->row}><{$lang->page->dang}><input id="page" name="page" type="text" class="text" size="3" maxlength="6" style="text-align:center;" value="<{$pageno}>"><{$lang->page->page}>&nbsp;<input id="btnGo" type="submit" class="button" name="Submit" value="GO">
            </td>
        </tr>
    </table>
	
</form>
<!-- End 账号和角色名搜索  -->
<{ if $viewData }>
	<!--span style="color:#090"><{$lang->page->searchResult}>:</span-->
	<{ if $search_type==1}>
		<table class="SumDataGrid" width="800px">
			<thead>
				<tr >
					<th colspan="2"><{$lang->page->accountName}>: <{$accountName}>, <{$lang->page->roleName}>: <{$roleName}></th>
				</tr>
			</thead>
			<tr>
				<td width="10%" align="center"><b><{$lang->page->hasLabel}></b></td>
				<{foreach from=$viewData item=log}>
					<td width="80%" align="center"><{$log.hasLabel}></td>
				<{/foreach}>
			</tr>
		</table>
	<{else}>

	<table class="SumDataGrid" width="960px">

		<tr >
	        <th width="10%"><{$lang->page->accountName}></th>
	        <th width="10%"><{$lang->page->roleName}></th>
	        <th width="50%"><{$lang->page->hasLabel}></th>
	        <th width="10%"><{$lang->page->updateTime}></th>
	    </tr>
		
	    <{foreach from=$viewData item=log}>
	    <tr>
			<td align="center"><{$log.account_name}></td>
			<td align="center"><{$log.role_name}></td>
	        <td align="center"><{$log.hasLabel}></td>
			<td align="center"><{$log.mtime|date_format:'%Y-%m-%d %H:%M:%S'}></td>
	    </tr>
		<{/foreach}>

	</table>
	<{/if}>

<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
</body>
</html>