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
		<div id="position"><{$lang->menu->class->systemManage}>: <{$lang->menu->serverConfig}></div>
		
		<form action="<{$smarty.const.URL_SELF}>?action=add" method="post">
			<table class="table_list">
				<tr class="table_list_head">
					<th><{$lang->page->id}></th>
					<th><{$lang->page->showName}></th>
					<!-- <th><{$lang->page->ver}></th> -->
					<th><{$lang->page->entranceUrl}></th>
					<th><{$lang->page->url}></th>
					<th><{$lang->page->port}></th>
					<th><{$lang->page->ip}></th>
					<th><{$lang->page->dbname}></th>
					<th><{$lang->page->dbuser}></th>
					<th><{$lang->page->dbpwd}></th>
				<{*	<th><{$lang->page->md5}></th>
				*}>
					<th><{$lang->page->onlineDate}></th>
					<th><{$lang->page->isCombine}></th>
					<th><{$lang->page->combineDate}></th>
					<th><{$lang->page->available}></th>
				</tr>
				<tr class="trEven">
					<th><input type="text" id="id" name="id" style="width: 30px;" /></th>
					<th><input type="text" id="name" name="name" style="width: 70px;" /></th>
					<!-- <th><input type="text" id="ver" name="ver" style="width: 50px;" /></th> -->
					<th><input type="text" id="entranceUrl" name="entranceUrl" /></th>
					<th><input type="text" id="url" name="url" /></th>
					<th><input type="text" id="port" name="port" style="width: 50px;" /></th>
					<th><input type="text" id="ip" name="ip" /></th>
					<th><input type="text" id="dbname" name="dbname" /></th>
					<th><input type="text" id="dbuser" name="dbuser" /></th>
					<th><input type="text" id="dbpwd" name="dbpwd" /></th>
			<{*		<th><input type="text" id="md5" name="md5" /></th>
			*}>
					<th><input type="text" id="onlinedate" name="onlinedate" onfocus="WdatePicker({el:'onlinedate',minDate:'<{$mindate}>',maxDate:'<{$nowDate}>'})" /></th>
					<th>
						<{$lang->page->combined}><input type="radio" name="iscombine" value="1" />
						<{$lang->page->notCombined}><input type="radio" name="iscombine" value="0" checked="checked" />
					</th>
					<th><input type="text" id="combinedate" name="combinedate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" /></th>
					<th>
						<{$lang->page->availableYes}><input type="radio" name="available" value="1" />
						<{$lang->page->availableNo}><input type="radio" name="available" value="0" checked="checked" />
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
				<th align="center" colspan="0"><{$lang->page->serverConfigList}></th>
			</tr>
			<tr class="table_list_head">
				<th><{$lang->page->id}></th>
				<th><{$lang->page->showName}></th>
				<!-- <th><{$lang->page->ver}></th> -->
				<th><{$lang->page->entranceUrl}></th>
				<th><{$lang->page->url}></th>
				<th><{$lang->page->port}></th>
				<th><{$lang->page->ip}></th>
				<th><{$lang->page->dbname}></th>
				<th><{$lang->page->dbuser}></th>
				<th><{$lang->page->dbpwd}></th>
			<{*	<th><{$lang->page->md5}></th>
			*}>
				<th><{$lang->page->onlineDate}></th>
				<th><{$lang->page->isCombine}></th>
				<th><{$lang->page->combineDate}></th>
				<th><{$lang->page->available}></th>
				<th><{$lang->player->operate}></th>
			</tr>
	
			<{foreach from=$serverList item=list}>			
			<tr class="<{cycle values="trEven,trOdd"}>" align="center" >
				<td>s<{$list.id}></td>
				<td>
					<span class="item-normal"><{$list.name}></span>
					<span class="item-editing"><input type="text" id="name_<{$list.id}>" name="name" value="<{$list.name}>" style="width: 50px;" /></span>
				</td>
				<!-- <td>
					<span class="item-normal"><{$list.ver}></span>
					<span class="item-editing"><input type="text" id="ver_<{$list.id}>" name="ver" value="<{$list.ver}>" style="width: 60px;" /></span>
				</td> -->
				<td>
					<span class="item-normal"><{$list.entranceUrl}></span>
					<span class="item-editing"><input type="text" id="entranceUrl_<{$list.id}>" name="entranceUrl" value="<{$list.entranceUrl}>" style="width: 150px;" /></span>
				</td>
				<td>
					<span class="item-normal"><{$list.url}></span>
					<span class="item-editing"><input type="text" id="url_<{$list.id}>" name="url" value="<{$list.url}>" style="width: 150px;" /></span>
				</td>
				<td>
					<span class="item-normal"><{$list.port}></span>
					<span class="item-editing"><input type="text" id="port_<{$list.id}>" name="port" value="<{$list.port}>" style="width: 50px;" /></span>
				</td>
				<td>
					<span class="item-normal"><{$list.ip}></span>
					<span class="item-editing"><input type="text" id="ip_<{$list.id}>" name="ip" value="<{$list.ip}>" style="width: 80px;" /></span>
				</td>
				<td>
					<span class="item-normal"><{$list.dbname}></span>
					<span class="item-editing"><input type="text" id="dbname_<{$list.id}>" name="dbname" value="<{$list.dbname}>" /></span>
				</td>
				<td>
					<span class="item-normal"><{$list.dbuser}></span>
					<span class="item-editing"><input type="text" id="dbuser_<{$list.id}>" name="dbuser" value="<{$list.dbuser}>" style="width: 60px;" /></span>
				</td>
				<td>
					<span class="item-normal"><{section name=loop loop=$list.dbpwd|count_characters:true}>*<{/section}></span>
					<span class="item-editing"><input type="text" id="dbpwd_<{$list.id}>" name="dbpwd" /></span>
				</td>
				<{*
				<td>
					<span class="item-normal"><{$list.md5}></span>
					<span class="item-editing"><input type="text" id="md5_<{$list.id}>" name="md5" value="<{$list.md5}>" style="width: 195px;" /></span>
				</td>
				*}>
				<td>
					<span class="item-normal"><{$list.onlinedate}></span>
					<span class="item-editing"><input type="text" id="onlinedate_<{$list.id}>" name="onlinedate" value="<{$list.onlinedate}>"  style="width: 70px;"/></span>
				</td>
				<td>
					<span class="item-normal"><{if $list.iscombine==1}><span style="color:red;"><{$lang->page->combined}></span><{else}><span style="color:green;"><{$lang->page->notCombined}></span><{/if}></span>
					<span class="item-editing">
						<{$lang->page->combined}><input type="radio" class="radio" name="iscombine_<{$list.id}>" value="1" <{if $list.iscombine==1}>checked="checked"<{/if}> />
						<{$lang->page->notCombined}><input type="radio" class="radio" name="iscombine_<{$list.id}>" value="0" <{if $list.iscombine==0}>checked="checked"<{/if}> />
					</span>
				</td>
				<td>
					<span class="item-normal"><{$list.combinedate}></span>
					<span class="item-editing"><input type="text" id="combinedate_<{$list.id}>" name="combinedate" value="<{$list.combinedate}>"  style="width: 70px;"/></span>
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
				<{*	<span class="item-normal"><input type="button" name="copy" value="<{$lang->page->copy}>" onclick="javascript:copyData(<{$list.id}>);" style="color:blue;" /></span>
				*}>
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
				if(		"" == $("input[id=id]").val() || 
//						"" == $("input[id=ver]").val() ||
						"" == $("input[id=url]").val() ||
						"" == $("input[id=entranceUrl]").val() ||
						"" == $("input[id=ip]").val() ||
						"" == $("input[id=port]").val() ||
						"" == $("input[id=dbuser]").val() ||
						"" == $("input[id=dbpwd]").val() ||
						"" == $("input[id=dbname]").val() ||
						"" == $("input[id=onlinedate]").val() ||
						"" == $("input[id=iscombine]").val() 
					//	"" == $("input[id=combinedate]").val()
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
//						"" == $("input[id=ver_"+num+"]").val() ||
						"" == $("input[id=url_"+num+"]").val() ||
						"" == $("input[id=entranceUrl_"+num+"]").val() ||
						"" == $("input[id=ip_"+num+"]").val() ||
						"" == $("input[id=port_"+num+"]").val() ||
						"" == $("input[id=dbuser_"+num+"]").val() ||
						"" == $("input[id=dbname_"+num+"]").val() ||
						"" == $("input[id=onlinedate_"+num+"]").val() ||
						"" == $("input[id=iscombine_"+num+"]").val() 
					//	"" == $("input[id=combinedate_"+num+"]").val()
				){alert("<{$lang->page->allMustNotEmpty}>"); return false;}
