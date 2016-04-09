<?php /* Smarty version 2.6.25, created on 2014-04-21 15:55:44
         compiled from module/pay/survey.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'round', 'module/pay/survey.tpl', 130, false),array('modifier', 'date_format', 'module/pay/survey.tpl', 146, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">                                    
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />          
<title><?php echo $this->_tpl_vars['lang']->menu->survey; ?>
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
:<?php echo $this->_tpl_vars['lang']->menu->survey; ?>
</b></div>
<div class='divOperation'>
<form name="myform" method="post" action="<?php echo $this->_tpl_vars['URL_SELF']; ?>
">

&nbsp;<?php echo $this->_tpl_vars['lang']->page->beginTime; ?>
：<input type='text' name='dateStart' id='startDay' size='12' value='<?php echo $this->_tpl_vars['dateStart']; ?>
'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />

&nbsp;&nbsp;<?php echo $this->_tpl_vars['lang']->page->endTime; ?>
：<input type='text' name='dateEnd' id='endDay' size='12' value='<?php echo $this->_tpl_vars['dateEnd']; ?>
'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />

&nbsp;&nbsp;

<input type="image" name='search' align="absmiddle" src="/static/images/search.gif" class="input2"  />

&nbsp;&nbsp;&nbsp;&nbsp
<input type="button" class="button" name="datePrev" value="<?php echo $this->_tpl_vars['lang']->page->today; ?>
" onclick="javascript:location.href='<?php echo $this->_tpl_vars['URL_SELF']; ?>
?dateStart=<?php echo $this->_tpl_vars['dateStrToday']; ?>
&dateEnd=<?php echo $this->_tpl_vars['dateStrToday']; ?>
';">
&nbsp;&nbsp
<input type="button" class="button" name="datePrev" value="<?php echo $this->_tpl_vars['lang']->page->prevTime; ?>
" onclick="javascript:location.href='<?php echo $this->_tpl_vars['URL_SELF']; ?>
?dateStart=<?php echo $this->_tpl_vars['dateStrPrev']; ?>
&dateEnd=<?php echo $this->_tpl_vars['dateStrPrev']; ?>
';">
&nbsp;&nbsp
<input type="button" class="button" name="dateNext" value="<?php echo $this->_tpl_vars['lang']->page->nextTime; ?>
" onclick="javascript:location.href='<?php echo $this->_tpl_vars['URL_SELF']; ?>
?dateStart=<?php echo $this->_tpl_vars['dateStrNext']; ?>
&dateEnd=<?php echo $this->_tpl_vars['dateStrNext']; ?>
';">
&nbsp;&nbsp
<input type="button" class="button" name="dateAll" value="<?php echo $this->_tpl_vars['lang']->page->allTime; ?>
" onclick="javascript:location.href='<?php echo $this->_tpl_vars['URL_SELF']; ?>
?dateStart=ALL&dateEnd=ALL';">
　　
</form>

</div>
<br />
<div>
	<table height="" cellspacing="0" border="0" class="DataGrid">
		<tr>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->proxy; ?>
：<?php echo $this->_tpl_vars['agent']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->proxyId; ?>
：<?php echo $this->_tpl_vars['agentId']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->areaName; ?>
：<?php echo $this->_tpl_vars['areaName']; ?>
</td>
			<td ></td>
		</tr>
		<tr>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->serverOnlineDate; ?>
：<?php echo $this->_tpl_vars['serverOnlineDay']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->havedOnlineDate; ?>
：<?php echo $this->_tpl_vars['hasOnlineDay']; ?>
</td>
			<td colspan="2"><?php echo $this->_tpl_vars['lang']->page->curProgrammeVer; ?>
：<?php echo $this->_tpl_vars['version']; ?>
</td>
		</tr>
		<tr>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->totalRegisterAccount; ?>
：<?php echo $this->_tpl_vars['totalAccount']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->totalCreateRole; ?>
：<?php echo $this->_tpl_vars['totalRole']; ?>
</td>
			<td colspan="2"><?php echo $this->_tpl_vars['lang']->page->roleMaxLevel; ?>
:<a style="color:#F40"><?php echo $this->_tpl_vars['roleMaxLevel']; ?>
</a> <?php echo $this->_tpl_vars['maxLevelRoleNames']; ?>
</td>
		</tr>
		<tr>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->arup; ?>
：<?php echo $this->_tpl_vars['allArpu']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->payRoleCount; ?>
：<?php echo $this->_tpl_vars['payAccountCnt']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->payRate; ?>
：<?php echo $this->_tpl_vars['allPayRate']; ?>
%</td>
			<td colspan="1"></td>
		</tr>
		<tr>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->totalConsumeMoney; ?>
：<?php echo $this->_tpl_vars['allPayCount']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->secPayCount; ?>
：<?php echo $this->_tpl_vars['allSecondPayCount']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->secPayRate; ?>
：<?php echo $this->_tpl_vars['allSecondPayRate']; ?>
%</td>
			<td></td>
		</tr>
		
		<tr>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->xsCostCount; ?>
：<?php echo $this->_tpl_vars['allXsCostCount']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->dayPayMore; ?>
：<?php echo $this->_tpl_vars['allMaxPay']['allMaxPay']; ?>
 , <?php echo $this->_tpl_vars['allMaxPay']['allMaxPayDate']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->dayMaxOnline; ?>
：<?php echo $this->_tpl_vars['allMaxOnline']['allMaxOnline']; ?>
 , <?php echo $this->_tpl_vars['allMaxOnline']['allMaxOnlineDate']; ?>
</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		
	</table>
	
	<br />
	<?php echo $this->_tpl_vars['lang']->page->betweenDate; ?>
: &nbsp;
	<table height="" cellspacing="0" border="0" class="DataGrid">
		<tr>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->loginCount; ?>
：<?php echo $this->_tpl_vars['viewData']['loginCount']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->creatRoleCount; ?>
：<?php echo $this->_tpl_vars['viewData']['createRoleCount']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->maxOnline; ?>
：<?php if ($this->_tpl_vars['viewData']['maxOnline']): ?><?php echo $this->_tpl_vars['viewData']['maxOnline']; ?>
<?php else: ?>0<?php endif; ?></td>
			<td ></td>
		</tr>
		
		<tr>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->arup; ?>
：<?php echo $this->_tpl_vars['viewData']['arup']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->payRoleCount; ?>
：<?php echo $this->_tpl_vars['viewData']['payRoleCount']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->payRate; ?>
：<?php echo $this->_tpl_vars['viewData']['payRate']; ?>
%</td>
			<td colspan="1"></td>
		</tr>
		
		<tr>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->consumeMoney; ?>
：<?php if ($this->_tpl_vars['viewData']['totalCost']): ?><?php echo $this->_tpl_vars['viewData']['totalCost']; ?>
<?php else: ?>0<?php endif; ?></td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->secPayCount; ?>
：<?php echo $this->_tpl_vars['viewData']['secPayCount']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->secPayRate; ?>
：<?php echo $this->_tpl_vars['viewData']['secPayRate']; ?>
%</td>
			<td></td>
		</tr>
		
		<tr>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->xsCostCount; ?>
：<?php echo $this->_tpl_vars['viewData']['xsCostCount']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->newPayCount; ?>
：<?php echo $this->_tpl_vars['viewData']['newPayCount']; ?>
</td>
			<td width="25%"><?php echo $this->_tpl_vars['lang']->page->newPayRate; ?>
：<?php echo $this->_tpl_vars['viewData']['newPayRate']; ?>
%</td>
			<td colspan="1"></td>
		</tr>
		
	</table>
	
</div>
<br />

<div>&nbsp;&nbsp;<?php echo $this->_tpl_vars['lang']->player->onlineUserCount; ?>
: <font color="red"><?php echo $this->_tpl_vars['currentOnline']['online']; ?>
</font>, &nbsp;<?php echo $this->_tpl_vars['lang']->player->onlinePayUserCount; ?>
: <font color="red"><?php echo $this->_tpl_vars['payUserOnline']; ?>
</font></div>

<br />
<div>
	<div style="border:1px solid SkyBlue; background:#D7E4F5;width:98%;"><?php echo $this->_tpl_vars['dateStart']; ?>
--<?php echo $this->_tpl_vars['dateEnd']; ?>
 <?php echo $this->_tpl_vars['lang']->page->total; ?>
<?php echo $this->_tpl_vars['diffDay']; ?>
<?php echo $this->_tpl_vars['lang']->page->dayPayMoneyAndMaxOnlinePic; ?>
</div>
	<table cellspacing="0" class="SumDataGrid">
		<tr>
			<th width="20" height="150"><?php echo $this->_tpl_vars['lang']->page->everydayPayMoney; ?>
</th>
			<?php if ($this->_tpl_vars['payOnline']): ?>
			<?php $_from = $this->_tpl_vars['payOnline']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
			<td align="center" valign="bottom"><?php echo $this->_tpl_vars['row']['total_pay']; ?>
<hr class="<?php if ($this->_tpl_vars['row']['total_pay']/$this->_tpl_vars['maxPayMoney'] >= 0.75): ?>hr_red<?php else: ?>hr_green<?php endif; ?>" style="height:<?php echo ((is_array($_tmp=$this->_tpl_vars['row']['total_pay']*120/$this->_tpl_vars['maxPayMoney'])) ? $this->_run_mod_handler('round', true, $_tmp) : round($_tmp)); ?>
px;"></td>
			<?php endforeach; endif; unset($_from); ?>
			<?php endif; ?>
		</tr>
		<tr>
			<th width="20" height="150"><?php echo $this->_tpl_vars['lang']->page->everydayMaxOnline; ?>
</th>
			<?php if ($this->_tpl_vars['payOnline']): ?>
			<?php $_from = $this->_tpl_vars['payOnline']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
			<td align="center" valign="bottom"><?php echo $this->_tpl_vars['row']['max_online']; ?>
<hr class="<?php if ($this->_tpl_vars['row']['max_online']/$this->_tpl_vars['maxOnline'] >= 0.75): ?>hr_red<?php else: ?>hr_green<?php endif; ?>" style="height:<?php echo ((is_array($_tmp=$this->_tpl_vars['row']['max_online']*120/$this->_tpl_vars['maxOnline'])) ? $this->_run_mod_handler('round', true, $_tmp) : round($_tmp)); ?>
px;"></td>
			<?php endforeach; endif; unset($_from); ?>
			<?php endif; ?>
		</tr>
		<tr>
			<th width="20"><?php echo $this->_tpl_vars['lang']->page->date; ?>
</th>
			<?php if ($this->_tpl_vars['payOnline']): ?>
			<?php $_from = $this->_tpl_vars['payOnline']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
			<td align="center"><?php if (0 == ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%w") : smarty_modifier_date_format($_tmp, "%w"))): ?><font color="red"><?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m.%d") : smarty_modifier_date_format($_tmp, "%m.%d")); ?>
<br><?php echo $this->_tpl_vars['lang']->page->sunday; ?>
</font><?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m.%d") : smarty_modifier_date_format($_tmp, "%m.%d")); ?>
<?php endif; ?></td>
			<?php endforeach; endif; unset($_from); ?>
			<?php endif; ?>
		</tr>
	</table>
</div>
</body>
</html>