var showIP = function( location ){
	alert(location.ip + '\n' + location.addr );
}

var queryIP = function(ip, callback){

	$.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip='+ip, 
		function(){
			if(remote_ip_info['ret'] == 1) {
				alert("ip: "+ip+"\n所属城市："+remote_ip_info['country']+remote_ip_info['province']+remote_ip_info['city']+"\n运营商："+remote_ip_info['isp']);
			} else if (remote_ip_info['ret'] == -1) {
				alert("ip: "+remote_ip_info['ip']+"\n保留地址");
			}	
		});

}
 
