<?php /* Smarty version 2.6.25, created on 2014-04-17 16:36:08
         compiled from module/item/item_consume_statistics.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/item/item_consume_statistics.tpl', 68, false),array('function', 'math', 'module/item/item_consume_statistics.tpl', 79, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<?php echo $this->_tpl_vars['lang']->menu->itemConsumeStatistics; ?>

</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
</head>

<body>
<div id="position">
<b><?php echo $this->_tpl_vars['lang']->menu->class->itemData; ?>
：<?php echo $this->_tpl_vars['lang']->menu->itemConsumeStatistics; ?>
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
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>

<form id="myform2" name="myform2" method="post" action="<?php echo $this->_tpl_vars['current_uri']; ?>
" style="display: inline;">
	<input type="submit" class="button" name="dateToday" value="<?php echo $this->_tpl_vars['lang']->page->today; ?>
" >&nbsp;&nbsp;
	<input type="submit" <?php if ($this->_tpl_vars['selectedDay'] && $this->_tpl_vars['selectedDay'] <= $this->_tpl_vars['minDate']): ?> disabled="disabled" <?php endif; ?> class="button" name="datePrev" value="<?php echo $this->_tpl_vars['lang']->page->prevTime; ?>
">&nbsp;&nbsp;
	<input type="submit" <?php if ($this->_tpl_vars['selectedDay'] && $this->_tpl_vars['selectedDay'] >= $this->_tpl_vars['maxDate']): ?> disabled="disabled" <?php endif; ?> class="button" name="dateNext" value="<?php echo $this->_tpl_vars['lang']->page->nextTime; ?>
">&nbsp;&nbsp;
	<input type="submit" class="button" name="dateAll" value="<?php echo $this->_tpl_vars['lang']->page->fromOnlineDate; ?>
" >
	<input type="hidden" class="button" name="selectedDay" value="<?php echo $this->_tpl_vars['selectedDay']; ?>
" >
</form>
</div>
<br />
<?php if ($this->_tpl_vars['viewData']): ?>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
	<caption class="table_list_head">
        <?php echo $this->_tpl_vars['lang']->menu->itemConsumeStatistics; ?>
 <?php echo $this->_tpl_vars['startDay']; ?>
 - <?php echo $this->_tpl_vars['endDay']; ?>
 
	</caption>
	<tr class='table_list_head'>
		<th align="center"><?php echo $this->_tpl_vars['lang']->item->itemID; ?>
</th>
		<th align="center"><?php echo $this->_tpl_vars['lang']->item->itemName; ?>
</th>
		<th align="center"><?php echo $this->_tpl_vars['lang']->item->consumeCount; ?>
</th>
		<th align="center"><?php echo $this->_tpl_vars['lang']->item->currentRank; ?>
</th>
		<th align="center"><?php echo $this->_tpl_vars['lang']->item->rankChange; ?>
</th>
	</tr>
	<?php $_from = $this->_tpl_vars['viewData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['rank'] => $this->_tpl_vars['item']):
        $this->_foreach['loop']['iteration']++;
?>
	<tr class='<?php echo smarty_function_cycle(array('values' => "trEven,trOdd"), $this);?>
'>
		<td align="center"><?php echo $this->_tpl_vars['item']['item_id']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['arrItemsAll'][$this->_tpl_vars['item']['item_id']]['name']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['item']['consume_count']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['rank']+1; ?>
</td>
		<td align="center">
			<?php if ($this->_tpl_vars['item']['rank_change'] == 0): ?>
				&nbsp;
			<?php elseif ($this->_tpl_vars['item']['rank_change'] > 0): ?>
				<font color="red">↑<?php echo $this->_tpl_vars['item']['rank_change']; ?>
</font>
			<?php else: ?>
				<font color="green">↓<?php echo smarty_function_math(array('equation' => "0-x",'x' => $this->_tpl_vars['item']['rank_change']), $this);?>
</font>
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>
<?php else: ?>
<font color='red'><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</font>
<?php endif; ?>
</div>

</body>
</html>