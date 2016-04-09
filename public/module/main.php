<?php 
include_once '../../protected/config/config.php';
include_once SYSDIR_ADMIN_INCLUDE."/global.php";
global $lang, $serverList;

$mysqlver = IFetchRowOne('SELECT VERSION() as ver');
$mysqlversion = $mysqlver[ver];
$dbsize = 0;
$tables = IFetchRowSet("SHOW TABLE STATUS LIKE 't_%'");
foreach($tables as $table) {
             $dbsize += $table['Data_length'] + $table['Index_length'];
         }
$dbsize = $dbsize ? sizecount($dbsize):"unknow";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>game管理后台</title>
<link rel="stylesheet" type="text/css" href="/static/css/base.css" />
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<base target="_self" />
<style type="text/css">
<!--
.STYLE1 {color: #333333}
.STYLE2 {
	color: #FFFFFF;
	font-weight: bold;
}
table.sortable tr:hover{
	background:#F5F5DC;
	border:#f00;
}
-->
</style>

</head>
<body leftmargin="8" topmargin='8' style="background:#e9eef5;">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse">
 
  <tr>
    <td width="100%" height="20">
	  <br/>
	<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#7AB5E0">
        <tr bgcolor="#E5F9FF">
          <td colspan="2" background="/static/images/mtbg2.gif"><font color="#FFFFFF" class="STYLE2"><b><?php echo $lang->sys->baseInfo?></b></font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td rowspan="1"><?php echo $lang->sys->systemAndPhp?>：</td>
          <td> Linux/PHP
            <?php echo @phpversion();?>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td rowspan="1"><?php echo $lang->sys->httpServer?>：</td>
          <td> 
             <?php echo $_SERVER['SERVER_SOFTWARE'];?>
          </td>
        </tr>  
        <tr bgcolor="#FFFFFF">
          <td rowspan="1"><?php echo $lang->sys->mysqlVersion?>：</td>
          <td> 
             <?php echo $mysqlversion;?>
          </td>
        </tr>   
        <tr bgcolor="#FFFFFF">
          <td rowspan="1"><?php echo $lang->sys->dbSize?>：</td>
          <td> 
             <?php echo $dbsize;?>
          </td>
        </tr> 
        <tr bgcolor="#FFFFFF">
          <td>
          	<?php echo $lang->sys->ifSaveMode?>：
          </td>
          <td>
          <font color='red'><?php echo ($isSafeMode ? 'Yes' : 'No')?></font>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>Register_Globals：</td>
          <td><font color='red'>
            <?php echo ini_get("register_globals") ? 'On' : 'Off'?>
            </font> &nbsp; 
          </td>
          </tr>
          <tr bgcolor="#FFFFFF">
          <td>Magic_Quotes_Gpc：</td>
          <td><font color='red'>
            <?php echo ini_get("magic_quotes_gpc") ? 'On' : 'Off'?>
            </font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td><?php echo $lang->sys->maxUploadFile?>：</td>
          <td>
            <?php echo ini_get("post_max_size")?>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td><?php echo $lang->sys->ifAllowRemoteConnect?>：</td>
          <td>
            <?php echo ini_get("allow_url_fopen") ? $lang->sys->support : $lang->sys->unsupport?>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td><?php echo $lang->sys->versionInfo?>：</td>
          <td>
          	<?php echo CFG_VERSION?>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="25%"><?php echo $lang->sys->devTeam?>：</td>
          <td width="75%"><?php echo $lang->sys->devTeamYWKF?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="25%"><?php echo $lang->sys->logDBInfo?>：</td>
          <td width="75%">
          	<ul id="logdbinfo">
			<?php 
				$html = '';
				foreach ($serverList as $key => $server)
				{
					$dbInfo = getDBInfo($server['ip'], $server['dbuser'], $server['dbpwd'], $server['dbname']) ;//dump($dbInfo);
					$html .=<<<HTML
					<li class=""><a href="#" style="font-weight:bold;font-size:110%;">$key: 
					{$lang->sys->logDBName}: {$dbInfo['dbname']} 
					{$lang->sys->logDBSize}: {$dbInfo['dbsize']} 
					</a>
					<table class="sortable" width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse; display:none;">
					<tr>
						<th>{$lang->sys->logTableName}</th>
						<th>{$lang->sys->logTableSize}</th>
						<th>{$lang->sys->logTableCharset}</th>
						<th>{$lang->sys->logTableComment}</th>
HTML;
					foreach( $dbInfo['tables'] as $table )
					{
						$tableSize = $table['Data_length'] + $table['Index_length'];
						$tableSizeText = sizecount( $tableSize );
						$html .=<<<HTML
						<tr>
							<td>{$table['Name']}</td>
							<td align="center" sorttable_customkey="$tableSize">$tableSizeText</td>
							<td align="center">{$table['Collation']}</td>
							<td>{$table['Comment']}</td>
						</tr>
HTML;
					}
					$html .= "</table></li>";
				}
				echo $html;
			?>
			</ul>
		  </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td width="100%" height="2" valign="top"></td>
  </tr>
</table>
<p align="center">
<?php echo CFG_POWERBY;?>
<br/><br/>
</p>
</body>
<script type="text/javascript">
window.onload = function(){
	var g = function(i){return document.getElementById(i);}
	var dbList = g('logdbinfo').children;
	for( i = 0; i < dbList.length; i++ ){
		var obj = dbList[i].getElementsByTagName('a')[0];
		obj.onclick = function(e){
			e.preventDefault();
			var parent = this.parentNode;
			var tableList = parent.getElementsByTagName('table')[0];
			if( tableList.style.display == 'none' ){
				tableList.style.display = '';
				parent.style.border = '1px solid red';
				parent.style.padding = '5px';
			}else{
				tableList.style.display = 'none';
				parent.style.border = 'none';
				parent.style.padding = '0';
			}
			return false;
		}
	}
}
</script>
</html>