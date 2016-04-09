<?php
    require_once( '../config/config.php' );
    error_reporting(E_ALL ^ E_NOTICE);
    include_once SYSDIR_ADMIN_DICT.'/equipConfig.php';
    include_once SYSDIR_ADMIN_DICT.'/gem.php';
    include_once SYSDIR_ADMIN_DICT.'/item.php';
    
   $arrItemsAll =  array_merge($dictItem,$equipConfig,$dictGem);
   if( count($arrItemsAll)>0 && is_array($arrItemsAll)){
       foreach($arrItemsAll as $key => $row){
            $arrAll[$row['id']] = $row;
        }
   }
    $file = SYSDIR_ADMIN_DICT.'/arrItemsAll.php';
    $str=<<<PHPSTR
<?php
//注意！或不清楚以下各变量的配置规则及用途，请不要随便动。
\$arrItemsAll = 
PHPSTR;
    $str .= var_export($arrAll,true).';';
     file_put_contents($file, $str);
   
   $str = "";
   $arrAll = array();
   if( count($arrItemsAll)>0 && is_array($arrItemsAll)){
       foreach($arrItemsAll as $key => $row){
           $row['item_name'] = $row['name'];
           $row['big_type'] = 0;
           $row['small_type'] = 0;
           $id = $row['id'];
           unset($row['id']);
           unset($row['name']);
           $arrAll[$id] = $row;
        }
   }
    $file = SYSDIR_ADMIN_DICT.'/item_list_dict.php';
    $str=<<<PHPSTR
<?php
//注意！或不清楚以下各变量的配置规则及用途，请不要随便动。
\$ITEM_LIST = 
PHPSTR;
    $str .= var_export($arrAll,true).';';
     file_put_contents($file, $str);
    