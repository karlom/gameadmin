<?php
include_once '../../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE . '/global.php';
global $lang;


/*******配置******************************************************************/
$key = 1;
$method = 'activityplayercareer';
$unixTime = time();
$sign = md5($key.$method.$unixTime);
/*******配置******************************************************************/

//获取用于显示的数据，这个最好不要在本文件的代码写，这样的耦合度是最高的，最好是用接口的形式提供,现在只是模拟数据用来显示
$viewData = json_decode(getCareerData($sign, $method, $unixTime), true);

if ($viewData !== "UNKNOWN") {
	if($viewData[country_array]){
		$country_array = $viewData[country_array];
	}
	if($viewData[career_array]){
		$career_array = $viewData[career_array];
	}
	$level_range = $viewData[level_range];
	$top_level = $viewData[top_level];
	$max = $top_level/$level_range;
	$registerData = $viewData[registerData];
	$activityData = $viewData[activityData];
	$levelData = $viewData[levelData];
	$type = $viewData[type];
	$rd = array();
	$ad = array();
	$result = array();
	$rd_total = 0;
	$ad_total = 0;
	$ld_total = 0;	
	$c = 0;
	if($type == 1){
		if($registerData){
			$total = 0;
			foreach($registerData as $key => $val){
				$country = $country_array[$val[country]];
				if(!isset($rd[$country][num])){
					$rd[$country][num] = $val[registerPlayerCount];
				}else{
					$rd[$country][num] += $val[registerPlayerCount];
				}
				$rd_total += $val[registerPlayerCount];
			}
			if($rd){
				foreach($rd as $key => $val){
					if($rd_total > 0){
						$rd[$key][percent] = round($val[num]/$rd_total*100, 2);
					}else{
						$rd[$key][percent] = 0;
					}					
				}
			}
		}
		if($activityData){
			$total = 0;
			foreach($activityData as $key => $val){
				$country = $country_array[$val[country]];
				if(!isset($ad[$country][num])){
					$ad[$country][num] = $val[activityPlayerCount];
				}else{
					$ad[$country][num] += $val[activityPlayerCount];
				}
				$ad_total += $val[activityPlayerCount];
			}
			if($ad){
				foreach($ad as $key => $val){
					if($ad_total > 0){
						$ad[$key][percent] = round($val[num]/$ad_total*100, 2);
					}else{
						$ad[$key][percent] = 0;
					}	
				}
			}
		}
		if($levelData){
			$total = 0;			
			for($i=0; $i<$max; $i++){
			    foreach($levelData as $key => $row){
					$country = $country_array[$row[country]];
			        if($row[level]>$i*$level_range && $row[level] <= ($i+1)*$level_range){
			        	$result[$i][$country][num] += $row[levelPlayerCount];
			        	$result[$i][total] += $row[levelPlayerCount];
			        }
			    }
			}
			foreach($result as $key=>$row){
				foreach($row as $k=>$r){
					if($k !== "total"){
						if($row[total] == 0){
							$result[$key][$k][percent] = 0;
						}else{
							$result[$key][$k][percent] = round($r[num]/$row[total]*100, 2);
						}
					}
				}
			}
			$t = 0;
			foreach($result as $key=>$row){
			    $t += $row[total];
			}
			$result[total] = $t;
			foreach($result as $key=>$row){
				if($key !== "total"){
					if($result[total] != 0){
						$result[$key][percent] = round($row[total]/$result[total]*100, 2);
					}else{
						$result[$key][percent] = 0;
					}					
				}
			}
			if($result){
				foreach($result as $key => $row){					
					if($key !== 'total'){
						$showData[$key][zg] = $row[total].'/'.$result[total].'('.$row[percent].'%)'.'<br/>';
						foreach($row as $k => $r){
							if($k !== 'total' && $k !== 'percent'){
								$showData[$key][$k] .= $r[num].'/'.$row[total].'('.$r[percent].'%)'.'<br/>';
							}
						}
					}
				}
				$count = count($country_array);
				$c = $count;
				$total_result[99][0] = $lang->player->level;
				$sort[0] = 0; 
				$i = 1;
				foreach($country_array as $key => $row){
					$total_result[99][$i] = $row;
					$sort[$row] = $i;
					$i++;
				}
				$total_result[99][$i] = $lang->player->total;
				$sort[zg] = $count+1; 
				foreach($showData as $key => $row){
					foreach($row as $k => $r){
						$total_result[$key][$sort[$k]] = $r;
					}
					for($a=1;$a<=$count;$a++){
						if(!isset($total_result[$key][$a])){
							$total_result[$key][$a] = '-';
						}
					}
					ksort($total_result[$key]);
				}
			}
		}
	}
	if($type == 2){
		if($registerData){
			$total = 0;
			foreach($registerData as $key => $val){
				$career = $career_array[$val[career]];
				if(!isset($rd[$career][num])){
					$rd[$career][num] = $val[registerPlayerCount];
				}else{
					$rd[$career][num] += $val[registerPlayerCount];
				}
				$rd_total += $val[registerPlayerCount];
			}
			if($rd){
				foreach($rd as $key => $val){
					if($rd_total > 0){
						$rd[$key][percent] = round($val[num]/$rd_total*100, 2);
					}else{
						$rd[$key][percent] = 0;
					}					
				}
			}
		}
		if($activityData){
			$total = 0;
			foreach($activityData as $key => $val){
				$career = $career_array[$val[career]];
				if(!isset($ad[$career][num])){
					$ad[$career][num] = $val[activityPlayerCount];
				}else{
					$ad[$career][num] += $val[activityPlayerCount];
				}
				$ad_total += $val[activityPlayerCount];
			}
			if($ad){
				foreach($ad as $key => $val){
					if($ad_total > 0){
						$ad[$key][percent] = round($val[num]/$ad_total*100, 2);
					}else{
						$ad[$key][percent] = 0;
					}	
				}
			}
		}
		if($levelData){
			$total = 0;			
			for($i=0; $i<$max; $i++){
			    foreach($levelData as $key => $row){
					$career = $career_array[$row[career]];
			        if($row[level]>$i*$level_range && $row[level] <= ($i+1)*$level_range){
			        	$result[$i][$career][num] += $row[levelPlayerCount];
			        	$result[$i][total] += $row[levelPlayerCount];
			        }
			    }
			}
			foreach($result as $key=>$row){
				foreach($row as $k=>$r){
					if($k !== "total"){
						if($row[total] == 0){
							$result[$key][$k][percent] = 0;
						}else{
							$result[$key][$k][percent] = round($r[num]/$row[total]*100, 2);
						}
					}
				}
			}
			$t = 0;
			foreach($result as $key=>$row){
			    $t += $row[total];
			}
			$result[total] = $t;
			foreach($result as $key=>$row){
				if($key !== "total"){
					if($result[total] != 0){
						$result[$key][percent] = round($row[total]/$result[total]*100, 2);
					}else{
						$result[$key][percent] = 0;
					}					
				}
			}
			if($result){
				foreach($result as $key => $row){					
					if($key !== 'total'){
						$showData[$key][zg] = $row[total].'/'.$result[total].'('.$row[percent].'%)'.'<br/>';
						foreach($row as $k => $r){
							if($k !== 'total' && $k !== 'percent'){
								$showData[$key][$k] .= $r[num].'/'.$row[total].'('.$r[percent].'%)'.'<br/>';
							}
						}
					}
				}
				$count = count($career_array);
				$c = $count;
				$total_result[99][0] = $lang->player->level;
				$sort[0] = 0; 
				$i = 1;
				foreach($career_array as $key => $row){
					$total_result[99][$i] = $row;
					$sort[$row] = $i;
					$i++;
				}
				$total_result[99][$i] = $lang->player->total;
				$sort[zg] = $count+1; 
				foreach($showData as $key => $row){
					foreach($row as $k => $r){
						$total_result[$key][$sort[$k]] = $r;
					}
					for($a=1;$a<=$count;$a++){
						if(!isset($total_result[$key][$a])){
							$total_result[$key][$a] = '-';
						}
					}
					ksort($total_result[$key]);
				}
			}
		}		
	}
	if($type == 3){
		if($registerData){
			foreach($registerData as $key => $val){
				$career = $career_array[$val[career]];
				$country = $country_array[$val[country]];
				$rd[$country][$career][num] += $val[registerPlayerCount];
				$rd[$country][total] += $val[registerPlayerCount];
				$rd_total += $val[registerPlayerCount];
			}
			if($rd){
				foreach($rd as $key => $val){
					foreach($val as $k => $v){
						if($k !== 'total'){
							if($val[total] > 0){
								$rd[$key][$k][percent] = round($v[num]/$val[total]*100, 2);
							}else{
								$rd[$key][$k][percent] = 0;
							}
						}
					}		
					if($rd_total > 0){
						$rd[$key][percent] = round($val[total]/$rd_total*100, 2);
					}else{
						$rd[$key][percent] = 0;
					}
				}
			}
		}
		if($activityData){
			foreach($activityData as $key => $val){
				$career = $career_array[$val[career]];
				$country = $country_array[$val[country]];
				$ad[$country][$career][num] += $val[activityPlayerCount];
				$ad[$country][total] += $val[activityPlayerCount];
				$ad_total += $val[activityPlayerCount];
			}
			if($ad){
				foreach($ad as $key => $val){
					foreach($val as $k => $v){
						if($k !== 'total'){
							if($val[total] > 0){
								$ad[$key][$k][percent] = round($v[num]/$val[total]*100, 2);
							}else{
								$ad[$key][$k][percent] = 0;
							}
						}
					}		
					if($ad_total > 0){
						$ad[$key][percent] = round($val[total]/$ad_total*100, 2);
					}else{
						$ad[$key][percent] = 0;
					}
				}
			}
		}
		if($levelData){	
			for($i=0; $i<$max; $i++){
			    foreach($levelData as $key => $row){
					$career = $career_array[$row[career]];
					$country = $country_array[$row[country]];
			        if($row[level]>$i*$level_range && $row[level] <= ($i+1)*$level_range){
			        	$result[$i][$career][$country][num] += $row[levelPlayerCount];
			        	$result[$i][$career][total] += $row[levelPlayerCount];
			        	$result[$i][total] += $row[levelPlayerCount];
						$ld_total += $row[levelPlayerCount];
			        }
			    }
			}
			if($result){			
				foreach($result as $key=>$row){
					foreach($row as $k=>$r){
						if($k !== 'total'){
							foreach($r as $k1=>$r1){
								if($k1 !== "total"){
								    if($r[total] == 0){
								        $result[$key][$k][$k1][percent] = 0;
								    }else{
								        $result[$key][$k][$k1][percent] = round($r1[num]/$r[total]*100, 2);
								    }
								}
							}
							if($row[total] > 0){
								$result[$key][$k][percent] = round($r[total]/$row[total]*100, 2);
							}else{
								$result[$key][$k][percent] = 0;
							}
						}
					}
					if($ld_total > 0){
						$result[$key][percent] = round($row[total]/$ld_total*100, 2);
					}else{
						$result[$key][percent] = 0;
					}
				}
				foreach($result as $key=>$row){
					$t = 0;
					foreach($row as $k=>$r){
				    	$t += $r[total];
					}
					$result[$key][total] = $t;
				}
			}
			if($result){
				foreach($result as $key => $row){
					$showData[$key][zg] = $row[total].'/'.$ld_total.'('.$row[percent].'%)'.'<br/>';
					foreach($row as $k => $r){
						if($k !== 'total' && $k !== 'percent'){
							foreach($r as $k1 => $r1){
								if($k1 !== 'total' && $k1 !== 'percent'){
									$showData[$key][$k] .= $k1.':'.$r1[num].'/'.$r[total].'('.$r1[percent].'%)'.'<br/>';
								}
							}
						}
					}
				}
				$count = count($career_array);
				$c = $count;
				$total_result[99][0] = $lang->player->level;
				$sort[0] = 0; 
				$i = 1;
				foreach($career_array as $key => $row){
					$total_result[99][$i] = $row;
					$sort[$row] = $i;
					$i++;
				}
				$total_result[99][$i] = $lang->player->total;
				$sort[zg] = $count+1; 
				foreach($showData as $key => $row){
					foreach($row as $k => $r){
						$total_result[$key][$sort[$k]] = $r;
					}
					for($a=1;$a<=$count;$a++){
						if(!isset($total_result[$key][$a])){
							$total_result[$key][$a] = '-';
						}
					}
					ksort($total_result[$key]);
				}
			}
		}
	}
}

