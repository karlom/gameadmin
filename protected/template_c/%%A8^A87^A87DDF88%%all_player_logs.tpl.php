<?php /* Smarty version 2.6.25, created on 2014-04-18 11:23:15
         compiled from module/player/all_player_logs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_checkboxes', 'module/player/all_player_logs.tpl', 79, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<?php echo $this->_tpl_vars['lang']->menu->allRoleLog; ?>

		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
				$("#selectAll").click(function(){
					//全选
					if($(this).attr("checked") == true) {
						$("input[name='checkbox[]']").each(function(){
							$(this).attr("checked",true);
						});
						$("input[name='selectType[]']").each(function(){
							$(this).attr("checked",true);
						});
					} else {
						//全不选
						$("input[name='checkbox[]']").each(function(){
							$(this).attr("checked",false);
						});	
						$("input[name='selectType[]']").each(function(){
							$(this).attr("checked",false);
						});	
					}
				});
				
				$("input[name='checkbox[]']").click(function(){
					$("input[name='checkbox[]']").each(function(){
						if($(this).attr("checked") == false) 
							$("#selectAll").attr("checked",false);
					});	
				});
				
				$("#accountName").keydown(function(){
					$("#roleName").val('');
				});
				$("#roleName").keydown(function(){
					$("#accountName").val('');
				});
			});
			
			function changePage(page) {
				$("#page").val(page);
				$("#searchform").submit();
			}
		</script>
	</head>
	<body>
		<div id="position">
			<b><?php echo $this->_tpl_vars['lang']->menu->class->userInfo; ?>
：<?php echo $this->_tpl_vars['lang']->menu->allRoleLog; ?>
</b>
		</div>
		<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
			<td><?php echo $this->_tpl_vars['lang']->page->beginTime; ?>
：<input type="text" size="13" class="Wdate" name="startDay" id="startDay" onfocus="WdatePicker({el:'startDay',dateFmt:'yyyy-MM-dd',minDate:'<?php echo $this->_tpl_vars['minDate']; ?>
',maxDate:'#F{$dp.$D(\'endDay\')}'})" value="<?php echo $this->_tpl_vars['startDay']; ?>
"></td>
			<td><?php echo $this->_tpl_vars['lang']->page->endTime; ?>
：<input type="text" size="13" class="Wdate" name="endDay" id="endDay" onfocus="WdatePicker({el:'endDay',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDay\')}',maxDate:'<?php echo $this->_tpl_vars['maxDate']; ?>
'})"  value="<?php echo $this->_tpl_vars['endDay']; ?>
"></td>
			
			<td><?php echo $this->_tpl_vars['lang']->player->accountName; ?>
: <input id="accountName" name="accountName" size="15" value="<?php echo $this->_tpl_vars['accountName']; ?>
" 	/></td>
			<td><?php echo $this->_tpl_vars['lang']->player->roleName; ?>
: <input id="roleName" name="roleName" size="15" value="<?php echo $this->_tpl_vars['roleName']; ?>
" /></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  /></td>
			<br />
			<?php echo $this->_tpl_vars['lang']->page->selectLog; ?>

			<label><input type="checkbox" name="selectType[]" id="selectAll" value="all" <?php if ($this->_tpl_vars['selectType']['all']): ?> checked="checked" <?php endif; ?>/><?php echo $this->_tpl_vars['lang']->page->all; ?>
</label>
			<!--
			<label><input type="checkbox" name="selectType[]" id="selectCurrency" value="currency" <?php if ($this->_tpl_vars['selectType']['currency']): ?> checked="checked" <?php endif; ?>/><?php echo $this->_tpl_vars['lang']->page->aboutCurrency; ?>
</label>
			<label><input type="checkbox" name="selectType[]" id="selectPet" value="pet" <?php if ($this->_tpl_vars['selectType']['pet']): ?> checked="checked" <?php endif; ?>/><?php echo $this->_tpl_vars['lang']->page->aboutPet; ?>
</label>
			<label><input type="checkbox" name="selectType[]" id="selectFamily" value="family" <?php if ($this->_tpl_vars['selectType']['family']): ?> checked="checked" <?php endif; ?>/><?php echo $this->_tpl_vars['lang']->page->aboutFamily; ?>
</label>
			<label><input type="checkbox" name="selectType[]" id="selectHome" value="home" <?php if ($this->_tpl_vars['selectType']['home']): ?> checked="checked" <?php endif; ?>/><?php echo $this->_tpl_vars['lang']->page->aboutHome; ?>
</label>
			<label><input type="checkbox" name="selectType[]" id="selectShenlu" value="shenlu" <?php if ($this->_tpl_vars['selectType']['shenlu']): ?> checked="checked" <?php endif; ?>/><?php echo $this->_tpl_vars['lang']->page->aboutShenlu; ?>
</label>
			<label><input type="checkbox" name="selectType[]" id="selectOther" value="other" <?php if ($this->_tpl_vars['selectType']['other']): ?> checked="checked" <?php endif; ?>/><?php echo $this->_tpl_vars['lang']->page->other; ?>
</label>
			-->
			<br />
			<?php echo smarty_function_html_checkboxes(array('options' => $this->_tpl_vars['checkboxData'],'checked' => $this->_tpl_vars['checked'],'separator' => "&nbsp;"), $this);?>

			
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
<input type="text" id="pageSize" name="pageSize" size="4" style="text-align:center;" value="<?php echo $this->_tpl_vars['pageSize']; ?>
"><?php echo $this->_tpl_vars['lang']->page->row; ?>

						<?php echo $this->_tpl_vars['lang']->page->dang; ?>
<input id="page" name="page" type="text" class="text" size="3" maxlength="6" style="text-align:center;" value="<?php echo $this->_tpl_vars['page']; ?>
" ><?php echo $this->_tpl_vars['lang']->page->page; ?>
&nbsp;<input id="btnGo" type="submit" class="button" name="Submit" value="GO">
					</td>
				</tr>
			</table>
		</form>
		
				
		<table class="DataGrid">
			<!--caption class="table_list_head" align="center">
				<?php echo $this->_tpl_vars['lang']->menu->allRoleLog; ?>

			</caption-->
			
			<tr align="center">
				<!--th style="width:10%"><?php echo $this->_tpl_vars['lang']->monitor->id; ?>
</th-->
				<th style="width:10%"><?php echo $this->_tpl_vars['lang']->page->time; ?>
</th>
		        <th style="width:10%"><?php echo $this->_tpl_vars['lang']->page->accountName; ?>
</th>
		        <th style="width:10%"><?php echo $this->_tpl_vars['lang']->page->roleName; ?>
</th>
		        <th style="width:5%"><?php echo $this->_tpl_vars['lang']->page->level; ?>
</th>
		        <th style="width:10%"><?php echo $this->_tpl_vars['lang']->page->keyword; ?>
</th>
		        <th style="width:40%"><?php echo $this->_tpl_vars['lang']->monitor->desc; ?>
</th>
			</tr>
			
			<?php if ($this->_tpl_vars['viewData']): ?>
			<?php $_from = $this->_tpl_vars['viewData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['logs']):
        $this->_foreach['loop']['iteration']++;
?>
			<tr align="center" <?php if ((1 & ($this->_foreach['loop']['iteration']-1))): ?> class="odd"<?php endif; ?> >
				<td><?php echo $this->_tpl_vars['logs']['mdate']; ?>
</td>
				<td><?php echo $this->_tpl_vars['logs']['account_name']; ?>
</td>
				<td><?php echo $this->_tpl_vars['logs']['role_name']; ?>
</td>
				<td><?php echo $this->_tpl_vars['logs']['level']; ?>
</td>
				<td><?php echo $this->_tpl_vars['logs']['key']; ?>
</td>
				<td><?php echo $this->_tpl_vars['logs']['desc']; ?>
</td>
			</tr>
			<?php endforeach; endif; unset($_from); ?>
			<?php else: ?>
			<tr>
				<td colspan="6"><b><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</b></td>
			</tr>
			<?php endif; ?>
		</table>
		<?php echo $this->_tpl_vars['pager_html']; ?>

	</body>
</html>