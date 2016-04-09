<?php /* Smarty version 2.6.25, created on 2014-04-17 15:42:26
         compiled from module/pay/qb_buy_goods.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/pay/qb_buy_goods.tpl', 91, false),array('modifier', 'date_format', 'module/pay/qb_buy_goods.tpl', 102, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
		<?php echo $this->_tpl_vars['lang']->menu->qdBuyGoods; ?>

	</title>
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/ip.js"></script>
	<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
	<script type="text/javascript" src="/static/js/global.js"></script>
	<script type="text/javascript" >
		function changePage(page){
			$("#page").val(page);
			$("#myform").submit();
		}
		$(document).ready(function(){
			$("#account_name").keydown(function(){
				$("#role_name").val('');
		
			});
			$("#role_name").keydown(function(){
				$("#account_name").val('');
		
			});
	
		});
		
	</script>
</head>

<body>
	
	<div id="position">
	<b><?php echo $this->_tpl_vars['lang']->menu->class->payAndSpand; ?>
：<?php echo $this->_tpl_vars['lang']->menu->qdBuyGoods; ?>
</b>
	</div>

	<form id="myform" name="myform" method="post" action="">
	<div class='divOperation'>
	<?php echo $this->_tpl_vars['lang']->page->beginTime; ?>
:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<?php echo $this->_tpl_vars['minDate']; ?>
',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<?php echo $this->_tpl_vars['dateStart']; ?>
' /> 
		<?php echo $this->_tpl_vars['lang']->page->endTime; ?>
:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<?php echo $this->_tpl_vars['maxDate']; ?>
'})" size='12' value='<?php echo $this->_tpl_vars['dateEnd']; ?>
' /> 
	
	&nbsp;<?php echo $this->_tpl_vars['lang']->player->roleName; ?>
:<input type="text" id="role_name" name="role_name" size="10" value="<?php echo $this->_tpl_vars['role_name']; ?>
" />
	&nbsp;<?php echo $this->_tpl_vars['lang']->player->accountName; ?>
:<input type="text" id="account_name" name="account_name" size="10" value="<?php echo $this->_tpl_vars['account_name']; ?>
" />
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
	
	</div>
	<br />
	<?php if ($this->_tpl_vars['viewData']): ?>
	
	<div><?php echo $this->_tpl_vars['lang']->pay->dateData; ?>
：<?php echo $this->_tpl_vars['lang']->pay->useQd; ?>
:<font color="red"><?php echo $this->_tpl_vars['date_data']['date_total']; ?>
</font>, <?php echo $this->_tpl_vars['lang']->pay->useGameCoin; ?>
:<font color="red"><?php echo $this->_tpl_vars['date_data']['game_coin']; ?>
</font>, <?php echo $this->_tpl_vars['lang']->pay->usePubacct; ?>
:<font color="red"><?php echo $this->_tpl_vars['date_data']['pubacct']; ?>
</font>, <?php echo $this->_tpl_vars['lang']->pay->useQbqd; ?>
:<font color="red"><?php echo $this->_tpl_vars['date_data']['qbqd']; ?>
</font></div>
	<br />
	<div><?php echo $this->_tpl_vars['lang']->pay->allData; ?>
：<?php echo $this->_tpl_vars['lang']->pay->useQd; ?>
:<font color="red"><?php echo $this->_tpl_vars['all_data']['all_total']; ?>
</font>, <?php echo $this->_tpl_vars['lang']->pay->useGameCoin; ?>
:<font color="red"><?php echo $this->_tpl_vars['all_data']['game_coin']; ?>
</font>, <?php echo $this->_tpl_vars['lang']->pay->usePubacct; ?>
:<font color="red"><?php echo $this->_tpl_vars['all_data']['pubacct']; ?>
</font>, <?php echo $this->_tpl_vars['lang']->pay->useQbqd; ?>
:<font color="red"><?php echo $this->_tpl_vars['all_data']['qbqd']; ?>
</font></div>
	<div> <?php echo $this->_tpl_vars['lang']->pay->payRoleCount; ?>
: <font color="red"><?php echo $this->_tpl_vars['payRoleCount']; ?>
</font> </div>
	
	<br />
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
	  <tr>
	    <td height="30" class="even">
	 <?php $_from = $this->_tpl_vars['pagelist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	 <a id="pageUrl" href="javascript:void(0);" onclick="changePage('<?php echo $this->_tpl_vars['item']; ?>
');"><?php echo $this->_tpl_vars['key']; ?>
</a><span style="width:5px;"></span>
	 <?php endforeach; endif; unset($_from); ?>
	<?php echo $this->_tpl_vars['lang']->page->record; ?>
(<?php echo $this->_tpl_vars['counts']; ?>
)&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['lang']->page->totalPage; ?>
(<?php echo $this->_tpl_vars['pageCount']; ?>
)
	<?php echo $this->_tpl_vars['lang']->page->everyPage; ?>
<input type="text" id="record" name="record" size="4" style="text-align:center;" value="<?php echo $this->_tpl_vars['record']; ?>
"><?php echo $this->_tpl_vars['lang']->page->row; ?>

	  <?php echo $this->_tpl_vars['lang']->page->dang; ?>
<input id="page" name="page" type="text" class="text" size="3" maxlength="6" style="text-align:center;" value="<?php echo $this->_tpl_vars['pageno']; ?>
" ><?php echo $this->_tpl_vars['lang']->page->page; ?>
&nbsp;<input id="btnGo" type="submit" class="button" name="Submit" value="GO">
	    </td>
	  </tr>
	</table>
	
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
		<tr align="center" class='table_list_head'>
	        <td width="10%"><?php echo $this->_tpl_vars['lang']->player->roleName; ?>
</td>
	        <td width="20%"><?php echo $this->_tpl_vars['lang']->player->accountName; ?>
</td>
	        <td width="5%"><?php echo $this->_tpl_vars['lang']->player->level; ?>
</td>
	        <td width="8%"><?php echo $this->_tpl_vars['lang']->item->itemID; ?>
</td>
	        <td width="8%"><?php echo $this->_tpl_vars['lang']->item->itemName; ?>
</td>
	        <td width="5%"><?php echo $this->_tpl_vars['lang']->item->itemCount; ?>
</td>
	        <td width="5%"><?php echo $this->_tpl_vars['lang']->pay->price; ?>
</td>
	        <td width="5%"><?php echo $this->_tpl_vars['lang']->pay->total; ?>
</td>
	        <td width="5%"><?php echo $this->_tpl_vars['lang']->pay->pubacct; ?>
</td>
	        <td width="8%"><?php echo $this->_tpl_vars['lang']->pay->qbqd; ?>
</td>
	        <td width="15%"><?php echo $this->_tpl_vars['lang']->pay->buyTime; ?>
</td>
	        <td width="20%"><?php echo $this->_tpl_vars['lang']->pay->billno; ?>
</td>
		</tr>
		
	<?php $_from = $this->_tpl_vars['viewData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['loop']['iteration']++;
?>
		<tr align="center" class='<?php echo smarty_function_cycle(array('values' => "trEven,trOdd"), $this);?>
'>
			<td class="cmenu" title="<?php echo $this->_tpl_vars['item']['role_name']; ?>
"><?php echo $this->_tpl_vars['item']['role_name']; ?>
</td>
			<td class="cmenu" title="<?php echo $this->_tpl_vars['item']['role_name']; ?>
"><?php echo $this->_tpl_vars['item']['account_name']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['level']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['item_id']; ?>
</td>
			<td><?php echo $this->_tpl_vars['arrItemsAll'][$this->_tpl_vars['item']['item_id']]['name']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['item_cnt']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['price']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['total_cost']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['pubacct']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['amt']; ?>
</td>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['ts'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')); ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['billno']; ?>
</td>
		</tr>
	<?php endforeach; else: ?>
		<font color='red'><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</font>
	<?php endif; unset($_from); ?>
	</table>
	<?php endif; ?>
	</div>
	</form>
	
</body>
</html>