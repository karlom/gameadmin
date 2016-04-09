<?php
/*
 * 生成装备配置文件脚本
 */

// //----------------countTime
//    $stime=microtime(true); //获取程序开始执行的时间
//    echo "hello world\n";   //你执行的代码
// //-------------------------------------------------------------------------------------------

$file = scandir("./");
//print_r($file);

$arr1 = array();
$arr2 = array();
foreach ($file as $k=>$v){
	if($v=='EquipConfig.lua'){
		$content = file('EquipConfig.lua');		
		foreach ($content as $c=>$t){
			preg_match('/[0-9]{8}/',$t,$arr1[$c]);							
			preg_match("/name=\".*?\"/",$t,$arr2[$c]);							
		}
	}
}

//array_filter($arr);

$arr3 = array();

foreach ($arr1 as $k1=>&$v1){
	if(empty($v1)){
		unset($arr1[$k1]);
	} else {
		$v1['id'] = $v1[0];
		$arr3[$k1]['id'] = $v1[0];
		unset($v1[0]);
	}
}

foreach ($arr2 as $k2=>&$v2){
	if(empty($v2)){
		unset($arr2[$k2]);
	} else {
		$v2['name'] = $v2[0];
		$v2['name'] = explode("\"",$v2['name']);
		$v2['name'] = $v2['name'][1];
		$arr3[$k2]['name'] = $v2['name'];
		unset($v2[0]);
	}
}

$arr = array();
foreach ($arr3 as $k=>$v){
	$arr[$v['id']] = $v;
}

ksort($arr);
//print_r($arr);
//die;

if(!empty($arr)){
        $str=<<<PHPSTR
<?php
//注意！或不清楚以下各变量的配置规则及用途，请不要随便动。
\$equipConfig = 
PHPSTR;
        $str .= var_export($arr,true).';';
}   

$putSize = @file_put_contents('./equipConfig.php',$str);
if (!$putSize) {
    echo "<script type=''>alert('生成失败!');</script>";
}else{
    echo "<script type=''>alert('生成成功!');</script>";
}   
exit();

// //-------------------------------------------------------------------------------------------
//    $etime=microtime(true);//获取程序执行结束的时间
//    $total=$etime-$stime;   //计算差值
//    echo "{$total} times";
// //-------------countTime 
