<?php /* Smarty version 2.6.25, created on 2014-04-17 16:36:21
         compiled from file:pager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'regex_replace', 'file:pager.tpl', 3, false),array('modifier', 'strpos', 'file:pager.tpl', 5, false),array('modifier', 'cat', 'file:pager.tpl', 7, false),)), $this); ?>
<?php if ($this->_tpl_vars['pages']['items']): ?>
	<?php if (! $this->_tpl_vars['current_uri']): ?>
		<?php $this->assign('current_uri', ((is_array($_tmp=$this->_supers['server']['REQUEST_URI'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, "/&page=\d*|page=\d*&?/", "") : smarty_modifier_regex_replace($_tmp, "/&page=\d*|page=\d*&?/", ""))); ?>
	<?php endif; ?>
	<?php $this->assign('pos', strpos($this->_tpl_vars['current_uri'], '?')); ?>
	<?php if ($this->_tpl_vars['pos'] == ''): ?>
		<?php $this->assign('current_uri', ((is_array($_tmp=$this->_tpl_vars['current_uri'])) ? $this->_run_mod_handler('cat', true, $_tmp, '?') : smarty_modifier_cat($_tmp, '?'))); ?>
	<?php endif; ?>
	<form action="<?php echo $this->_tpl_vars['current_uri']; ?>
" method="get" style="display:inline">
	<a href="<?php echo $this->_tpl_vars['current_uri']; ?>
&page=<?php echo $this->_tpl_vars['pages']['first']['num']; ?>
"><?php echo $this->_tpl_vars['pages']['first']['label']; ?>
</a> |
	<a href="<?php echo $this->_tpl_vars['current_uri']; ?>
&page=<?php echo $this->_tpl_vars['pages']['prev']['num']; ?>
"><?php echo $this->_tpl_vars['pages']['prev']['label']; ?>
</a> |
	<?php $_from = $this->_tpl_vars['pages']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['page_log_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['page_log_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['text'] => $this->_tpl_vars['page']):
        $this->_foreach['page_log_loop']['iteration']++;
?>
		<?php if ($this->_tpl_vars['page']['current']): ?>
			<font color="red"><?php echo $this->_tpl_vars['page']['num']; ?>
</font> |
			<?php $this->assign('current_page', $this->_tpl_vars['page']['num']); ?>
		<?php else: ?>
			<a href="<?php echo $this->_tpl_vars['current_uri']; ?>
&page=<?php echo $this->_tpl_vars['page']['num']; ?>
"><?php echo $this->_tpl_vars['page']['num']; ?>
</a> |
		<?php endif; ?>
		
	<?php endforeach; endif; unset($_from); ?>
	<a href="<?php echo $this->_tpl_vars['current_uri']; ?>
&page=<?php echo $this->_tpl_vars['pages']['next']['num']; ?>
"><?php echo $this->_tpl_vars['pages']['next']['label']; ?>
</a> |
	<a href="<?php echo $this->_tpl_vars['current_uri']; ?>
&page=<?php echo $this->_tpl_vars['pages']['last']['num']; ?>
"><?php echo $this->_tpl_vars['pages']['last']['label']; ?>
</a> |
	<?php echo $this->_tpl_vars['pages']['recordCount']['label']; ?>
: <?php echo $this->_tpl_vars['pages']['recordCount']['num']; ?>
 
	<?php echo $this->_tpl_vars['pages']['pageCount']['label']; ?>
: <?php echo $this->_tpl_vars['pages']['pageCount']['num']; ?>
 
		</form>
<?php endif; ?>
