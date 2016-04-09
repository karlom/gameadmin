<?php /* Smarty version 2.6.25, created on 2014-04-17 15:42:40
         compiled from module/pay/regular_send_item.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'module/pay/regular_send_item.tpl', 468, false),array('function', 'html_options', 'module/pay/regular_send_item.tpl', 615, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['lang']->menu->regularSendItem; ?>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
    var tr = 0;
	$(document).ready(function(){
		if ('<?php echo $this->_tpl_vars['submitApply']; ?>
' == 'done') {
			alert("<?php echo $this->_tpl_vars['lang']->alert->submitAppy; ?>
");
		}		
        $('#frm').submit(function(){		
            if($("#role_name_list").val() == '' && $("#byRoleName").attr("checked") == true){
                alert("<?php echo $this->_tpl_vars['lang']->verify->recRoleName; ?>
");
                return false;
            }
            if($("#reason").val() == ''){
                alert("<?php echo $this->_tpl_vars['lang']->verify->sendReasonNotNull; ?>
");
                return false;
            }
            if($("#mailTitle").val() == ''){
                alert("<?php echo $this->_tpl_vars['lang']->verify->sendTitleNotNull; ?>
");
                return false;
            }
            if($("#mailContent").val() == ''){
                alert("<?php echo $this->_tpl_vars['lang']->verify->sendContentNotNull; ?>
");
                return false;
            }
			if( $("#add_item_table tr").size() <= 1  ){
				alert("<?php echo $this->_tpl_vars['lang']->verify->sendItemNotNull; ?>
");
				return false;
			}
            if(confirm("<?php echo $this->_tpl_vars['lang']->verify->sureApply; ?>
?")){
                return true;
            }
            if($("#sendTime").val() == ''){
                alert("请输入发送时间！");
                return false;
            }
            return false;
        });

        $('#add_item').click(function(){
			if ( $("#add_item_table tr").size() >= 8 ) {
				//一次最多只能发7个道具
				alert('道具数量达到上限，一次最多只能发7个道具！') ;
				return ;
			}
            var item_id = $('#goods_type_id').val();
            if(item_id == ''){
                alert('<?php echo $this->_tpl_vars['lang']->verify->itemName; ?>
');
                return;
            }
            $('#goods_type_id').val('')
            var item_num = $('#item_num').val();
            if(item_num == ''){
                alert('<?php echo $this->_tpl_vars['lang']->verify->itemNum; ?>
');
                return;
            }
            
            var bind = $("input[name='bind'][type='radio']:checked").val();
            if(bind == ''){
                alert('<?php echo $this->_tpl_vars['lang']->verify->bindType; ?>
');
                return;
            }
            
            if(bind == 'yes'){
                bind = '<?php echo $this->_tpl_vars['lang']->verify->yes; ?>
';
                bind_flag = 1;
            }
            else if(bind == 'no'){
                bind = '<?php echo $this->_tpl_vars['lang']->verify->no; ?>
';
                bind_flag = 0;
            }
            var strength = $('#strength').val()?$('#strength').val():0;
            var quality = $('#quality').val();
            var gems_type_id = new Array();
            $('.addMoreGemsClass').each(function(){
				if ($(this).val() != "") {
					gems_type_id.push($(this).val());
				}
            });

			//提交道具后清空数据
            $('#strength').val('');
            $('#quality').val('');
            $('#item_num').val('1');
            $('.addMoreGemsClass').each(function(){
            	$(this).val('');
            });           
            
            var hidden = "<input type='hidden' id= 'item["+tr+"][item_id]' name='item["+tr+"][item_id]' value = '" + item_id + "'>";
            hidden += "<input type='hidden' id= 'item["+tr+"][item_num]' name='item["+tr+"][item_num]' value = '" + item_num + "'>";
            hidden += "<input type='hidden' id= 'item["+tr+"][item_bind]' name='item["+tr+"][item_bind]' value = '" + bind_flag + "'>";
            hidden += "<input type='hidden' id= 'item["+tr+"][item_strength]' name='item["+tr+"][item_strength]' value = '" + strength + "'>";
            hidden += "<input type='hidden' id= 'item["+tr+"][item_quality]' name='item["+tr+"][item_quality]' value = '" + quality + "'>";
            hidden += "<input type='hidden' id= 'item["+tr+"][item_gems_type_id]' name='item["+tr+"][item_gems_type_id]' value = '" + gems_type_id + "'>";            
            tr++;
            
			if (isWeapon) {
				var tr_obj = '<tr><td>'+item_id+'</td><td>'+item_num+'</td><td>'+bind+'</td><td>'+strength+'</td><td>'+quality+'</td><td>'+gems_type_id+'</td><td>'+
	            "<input id='del_times' type='button' value='<?php echo $this->_tpl_vars['lang']->verify->deleteItem; ?>
' />"+hidden+'</td></tr>';
			} else {
				var tr_obj = '<tr><td>'+item_id+'</td><td>'+item_num+'</td><td>'+bind+'</td><td>--</td><td>--</td><td>--</td><td>'+
	            "<input id='del_times' type='button' value='<?php echo $this->_tpl_vars['lang']->verify->deleteItem; ?>
' />"+hidden+'</td></tr>';
			}
            $("#add_item_table").append(tr_obj);
            $("input[id=del_times]").bind("click", delTimes);            
            doDisable()
            return;
        });
        function delTimes(){
			$(this).parent().parent().remove();
		}
    });
	
</script>
<!-- start 支持as3 的富文本编辑器	-->
		<link rel="stylesheet" type="text/css" href="/static/richTextEditor/richTextEditor.css" />
        <script type="text/javascript" src="/static/richTextEditor/history/history.js"></script>
        <script type="text/javascript" src="/static/richTextEditor/swfobject.js"></script>
        <script type="text/javascript">
            var swfVersionStr = "10.0.0";
            var xiSwfUrlStr = "/static/richTextEditor/playerProductInstall.swf";
            var flashvars = {};
            var params = {};
            params.quality = "high";
            params.bgcolor = "#ffffff";
            params.allowscriptaccess = "sameDomain";
            params.allowfullscreen = "true";
            var attributes = {};
            attributes.id = "richTextEditor";
            attributes.name = "richTextEditor";
            attributes.align = "middle";
            swfobject.embedSWF(
                "/static/richTextEditor/richTextEditor.swf", "flashContent",
                "100%", "100%", 
                swfVersionStr, xiSwfUrlStr, 
                flashvars, params, attributes);
			swfobject.createCSS("#flashContent", "display:block;text-align:left;");
			
			function setHtmlToEditor(){
				var str = '<?php echo $this->_tpl_vars['mailContent']; ?>
';
				return str;
			}
			
			function getHtmlFromEditor(strHtml){
				document.getElementById("mailContent").value = strHtml;
			}
        </script>
<!-- end 支持as3 的富文本编辑器 -->

</head>

<body>
<!-- ================== start autocomplete ==================== -->
<script language="javascript">
	$(document).ready(function(){
		$("#goods_type_id").focus(showItem).keyup(showItem);
		$(".addMoreGemsClass").live('focus', showGem).live('keyup', showGem);
		//$("input[id^='gems_type']").focus(showGem).keyup(showGem);
		var offsetItem = $("#goods_type_id").offset();
		var offsetGem = $(".addMoreGemsClass").offset();
		$(".autoMain").css("top",offsetItem.top+20).css("left",offsetItem.left);
		$(".gemsMain").css("top",offsetGem.top+20).css("left",offsetGem.left);
		$("#autoClose").click(function(){
			$(".autoMain").hide();
		});
		$("#gemsClose").click(function(){
			$(".gemsMain").hide();
		});
		$(".autoList>li").click(function(){
			$("#goods_type_id").val($.trim($(this).text()));
			$(".autoMain").hide();		
			strNhole = $(this).attr("title");
			arrSnH = strNhole.split("|");
			var maxStrLv = arrSnH[0];	//最大强化等级
			if(arrSnH[1]){
				var holes = arrSnH[1].split(",");
				hole1 = holes[0];
				hole2 = holes[1];
			} else {
				hole1 = hole2 = "";
			}
			arrSplit = doSplit();
			if (arrSplit[0].charAt(0) == 2){
				$("#strength").removeAttr('disabled');
				$("#strLv").val("(0- " + maxStrLv + " )");	//最大强化等级
				$("#quality").removeAttr('disabled');
				if(hole1) {
					$("#gems_type_id_1").val("");
					$("#gems_type_id_1").removeAttr('disabled');
				}
				if(hole2) {
					$("#gems_type_id_2").val("");
					$("#gems_type_id_2").removeAttr('disabled');
				}
//				$("#addMore").removeAttr('disabled');
				isWeapon = true;
			} else {
				isWeapon = false;
			}
			$("#type").val(arrSplit[0]);
		});
		
		$("#autoReSet").click(function(){
			doDisable()
			showItem();
		});

		$("#color option[value='4'], #color option[value='5']").click(function(){
			$("#hole option[value='5']").removeAttr('disabled');
			$("#hole option[value='6']").removeAttr('disabled');
		})
		
		$("color option[value='3'], option[value='2'], option[value='1'], option[value='0']").click(function(){
			$("#hole option[value='5']").attr('disabled','disabled');
			$("#hole option[value='6']").attr('disabled','disabled');
		})
	
		$("#hole option[value='5']").attr('disabled','disabled');
		$("#hole option[value='6']").attr('disabled','disabled');

		$("#selectedCompare").change(function(){
			if('0' == $(this).val()){
				$("#endLevel").hide();
			}else{
				$("#endLevel").show();
			}
			if('4' == $(this).val()){
				$("#startLevel").show();
			}else{
				$("#startLevel").hide();
			}
		});
		
		//新增定时发送道具
		$("#frm").hide();
		frmShow = 0;
		$("#add_record").click(function(){
			if( frmShow == 0 ){
				$("#frm").show();
				frmShow = 1;
			} else {
				$("#frm").hide();
				frmShow = 0;
			}
		});
		
	});
	
	function doSplit(){
		str = $("#goods_type_id").val();
		arrSplit = str.split("|");
		arrSplit[0] = arrSplit[0] ? $.trim(arrSplit[0]) : '';
		arrSplit[1] = arrSplit[1] ? $.trim(arrSplit[1]) : '';
		return arrSplit;
	}
	
	function gemsSplit(target){
		str = $(target).val();
		arrSplit = str.split("|");
		arrSplit[0] = arrSplit[0] ? $.trim(arrSplit[0]) : '';
		arrSplit[1] = arrSplit[1] ? $.trim(arrSplit[1]) : '';
		return arrSplit;
	}
	
	function showItem(){
		$(".autoMain").show();
		arrSplit = doSplit();
		keyWord = arrSplit[0];
		if(keyWord && '' != keyWord){
			$(".autoList>li").each(function(){
				liText = $(this).text();
				if(-1!=liText.indexOf(keyWord)){
					$(this).show();
				}else{
					$(this).hide();
				}
			});
		}else{
			$(".autoList>li").show();
		}
	}

	function showGem(e){
		console.log(e);
		var target = e.currentTarget;
		var hole = $(target).attr("name").split("_")[3];
		console.log("变量hole=",hole);
		console.log("变量hole1=",hole1);
		console.log("变量hole2=",hole2);
		$(".gemsMain").show();
		if(hole == 1) {
			if(hole1==1){
				$(".gemsList").hide();
				$("#gemsList1").show();
				$("#gemsList2").hide();
				$("#gemsList3").hide();
				$("#gemsList4").hide();
			} else if (hole1==3) {
				$(".gemsList").hide();
				$("#gemsList1").hide();
				$("#gemsList2").hide();
				$("#gemsList3").show();
				$("#gemsList4").hide();
			}
		} else if(hole == 2){
			if(hole2 == 2) {
				$(".gemsList").hide();
				$("#gemsList1").hide();
				$("#gemsList2").show();
				$("#gemsList3").hide();
				$("#gemsList4").hide();
			} else if(hole2 == 4) {
				$(".gemsList").hide();
				$("#gemsList1").hide();
				$("#gemsList2").hide();
				$("#gemsList3").hide();
				$("#gemsList4").show();
			}
		}
			
		$(".gemsList>li").unbind('click').bind('click', function(){
			$(target).val($.trim($(this).text()));
			$(".gemsMain").hide();		
			arrSplit = gemsSplit();
			//$("#type").val(arrSplit[0]);
		});
		arrSplit = gemsSplit(target);
		keyWord = arrSplit[0];
		if(keyWord && '' != keyWord){
			$(".gemsList>li").each(function(){
				liText = $(this).text();
				if(-1!=liText.indexOf(keyWord)){
					$(this).show();
				}else{
					$(this).hide();
				}
			});
		}else{
			$(".gemsList>li").show();
		}
	}

	function doDisable(){
		$("#goods_type_id").val("");
		$("#strength").attr('disabled','disabled');
		$("#quality").attr('disabled','disabled');
		$("#color").attr('disabled','disabled');
		$("#hole").attr('disabled','disabled');
		$(".addMoreGemsClass").attr('disabled','disabled');
//		$("#addMore").attr('disabled','disabled');
	}

	function addMoreGems(){
		var tmp = $(".addMoreGemsClass:last").attr('id');
		var num = parseInt(tmp.substr(tmp.length-1,1));
		num = num + 1;
		$("#addMoreGems").append("<input type=\"text\" id=\"gems_type_id_"+num+"\" class=\"addMoreGemsClass\" \>");
	}
</script>

<div class="autoMain">
	<div align="right" class="autoClose"><a id="autoReSet" href="javascript:void(0);"><?php echo $this->_tpl_vars['lang']->verify->clearChooseAgain; ?>
</a>&nbsp;&nbsp;<a id="autoClose" href="javascript:void(0);"><?php echo $this->_tpl_vars['lang']->verify->close; ?>
</a></div>
	<ul class="autoList">
		<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['item']['quality'] == 1): ?>
        <li style="background-color:#61FEBF" title="<?php echo $this->_tpl_vars['item']['maxStrengthenLv']; ?>
|<?php echo $this->_tpl_vars['item']['gemHole']; ?>
">
        <?php elseif ($this->_tpl_vars['item']['quality'] == 2): ?>
        <li style="background-color:#72BFFE" title="<?php echo $this->_tpl_vars['item']['maxStrengthenLv']; ?>
|<?php echo $this->_tpl_vars['item']['gemHole']; ?>
">
        <?php elseif ($this->_tpl_vars['item']['quality'] == 3): ?>
        <li style="background-color:#DCC5FC" title="<?php echo $this->_tpl_vars['item']['maxStrengthenLv']; ?>
|<?php echo $this->_tpl_vars['item']['gemHole']; ?>
">
        <?php elseif ($this->_tpl_vars['item']['quality'] == 4): ?>
        <li style="background-color:#FFE0B3" title="<?php echo $this->_tpl_vars['item']['maxStrengthenLv']; ?>
|<?php echo $this->_tpl_vars['item']['gemHole']; ?>
">
        <?php else: ?>
        <li title="<?php echo $this->_tpl_vars['item']['maxStrengthenLv']; ?>
|<?php echo $this->_tpl_vars['item']['gemHole']; ?>
">
        <?php endif; ?>
        <?php echo $this->_tpl_vars['key']; ?>
 | <?php echo $this->_tpl_vars['item']['name']; ?>
</li>
		<?php endforeach; endif; unset($_from); ?>
	</ul>
</div>

<!-- 宝石列表 START -->
<div class="gemsMain">
	<div align="right" class="gemsClose"><a id="gemsClose" href="javascript:void(0);"><?php echo $this->_tpl_vars['lang']->verify->close; ?>
</a></div>
	<ul class="gemsList">
		<?php $_from = $this->_tpl_vars['gems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['gem']):
?>
        <?php if ($this->_tpl_vars['gem']['quality'] == 1): ?>
        <li style="background-color:#61FEBF">
        <?php elseif ($this->_tpl_vars['gem']['quality'] == 2): ?>
        <li style="background-color:#72BFFE">
        <?php elseif ($this->_tpl_vars['gem']['quality'] == 3): ?>
        <li style="background-color:#DCC5FC">
        <?php elseif ($this->_tpl_vars['gem']['quality'] == 4): ?>
        <li style="background-color:#FFE0B3">
        <?php else: ?>
        <li>
        <?php endif; ?>
        <?php echo $this->_tpl_vars['key']; ?>
 | <?php echo $this->_tpl_vars['gem']['name']; ?>
</li>
		<?php endforeach; endif; unset($_from); ?>
	</ul>
<!--	-->
	<ul class="gemsList" id="gemsList1">
	<?php $_from = $this->_tpl_vars['gems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['gem']):
?>
	<?php if ($this->_tpl_vars['gem']['holeType'] == 1): ?>
        <li><?php echo $this->_tpl_vars['key']; ?>
 | <?php echo $this->_tpl_vars['gem']['name']; ?>
</li>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
	<ul class="gemsList" id="gemsList2">
	<?php $_from = $this->_tpl_vars['gems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['gem']):
?>
	<?php if ($this->_tpl_vars['gem']['holeType'] == 2): ?>
        <li><?php echo $this->_tpl_vars['key']; ?>
 | <?php echo $this->_tpl_vars['gem']['name']; ?>
</li>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
	<ul class="gemsList" id="gemsList3">
	<?php $_from = $this->_tpl_vars['gems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['gem']):
?>
	<?php if ($this->_tpl_vars['gem']['holeType'] == 3): ?>
        <li><?php echo $this->_tpl_vars['key']; ?>
 | <?php echo $this->_tpl_vars['gem']['name']; ?>
</li>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
	<ul class="gemsList" id="gemsList4">
	<?php $_from = $this->_tpl_vars['gems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['gem']):
?>
	<?php if ($this->_tpl_vars['gem']['holeType'] == 4): ?>
        <li><?php echo $this->_tpl_vars['key']; ?>
 | <?php echo $this->_tpl_vars['gem']['name']; ?>
</li>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
</div>
<!-- 宝石列表 END -->
 
<!-- ================== end autocomplete ==================== -->

<div id="position"><?php echo $this->_tpl_vars['lang']->menu->regularSendItem; ?>
</div> 

<br />
<?php if ($this->_tpl_vars['msg']): ?>
<div class="red"><?php echo $this->_tpl_vars['msg']; ?>
</div>
<?php endif; ?>
<form action="" id="record_list" method="post">
	定时发放道具列表：
	<table class="DataGrid">
		<?php if ($this->_tpl_vars['recordList']): ?>
		<tr>
			<th style="width:3%">ID</th>
			<th style="width:5%">操作人</th>
			<th style="width:8%">操作时间1</th>
			<th style="width:10%">道具发放时间</th>
			<th style="width:10%">原因</th>
			<th style="width:15%">赠送列表</th>
			<th style="width:15%">道具列表</th>
			<th style="width:15%">信件标题</th>
			<th style="width:10%">信件内容</th>
			<th style="width:5%">状态</th>
			<th style="width:5%">操作</th>
		</tr>
			<?php $_from = $this->_tpl_vars['recordList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['record'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['record']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['list']):
        $this->_foreach['record']['iteration']++;
?>
		<tr align="center">
			<td><?php echo $this->_tpl_vars['list']['id']; ?>
</td>
			<td><?php echo $this->_tpl_vars['list']['add_person']; ?>
</td>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['list']['add_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')); ?>
</td>
			<td>从 <?php echo ((is_array($_tmp=$this->_tpl_vars['list']['begin_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')); ?>
<br/>到 <?php echo ((is_array($_tmp=$this->_tpl_vars['list']['end_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')); ?>
<br/>每天 <?php echo $this->_tpl_vars['list']['send_time']; ?>
 发送</td>
			<td><?php echo $this->_tpl_vars['list']['reason']; ?>
</td>
			<td><?php echo $this->_tpl_vars['list']['roleNameList']; ?>
</td>
			<td><?php echo $this->_tpl_vars['list']['item']; ?>
</td>
			<td><?php echo $this->_tpl_vars['list']['mailTitle']; ?>
</td>
			<td><?php echo $this->_tpl_vars['list']['mailContent']; ?>
</td>
			<td><?php echo $this->_tpl_vars['dictStatus'][$this->_tpl_vars['list']['status']]; ?>
</td>
			<td>
	        	<a class="yes" href="?action=yes&id=<?php echo $this->_tpl_vars['list']['id']; ?>
&endTime=<?php echo $this->_tpl_vars['list']['end_time']; ?>
&verifyResult=<?php echo $this->_tpl_vars['dictStatus'][$this->_tpl_vars['list']['status']]; ?>
" onClick="return confirm('<?php echo $this->_tpl_vars['lang']->apply->sureToStart; ?>
')"><?php echo $this->_tpl_vars['lang']->apply->start; ?>
</a>
	        	<a class="no" href="?action=no&id=<?php echo $this->_tpl_vars['list']['id']; ?>
&endTime=<?php echo $this->_tpl_vars['list']['end_time']; ?>
&verifyResult=<?php echo $this->_tpl_vars['dictStatus'][$this->_tpl_vars['list']['status']]; ?>
" onClick="return confirm('<?php echo $this->_tpl_vars['lang']->apply->sureToStop; ?>
')"><?php echo $this->_tpl_vars['lang']->apply->stop; ?>
</a>
			</td>
		</tr>
			<?php endforeach; endif; unset($_from); ?>
		
		<?php else: ?>
		<tr><td><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</td></tr>
		<?php endif; ?>
	</table>
</form>

<br />
<!-- 
<input type="button" id="add_record" name="add_record" value="添加" style="display:none;"/>
 -->
<input type="button" id="add_record" name="add_record" value="添加" />

<br />

<form action="<?php echo $this->_tpl_vars['URL_SELF']; ?>
?action=send" id="frm" method="post" >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="800">
		<tr>
			<td height="30" colspan="2" background="/static/images/wbg.gif"><b><?php echo $this->_tpl_vars['lang']->page->sendDes; ?>
</b>：</td>
		</tr>
		
		<tr>
			<td>
			<?php echo $this->_tpl_vars['lang']->page->beginTime; ?>
:<input id='startdate' name='startdate' type="text" class="Wdate" onfocus="WdatePicker({el:'startdate',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'<?php echo $this->_tpl_vars['minDate']; ?>
',maxDate:'#F{$dp.$D(\'enddate\')}'})" size='24' value='<?php echo $this->_tpl_vars['startDate']; ?>
' /> 
			</td>
			<td>
			<?php echo $this->_tpl_vars['lang']->page->endTime; ?>
:<input id='enddate' name='enddate' type="text" class="Wdate" onfocus="WdatePicker({el:'enddate',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'startdate\')}',maxDate:'<?php echo $this->_tpl_vars['maxDate']; ?>
'})" size='24' value='<?php echo $this->_tpl_vars['endDate']; ?>
' /> 
			</td>
		</tr>
		<tr>
			<td colspan="2">发送时间：<input id='sendTime' name='sendTime' type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'HH:mm:ss'})" size='12' value='<?php echo $this->_tpl_vars['sendTime']; ?>
' /></td>
		</tr>
		<tr>
			<td>
				<input type="radio" id="byRoleName" name="sendType" value="0" checked="checked"/><?php echo $this->_tpl_vars['lang']->apply->byRoleName; ?>

			</td>
			<td>
				<input type="radio" id="byCondition" name="sendType" value="1" /><?php echo $this->_tpl_vars['lang']->apply->byCondition; ?>

			</td>
		</tr>
		<tr>
			<td rowspan="6">
				<textarea style="height:200px;" name="role_name_list" id="role_name_list" cols="30"><?php echo $this->_tpl_vars['role_name_list']; ?>
</textarea>
			</td>
			<td>
				<input type="checkbox" name="online" value="1"/> <?php echo $this->_tpl_vars['lang']->apply->onlineOnly; ?>

			</td>
		</tr>
			<td><?php echo $this->_tpl_vars['lang']->sys->playerLevel; ?>
：<input type="text" id="startLevel" name="startLevel" size="5" style="display:none"></input>
				<select name="selectedCompare" id="selectedCompare">
					<option value="0"><?php echo $this->_tpl_vars['lang']->page->unlimited; ?>
</option>
					<option value="1"><?php echo $this->_tpl_vars['lang']->page->level; ?>
 ≥ x</option>
					<option value="2"><?php echo $this->_tpl_vars['lang']->page->level; ?>
 ＝ x</option>
					<option value="3"><?php echo $this->_tpl_vars['lang']->page->level; ?>
 ≤ x</option>
					<option value="4">y ≤ <?php echo $this->_tpl_vars['lang']->page->level; ?>
 ≤ x</option>
				</select>
				<input type="text" id="endLevel" name="endLevel" size="5" style="display:none"></input>
			</td>
		</tr>
		<tr><td><?php echo $this->_tpl_vars['lang']->apply->fromLastLoginPrefix; ?>
：<input type="text" id="timeFromLastLogin" name="timeFromLastLogin" size="5"></input><?php echo $this->_tpl_vars['lang']->apply->fromLastLoginSuffix; ?>
</td></tr>
		<tr>
			<td>
				<?php echo $this->_tpl_vars['lang']->page->sex; ?>
：<select name="sex" id="sex">
					<option value="0"><?php echo $this->_tpl_vars['lang']->page->unlimited; ?>
</option>
					<option value="1"><?php echo $this->_tpl_vars['lang']->player->male; ?>
</option>
					<option value="2"><?php echo $this->_tpl_vars['lang']->player->female; ?>
</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']->occupation->occupation; ?>
：<select name="job" id="job">
					<option value="0"><?php echo $this->_tpl_vars['lang']->page->unlimited; ?>
</option>
					<option value="1"><?php echo $this->_tpl_vars['lang']->occupation->wuzun; ?>
</option>
					<option value="2"><?php echo $this->_tpl_vars['lang']->occupation->lingxiu; ?>
</option>
					<option value="3"><?php echo $this->_tpl_vars['lang']->occupation->jianxian; ?>
</option>
				</select>
			</td>
		</tr>
		<tr><td><?php echo $this->_tpl_vars['lang']->apply->family; ?>
：<input type="text" name="family" id="family"></input></td></tr>
	<!--	
		<tr><td><?php echo $this->_tpl_vars['lang']->menu->onlineUser; ?>
:<input type="checkbox" name="onlinePlayer" id="onlinePlayer" value="1"></input></td></tr>
	-->
		<!--
		<?php if ($this->_tpl_vars['strMsg']): ?>
		<tr>
			<td colspan="2"><span style="color:red;"><?php echo $this->_tpl_vars['strMsg']; ?>
</span></td>
		</tr>
		<?php endif; ?>
		-->
		<tr>
			<td colspan="2"><b><?php echo $this->_tpl_vars['lang']->page->applyReason; ?>
：</b>
			<br />
			<textarea style="width: 700px; height: 50px;" rows="3" cols="80" id="reason" name="reason"></textarea>
	        </td>
		</tr>
        
		<tr>
		
			<td width="35%">
				
				<table cellspacing="1" cellpadding="5" class="SumDataGrid">
					<tr>
						<th colspan="2"><?php echo $this->_tpl_vars['lang']->page->applyItems; ?>
</th>
					</tr>
					<tr>
						<td align="right"><?php echo $this->_tpl_vars['lang']->page->itemsType; ?>
：</td>
						<td>
							<input type="text" name="goods_type_id" id="goods_type_id" value="">                            
						</td>
					</tr>
					<tr>
						<td align="right"><?php echo $this->_tpl_vars['lang']->page->sendNum; ?>
：</td>
						<td><input type="text" name="item_num" id="item_num" value="1"></td>
					</tr>
					<tr>
						<td align="right"><?php echo $this->_tpl_vars['lang']->page->isBind; ?>
：</td>
						<td>
                        <input type="radio" name="bind" id="bind" value="yes" checked="1"/><?php echo $this->_tpl_vars['lang']->page->bind; ?>

                        <input type="radio" name="bind" id="bind" value="no" /><?php echo $this->_tpl_vars['lang']->page->unbind; ?>

                        </td>
					</tr>
					<tr>
						<td align="right"><?php echo $this->_tpl_vars['lang']->page->strLevel; ?>
：</td>
						<td>
							<input name="strength" id="strength" type="text" style="width:80px;" disabled='disabled' />
							<input id="strLv" type="text" style="background-color:#E9E9F9;color:#0088FF" size="8" readonly="readonly" value="(0- 100 )"/>
						</td>
					</tr>
					
					<tr>
						<td align="right"><?php echo $this->_tpl_vars['lang']->item->quality; ?>
：</td>
						<td>
							<select name="quality" id="quality" style="width:100px;" disabled='disabled'>
								<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['dictQuality']), $this);?>

							</select>
						</td>
					</tr>
					
					<tr>
						<td align="right">
							<?php echo $this->_tpl_vars['lang']->item->gem; ?>
：
						</td>
						<td id="addMoreGems">
							<?php echo $this->_tpl_vars['lang']->item->hole1; ?>
: <input type="text" name="gems_type_id_1" id="gems_type_id_1" class="addMoreGemsClass" value="" disabled='disabled'>
							<br />
							<?php echo $this->_tpl_vars['lang']->item->hole2; ?>
: <input type="text" name="gems_type_id_2" id="gems_type_id_2" class="addMoreGemsClass" value="" disabled='disabled'>
						</td>
					</tr>
					
					<tr>
						<td colspan="2" align="middle">
                            <input type="button" id="add_item" name="add_item" value="<?php echo $this->_tpl_vars['lang']->page->addItems; ?>
" />
						</td>
					</tr>
				</table>
                <?php echo $this->_tpl_vars['lang']->page->remaskSearch; ?>

			</td>
			
			<td width="75%">
            <b><?php echo $this->_tpl_vars['lang']->page->mailTitle; ?>
：<input type="text" name="mailTitle" id="mailTitle" maxlength="30" style="width:400px;" /></b><br />
			<b><?php echo $this->_tpl_vars['lang']->page->mailCon; ?>
：</b>
			<br />
			<!-- start 支持as3 的富文本编辑器	-->
			<div id="richTextEditorDiv" style="width:497px; height:335px;">
        	<!-- start 若版本不支持 打印提示	-->
	        <div id="flashContent">
	        	<p>
		        	To view this page ensure that Adobe Flash Player version 
					10.0.0 or greater is installed. 
				</p>
				<script type="text/javascript"> 
					var pageHost = ((document.location.protocol == "https:") ? "https://" :	"http://"); 
					document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='"+ pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
				</script> 
			</div>
			<!-- end  若版本不支持 打印提示	-->
	   	 
	       	<noscript>
	            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="richTextEditor">
	                <param name="movie" value="richTextEditor.swf" />
	                <param name="quality" value="high" />
	                <param name="bgcolor" value="#ffffff" />
	                <param name="allowScriptAccess" value="sameDomain" />
	                <param name="allowFullScreen" value="true" />
	                <!--[if !IE]>-->
	                <object type="application/x-shockwave-flash" data="/static/richTextEditor/richTextEditor.swf" width="100%" height="100%">
	                    <param name="quality" value="high" />
	                    <param name="bgcolor" value="#ffffff" />
	                    <param name="allowScriptAccess" value="sameDomain" />
	                    <param name="allowFullScreen" value="true" />
	                <!--<![endif]-->
	                <!--[if gte IE 6]>-->
	                	<p> 
	                		Either scripts and active content are not permitted to run or Adobe Flash Player version
	                		10.0.0 or greater is not installed.
	                	</p>
	                <!--<![endif]-->
	                    <a href="http://www.adobe.com/go/getflashplayer">
	                        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" />
	                    </a>
	                <!--[if !IE]>-->
	                </object>
	                <!--<![endif]-->
	            </object>
		    </noscript>	
			</div>
			<!-- end 支持as3 的富文本编辑器	-->
			
			<textarea style="display:none;" rows="17" cols="50" id="mailContent" name="mailContent"></textarea>
			<!-- <textarea style="float:right; width: 500px; height: 200px;" rows="17" cols="50" id="content" name="content"></textarea> -->
			
			</td>
		</tr>
        <tr>
            <td colspan="2">
            <b><?php echo $this->_tpl_vars['lang']->page->itemsList; ?>
</b>&nbsp;(<?php echo $this->_tpl_vars['lang']->page->itemLimit; ?>
)
            <table id="add_item_table" cellspacing="1" cellpadding="5" class="SumDataGrid" style="width:100%">
                <tr>
                    <th><?php echo $this->_tpl_vars['lang']->page->itemsName; ?>
</th><th><?php echo $this->_tpl_vars['lang']->page->itemsNum; ?>
</th><th><?php echo $this->_tpl_vars['lang']->page->isBind; ?>
</th><th><?php echo $this->_tpl_vars['lang']->page->strLevel; ?>
</th><th><?php echo $this->_tpl_vars['lang']->item->quality; ?>
</th><th><?php echo $this->_tpl_vars['lang']->item->gem; ?>
</th><th><?php echo $this->_tpl_vars['lang']->page->deal; ?>
</th>
                </tr>
            </table>
            </td>
        </tr>
		<tr>
			<td colspan="2"><input type="submit" style="width:100px;height:50px;" id="btnSubmit" name="btnSubmit" value="<?php echo $this->_tpl_vars['lang']->page->apply; ?>
" /></td>
		</tr>
	</table>
</form>

</body>
</html>