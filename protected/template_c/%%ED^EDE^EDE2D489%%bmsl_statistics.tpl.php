<?php /* Smarty version 2.6.25, created on 2014-04-18 11:16:12
         compiled from module/activity/bmsl_statistics.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<?php echo $this->_tpl_vars['lang']->menu->bumieshilian; ?>

		</title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
		<script type="text/javascript" src="/static/js/sorttable.js"></script>
		<script type="text/javascript">
			
			rankIsShow = 0;
			showDay = "";
			showType = "";
			
			function showRank(day,tp){
				var aid = "#"+tp+"-"+day;
				var rid = "#"+tp+"-rank-"+day; 
			
				if( $(rid).length <= 0 ) {
					var rid = "#no_data";
				}
				
				if( rankIsShow == 0 ){
										
					$(rid).show();
					
					rankIsShow = 1;
					showDay = day;
					showType = tp;
					var offsetDayRank = $(aid).offset();
					$(rid).css("top",offsetDayRank.top+20).css("left",offsetDayRank.left);
				} else {
					if( showDay == day && showType == tp) {
						$(rid).hide();
						rankIsShow = 0;
					} else {
						$("div.rank").hide();
						$(rid).show();
						rankIsShow = 1;
						showDay = day;
						showType = tp;
						var offsetDayRank = $(aid).offset();
						$(rid).css("top",offsetDayRank.top+20).css("left",offsetDayRank.left);
					}
				}
			}
		
			function hideRank() {
				$("div.rank").hide();
				$("div.score").hide();
				dayRankShow = 0;
			}
		</script>
		
	</head>
	<body>
		<div id="position">
			<b><?php echo $this->_tpl_vars['lang']->menu->class->activityManage; ?>
：<?php echo $this->_tpl_vars['lang']->menu->bumieshilian; ?>
<?php echo $this->_tpl_vars['lang']->menu->dataStatistics; ?>
</b>
		</div>
		
		<div><?php echo $this->_tpl_vars['lang']->page->serverOnlineDate; ?>
: <?php echo $this->_tpl_vars['minDate']; ?>
 &nbsp; <?php echo $this->_tpl_vars['lang']->page->today; ?>
: <?php echo $this->_tpl_vars['maxDate']; ?>
</div>
		<br />
		
		<div><h3>活动参与数据：</h3></div>
		
		<br />
		<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
			<td>&nbsp;<?php echo $this->_tpl_vars['lang']->page->date; ?>
：<input type="text" size="13" class="Wdate" name="startDay" id="startDay" onfocus="WdatePicker({el:'startDay',dateFmt:'yyyy-MM-dd',minDate:'<?php echo $this->_tpl_vars['minDate']; ?>
',maxDate:'#F{$dp.$D(\'endDay\')}'})" value="<?php echo $this->_tpl_vars['startDay']; ?>
"></td>
			<td>&nbsp;<?php echo $this->_tpl_vars['lang']->page->date; ?>
：<input type="text" size="13" class="Wdate" name="endDay" id="endDay" onfocus="WdatePicker({el:'endDay',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDay\')}',maxDate:'<?php echo $this->_tpl_vars['maxDate']; ?>
'})" value="<?php echo $this->_tpl_vars['endDay']; ?>
"></td>
			<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
		</form>
		<br />
		
		<div>&nbsp;&nbsp;活动开启时间：15:00 - 15:30</div>

		<table class="DataGrid" style="width:960px">
				<tr align="center">
					<th>日期</th>
					<th>可参与人数</th>
					<th>参与人数</th>
					<th>参与度</th>
					<th>房间数</th>
				</tr>
				
		<?php if ($this->_tpl_vars['joinData']): ?>
			<?php $_from = $this->_tpl_vars['joinData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['day_data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['day_data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['day']):
        $this->_foreach['day_data']['iteration']++;
?>
				<tr align="center">
					<td><?php echo $this->_tpl_vars['day']['mdate']; ?>
</td>
					<td><?php echo $this->_tpl_vars['day']['act_count']; ?>
</td>
					<td><?php echo $this->_tpl_vars['day']['join_count']; ?>
</td>
					<td><?php echo $this->_tpl_vars['day']['joinRate']; ?>
%</td>
					<td><?php echo $this->_tpl_vars['day']['room_count']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
		<?php else: ?>		
			<tr><td colspan="5"><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</td></tr>
		<?php endif; ?>
		</table>

	<br />
	<div><h3>活动数据：</h3></div>
	<br />
	<form id="searchform" name="searchform" action="" method="POST" accept-charset="utf-8">
		<td>&nbsp;<?php echo $this->_tpl_vars['lang']->page->date; ?>
：<input type="text" size="13" class="Wdate" name="selectDay" id="selectDay" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'<?php echo $this->_tpl_vars['minDate']; ?>
',maxDate:'<?php echo $this->_tpl_vars['maxDate']; ?>
'})" value="<?php echo $this->_tpl_vars['selectDay']; ?>
"></td>
		<td><input type="image" name="search" src="/static/images/search.gif" align="absmiddle"  /></td>
	</form>

	<br />
	
	<?php if ($this->_tpl_vars['viewData']): ?>
	
	<?php $_from = $this->_tpl_vars['viewData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['day_data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['day_data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['day']):
        $this->_foreach['day_data']['iteration']++;
?>
	<table style="width:960px;height:140px;" class="CopyDataGrid">
		<tr>
			<td style="width:180px;height:100%;">
				<table style="width:100%;height:100%;" class="CopyDataGrid">
					<tr><td  <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['selectDay']): ?> class="TodayDataHead" <?php else: ?> class="DataHead" <?php endif; ?> >日期</td></tr>
					<tr><td><?php if ($this->_tpl_vars['key'] == 'thisWeek'): ?>本周<br /><?php echo $this->_tpl_vars['thisWeek']; ?>
<?php elseif ($this->_tpl_vars['key'] == 'lastWeek'): ?>上周<br /><?php echo $this->_tpl_vars['lastWeek']; ?>
<?php else: ?><?php echo $this->_tpl_vars['key']; ?>
<?php endif; ?></td></tr>
				</table>
			</td>
			<td style="width:780px;height:100%;">
				<table style="width:100%;height:100%;" class="CopyDataGrid">
					<tr>
						<td style="width:780px;height:70px;">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="8"   <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['selectDay']): ?> class="TodayDataHead" <?php else: ?> class="DataHead" <?php endif; ?> >基本信息</td></tr>
								<tr>
									<th>平均怪物强度</th>
									<th>最高怪物强度</th>
									<th>排名数据</th>
									<th>平均存活人数</th>
									<th>存活最高人数</th>
									<th>排名数据</th>
									<th>所有存活列表</th>
									<th>平均救助次数</th>
								</tr>
								<tr>
									<td><?php if ($this->_tpl_vars['day']['avgMonsterStrength']): ?><?php echo $this->_tpl_vars['day']['avgMonsterStrength']; ?>
<?php else: ?>0<?php endif; ?></td>
									<td><?php if ($this->_tpl_vars['day']['maxMonsterStrength']): ?><?php echo $this->_tpl_vars['day']['maxMonsterStrength']; ?>
<?php else: ?>0<?php endif; ?></td>
									<td><a id="strength-<?php echo $this->_tpl_vars['key']; ?>
" href="javascript:showRank('<?php echo $this->_tpl_vars['key']; ?>
','strength');" style="color:#215868;text-decoration:underline;">查看</a></td>
									<td><?php echo $this->_tpl_vars['day']['avgAlive']; ?>
</td>
									<td><?php echo $this->_tpl_vars['day']['maxAlive']['aliveCount']; ?>
</td>
									<td title="点击查看排名"><a id="alive-<?php echo $this->_tpl_vars['key']; ?>
" href="javascript:showRank('<?php echo $this->_tpl_vars['key']; ?>
','alive');" style="color:#215868;text-decoration:underline;">查看</a></td>
									<td title="点击查看名单"><a id="all_alive-<?php echo $this->_tpl_vars['key']; ?>
" href="javascript:showRank('<?php echo $this->_tpl_vars['key']; ?>
','all_alive');" style="color:#215868;text-decoration:underline;">查看</a></td>
									<td><?php echo $this->_tpl_vars['day']['avgHelpCount']; ?>
</td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td style="width:780px;height:70px;" colspan="2">
							<table style="width:100%;height:100%;" class="CopyDataGrid">
								<tr><td colspan="7"   <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['selectDay']): ?> class="TodayDataHead" <?php else: ?> class="DataHead" <?php endif; ?> >记忆之石</td></tr>
								<tr>
									<th>加强攻击</th>
									<th>加强防御</th>
									<th>加强气力恢复</th>
									<th>复活</th>
									<th>消耗总量</th>
									<th>购买总量</th>
									<th>生成总量</th>
								</tr>
								<tr>
									<td><?php echo $this->_tpl_vars['day']['stoneUseWay']['attack']; ?>
</td>
									<td><?php echo $this->_tpl_vars['day']['stoneUseWay']['defense']; ?>
</td>
									<td><?php echo $this->_tpl_vars['day']['stoneUseWay']['restore']; ?>
</td>
									<td><?php echo $this->_tpl_vars['day']['stoneUseWay']['relive']; ?>
</td>
									<td><?php if ($this->_tpl_vars['day']['stoneAllUse']): ?><?php echo $this->_tpl_vars['day']['stoneAllUse']; ?>
<?php else: ?>0<?php endif; ?></td>
									<td><?php if ($this->_tpl_vars['day']['stoneAllBuy']): ?><?php echo $this->_tpl_vars['day']['stoneAllBuy']; ?>
<?php else: ?>0<?php endif; ?></td>
									<td><?php if ($this->_tpl_vars['day']['stoneAllOutput']): ?><?php echo $this->_tpl_vars['day']['stoneAllOutput']; ?>
<?php else: ?>0<?php endif; ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br />
	<?php endforeach; endif; unset($_from); ?>
	
	<?php else: ?>
		<div><b><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</b></div>
	<?php endif; ?>

	
	
<?php $_from = $this->_tpl_vars['viewData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['day_data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['day_data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['day']):
        $this->_foreach['day_data']['iteration']++;
?>
	<!-- 最高怪物强度所在房间排行榜 -->
	<?php if ($this->_tpl_vars['day']['maxMonsterStrengthRank']): ?>
	<div id="strength-rank-<?php echo $this->_tpl_vars['key']; ?>
" class="rank">
		<div class="rank_thead">
			<table>
				<tr >
					<th style="width:40px">房号</th>
					<th style="width:40px">排名</th>
					<th style="width:100px">玩家名称</th>
					<th style="width:40px">职业</th>
					<th style="width:80px">生存时间(s)</th>
					<th style="width:90px">拯救队友次数</th>
					<th style="width:80px">个人得分</th>
					<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
				</tr>
			</table>
		</div>
		<div class="rank_tbody">
			<table>
				<?php $_from = $this->_tpl_vars['day']['maxMonsterStrengthRank']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['rank_data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['rank_data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['rankKey'] => $this->_tpl_vars['rank']):
        $this->_foreach['rank_data']['iteration']++;
?>
				<tr class="rank_list" align="center">
					<td style="width:40px"><?php echo $this->_tpl_vars['rank']['scene_id']; ?>
</td>
					<td style="width:40px"><?php echo $this->_tpl_vars['rank']['rank']; ?>
</td>
					<td style="width:100px"><?php echo $this->_tpl_vars['rank']['role_name']; ?>
</td>
					<td style="width:40px"><?php echo $this->_tpl_vars['dictJobs'][$this->_tpl_vars['rank']['job']]; ?>
</td>
					<td style="width:80px"><?php echo $this->_tpl_vars['rank']['live_sec']; ?>
</td>
					<td style="width:90px"><?php echo $this->_tpl_vars['rank']['save_cnt']; ?>
</td>
					<td style="width:80px"><?php echo $this->_tpl_vars['rank']['score_all']; ?>
</td>
					<td style="width:45px"></td>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
			</table>
		</div>
	</div>
	<?php endif; ?>

	<!-- 最高存活人数所在房间排行榜 -->
	<?php if ($this->_tpl_vars['day']['maxAliveRank']): ?>
	<div id="alive-rank-<?php echo $this->_tpl_vars['key']; ?>
" class="rank">
		<div class="rank_thead">
			<table>
				<tr >
					<th style="width:40px">房号</th>
					<th style="width:40px">排名</th>
					<th style="width:100px">玩家名称</th>
					<th style="width:40px">职业</th>
					<th style="width:80px">生存时间(s)</th>
					<th style="width:90px">拯救队友次数</th>
					<th style="width:80px">个人得分</th>
					<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
				</tr>
			</table>
		</div>
		<div class="rank_tbody">
			<table>
				<?php $_from = $this->_tpl_vars['day']['maxAliveRank']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['rank_data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['rank_data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['rankKey'] => $this->_tpl_vars['rank']):
        $this->_foreach['rank_data']['iteration']++;
?>
				<tr class="rank_list" align="center">
					<td style="width:40px"><?php echo $this->_tpl_vars['rank']['scene_id']; ?>
</td>
					<td style="width:40px"><?php echo $this->_tpl_vars['rank']['rank']; ?>
</td>
					<td style="width:100px"><?php echo $this->_tpl_vars['rank']['role_name']; ?>
</td>
					<td style="width:40px"><?php echo $this->_tpl_vars['dictJobs'][$this->_tpl_vars['rank']['job']]; ?>
</td>
					<td style="width:80px"><?php echo $this->_tpl_vars['rank']['live_sec']; ?>
</td>
					<td style="width:90px"><?php echo $this->_tpl_vars['rank']['save_cnt']; ?>
</td>
					<td style="width:80px"><?php echo $this->_tpl_vars['rank']['score_all']; ?>
</td>
					<td style="width:45px"></td>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
			</table>
		</div>
	</div>
	<?php endif; ?>

	<!-- 所有存活玩家名单 -->
	<div id="all_alive-rank-<?php echo $this->_tpl_vars['key']; ?>
" class="rank">
		<?php if ($this->_tpl_vars['day']['allAliveList']): ?>
		<div class="rank_thead">
			<table>
				<tr>
					<th style="width:40px">房号</th>
					<th style="width:40px">排名</th>
					<th style="width:100px">玩家名称</th>
					<th style="width:40px">职业</th>
					<th style="width:80px">生存时间(s)</th>
					<th style="width:90px">拯救队友次数</th>
					<th style="width:80px">个人得分</th>
					<th style="width:45px"><input type="button" value="关闭" onclick="javascript:hideRank();" /></th>
				</tr>
			</table>
		</div>
		<div class="rank_tbody">
			<table>
				<?php $_from = $this->_tpl_vars['day']['allAliveList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['rank_data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['rank_data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['rankKey'] => $this->_tpl_vars['rank']):
        $this->_foreach['rank_data']['iteration']++;
?>
				<tr class="rank_list" align="center">
					<td style="width:40px"><?php echo $this->_tpl_vars['rank']['scene_id']; ?>
</td>
					<td style="width:40px"><?php echo $this->_tpl_vars['rank']['rank']; ?>
</td>
					<td style="width:100px"><?php echo $this->_tpl_vars['rank']['role_name']; ?>
</td>
					<td style="width:40px"><?php echo $this->_tpl_vars['dictJobs'][$this->_tpl_vars['rank']['job']]; ?>
</td>
					<td style="width:80px"><?php echo $this->_tpl_vars['rank']['live_sec']; ?>
</td>
					<td style="width:90px"><?php echo $this->_tpl_vars['rank']['save_cnt']; ?>
</td>
					<td style="width:80px"><?php echo $this->_tpl_vars['rank']['score_all']; ?>
</td>
					<td style="width:45px"></td>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
			</table>
		</div>
		<?php else: ?>
			<div><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</div>
		<?php endif; ?>
	</div>
<?php endforeach; endif; unset($_from); ?>

<div id="no_data" class="rank" ><?php echo $this->_tpl_vars['lang']->page->noData; ?>
</div>

	</body>
</html>