//				if (!isURL($("input[id=url_<{$list.id}>]").val())) {return false;}
//				if (!isIP($("input[id=ip_<{$list.id}>]").val())) {return false;}
//				if (!isNum($("input[id=port_<{$list.id}>]").val(), 'port')) {return false;}

				$.ajax({
					type: "POST",
					url: "<{$smarty.const.URL_SELF}>?action=update",
					data: "id="+num
					+"&name="+$("input[id=name_"+num+"]").val()
//					+"&ver="+$("input[id=ver_"+num+"]").val()
					+"&url="+$("input[id=url_"+num+"]").val()
					+"&entranceUrl="+$("input[id=entranceUrl_"+num+"]").val()
					+"&ip="+$("input[id=ip_"+num+"]").val()
					+"&port="+$("input[id=port_"+num+"]").val()
					+"&dbuser="+$("input[id=dbuser_"+num+"]").val()
					+"&dbpwd="+$("input[id=dbpwd_"+num+"]").val()
					+"&dbname="+$("input[id=dbname_"+num+"]").val()
				//	+"&md5="+$("input[id=md5_"+num+"]").val()
					+"&onlinedate="+$("input[id=onlinedate_"+num+"]").val()
					+"&iscombine="+$("input[name=iscombine_"+num+"]:checked").val()
					+"&combinedate="+$("input[id=combinedate_"+num+"]").val()
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
				<{foreach from=$serverList item=list}>
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