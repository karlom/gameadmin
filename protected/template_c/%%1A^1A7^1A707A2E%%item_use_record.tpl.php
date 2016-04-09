<?php /* Smarty version 2.6.25, created on 2014-04-17 16:36:21
         compiled from module/item/item_use_record.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'json_encode', 'module/item/item_use_record.tpl', 20, false),array('modifier', 'date_format', 'module/item/item_use_record.tpl', 86, false),array('function', 'html_options', 'module/item/item_use_record.tpl', 63, false),array('function', 'cycle', 'module/item/item_use_record.tpl', 85, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<?php echo $this->_tpl_vars['lang']->menu->itemUseRecord; ?>

</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$.autolist({
		bind: 'item_id_widget',
		options: <?php echo json_encode($this->_tpl_vars['itemList']); ?>
,
		onItemClick: function(key, item){
			$('#item_id_widget').val(item.text());
//			$('#item_id').val(key);
		},
/*		onReset: function(){
			$('#item_id').val('');
		}*/
	});
})
</script>
</head>

<body>
<div id="position">
<b><?php echo $this->_tpl_vars['lang']->menu->class->itemData; ?>
：<?php echo $this->_tpl_vars['lang']->menu->itemUserRecord; ?>
</b>
</div> 

<!-- Start 成功信息提示 -->
<?php if ($this->_tpl_vars['successMsg']): ?>
<div class="success_msg_box">
	<?php echo $this->_tpl_vars['successMsg']; ?>

</div>
<?php endif; ?>
<!-- End 成功信息提示 -->

<!-- Start 错误信息提示 -->
<?php if ($this->_tpl_vars['errorMsg']): ?>
<div class="error_msg_box">
	<?php echo $this->_tpl_vars['errorMsg']; ?>

</div>
<?php endif; ?>
<!-- End 错误信息提示 -->

<div class='divOperation'>
	<form id="myform" name="myform" method="get" action="" style="display: inline;">
		<?php echo $this->_tpl_vars['lang']->page->beginTime; ?>
：<input type="text" size="13" class="Wdate" name="start_day" id="start_day" onfocus="WdatePicker({el:'start_day',dateFmt:'yyyy-MM-dd',minDate:'<?php echo $this->_tpl_vars['minDate']; ?>
',maxDate:'#F{$dp.$D(\'end_day\')}'})" value="<?php echo $this->_tpl_vars['startDay']; ?>
">
		<?php echo $this->_tpl_vars['lang']->page->endTime; ?>
：<input type="text" size="13" class="Wdate" name="end_day" id="end_day" onfocus="WdatePicker({el:'end_day',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'start_day\')}',maxDate:'<?php echo $this->_tpl_vars['maxDate']; ?>
'})"  value="<?php echo $this->_tpl_vars['endDay']; ?>
">
		&nbsp;<?php echo $this->_tpl_vars['lang']->player->roleName; ?>
:<input type="text" id="role_name" name="role_name" size="15" value="<?php echo $this->_tpl_vars['roleName']; ?>
" />
		&nbsp;<?php echo $this->_tpl_vars['lang']->player->accountName; ?>
:<input type="text" id="account_name" name="account_name" size="15" value="<?php echo $this->_tpl_vars['accountName']; ?>
" />
		
		<?php echo $this->_tpl_vars['lang']->item->itemName; ?>
:<input id='item_id_widget' name='item_id_widget' type="text" size='30' value='<?php if ($this->_tpl_vars['itemID'] > 0): ?><?php echo $this->_tpl_vars['itemID']; ?>
 | <?php echo $this->_tpl_vars['itemList'][$this->_tpl_vars['itemID']]; ?>
<?php endif; ?>' /> 
		<!--input id='item_id' name='item_id' type="hidden" size='12' value='<?php echo $this->_tpl_vars['itemID']; ?>
' /--> 
		<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sortArray'],'selected' => $this->_tpl_vars['selectedSortLine'],'name' => 'sortby'), $this);?>

		<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
		&nbsp;&nbsp;
	</form>
</div>
<br />
<?php if ($this->_tpl_vars['viewData']['data']): ?>
<?php ob_start();
$_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'file:pager.tpl', 'smarty_include_vars' => array('pages' => $this->_tpl_vars['pager'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
$this->assign('pager_html', ob_get_contents()); ob_end_clean();
 ?>
<?php echo $this->_tpl_vars['pager_html']; ?>

<table cellspacing="1" cellpadding="3" border="0" class='table_list' >

<tr class='table_list_head'>
		<th align="center" width="10%"><?php echo $this->_tpl_vars['lang']->item->datetime; ?>
</th>
		<th align="center" width="10%"><?php echo $this->_tpl_vars['lang']->item->roleName; ?>
</th>
		<th align="center" width="5%"><?php echo $this->_tpl_vars['lang']->item->roleLevel; ?>
</th>
		<th align="center" width="15%"><?php echo $this->_tpl_vars['lang']->item->itemName; ?>
</th>
		<th align="center" width="5%"><?php echo $this->_tpl_vars['lang']->item->bind; ?>
</th>
		<th align="center" width="5%"><?php echo $this->_tpl_vars['lang']->item->itemCount; ?>
</th>
		<th align="center" width="30%"><?php echo $this->_tpl_vars['lang']->item->detail; ?>
</th>
		<th align="center" width="15%"><?php echo $this->_tpl_vars['lang']->item->type; ?>
</th>
	</tr>
	<?php $_from = $this->_tpl_vars['viewData']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['loop']['iteration']++;
?>
	<tr class='<?php echo smarty_function_cycle(array('values' => "trEven,trOdd"), $this);?>
'>
		<td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['mtime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')); ?>
</td>
		<td align="center" class="cmenu" title="<?php echo $this->_tpl_vars['item']['role_name']; ?>
"><?php echo $this->_tpl_vars['item']['role_name']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['item']['level']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['item']['item_id']; ?>
 | <?php echo $this->_tpl_vars['itemList'][$this->_tpl_vars['item']['item_id']]; ?>
</td>
		<td align="center"><?php if ($this->_tpl_vars['item']['isbind'] == 1): ?><?php echo $this->_tpl_vars['lang']->item->yes; ?>
<?php else: ?><?php echo $this->_tpl_vars['lang']->item->no; ?>
<?php endif; ?></td>
		<td align="center"><?php echo $this->_tpl_vars['item']['item_num']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['item']['detail']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['dictItemUsageType'][$this->_tpl_vars['item']['type']]; ?>
</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>
<br />
<?php echo $this->_tpl_vars['pager_html']; ?>

<?php else: ?>
<font color='red'><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</font>
<?php endif; ?>
</div>

</body>
</html>