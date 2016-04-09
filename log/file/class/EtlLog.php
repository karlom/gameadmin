<?php
class EtlLog {
	
	/**
	 * 对服务端同步过来的日志进行抽取转换载入的处理结果记录
	 *
	 * @param string $logFile
	 * @param int $seccess
	 * @param string $errMsg
	 */
	public static function replaceEtlLog($logFile,$seccess,$errMsg){
		$update_time = time();
		$sql = " REPLACE INTO ".T_LOG_ETL." (`log_file`,`seccess`,`err_msg`,`update_time`) values('{$logFile}',{$seccess},'{$errMsg}',{$update_time}) ";
		IQuery($sql);
	}
	
	/**
	 * 查询某个日志文件的处理情况
	 *
	 * @param string $fileName
	 * @return array
	 */
	public static function getEtlLogByFileName($fileName) {
		$sqlLogEtl = " SELECT * FROM ".T_LOG_ETL ." WHERE `log_file`='{$fileName}' " ;
		return IFetchRowOne($sqlLogEtl);
	}
	
}