$smarty->assign('type', $type);
$smarty->assign('lang', $lang);
$smarty->assign('rd', $rd);
$smarty->assign('ad', $ad);
$smarty->assign('c', $c);
$smarty->assign('rd_total', $rd_total);
$smarty->assign('ad_total', $ad_total);
$smarty->assign('ld_total', $ld_total);
$smarty->assign('level_range', $level_range);
$smarty->assign('career_array', $career_array);
$smarty->assign('country_array', $country_array);		
$smarty->assign('total_result', $total_result);
$smarty->display('module/player/player_carrer.tpl');

function getCareerData($sign, $method, $unixTime) {
	$data = array(
		'type'=>3, 
		'country_array' => array(
 			1 => '蜀',
 			2 => '楚', 
			3 => '秦'
		 ),
		'career_array' => array(
			1 => '尚武',
			2 => '逍遥', 
			3 => '流星'
		),
		'level_range' => 10,
		'top_level' => 120,
		'registerData' => array(
			array(
				'career' => 3,
				'country' => 2,
				'registerPlayerCount' => 240
			),
			array(
				'career' => 1,
				'country' => 3,
				'registerPlayerCount' => 300
			),
			array(
				'career' => 2,
				'country' => 1,
				'registerPlayerCount' => 330
			),
			array(
				'career' => 3,
				'country' => 1,
				'registerPlayerCount' => 230
			),
			array(
				'career' => 1,
				'country' => 2,
				'registerPlayerCount' => 270
			),
			array(
				'career' => 2,
				'country' => 3,
				'registerPlayerCount' => 305
			)
		),
		'activityData' => array(
			array( 
				'career' => 2,
				'country' => 3,
				'activityPlayerCount' => 120
			),
			array( 
				'career' => 2,
				'country' => 1,
				'activityPlayerCount' => 100
			),
			array( 
				'career' => 1,
				'country' => 3,
				'activityPlayerCount' => 150
			),
			array( 
				'career' => 1,
				'country' => 2,
				'activityPlayerCount' => 120
			),
			array( 
				'career' => 3,
				'country' => 2,
				'activityPlayerCount' => 130
			),
			array( 
				'career' => 3,
				'country' => 1,
				'activityPlayerCount' => 170
			),
			array( 
				'career' => 3,
				'country' => 3,
				'activityPlayerCount' => 140
			)
		),
		'levelData' => array(
			array( 
				'career' => 1,
				'country' => 3,
				'level' => 9,
				'levelPlayerCount' => 12
			),
			array( 
				'career' => 2,
				'country' => 2,
				'level' => 15,
				'levelPlayerCount' => 15
			),
			array( 
				'career' => 1,
				'country' => 2,
				'level' => 25,
				'levelPlayerCount' => 14
			),
			array( 
				'career' => 2,
				'country' => 3,
				'level' => 38,
				'levelPlayerCount' => 13
			),
			array( 
				'career' => 2,
				'country' => 1,
				'level' => 48,
				'levelPlayerCount' => 36
			),
			array( 
				'career' => 3,
				'country' => 3,
				'level' => 55,
				'levelPlayerCount' => 23
			),
			array( 
				'career' => 3,
				'country' => 2,
				'level' => 62,
				'levelPlayerCount' => 15
			),
			array( 
				'career' => 2,
				'country' => 2,
				'level' => 67,
				'levelPlayerCount' => 18
			),
			array( 
				'career' => 3,
				'country' => 1,
				'level' => 75,
				'levelPlayerCount' => 26
			),
			array( 
				'career' => 3,
				'country' => 3,
				'level' => 85,
				'levelPlayerCount' => 16
			),
			array( 
				'career' => 1,
				'country' => 2,
				'level' => 91,
				'levelPlayerCount' => 12
			),
			array( 
				'career' => 1,
				'country' => 1,
				'level' => 95,
				'levelPlayerCount' => 11
			),
			array( 
				'career' => 2,
				'country' => 2,
				'level' => 111,
				'levelPlayerCount' => 21
			),
			array( 
				'career' => 1,
				'country' => 2,
				'level' => 113,
				'levelPlayerCount' => 11
			),
			array( 
				'career' => 3,
				'country' => 2,
				'level' => 116,
				'levelPlayerCount' => 3
			)
		)
	);
	return json_encode($data);
}