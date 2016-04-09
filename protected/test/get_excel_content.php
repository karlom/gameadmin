<?php
    require_once( '../config/config.php' );
    error_reporting(E_ALL ^ E_NOTICE);
    
     $arr = array(
        array(
            'filename'=>'Item.csv',
            'outfile'=>'item.php',
            'arrayName'=>'dictItem',
            'startRow'=>3,
            'field'=>array(
                0 => 'id',
                1 => 'name',
            ),
        ),
        array(
            'filename'=>'Gem.csv',
            'outfile'=>'gem.php',
            'arrayName'=>'dictGem',
            'startRow'=>3,
            'field'=>array(
                0 => 'id',
                1 => 'name',
                9 => 'holeType',
            ),
        ),
        array(
            'filename'=>'Equip.csv',
            'outfile'=>'equipConfig.php',
            'arrayName'=>'equipConfig',
            'startRow'=>3,
            'field'=>array(
                0 => 'id',
                1 => 'name',
                21 => 'maxStrengthenLv',
                22 => 'gemHole',
            ),
        ),
        array(
            'filename'=>'Task.csv',
            'outfile'=>'task.php',
            'arrayName'=>'dictTask',
            'startRow'=>3,
            'endID'=>10000,
            'field'=>array(
                0 => 'id',
                3 => 'name',
                7 => 'type',
            ),
        ),
        array(
            'filename'=>'HuoYue.csv',
            'outfile'=>'huoyue.php',
            'arrayName'=>'dictHuoyue',
            'startRow'=>3,
            'field'=>array(
                0 => 'id',
                1 => 'key',
                2 => 'name',
                3 => 'count',
                4 => 'huoyuedu',
            ),
        ),
    );
   foreach ($arr as &$conf){
   	   $strResult = '';
	   if (!file_exists($conf['filename'])) {
			echo "错误! 文件{$conf['filename']}不存在!\n";
			continue;
	   }
	   $tmpcsv = 'tmp.csv';
	   if(file_exists($tmpcsv)){
	   	unlink($tmpcsv);
	   }
	   exec("iconv -f gbk -t utf8  {$conf['filename']} > {$tmpcsv}");
       $fp = @fopen($tmpcsv,'r');
       if (!$fp) {
       		echo "无法打开临时文件{$tmpcsv}\n";
       }
       $rowIndex = 0;
       while ($row=fgetcsv($fp)) {
       		if ($rowIndex >= $conf['startRow']) {
	       		$strRowTmp = '';
	       		$id = '';
	       		foreach ($row as $colIndex => $val) {
	       			if( $conf['endID'] && $val >= $conf['endID'] )
	       				break;
	       			foreach ($conf['field'] as $fieldIndex => $fieldName) {
	       				$fieldName = trim($fieldName);
	       				if ($colIndex == $fieldIndex) {
	       					$strRowTmp .= "'{$fieldName}' => '{$val}', ";
	       					if ('id' == $fieldName ) {
		       					$id = $val;
		       				}
	       				}
	       			}
	       		}
	       		if ($id && $strRowTmp) {
	       			$strResult .= "\t{$id} => array({$strRowTmp}),\n";
	       		}
       		}
       		$rowIndex++;
       }
       fclose($fp);
       $strResult = "<?php\n \${$conf['arrayName']}=array(\n{$strResult});";
       file_put_contents(SYSDIR_ADMIN_DICT.'/'.$conf['outfile'],$strResult);
//       file_put_contents($conf['outfile'],$strResult);
   }
