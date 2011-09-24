<?php
session_start();
class checkImage {

	private $config;
	private $im;
	private $str;

	function __construct() {
		$this->config['width']      = 50;
		$this->config['height']     = 20;
		$this->config['vcode']      = "vcode";
		$this->config['type']       = "default";
		$this->config['length']     = 4;
		$this->config['interfere']  = 10;
		$this->str['default']       = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		$this->str['string']        = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$this->str['int']           = "0123456789";
	}

	public function init($config=array()){
		if (!empty($config) && is_array($config)){
			foreach($config as $key=>$value){
				$this->config[$key] =   $value;
			}
		}
	}

	public function create(){
		if (!function_exists("imagecreate")){
			return false;
		}
		$this->createImage();
	}

	private function createImage(){
		$this->im   =   imagecreate($this->config['width'],$this->config['height']);
		imagecolorallocate($this->im, 255, 255, 255);

		$bordercolor=   imagecolorallocate($this->im,0,0,0);
		imagerectangle($this->im,0,0,$this->config['width']-1,$this->config['height']-1,$bordercolor);

		$this->createStr();
		$vcode  =   $_SESSION[$this->config['vcode']];
		$fontcolor  =   imagecolorallocate($this->im,46,46,46);
		for($i=0;$i<$this->config['length'];$i++){
			imagestring($this->im,5,$i*10+6,rand(2,5),$vcode[$i],$fontcolor);
		}

		$interfere  =   $this->config['interfere'];
		$interfere  =   $interfere>30?"30":$interfere;
		if (!empty($interfere) && $interfere>1){
			for($i=1;$i<$interfere;$i++){
				$linecolor  =   imagecolorallocate($this->im,rand(0,255),rand(0,255),rand(0,255));
				$x  =   rand(1,$this->config['width']);
				$y  =   rand(1,$this->config['height']);
				$x2 =   rand($x-10,$x+10);
				$y2 =   rand($y-10,$y+10);
				imageline($this->im,$x,$y,$x2,$y2,$linecolor);
			}
		}
		header("Pragma:no-cachern");
		header("Cache-Control:no-cachern");
		header("Expires:0rn");
		header("content-type:image/jpegrn");
		imagejpeg($this->im);
		imagedestroy($this->im);
		exit;
	}

	private function createStr(){
		if ($this->config['type']=="int"){
			for($i=1;$i<=$this->config['length'];$i++){
				$vcode  .=  rand(0,9);
			}
			$_SESSION[$this->config['vcode']] = $vcode;
			return true;
		}
		$len    =   strlen($this->str[$this->config['type']]);
		if (!$len){
			$this->config['type'] = "default";
			$this->create_str();
		}
		for($i=1;$i<=$this->config['length'];$i++){
			$offset  =  rand(0,$len-1);
			$vcode  .=  substr($this->str[$this->config['type']],$offset,1);
		}
		$_SESSION[$this->config['vcode']] = $vcode;
		return true;
	}

}

$v = new checkImage();
$config['width']  =   60;         //验证码宽
$config['height'] =   20;         //验证码高
$config['vcode']  =   'admin_checkcode';    //检查验证码时用的SESSION
$config['type']   =   'default';  //验证码展示的类型default:大写字母,string:小写字母,int:数字
$config['length'] =   4;          //验证码长度
$config['interfere']= 15;         //干扰线强度,范围为1-30,0或空为不起用干扰线
$v->init($config);    //配置
$v->create();

?> 
