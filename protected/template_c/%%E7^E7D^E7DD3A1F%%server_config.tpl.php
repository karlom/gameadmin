<?php /* Smarty version 2.6.25, created on 2014-04-16 15:24:04
         compiled from module/system/server_config.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/system/server_config.tpl', 100, false),array('modifier', 'count_characters', 'module/system/server_config.tpl', 135, false),)), $this); ?>
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
	<title><?php echo $this->_tpl_vars['lang']->menu->serverConfig; ?>
</title>
	</head>

	<body>
		<div id="position"><?php echo $this->_tpl_vars['lang']->menu->class->systemManage; ?>
: <?php echo $this->_tpl_vars['lang']->menu->serverConfig; ?>
</div>
		
		<form action="<?php echo @URL_SELF; ?>
?action=add" method="post">
			<table class="table_list">
				<tr class="table_list_head">
					<th><?php echo $this->_tpl_vars['lang']->page->id; ?>
</th>
					<th><?php echo $this->_tpl_vars['lang']->page->showName; ?>
</th>
					<!-- <th><?php echo $this->_tpl_vars['lang']->page->ver; ?>
</th> -->
					<th><?php echo $this->_tpl_vars['lang']->page->entranceUrl; ?>
</th>
					<th><?php echo $this->_tpl_vars['lang']->page->url; ?>
</th>
					<th><?php echo $this->_tpl_vars['lang']->page->port; ?>
</th>
					<th><?php echo $this->_tpl_vars['lang']->page->ip; ?>
</th>
					<th><?php echo $this->_tpl_vars['lang']->page->dbname; ?>
</th>
					<th><?php echo $this->_tpl_vars['lang']->page->dbuser; ?>
</th>
					<th><?php echo $this->_tpl_vars['lang']->page->dbpwd; ?>
</th>
									<th><?php echo $this->_tpl_vars['lang']->page->onlineDate; ?>
</th>
					<th><?php echo $this->_tpl_vars['lang']->page->isCombine; ?>
</th>
					<th><?php echo $this->_tpl_vars['lang']->page->combineDate; ?>
</th>
					<th><?php echo $this->_tpl_vars['lang']->page->available; ?>
</th>
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
								<th><input type="text" id="onlinedate" name="onlinedate" onfocus="WdatePicker({el:'onlinedate',minDate:'<?php echo $this->_tpl_vars['mindate']; ?>
',maxDate:'<?php echo $this->_tpl_vars['nowDate']; ?>
'})" /></th>
					<th>
						<?php echo $this->_tpl_vars['lang']->page->combined; ?>
<input type="radio" name="iscombine" value="1" />
						<?php echo $this->_tpl_vars['lang']->page->notCombined; ?>
<input type="radio" name="iscombine" value="0" checked="checked" />
					</th>
					<th><input type="text" id="combinedate" name="combinedate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" /></th>
					<th>
						<?php echo $this->_tpl_vars['lang']->page->availableYes; ?>
<input type="radio" name="available" value="1" />
						<?php echo $this->_tpl_vars['lang']->page->availableNo; ?>
<input type="radio" name="available" value="0" checked="checked" />
					</th>			
				</tr>
				<tr class="trOdd">
					<td align="center" colspan="0">
						<input type="submit" name="insert_submit" value="<?php echo $this->_tpl_vars['lang']->page->add; ?>
" />
					</td>
				</tr>
			</table>
		</form>		
		
		<br />

		<table class="table_list">
			<tr class="table_list_head">
				<th align="center" colspan="0"><?php echo $this->_tpl_vars['lang']->page->serverConfigList; ?>
</th>
			</tr>
			<tr class="table_list_head">
				<th><?php echo $this->_tpl_vars['lang']->page->id; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']->page->showName; ?>
</th>
				<!-- <th><?php echo $this->_tpl_vars['lang']->page->ver; ?>
</th> -->
				<th><?php echo $this->_tpl_vars['lang']->page->entranceUrl; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']->page->url; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']->page->port; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']->page->ip; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']->page->dbname; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']->page->dbuser; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']->page->dbpwd; ?>
</th>
							<th><?php echo $this->_tpl_vars['lang']->page->onlineDate; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']->page->isCombine; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']->page->combineDate; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']->page->available; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']->player->operate; ?>
</th>
			</tr>
	
			<?php $_from = $this->_tpl_vars['serverList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>			
			<tr class="<?php echo smarty_function_cycle(array('values' => "trEven,trOdd"), $this);?>
" align="center" >
				<td>s<?php echo $this->_tpl_vars['list']['id']; ?>
</td>
				<td>
					<span class="item-normal"><?php echo $this->_tpl_vars['list']['name']; ?>
</span>
					<span class="item-editing"><input type="text" id="name_<?php echo $this->_tpl_vars['list']['id']; ?>
" name="name" value="<?php echo $this->_tpl_vars['list']['name']; ?>
" style="width: 50px;" /></span>
				</td>
				<!-- <td>
					<span class="item-normal"><?php echo $this->_tpl_vars['list']['ver']; ?>
</span>
					<span class="item-editing"><input type="text" id="ver_<?php echo $this->_tpl_vars['list']['id']; ?>
" name="ver" value="<?php echo $this->_tpl_vars['list']['ver']; ?>
" style="width: 60px;" /></span>
				</td> -->
				<td>
					<span class="item-normal"><?php echo $this->_tpl_vars['list']['entranceUrl']; ?>
</span>
					<span class="item-editing"><input type="text" id="entranceUrl_<?php echo $this->_tpl_vars['list']['id']; ?>
" name="entranceUrl" value="<?php echo $this->_tpl_vars['list']['entranceUrl']; ?>
" style="width: 150px;" /></span>
				</td>
				<td>
					<span class="item-normal"><?php echo $this->_tpl_vars['list']['url']; ?>
</span>
					<span class="item-editing"><input type="text" id="url_<?php echo $this->_tpl_vars['list']['id']; ?>
" name="url" value="<?php echo $this->_tpl_vars['list']['url']; ?>
" style="width: 150px;" /></span>
				</td>
				<td>
					<span class="item-normal"><?php echo $this->_tpl_vars['list']['port']; ?>
</span>
					<span class="item-editing"><input type="text" id="port_<?php echo $this->_tpl_vars['list']['id']; ?>
" name="port" value="<?php echo $this->_tpl_vars['list']['port']; ?>
" style="width: 50px;" /></span>
				</td>
				<td>
					<span class="item-normal"><?php echo $this->_tpl_vars['list']['ip']; ?>
</span>
					<span class="item-editing"><input type="text" id="ip_<?php echo $this->_tpl_vars['list']['id']; ?>
" name="ip" value="<?php echo $this->_tpl_vars['list']['ip']; ?>
" style="width: 80px;" /></span>
				</td>
				<td>
					<span class="item-normal"><?php echo $this->_tpl_vars['list']['dbname']; ?>
</span>
					<span class="item-editing"><input type="text" id="dbname_<?php echo $this->_tpl_vars['list']['id']; ?>
" name="dbname" value="<?php echo $this->_tpl_vars['list']['dbname']; ?>
" /></span>
				</td>
				<td>
					<span class="item-normal"><?php echo $this->_tpl_vars['list']['dbuser']; ?>
</span>
					<span class="item-editing"><input type="text" id="dbuser_<?php echo $this->_tpl_vars['list']['id']; ?>
" name="dbuser" value="<?php echo $this->_tpl_vars['list']['dbuser']; ?>
" style="width: 60px;" /></span>
				</td>
				<td>
					<span class="item-normal"><?php unset($this->_sections['loop']);
$this->_sections['loop']['name'] = 'loop';
$this->_sections['loop']['loop'] = is_array($_loop=((is_array($_tmp=$this->_tpl_vars['list']['dbpwd'])) ? $this->_run_mod_handler('count_characters', true, $_tmp, true) : smarty_modifier_count_characters($_tmp, true))) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['loop']['show'] = true;
$this->_sections['loop']['max'] = $this->_sections['loop']['loop'];
$this->_sections['loop']['step'] = 1;
$this->_sections['loop']['start'] = $this->_sections['loop']['step'] > 0 ? 0 : $this->_sections['loop']['loop']-1;
if ($this->_sections['loop']['show']) {
    $this->_sections['loop']['total'] = $this->_sections['loop']['loop'];
    if ($this->_sections['loop']['total'] == 0)
        $this->_sections['loop']['show'] = false;
} else
    $this->_sections['loop']['total'] = 0;
if ($this->_sections['loop']['show']):

            for ($this->_sections['loop']['index'] = $this->_sections['loop']['start'], $this->_sections['loop']['iteration'] = 1;
                 $this->_sections['loop']['iteration'] <= $this->_sections['loop']['total'];
                 $this->_sections['loop']['index'] += $this->_sections['loop']['step'], $this->_sections['loop']['iteration']++):
$this->_sections['loop']['rownum'] = $this->_sections['loop']['iteration'];
$this->_sections['loop']['index_prev'] = $this->_sections['loop']['index'] - $this->_sections['loop']['step'];
$this->_sections['loop']['index_next'] = $this->_sections['loop']['index'] + $this->_sections['loop']['step'];
$this->_sections['loop']['first']      = ($this->_sections['loop']['iteration'] == 1);
$this->_sections['loop']['last']       = ($this->_sections['loop']['iteration'] == $this->_sections['loop']['total']);
?>*<?php endfor; endif; ?></span>
					<span class="item-editing"><input type="text" id="dbpwd_<?php echo $this->_tpl_vars['list']['id']; ?>
" name="dbpwd" /></span>
				</td>
								<td>
					<span class="item-normal"><?php echo $this->_tpl_vars['list']['onlinedate']; ?>
</span>
					<span class="item-editing"><input type="text" id="onlinedate_<?php echo $this->_tpl_vars['list']['id']; ?>
" name="onlinedate" value="<?php echo $this->_tpl_vars['list']['onlinedate']; ?>
"  style="width: 70px;"/></span>
				</td>
				<td>
					<span class="item-normal"><?php if ($this->_tpl_vars['list']['iscombine'] == 1): ?><span style="color:red;"><?php echo $this->_tpl_vars['lang']->page->combined; ?>
</span><?php else: ?><span style="color:green;"><?php echo $this->_tpl_vars['lang']->page->notCombined; ?>
</span><?php endif; ?></span>
					<span class="item-editing">
						<?php echo $this->_tpl_vars['lang']->page->combined; ?>
<input type="radio" class="radio" name="iscombine_<?php echo $this->_tpl_vars['list']['id']; ?>
" value="1" <?php if ($this->_tpl_vars['list']['iscombine'] == 1): ?>checked="checked"<?php endif; ?> />
						<?php echo $this->_tpl_vars['lang']->page->notCombined; ?>
<input type="radio" class="radio" name="iscombine_<?php echo $this->_tpl_vars['list']['id']; ?>
" value="0" <?php if ($this->_tpl_vars['list']['iscombine'] == 0): ?>checked="checked"<?php endif; ?> />
					</span>
				</td>
				<td>
					<span class="item-normal"><?php echo $this->_tpl_vars['list']['combinedate']; ?>
</span>
					<span class="item-editing"><input type="text" id="combinedate_<?php echo $this->_tpl_vars['list']['id']; ?>
" name="combinedate" value="<?php echo $this->_tpl_vars['list']['combinedate']; ?>
"  style="width: 70px;"/></span>
				</td>
				<td>
					<span class="item-normal"><?php if ($this->_tpl_vars['list']['available'] == 0): ?><span style="color:red;"><?php echo $this->_tpl_vars['lang']->page->availableNo; ?>
</span><?php else: ?><span style="color:green;"><?php echo $this->_tpl_vars['lang']->page->availableYes; ?>
</span><?php endif; ?></span>
					<span class="item-editing">
						<?php echo $this->_tpl_vars['lang']->page->availableYes; ?>
<input type="radio" class="radio" name="available_<?php echo $this->_tpl_vars['list']['id']; ?>
" value="1" <?php if ($this->_tpl_vars['list']['available'] == 1): ?>checked="checked"<?php endif; ?> />
						<?php echo $this->_tpl_vars['lang']->page->availableNo; ?>
<input type="radio" class="radio" name="available_<?php echo $this->_tpl_vars['list']['id']; ?>
" value="0" <?php if ($this->_tpl_vars['list']['available'] == 0): ?>checked="checked"<?php endif; ?> />
					</span>
				</td>
				<td >
					<span class="item-normal"><input type="button" value="<?php echo $this->_tpl_vars['lang']->page->update; ?>
" class="btn-toggle" /></span>
					<span class="item-editing"><input type="button" name="update_button" value="<?php echo $this->_tpl_vars['lang']->page->submit; ?>
" pvalue="<?php echo $this->_tpl_vars['list']['id']; ?>
" style="color:green;" ></span>
					<span class="item-normal"><input type="button" name="delete_button" value="<?php echo $this->_tpl_vars['lang']->page->del; ?>
" pvalue="<?php echo $this->_tpl_vars['list']['id']; ?>
" /></span>
					<span class="item-editing"><input type="button" name="cancel_update" value="<?php echo $this->_tpl_vars['lang']->page->cancel; ?>
" class="btn-toggle" style="color:red;" /></span>
								</td>
			</tr>
			<?php endforeach; endif; unset($_from); ?>
		</table>
		
		<script type="text/javascript">
			<?php if ('add' == $this->_tpl_vars['action']): ?>
				$(parent.document).find("frame[id=topFrame]").attr("src", "./top.php");
				$(parent.document).find("frame[id=menu]").attr("src", "./left.php");
			<?php endif; ?>
				
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
				){alert("<?php echo $this->_tpl_vars['lang']->page->allMustNotEmpty; ?>
"); return false;}
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
				){alert("<?php echo $this->_tpl_vars['lang']->page->allMustNotEmpty; ?>
"); return false;}
//				if (!isURL($("input[id=url_<?php echo $this->_tpl_vars['list']['id']; ?>
]").val())) {return false;}
//				if (!isIP($("input[id=ip_<?php echo $this->_tpl_vars['list']['id']; ?>
]").val())) {return false;}
//				if (!isNum($("input[id=port_<?php echo $this->_tpl_vars['list']['id']; ?>
]").val(), 'port')) {return false;}

				$.ajax({
					type: "POST",
					url: "<?php echo @URL_SELF; ?>
?action=update",
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
				if(confirm("<?php echo $this->_tpl_vars['lang']->page->confirmDel; ?>
")) {
					var num = $(this).attr("pvalue");
					$.ajax({
						type: "POST",
						url: "<?php echo @URL_SELF; ?>
?action=delete",
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
						alert("<?php echo $this->_tpl_vars['lang']->page->IDMustBeNum; ?>
");
						return false;
					} else {
						alert("<?php echo $this->_tpl_vars['lang']->page->portMustBeNum; ?>
");
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
					alert("<?php echo $this->_tpl_vars['lang']->page->mustBeURL; ?>
");
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
					alert("<?php echo $this->_tpl_vars['lang']->page->mustBeIP; ?>
");
					return false;
				}
			}

			function isEqual(num) {
				var str1 = ",";
				<?php $_from = $this->_tpl_vars['serverList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
				var str2 = "<?php echo $this->_tpl_vars['list']['id']; ?>
,";
				str1 = str1.concat(str2);
				<?php endforeach; endif; unset($_from); ?>
				num = "," + num + ",";
				if (str1.match(num)){
					alert("<?php echo $this->_tpl_vars['lang']->page->conflictWithExistId; ?>
");
					return true;
				} else {
					return false;
				}
			}

			function reloadPage() {
				location.href = "<?php echo @URL_SELF; ?>
";
				$(parent.document).find("frame[id=topFrame]").attr("src", "./top.php");
				$(parent.document).find("frame[id=menu]").attr("src", "./left.php");
			}
		</script>	
	</body>
</html>