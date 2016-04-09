<?php
/**
 * operation_dict.php
 */

include_once("../../../protected/dict/opTypeConfig.php");

$dictOperation;
$dictCurrency;

$dictMoney = array (
	"item" => '道具',
	"gold" => '仙石',
	"silver" => '铜币',
	"lingqi" => '灵气',
	"liquan" => '绑定仙石',
	"tiancheng" => '天城令',
	'jyzs' => '记忆之石',
	'yaohun' => '妖魂',
	"bindMoney" => '绑定铜币',
);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			消费类型对应查询表
		</title>
	</head>
<body>

<form>
	<br />	
	<div id="desc">
		<b>
			&nbsp;说明：消费类型值=货币对应值+操作对应值。<br />	
			&nbsp;如：10009表示 “通过采集获得道具”，30009表示“通过采集获得铜币”，其他类推。
		</b>
	</div>
	
	<table bgcolor="#ffc0cb" border="1" id="t2" style="position:absolute;left:20px;top:80px">
		<caption>
			<?php echo $lang->page->type; ?>
		</caption>
		
		<tr>
			<th style='width:150px' >货币/道具</th>
			<th style='width:150px' align='center'>对应值</th>
		</tr>
		
		<?php
			foreach($dictMoney as $k => $v) {
				echo "<tr>";
				echo "<td>{$v}</td>";
				echo "<td align='center'>{$dictCurrency[$k]}</td>";
				echo "</tr>";
			} 
		?>
	</table>
			
	<table bgcolor="#ffc0cb" border="1" id="t3" style="position:absolute;left:350px;top:80px">
		<caption>
			<?php echo $lang->page->type; ?>
		</caption>
		<tr>
			<th>操作</th>
			<th>对应值</th>
		</tr>
		<?php
		foreach($dictOperation as $k => $v) {
			echo "<tr>";
			echo "<td style='width:200px' >{$v}</td>";
			echo "<td style='width:100px' align='center'>{$k}</td>";
			echo "</tr>";
		}
		?>
	</table>
</form>
</body>
<html>