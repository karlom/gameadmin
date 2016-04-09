<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
	<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
	<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
	<style type="text/css">
		input{width:100px; margin: 0;}
		input[type=radio] {width:auto;}
		input[type=button] {width:auto;}
		input[type=submit] {width:auto;}
	</style>
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<title><{$lang->menu->serverConfig}></title>
	</head>

	<body>
		<div id="position"><{$lang->menu->class->systemManage}>: <{$lang->menu->adminConfig}></div>
		
		<form action="<{$smarty.const.URL_SELF}>?action=add" method="post">
			<table class="table_list">
				<tr class="table_list_head">
					<th><{$lang->page->urlName}></th>
					<th><{$lang->page->adminName}></th>
					<!-- <th><{$lang->page->ver}></th> -->
					<th><{$lang->page->isAvailable}></th>
				</tr>
				<tr class="trEven">
					<th><input type="text" id="urlname" name="urlname" style="width: 150px;" /></th>
					<!-- <th><input type="text" id="ver" name="adminname" style="width: 50px;" /></th> -->
					<th><input type="text" id="adminname" name="adminname" style="width: 150px;"/></th>
					<th>
						<{$lang->page->availableYes}><input type="radio" name="available" value="1" checked="checked"/>
						<{$lang->page->availableNo}><input type="radio" name="available" value="0"  />
					</th>			
				</tr>
				<tr class="trOdd">
					<td align="center" colspan="0">
						<input type="submit" name="insert_submit" value="<{$lang->page->add}>" />
					</td>
				</tr>
			</table>
		</form>		
		
		<br />

		<table class="table_list">
			<tr class="table_list_head">
				<th align="center" colspan="0"><{$lang->page->adminConfigList}></th>
			</tr>
			<tr class="table_list_head">
			  <th>id</th>
				<th><{$lang->page->urlName}></th>
				<th><{$lang->page->adminName}></th>
					<!-- <th><{$lang->page->ver}></th> -->
				<th><{$lang->page->isAvailable}></th>
				<th><{$lang->player->operate}></th>
			</tr>
	
			<{foreach from=$adminList item=list}>			
			<tr class="<{cycle values="trEven,trOdd"}>" align="center" >
				<td><{$list.id}></td>
				<td>
					<span class="item-normal"><{$list.url}></span>
					<span class="item-editing"><input type="text" id="urlname_<{$list.id}>" name="urlname" value="<{$list.url}>" style="width: 150px;" /></span>
				</td>
				<td>
					<span class="item-normal"><{$list.name}></span>
					<span class="item-editing"><input type="text" id="adminname_<{$list.id}>" name="adminname" value="<{$list.name}>" style="width: 150px;" /></span>
				</td>
				<td>
					<span class="item-normal"><{if $list.available==0}><span style="color:red;"><{$lang->page->availableNo}></span><{else}><span style="color:green;"><{$lang->page->availableYes}></span><{/if}></span>
					<span class="item-editing">
						<{$lang->page->availableYes}><input type="radio" class="radio" name="available_<{$list.id}>" value="1" <{if $list.available==1}>checked="checked"<{/if}> />
						<{$lang->page->availableNo}><input type="radio" class="radio" name="available_<{$list.id}>" value="0" <{if $list.available==0}>checked="checked"<{/if}> />
					</span>
				</td>
				<td >
					<span class="item-normal"><input type="button" value="<{$lang->page->update}>" class="btn-toggle" /></span>
					<span class="item-editing"><input type="button" name="update_button" value="<{$lang->page->submit}>" pvalue="<{$list.id}>" style="color:green;" ></span>
					<span class="item-normal"><input type="button" name="delete_button" value="<{$lang->page->del}>" pvalue="<{$list.id}>" /></span>
					<span class="item-editing"><input type="button" name="cancel_update" value="<{$lang->page->cancel}>" class="btn-toggle" style="color:red;" /></span>
				</td>
			</tr>
			<{/foreach}>
		</table>
		
		<script type="text/javascript">
			<{if "add" == $action}>
				$(parent.document).find("frame[id=topFrame]").attr("src", "./top.php");
				$(parent.document).find("frame[id=menu]").attr("src", "./left.php");
			<{/if}>
				
			$("tr .btn-toggle").click(function(){
				$(this).parents("tr:eq(0)").toggleClass("editing");
			});

			// 插入前的检测
			$("input[name=insert_submit]").click(function(){
				if(		"" == $("input[id=urlname]").val() || 
      				"" == $("input[id=adminname]").val()
				){alert("<{$lang->page->allMustNotEmpty}>"); return false;}
//				if (!isNum($("input[id=id]").val(), 'id')) {return false;}
//				if (isEqual($("input[id=id]").val())) {return false;}
//				if (!isURL($("input[id=url]").val())) {return false;}	
//				if (!isURL($("input[id=entranceUrl]").val())) {return false;}	
//				if (!isIP($("input[id=ip]").val())) {return false;}
//				if (!isNum($("input[id=port]").val(), 'port')) {return false;}	
			});

			// 修改后的检测
			$("input[name=update_button]").click(function(){
				var num = $(this).attr("pvalue");
				if(
						"" == $("input[id=urlname_"+num+"]").val() ||
						"" == $("input[id=adminname_"+num+"]").val()
				){alert("<{$lang->page->allMustNotEmpty}>"); return false;}
//				if (!isURL($("input[id=url_<{$list.id}>]").val())) {return false;}
//				if (!isIP($("input[id=ip_<{$list.id}>]").val())) {return false;}
//				if (!isNum($("input[id=port_<{$list.id}>]").val(), 'port')) {return false;}

				$.ajax({
					type: "POST",
					url: "<{$smarty.const.URL_SELF}>?action=update",
					data: "id="+num
					+"&urlname="+$("input[id=urlname_"+num+"]").val()
					+"&adminname="+$("input[id=adminname_"+num+"]").val()
					+"&available="+$("input[name=available_"+num+"]:checked").val(),
					dataType: "json",
					success: function(data){
						if(1 == data.result){
							reloadPage();
						}
					}
				});
			});

			$("input[name=delete_button]").click(function(){
				if(confirm("<{$lang->page->confirmDel}>")) {
					var num = $(this).attr("pvalue");
					$.ajax({
						type: "POST",
						url: "<{$smarty.const.URL_SELF}>?action=delete",
						data: "id="+num,
						success: function(data){
							reloadPage();
						}
					});
				}
				else{
					return false;
				}
			});
			
			function copyData(id){
				document.getElementById("id").value = id+1;
				document.getElementById("name").value = document.getElementById("name_"+id).value;
				document.getElementById("entranceUrl").value = document.getElementById("entranceUrl_"+id).value;
				document.getElementById("url").value = document.getElementById("url_"+id).value;
				document.getElementById("port").value = document.getElementById("port_"+id).value;
				document.getElementById("ip").value = document.getElementById("ip_"+id).value;
				document.getElementById("dbname").value = document.getElementById("dbname_"+id).value;
				document.getElementById("dbuser").value = document.getElementById("dbuser_"+id).value;
				document.getElementById("md5").value = document.getElementById("md5_"+id).value;
				document.getElementById("onlinedate").value = document.getElementById("onlinedate_"+id).value;
			}

			function isNum(num, type) {
				var result = isNaN(num);
				if (! result) {
					return true;
				} else {
					if(type == "id"){
						alert("<{$lang->page->IDMustBeNum}>");
						return false;
					} else {
						alert("<{$lang->page->portMustBeNum}>");
					}
				}
			}
			
			function isURL(str) {
				var regURL = /(http[s]?|ftp):\/\/[^\/\.]+?\..+\w$/i;
				var result = regURL.test(str); // test 返回值为 true/false
				//var result = str.match(regURL); // match 返回值为匹配字符串
				if (result) {
					return true;
				} else {
					alert("<{$lang->page->mustBeURL}>");
					return false;
				}
			}

			function isIP(str) {
				var regIP = /^(\d+)\.(\d+)\.(\d+)\.(\d+)$/g;
				var result = regIP.test(str);
				//var result = str.match(regIP);
				if (result && RegExp.$1<256 && RegExp.$2<256 && RegExp.$3<256 && RegExp.$4<256) {
					return true;
				} else {
					alert("<{$lang->page->mustBeIP}>");
					return false;
				}
			}

			function isEqual(num) {
				var str1 = ",";
				<{foreach from=$adminList item=list}>
				var str2 = "<{$list.id}>,";
				str1 = str1.concat(str2);
				<{/foreach}>
				num = "," + num + ",";
				if (str1.match(num)){
					alert("<{$lang->page->conflictWithExistId}>");
					return true;
				} else {
					return false;
				}
			}

			function reloadPage() {
				location.href = "<{$smarty.const.URL_SELF}>";
				$(parent.document).find("frame[id=topFrame]").attr("src", "./top.php");
				$(parent.document).find("frame[id=menu]").attr("src", "./left.php");
			}
		</script>	
	</body>
</html>
