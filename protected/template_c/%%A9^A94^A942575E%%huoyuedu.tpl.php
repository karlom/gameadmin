<?php /* Smarty version 2.6.25, created on 2014-04-18 11:17:31
         compiled from module/basedata/huoyuedu.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo $this->_tpl_vars['lang']->menu->huoyuedu; ?>
</title>
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<script type="text/javascript" src="/static/js/highcharts/highcharts.js"></script>
	<script type="text/javascript">
		
		$(document).ready(function(){
			
			var huoyuedu = new Highcharts.Chart({
		        chart: {
		            renderTo: 'huoyuedu',
		            defaultSeriesType: 'spline',
			        type:'column'
		        },
		        title: {
		            text: '<?php echo $this->_tpl_vars['selectDay']; ?>
 玩家活跃度'
		         },
		         xAxis: {
		            categories: [
					<?php $_from = $this->_tpl_vars['viewData']['huoyue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['hy'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['hy']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['it']):
        $this->_foreach['hy']['iteration']++;
?>
						'<?php echo $this->_tpl_vars['key']; ?>
'<?php if (! ($this->_foreach['hy']['iteration'] == $this->_foreach['hy']['total'])): ?>,<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					]
		         },
		         yAxis: {
		            title: {
		               text: ''
		            }
		         },
				plotOptions: {
	                column: {
	                    dataLabels: {
	                        enabled: true
	                    }
	                }
	            },
		         series: [{
		            name: '人数',
					data:[
						<?php $_from = $this->_tpl_vars['viewData']['huoyue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['hy'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['hy']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['it']):
        $this->_foreach['hy']['iteration']++;
?>
						{
							dataLabels :{formatter : function(){ return '<strong><?php echo $this->_tpl_vars['it']; ?>
</strong>'} },
							y: <?php echo $this->_tpl_vars['it']; ?>

						}
						<?php if (! ($this->_foreach['hy']['iteration'] == $this->_foreach['hy']['total'])): ?>,<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					]
		         }]
			});  
					
			var huoyueFinishRate = new Highcharts.Chart({
		        chart: {
		            renderTo: 'finishRate',
		            defaultSeriesType: 'spline',
			        type:'column'
		        },
		        title: {
		            text: '<?php echo $this->_tpl_vars['selectDay']; ?>
 活跃行动完成率'
		         },
		         xAxis: {
		            categories: [
					<?php $_from = $this->_tpl_vars['viewData']['finishRate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['hyr'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['hyr']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['it']):
        $this->_foreach['hyr']['iteration']++;
?>
						'<strong><?php echo $this->_tpl_vars['it']['name']; ?>
</strong>'<?php if (! ($this->_foreach['hyr']['iteration'] == $this->_foreach['hyr']['total'])): ?>,<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					],
					labels: {
						rotation: -45,
						align: 'right',
						style: {
							font: 'normal 13px Verdana, sans-serif'
						}
					}
		         },
		         yAxis: {
		            title: {
		               text: '百分比'
		            }
		         },
				plotOptions: {
	                column: {
	                    dataLabels: {
	                        enabled: true
	                    }
	                }
	            },
		         series: [{
		            name: '完成率',
					data:[
						<?php $_from = $this->_tpl_vars['viewData']['finishRate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['hyr'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['hyr']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['it']):
        $this->_foreach['hyr']['iteration']++;
?>
						{
							dataLabels :{formatter : function(){ return '<strong><?php echo $this->_tpl_vars['it']['rate']; ?>
</strong>'} },
							y: <?php echo $this->_tpl_vars['it']['rate']; ?>

						}
						<?php if (! ($this->_foreach['hyr']['iteration'] == $this->_foreach['hyr']['total'])): ?>,<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					]
		         }]
			});    
		});
	</script>
	
</head>
<body>
	<div id="position">
		<b><?php echo $this->_tpl_vars['lang']->menu->class->baseData; ?>
：<?php echo $this->_tpl_vars['lang']->menu->huoyuedu; ?>
</b>
	</div>
	
	<div><?php echo $this->_tpl_vars['lang']->page->serverOnlineDate; ?>
: <?php echo $this->_tpl_vars['minDate']; ?>
 &nbsp; <?php echo $this->_tpl_vars['lang']->page->today; ?>
: <?php echo $this->_tpl_vars['maxDate']; ?>
</div>
	
	
	<br />
	<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
		<td>&nbsp;<?php echo $this->_tpl_vars['lang']->page->date; ?>
：<input type="text" size="13" class="Wdate" name="selectDate" id="selectDate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'<?php echo $this->_tpl_vars['minDate']; ?>
',maxDate:'<?php echo $this->_tpl_vars['maxDate']; ?>
'})" value="<?php echo $this->_tpl_vars['selectDate']; ?>
"></td>
		<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
	</form>

	<br />
	<div><h3>玩家活跃度：</h3></div>
	<?php if ($this->_tpl_vars['viewData']['huoyue']): ?>
	<div id="huoyuedu" style="width: 960px; height: 400px"></div>
	<?php else: ?>
	<div><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</div>
	<?php endif; ?>
	
	<br />
	<div><h3>活跃行动完成率：</h3></div>
	<?php if ($this->_tpl_vars['viewData']['finishRate']): ?>
	<div id="finishRate" style="width: 960px; height: 400px"></div>
	<?php else: ?>
	<div><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</div>
	<?php endif; ?>
	
	<br />
	
	<div><h3>活跃奖励礼包领取率：</h3></div>
	<br />
	<?php if ($this->_tpl_vars['viewData']): ?>
	<table class="DataGrid" style="width:960px">
			<tr >
				<th>活跃礼包</th>
				<th>礼包ID</th>
				<th>可领取玩家数</th>
				<th>已领取玩家数</th>
				<th>领取率</th>
			</tr>
			
		<?php $_from = $this->_tpl_vars['viewData']['rewardTakeRate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['reward'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['reward']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['reward']['iteration']++;
?>
			<tr align="center">
				<td><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
				<td><?php echo $this->_tpl_vars['item']['item_id']; ?>
</td>
				<td><?php echo $this->_tpl_vars['item']['all']; ?>
</td>
				<td><?php echo $this->_tpl_vars['item']['taked']; ?>
</td>
				<td><?php echo $this->_tpl_vars['item']['rate']; ?>
%</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</table>
	<?php else: ?>		
		<div><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</div>
	<?php endif; ?>
		
	<br />

</body>
</html>