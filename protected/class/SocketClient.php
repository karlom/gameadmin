<?php
class SocketClient {
	private $host = ''; // 通信地址
    private $port = ''; // 通信端口
	private $socket = null ;
	
	public function __construct($serverip='', $port='')
	{
		if('' == $serverip || '' == $port){
			$serverID = substr($_SESSION['gameAdminServer'],1);
			
//			$sql = "select * from ".T_SOCKET_INI." order by id desc";
			if($serverID){
				$sql = "select * from ".T_SERVER_CONFIG." where id=".$serverID." order by id desc";
			} else {
				$sql = "select * from ".T_SERVER_CONFIG." order by id desc";
			}
			
//			$result = AFetchRowOne($sql);
			$result = IFetchRowOne($sql);
//			print_r($result);die();
			
			if($result['ip'] && $result['port']){
//				$this->host = $result['serverip'];
				$this->host = $result['ip'];
				$this->port = $result['port'];
			}else{
				echo "获取Socket Host和Port出错";
				exit();
			}
		}else{
			$this->host = $serverip;
			$this->port = $port;
		}
	}
	
	/**
	 * 发起socket请求
	 *
	 * @param string $action
	 * @param array $data
	 * @return array
	 */
	public function rpc($data)
	{
		if('' == $this->host && '' == $this->port){
			return array('result'=>10005,'errorMsg'=>'获取游戏接口配置错误'); 
		}
		$this->socket = @socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
		if (!$this->socket) { 
			socket_close($this->socket); //关闭socket
			unset($this->socket); //释放资源
			return array('result'=>10001,'errorMsg'=>'创建socket客户端资源失败'); 
		}
		$connect = @socket_connect($this->socket,$this->host, $this->port);
		if (!$connect) { 
			socket_close($this->socket); //关闭socket
			unset($this->socket); //释放资源
			return array('result'=>10002,'errorMsg'=>'连接游戏服务器失败'); 
		}
		
		$strJson = decodeUnicode(json_encode($data));	//中文字符处理
		$binStrLength = $this->decToBinStr( strlen($strJson) );
		
		$str = $binStrLength.$strJson;
		$write = @socket_write($this->socket,$str);
		if (false===$write) { 
			socket_close($this->socket); //关闭socket
			unset($this->socket); //释放资源
			return array('result'=>10003,'errorMsg'=>'发送消息到游戏服务器失败'); 
		}
		
		
		$returnDataLen = $this->binStrToDec($this->read(4)); //包头4个字节，记录返回的json数据长度
		
		$returnData = $this->read($returnDataLen);	//读完4个字节的长度数据，接着按长度读取返回的json数据。

		//处理不可见特殊字符
		include_once(SYSDIR_ADMIN_DICT . '/dictChar.php');
		if(!empty($dictChar)){
			foreach($dictChar as $v) {
				$returnData = str_replace($v,'??', $returnData);
			}
		}

		$serverRet = json_decode($returnData,true);//返回的Json数据格式为：[ { “result” : “1” }]

		if(!is_array($serverRet) || !array_key_exists('result',$serverRet) ){
			socket_close($this->socket); //关闭socket
			unset($this->socket); //释放资源
			return array('result'=>10004,'errorMsg'=>'服务器返回数据格式不正确');
		}
		socket_close($this->socket); //关闭socket
		unset($this->socket); //释放资源
		return $serverRet;
	}
	
	/**
	 * 读取socket服务端返回的数据
	 *
	 * @param int $length
	 * @return string
	 */
	
	private function read($length)
	{
		$data = '';
		$i = 0;
		while($i < $length){
			$result = @socket_read($this->socket,1,PHP_NORMAL_READ);
			$data .= $result;
			$i++;
		}
		return $data;
	}
	/**/
	/**
	 * 把二进制转换为十进制
	 *
	 * @param binary $binStr
	 * @return int
	 */
	/*
	private function binStrToDec($binStr){
		$len = strlen($binStr);
		$str = '';
		for($i=0;$i<$len;$i++){
			$str .= str_pad(decbin(ord($binStr[$i])),8,'0',STR_PAD_LEFT);
		}
		$rs = bindec($str);
		return $rs;
	}
	*/
	private function binStrToDec($binStr){
		// 从二进制转换成十进制（32bit signed short）
		$array = unpack("l",$binStr);	//unpack出来的是数组
		return $array[1];
	}
	/**
	 * 十进制转换为二进制
	 *
	 * @param int $num
	 * @param int $byte 转换后所占字节数
	 * @return binary string
	 */
	/*
	private function decToBinStr($num,$byte=4)
	{
		$strBin = decbin($num);
		$strBin = str_pad($strBin,$byte*8,'0',STR_PAD_LEFT);
		$str = '';
		while ($strBin) {
			$str .= chr(bindec(substr($strBin,0,8)));
			$strBin = substr($strBin,8);
		}
		return $str;
	}
	*/
	private function decToBinStr($num) {
		//转成2字节的二进制串（32bit signed short）
		return pack("l",$num);
	}
}
