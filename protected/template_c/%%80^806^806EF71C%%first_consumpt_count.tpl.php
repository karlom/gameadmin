<?php /* Smarty version 2.6.25, created on 2014-04-18 11:18:21
         compiled from module/pay/first_consumpt_count.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">                                    
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />          
<title><?php echo $this->_tpl_vars['lang']->menu->firstConsumptCount; ?>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">            
<link rel="stylesheet" href="/static/css/style.css" type="text/css">           
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<style type="text/css">                                                        
        .hr_red{                                                               
                background-color:red;                                          
                width:6px;                                                     
        }       
</style>        
</head> 

<body style="margin:0px;padding:20px;">
<div id="position"><b><?php echo $this->_tpl_vars['lang']->menu->class->payAndSpand; ?>
:<?php echo $this->_tpl_vars['lang']->menu->firstConsumptCount; ?>
</b></div>
<div class='divOperation'>
	<form name="myform" method="post" action="<?php echo $this->_tpl_vars['URL_SELF']; ?>
">
		
	&nbsp;<?php echo $this->_tpl_vars['lang']->page->beginTime; ?>
：<input type="text" size="13" class="Wdate" name="dateStart" id="dateStart" onfocus="WdatePicker({el:'dateStart',dateFmt:'yyyy-MM-dd',minDate:'<?php echo $this->_tpl_vars['minDate']; ?>
',maxDate:'#F{$dp.$D(\'dateEnd\')}'})" value="<?php echo $this->_tpl_vars['dateStart']; ?>
">
	
	&nbsp;&nbsp;<?php echo $this->_tpl_vars['lang']->page->endTime; ?>
：<input type="text" size="13" class="Wdate" name="dateEnd" id="dateEnd" onfocus="WdatePicker({el:'dateEnd',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'dateStart\')}',maxDate:'<?php echo $this->_tpl_vars['maxDate']; ?>
'})"  value="<?php echo $this->_tpl_vars['dateEnd']; ?>
">
	
	
	&nbsp;&nbsp;
	
	<input type="image" name='search' align="absmiddle" src="/static/images/search.gif" class="input2"  />
	　
	</form>
</div>

<br />

<?php echo $this->_tpl_vars['lang']->pay->allServerPay; ?>

<?php if ($this->_tpl_vars['viewData']): ?>
<div>
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:960px;">
		<tr>
			<th width="20%"><?php echo $this->_tpl_vars['lang']->page->date; ?>
</th>
			<th width="20%"><?php echo $this->_tpl_vars['lang']->page->firstConsume1; ?>
</th>
			<th width="20%"><?php echo $this->_tpl_vars['lang']->page->firstConsume2; ?>
</th>
		</tr>
	<?php $_from = $this->_tpl_vars['viewData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['day']):
?>
		<tr align="center">
			<td><?php echo $this->_tpl_vars['day']['date']; ?>
</td>
			<td><?php echo $this->_tpl_vars['day']['consumpt1']; ?>
</td>
			<td><?php echo $this->_tpl_vars['day']['consumpt2']; ?>
</td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>
	</table>	
</div>
<?php else: ?>
<div class="red"><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</div>
<?php endif; ?>
<br />

</body>
</html>