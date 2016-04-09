/** 
 * @fileoverview MValidate.js文件定义WEB界面表单基本通用的JavaScript脚本验证功能
 * @version 0.1 
 * @author 曹春城 <br />
 * CopyRight www..com 2010
 */


/**
 * @class JavaScript表单基本验证类。<br />
 * 此类功能包括：<br />
 * 1.手机号码有效性验证<br />
 * 2.数字有效性验证<br />
 * 3.字符有效性验证<br />
 * 4.非空有效性验证<br />
 * 5.日期有效性验证<br />
 * 6.Email地址有效性验证<br />
 * 7.URL有效性验证<br />
 * 8.字符转义<br />
 * 9.IP地址有效性验证<br />
 * @constructor 构造函数
 * @throws MemoryException 如果没有足够的内存
 * @return 返回 MValidateClass 对象
 */
function MValidateClass(){
	/**
	 * @ignore
	 * 全局变量定义
	 */
	 
	/**
	 * 全局变量，系统特殊字符定义。
	 * JS_GLOBAL_VALIDATE_SPCH='<>"&'
	 * @return 返回特殊字符
	 * @type String
	 */
	this.JS_GLOBAL_VALIDATE_SPCH = function(){
		return '<>"&';
	}
	
	
	/**
	 * @ignore
	 * 手机号码有效性验证
	 */
	
	/**
	 * 基本的检验手机号码的有效性。
	 * 即:
	 * 手机号码是11位的数字，
	 * 手机号码是12位的数字，并第一位是0开头
	 * 
	 * @param mobile String 手机号码 参数必须 是
	 * @return 合法返回true，非法返回false
	 * @type boolean
	 */
	this.isMobile = function(mobile){
		if(mobile == '' || mobile == null || mobile == undefined){
			return false;
		}
		var mReg =/(^[0-9]{11}$)|(^0[0-9]{11}$)/;  
	    if (mReg.test( mobile)) {  
	      return true;  
	    }  
	    return false;  
	}
	/**
	 * 判断手机号码，即： <br />
	 * 一、移动电话号码为11或12位，如果为12位,那么第一位为0 <br /> 
	 * 二、11位移动电话号码的第一位和第二位为"13","15"  <br />
	 * 三、12位移动电话号码的第二位和第三位为"13","15" <br />
	 * @param mobile String 手机号码 参数必须 是
	 * @return 合法返回true，非法返回false
	 * @type boolean
	 */
	this.isMobileZh = function(mobile){
		if(mobile == '' || mobile == null || mobile == undefined){
			return false;
		}
		var mReg =/(^[1][3][0-9]{9}$)|(^0[1][3][0-9]{9}$)|(^[1][5][0-9]{9}$)|(^0[1][5][0-9]{9}$)/;  
	    if (mReg.test( mobile)) {  
	      return true;  
	    }  
	    return false; 
	}
	/**
	 * 验证输入的手机号码是否在指定的号码段中
	 * 这里使用的验证范围比较逻辑是：
	 * beginNumber <= mobile <= endNumber
	 * 这里判断的手机号码都必须是经过isMobile(mobile)函数验证通过的手机号码
	 * @see #isMobile
	 * @param mobile  String 手机号码 参数必须 是
	 * @param beginNumber String 开始手机号码 参数必须 是
	 * @param endNumber String 结束手机号码 参数必须 是
	 * @return 合法返回true，非法返回false
	 * @type boolean
	 */
	this.checkMobileRange = function(mobile,beginNumber,endNumber){
		if(!(this.isMobile(mobile) && this.isMobile(beginNumber) && this.isMobile(endNumber)) ){
			return false;
		}
		if(mobile.substring(0,1) == '0'){
			mobile = mobile.substring(1,mobile.length);
		}
		if(beginNumber.substring(0,1) == '0'){
			beginNumber = beginNumber.substring(1,beginNumber.length);
		}
		if(mobile.substring(0,1) == '0'){
			endNumber = endNumber.substring(1,endNumber.length);
		}
		var m = new Number(mobile);
		var b = new Number(beginNumber);
		var e = new Number(endNumber);
		
		if(m >= b && m <= e){
			return true;
		}
		return false;
	}
	/**
	 * 根据传转入的手机号码和指定的手机号码合法长度来验证。
	 * 手机号码长度默认长度是的11位
	 * @param mobile String 手机号码 参数必须 是
	 * @param len int 长度 默认是11 参数必须 否
	 * @return 合法返回true，非法返回false
	 * @type boolean
	 */
	this.checkMobileLength = function(mobile,len){
		if(mobile == '' || mobile == null || mobile == undefined){
			return false;
		}
		if(mobile.length != len){
			return false;
		}
		var i = 0;
		for(i = 0; i < mobile.length; i++){
			var ch = mobile.charAt(i);
			if (ch < '0' || ch > '9') return false;
		}
		return true;
	}
	/**
	 * 验证手机号码是否是属于那一个国家的。
	 * 传入的手机号码必须带有国家编码，否则验证结果不是正确的。
	 * 手机号码必须是 +8613800138000或是8613800138000的形式
	 * 国家编码是：86（中国代码），852（中国香港）
	 * @param mobile String 手机号码 参数必须 是
	 * @param countryCode String 国家编码 参数必须 是
	 * @return 合法返回true，非法返回false
	 * @type boolean
	 */
	this.checkMobileCountry = function(mobile,countryCode){
		if(mobile == '' || mobile == null || mobile == undefined){
			return false;
		}
		if(countryCode == '' || countryCode == null || countryCode == undefined){
			return false;
		}
		var i = 0;
		for(i = 0; i < mobile.length; i++){
			var ch = mobile.charAt(i);
			if ((ch < '0' || ch > '9') && !(ch == '+' && i == 0)){
				 return false;
			}
		}
		for(i = 0; i < countryCode.length; i++){
			var ch = countryCode.charAt(i);
			if ((ch < '0' || ch > '9') && !(ch == '+' && i == 0)){
				 return false;
			}
		}
		if(mobile.indexOf("+") != -1){
			mobile = mobile.substring(1,mobile.length);
		}
		if(countryCode.indexOf("+") != -1){
			countryCode = countryCode.substring(1,countryCode.length);
		}
		
		
		var flag = mobile.indexOf(countryCode);
		if(flag == 0){
			return true;
		}
		return false;
	}
	/**
	 * 验证手机号码是的前缀数据是否合法。
	 * 即根据传入的前缀数据验证手机号码是不是以此前缀开头的。
	 * 这里判断的手机号码都必须是经过isMobile(mobile)函数验证通过的手机号码
	 * @see #isMobile
	 * @param mobile String 手机号码 参数必须 是
	 * @param preStr String 匹配前缀 参数必须 是
	 * @return 合法返回true，非法返回false
	 * @type boolean
	 */
	this.checkMobilePrefix = function(mobile,preStr){
		if(!(this.isMobile(mobile))){
			return false;
		}
		if(preStr == '' || preStr == null || preStr == undefined){
			return false;
		}
		var i = mobile.indexOf(preStr);
		if(i == 0){
			return true;
		}
		return false;
	}
	/**
	 * 验证手机号码是的后缀数据是否合法。
	 * 即根据传入的后缀数据验证手机号码是不是以此前缀开头的。
	 * 这里判断的手机号码都必须是经过isMobile(mobile)函数验证通过的手机号码
	 * @see #isMobile
	 * @param mobile String 手机号码 参数必须 是
	 * @param preStr String 匹配后缀 参数必须 是
	 * @return 合法返回true，非法返回false
	 * @type boolean
	 */
	this.checkMobileSuffix = function(mobile,sufStr){
		if(!(this.isMobile(mobile))){
			return false;
		}
		if(sufStr == '' || sufStr == null || sufStr == undefined){
			return false;
		}
		var i = mobile.lastIndexOf(sufStr);
		if((i + sufStr.length) == mobile.length){
			return true;
		}
		return false;
	}
	
	
	/**
	 * @ignore
	 * 数字有效性验证
	 */
	 
	 /**
	  * 验证是否是整数
	  * @param num int 整数 参数必须 是
	  * @return 合法返回true，非法返回false
	  * @type boolean
	  */
	 this.isNumeric = function(num){
	 	if (num === ""){
	 		return false;
	 	}
	 	var numberReg = /^[+-]?([1-9]\d*|[0])$/;
	 	if(!numberReg.test(num)){
	 		return false;
	 	}
		return true;
	 }
	 /**
	  * 验证是否是正整数 不包括零
	  * @param num int 整数 参数必须 是
	  * @return 合法返回true，非法返回false
	  * @type boolean
	  */
	 this.isPNumeric = function(num){
		if (num === ""){
	 		return false;
	 	}
	 	var numberReg = /^[+]?([1-9]\d*)$/;
	 	if(!numberReg.test(num)){
	 		return false;
	 	}
		return true;
	 }
	 /**
	  * 验证是否是负整数 不包括零
	  * @param num int 整数 参数必须 是
	  * @return 合法返回true，非法返回false
	  * @type boolean
	  */
	 this.isNNumeric = function(num){
		if (num === ""){
	 		return false;
	 	}
	 	var numberReg = /^[-]([1-9]\d*)$/;
	 	if(!numberReg.test(num)){
	 		return false;
	 	}
		return true;
	 }
	 /**
	  * 验证是否是非正整数 即负整数和零
	  * @param num int 整数 参数必须 是
	  * @return 合法返回true，非法返回false
	  * @type boolean
	  */
	 this.isNotPNumeric = function(num){
		if (num === ""){
	 		return false;
	 	}
	 	var numberReg = /^([-]([1-9]\d*))|([0])$/;
	 	if(!numberReg.test(num)){
	 		return false;
	 	}
		return true;
	 }
	 /**
	  * 验证是否是非负整数 即正整数和零
	  * @param num int 整数 参数必须 是
	  * @return 合法返回true，非法返回false
	  * @type boolean
	  */
	 this.isNotNNumeric = function(num){
		if (num === ""){
	 		return false;
	 	}
	 	var numberReg = /^[+]?([1-9]\d*|[0])$/;
	 	if(!numberReg.test(num)){
	 		return false;
	 	}
		return true;
	 }
	 /**
	  * 验证是否是浮点数
	  * @param dec float 浮点数 参数必须 是
	  * @return 合法返回true，非法返回false
	  * @type boolean
	  */
	 this.isDecimal = function(dec){
	 	if (dec === ""){
	 		return false;
	 	}
		var decimalReg = /^[+-]?([1-9]\d*|[1-9]\d*[.]\d*|0[.]\d*[1-9]\d*|0?[.]0+|0)$/;
	 	if(!decimalReg.test(dec)){
	 		return false;
	 	}
		return true;
	 }
	 /**
	  * 验证是否是正浮点数 不包括零
	  * @param dec float 浮点数 参数必须 是
	  * @return 合法返回true，非法返回false
	  * @type boolean
	  */
	 this.isPDecimal = function(dec){
	 	if (dec === ""){
	 		return false;
	 	}
		var decimalReg = /^[+]?([1-9]\d*|[1-9]\d*[.]\d*|0[.]\d*[1-9]\d*)$/;
	 	if(!decimalReg.test(dec)){
	 		return false;
	 	}
		return true;
	 }
	 /**
	  * 验证是否是负浮点数 不包括零
	  * @param dec float 浮点数 参数必须 是
	  * @return 合法返回true，非法返回false
	  * @type boolean
	  */
	 this.isNDecimal = function(dec){
	 	if (dec === ""){
	 		return false;
	 	}
		var decimalReg = /^[-]([1-9]\d*|[1-9]\d*[.]\d*|0[.]\d*[1-9]\d*)$/;
	 	if(!decimalReg.test(dec)){
	 		return false;
	 	}
		return true;
	 }
	 	 /**
	  * 验证是否是非正浮点数 即负浮点数和零
	  * @param dec float 浮点数 参数必须 是
	  * @return 合法返回true，非法返回false
	  * @type boolean
	  */
	 this.isNotPDecimal = function(dec){
	 	if (dec === ""){
	 		return false;
	 	}
		var decimalReg = /^([-]([1-9]\d*|[1-9]\d*[.]\d*|0[.]\d*[1-9]\d*))|([0])$/;
	 	if(!decimalReg.test(dec)){
	 		return false;
	 	}
		return true;
	 }
	 /**
	  * 验证是否是非负浮点数 即正浮点数和零
	  * @param dec float 浮点数 参数必须 是
	  * @return 合法返回true，非法返回false
	  * @type boolean
	  */
	 this.isNotNDecimal = function(dec){
	 	if (dec === ""){
	 		return false;
	 	}
		var decimalReg = /^[+]?([1-9]\d*|[1-9]\d*[.]\d*|0[.]\d*[1-9]\d*|[0])$/;
	 	if(!decimalReg.test(dec)){
	 		return false;
	 	}
		return true;
	 }
	 /**
	  * 判断小数的位数 即数字的小数位小于等于places返回true，否则返回false
	  * @param number int或float 数字 参数必须 是
	  * @param places int 小数位数 参数必须 是
	  * @return 合法返回true，非法返回false
	  * @type boolean
	  */
	 this.isDecimalFormat = function(number,places){
	 	if (number === "") return false;
	 	if(!this.isDecimal(number)){
	 		return false;
	 	}
	 	if(number.indexOf("-") != -1 || number.indexOf("+") != -1 ){
	 		number = number.substring(1,number.length);
	 	}
		var i;
		var numOfPeriod=0;
		var numOfDecimalPlaces=0;
		for(i = 0; i < number.length; i++){
			var ch = number.charAt(i);
			if (ch=='.') numOfPeriod++;
			if (numOfPeriod>1) return false;
			if ((ch < '0' || ch > '9') && (ch !='.')) return false;
			if (numOfPeriod==1 && (ch >= '0' && ch <= '9')) numOfDecimalPlaces++;
			if (numOfDecimalPlaces > places) return false;
		}
		return true;
	 }
	 /**
	  * 判断一个数字是否某一个范围的数
	  * 即：beginNumber <= number <= endNumber
	  * 如下：1<= 1 <= 3 返回true，2.56 <= 3 <= 4.44 返回true
	  * @param number int或float 数字 参数必须 是
	  * @param beginNumber int或float 开始数字 参数必须 是
	  * @param endNumber int或float 结束数 参数必须 是
	  * @return 合法返回true，非法返回false
	  * @type boolean
	  */
	 this.betweenNumber = function(number,beginNumber,endNumber){
	 	if(!(this.isDecimal(number) && this.isDecimal(beginNumber) 
	 		&& this.isDecimal(endNumber))){
	 		return false;
	 	}
	 	var num = new Number(number);
	 	var begin = new Number(beginNumber);
	 	var end = new Number(endNumber);
	 	if(!(num >= begin && num <= end)){
	 			return false;
	 	}
	 	return true;
	 }
	 /**
	  * 获取最小的整数，则返回－2^31 = -2147483648
	  * @return 返回最小整数
	  * @type int
	  */
	 this.getNumericMix = function(){
	 	return -2147483648;
	 }
	 /**
	  * 获取最大的整数，则返回2^31－1 = 2147483647
	  * @return 返回最大整数
	  * @type int
	  */
	 this.getNumericMax = function(){
	 	return 2147483647;
	 }
	 /**
	  * 获取最小的浮点数，返回Number.MIN_VALUE （IE4）
	  * @return 返回最小浮点数
	  * @type float
	  */
	 this.getDecimalMix = function(){
	 	return Number.MIN_VALUE;
	 }
	 /**
	  * 获取最大的浮点数，返回Number.MAX_VALUE （IE4）
	  * @return 返回最大浮点数
	  * @type float
	  */
	 this.getDecimalMax = function(){
	 	return Number.MAX_VALUE;
	 }
	 /**
	  * 格式化数字输出，即23456.856通过格式化之后输出23,456.856。
	  * 使用此函数必须保存参数的有效性。
	  * 参数pattern的规则定义如下：<br />
	  * '' 空值表示不格式化 <br />
	  * #,### 表示只格式化整数部分，如果有小数，则去除小数部分的数，按四舍五入计算小数进位到整数 <br />
	  * 
	  * #,###.000# 表示整数部分按每三位数用逗号分隔，小数取四位，如果没有第二或第三位小数，则相应补零，
	  * 如果没有第四位小数，则不补零，如果有第五位小数，则按四舍五入计算第四位小数的值 <br />
	  * 
	  * #,###.00 表示整数部分按每三位数用逗号分隔，小数取二位，如果没有第二位小数，则补零，
	  * 如果有第三个小数，则按四舍五入计算第二位的值 <br />
	  * 
	  * #,###.0# 表示整数部分按每三位数用逗号分隔，小数取二位，如果没有第二位小数，则不会补零，
	  * 如果有第三个小数，则按四舍五入计算第二位的值 <br />
	  * 
	  * @param number int或float 数字  参数必须 是
	  * @param pattern String 格式化规则 参数必须 是
	  * @return 返回已格式化的数据，出错返回number值
	  * @type String
	  */
	 this.getNumberFormat = function(number,pattern){
	 	var subPrefix = "";
	 	var str = (new Number(number)).toString(10);
	 	if(str.indexOf("-") != -1){
	 		subPrefix = "-";
	 		str = str.substring(1,str.length);
	 		number = str;
	 	}
	    var strInt;
	    var strFloat;
	    var formatInt;
	    var formatFloat;
	    if(/\./.test(pattern)){
	        formatInt = pattern.split('.')[0];
	        formatFloat = pattern.split('.')[1];
	    }else{
	    	formatInt = pattern;
	    	formatFloat = null;
	    }
	    if(/\./.test(str)){
	        if(formatFloat!=null){
	            var tempFloat = Math.round(parseFloat('0.'+str.split('.')[1])*Math.pow(10,formatFloat.length))/Math.pow(10,formatFloat.length);
	            strInt = (Math.floor(number)+Math.floor(tempFloat)).toString();
	            strFloat = /\./.test(tempFloat.toString())?tempFloat.toString().split('.')[1]:'0';            
	        }else{
	        	strInt = Math.round(number).toString();
	            strFloat = '0';
	        }
	    }else{
	        strInt = str;
	        strFloat = '0';
	    }
	    if(formatInt!=null){
	        var outputInt = '';
	        var zero = formatInt.match(/0*$/)[0].length;
	        var comma = null;
	        if(/,/.test(formatInt)){
	            comma = formatInt.match(/,[^,]*/)[0].length-1;
	        }
	        var newReg = new RegExp('(\\d{'+comma+'})','g');
	        if(strInt.length<zero){
	            outputInt = new Array(zero+1).join('0')+strInt;
	            outputInt = outputInt.substr(outputInt.length-zero,zero);
	        }else{
	            outputInt = strInt;
	        }
	        outputInt = outputInt.substr(0,outputInt.length%comma)+outputInt.substring(outputInt.length%comma).replace(newReg,(comma!=null?',':'')+'$1');
	        outputInt = outputInt.replace(/^,/,'');
	
	        strInt = outputInt;
	    }
	    if(formatFloat!=null){
	        var outputFloat = '';
	        var zero = formatFloat.match(/^0*/)[0].length;
	
	        if(strFloat.length<zero){
	            outputFloat = strFloat+new Array(zero+1).join('0');
	            //outputFloat = outputFloat.substring(0,formatFloat.length);
	            var outputFloat1 = outputFloat.substring(0,zero);
	            var outputFloat2 = outputFloat.substring(zero,formatFloat.length);
	            outputFloat = outputFloat1+outputFloat2.replace(/0*$/,'');
	        }else{
	            outputFloat = strFloat.substring(0,formatFloat.length);
	        }
	        strFloat = outputFloat;
	    }else{
	        if(pattern!='' || (pattern=='' && strFloat=='0')){
	            strFloat    = '';
	        }
    	}
    	
    	return subPrefix + strInt+(strFloat==''?'':'.'+strFloat);
	 }
	 
	 /**
	  * @ignore
	  * 字符有效性验证
	  */
	  
	  /**
	   * 获取字符串的长度
	   * 此处的计算方式是一个汉字也是算长度为1
	   * @param str String 字符串 参数必须 是
	   * @return 返回字符串的长度
	   * @type int
	   */
	  this.getLength = function(str){
	  		return str.length;
	  }
	  /**
	   * 判断字符串长度是否大于指定长度。
	   * 如果字符串长度大于指定长度，返回true，
	   * 否则返回false。
	   * 此方法使用getLength(str)方法获取字符长度，
	   * 即：getLength(str) > len 返回true，其它返回false。
	   * @see #getLength
	   * @param str String 字符串 参数必须 是
	   * @param len int 长度 参数必须 是
	   * @return 合法返回true，非法返回false
	   * @type boolean
	   */
	  this.bigLength = function(str,len){
	  	if(this.getLength(str) > len){
	  		return true;
	  	}
	  	return false;
	  }
	  /**
	   * 判断字符串长度是否小于指定的长度。字符串长度小于指定长度，返回true，否则返回false。
	   * 此方法使用getLength(str)方法获取字符长度，
	   * 即：getLength(str) < len 返回true，其它返回false。
	   * @see #getLength
	   * @param str String 字符串 参数必须 是
	   * @param len int 长度 参数必须 是
	   * @return 合法返回true，非法返回false
	   * @type boolean
	   */
	  this.lessLength = function(str,len){
	  	if(this.getLength(str) < len){
	  		return true;
	  	}
	  	return false;
	  } 
	  /**
	   * 判断字符串长度是否等于指定的长度。字符串长度等于指定长度，返回true，否则返回false。
	   * 此方法使用getLength(str)方法获取字符长度，
	   * 即：str.length = len  返回true，其它返回false。
	   * @see #getLength
	   * @param str String 字符串 参数必须 是
	   * @param len int 长度 参数必须 是
	   * @return 合法返回true，非法返回false
	   * @type boolean
	   */
	  this.equalLength = function(str,len){
	  	if(this.getLength(str) == len){
	  		return true;
	  	}
	  	return false;
	  }
	  /**
	   * 将字符串的前后空格去除并返回，
	   * 如果输入的参数全是空格的字符串则返回空字符串。
	   * @param str String 字符串 参数必须 是
	   * @return 返回已处理的字符串
	   * @type String
	   */
	  this.trim = function(str){
	  	var end = false;
		var ch;
		while(!end){
			if (str.length == 0) break;
			ch = str.charAt(0);
			if (ch == ' ')	str = str.substring(1,str.length);
			else end = true;
		}
		end = false;
		while(!end){
			if (str.length == 0) break;
			ch = str.charAt(str.length-1);
			if (ch == ' ')	str = str.substring(0,str.length-1);
			else end = true;
		}
		return str;
	  }
	  /**
	   * 判断字符串是否是只包含大小写字母和数字，如果字符串是空的，则返回false。
	   * @param str String 字符串 参数必须 是
	   * @return 合法返回true，非法返回false
	   * @type boolean
	   */
	  this.isAlphanumeric = function(str){
	  	if (str == "") return false;
		var i;
		for (i = 0; i < str.length; i++){
			var ch = str.charAt(i);
			if ( ((ch < 'A' || ch > 'Z') && (ch < 'a' || ch > 'z')) && (ch < '0' || ch > '9') )	return false;
		}
		return true;
	  }
	  /**
	   * 判断字符字母是否<b>全是大写字母</b>
	   * @param str  String 字符串 参数必须 是
	   * @return 合法返回true，非法返回false
	   * @type boolean
	   */
	  this.isUpperCase = function(str){
	  	if (str == "") return false;
		var i;
		for (i = 0; i < str.length; i++){
			var ch = str.charAt(i);
			if (ch < 'A' || ch > 'Z')return false;
		}
		return true;
	  }
	  /**
	   * 判断字符字母是否<b>全是小写字母</b>
	   * @param str  String 字符串 参数必须 是
	   * @return 合法返回true，非法返回false
	   * @type boolean
	   */
	  this.isLowerCase = function(str){
	  	if (str == "") return false;
		var i;
		for (i = 0; i < str.length; i++){
			var ch = str.charAt(i);
			if (ch < 'a' || ch > 'z')return false;
		}
		return true;
	  }
	  /**
	   * 判断字符是否<b>全是数字</b>
	   * @param str  String 字符串 参数必须 是
	   * @return 合法返回true，非法返回false
	   * @type boolean
	   */
	  this.isDigits = function(str){
	  	if (str == "") return false;
		var i;
		for (i = 0; i < str.length; i++){
			var ch = str.charAt(i);
			if (ch < '0' || ch > '9')return false;
		}
		return true;
	  }
	  /**
	   * 判断字符是否是<b>全是汉字</b>
	   * @param str  String 字符串 参数必须 是
	   * @return 合法返回true，非法返回false
	   * @type boolean
	   */
	  this.isChinese = function(str){
	  	var i;
	  	var chinese_reg = /[\u4e00-\u9fa5]/;
		for (i = 0; i < str.length; i++){
			var ch = str.charAt(i);
			if(!chinese_reg.test(ch)){
				return false;
			}
		}
		return true;
	  }
	  /**
	   * 判断字符是否是<b>包含汉字</b>
	   * @param str  String 字符串 参数必须 是
	   * @return 合法返回true，非法返回false
	   * @type boolean
	   */
	  this.isContainChinese = function(str){
	  	var i;
	  	var chinese_reg = /[\u4e00-\u9fa5]/;
		for (i = 0; i < str.length; i++){
			var ch = str.charAt(i);
			if(chinese_reg.test(ch)){
				return true;
			}
		}
		return false;
	  }
	  /**
	   * 判断字符中是否存在非法字符，此方法有两个参数，可以只传一个参数。
	   * 即spch特殊字符串是指系统定义的非法字符。如果不设置此字符串的值，
	   * 将使用系统设置的特殊字符进行验证。
	   * spch=JS_GLOBAL_VALIDATE_SPCH
	   * @see #JS_GLOBAL_VALIDATE_SPCH
	   * @param str String 字符串 参数必须 是
	   * @param spch String 特殊字符串 参数必须 否
	   * @return  合法的返回true，非法返回false
	   * @type boolean
	   */
	  this.checkSafeChar = function(str,spch){
	  	if(spch == "" || spch == null ){
	  		spch = this.JS_GLOBAL_VALIDATE_SPCH();
	  	}
	  	var i = 0;
	  	for(i = 0; i < str.length; i++){
	  		var j = 0;
	  		for(j = 0; j < spch.length; j++){
	  			if(str.charAt(i) == spch.charAt(j)){
	  				return false;
	  			}
	  		}
	  	}
	  	return true;
	  } 
	  
	/**
	 * @ignore
	 * 非空字符有效性验证
	 */
	
	/**
	 * 判断字符是否是为空
	 * @param str String 字符串 参数必须 是
	 * @return  合法的返回true，非法返回false
	 * @type boolean
	 */
	this.isNull = function(str){
		if(str == null){
			return true;
		}
		if(str == undefined){
			return true;
		}
		if(str == ""){
			return true;
		}
		return false;
	}
	/**
	 * 判断字符是否是全为空格
	 * 此方法调用trim(str)函数来判断。
	 * @see #trim
	 * @param str String 字符串 参数必须 是
	 * @return  合法的返回true，非法返回false
	 * @type boolean
	 */
	this.isEmpty = function(str){
		if(this.trim(str) == ''){
			return true;
		}
		return false;
	}
	/**
	 * 判断字符是否是全为Tab键
	 * @param str String 字符串 参数必须 是
	 * @return  合法的返回true，非法返回false
	 * @type boolean
	 */
	this.isEmptyOfTab = function(str){
		var end = false;
		var ch;
		while(!end){
			if (str.length == 0) break;
			ch = str.charAt(0);
			if (ch == '	')	str = str.substring(1,str.length);
			else end = true;
		}
		end = false;
		while(!end){
			if (str.length == 0) break;
			ch = str.charAt(str.length-1);
			if (ch == '	')	str = str.substring(0,str.length-1);
			else end = true;
		}
		if(str == ''){
			return true;
		}
		return false;
	}
	
	/**
	 * @ignore
	 * 日期有效性验证
	 */
	/**
	 * 判断日期是否合法，如果不指定日期格式，即：
	 * 默认格式为yyyy-MM-dd
	 * @param date String 日期 参数必须 是
	 * @param format String 日期格式 参数必须 否
	 * @return  合法的返回true，非法返回false
	 * @type boolean
	 */
	this.isDate = function(date,format){
		var dformat = '';
		if(date == ''){
			return false;
		}
		if( ((format == null)) || (format == '')|| (format == "undefined")){
			dformat = "yyyy-MM-dd"; 
		}else{
			dformat = format;
		}
		if(date.length != dformat.length){
			return false;
		}
	    var year,month,day,yi,Mi,di; 
	    yi = dformat.indexOf("yyyy");  
	    Mi = dformat.indexOf("MM");  
	    di = dformat.indexOf("dd");
	    if(yi == -1 || Mi == -1 || di == -1){
	     	return false;  
	    }else{  
	        year = date.substring(yi, yi+4);  
	        month = date.substring(Mi, Mi+2);  
	        day = date.substring(di, di+2);  
	    }
	    
	    if(isNaN(year) || isNaN(month) || isNaN(day)){
	    	return false;
	    }
	    if(year.length != 4 || month.length != 2 || day.length != 2){
	    	return false;
	    }

		if (month < 1 || month > 12) { // check month range
			return false;
		}
		if (day < 1 || day > 31) {
			return false;
		}
		if ((month==4 || month==6 || month==9 || month==11) && day==31) {
			return false;
		}
		if (month == 2) { // check for february 29th
			var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
			if (day>29 || (day==29 && !isleap)) {
				return false;
		   	}
		}
		if (year>9998 || year<1950)
		return false;
		return true;
	}
	/**
	 * 判断时间是否合法，如果不指定时间格式，即：
	 * 默认格式为HH:mm:ss
	 * @param time String 时间 参数必须 是
	 * @param format String 时间格式 参数必须 否
	 * @return  合法的返回true，非法返回false
	 * @type boolean
	 */
	this.isTime = function(time,format){
		var tformat = '';
		if(time == ''){
			return false;
		}
		if( ((format == null)) || (format == '')|| (format == "undefined")){
			tformat = "HH:mm:ss"; 
		}else{
			tformat = format;
		}
		if(time.length != tformat.length){
			return false;
		}
		var H,m,s,Hi,mi,si;
		Hi = tformat.indexOf("HH");  
    	mi = tformat.indexOf("mm");  
    	si = tformat.indexOf("ss");
    	if(Hi == -1 || mi == -1 || si == -1){
    		return false;
    	}
    	H = time.substring(Hi, Hi+2);  
        m = time.substring(mi, mi+2);  
        s = time.substring(si, si+2);
        if(isNaN(H) || isNaN(m) || isNaN(s)){
		    return false;
		}
        if(H.length != 2 || m.length != 2 || s.length != 2){
		    return false;
		}
    	if(H < 0 || H > 23){
    		return false;
    	}
    	if(m < 0 || m > 59){
    		return false;
    	}
    	if(s < 0 || s > 59){
    		return false;
    	}
    	return true;
	}
	/**
	 * 判断某日期是否在一定的日期范围内，即beginDate<=date<=endDate，
	 * 日期格式为yyyy-MM-dd
	 * @param date String 日期 参数必须 是
	 * @param beginDate String 开始日期 参数必须 是
	 * @param beginDate String 结束日期 参数必须 是
	 * @return  合法的返回true，非法返回false
	 * @type boolean
	 */
	this.isBetweenDate = function(date,beginDate,endDate){
		var datePat = /^(\d{4})-(\d{1,2})-(\d{1,2})$/; 
		var dateArray = date.match(datePat);
		var beginArray = beginDate.match(datePat);
		var endArray = endDate.match(datePat);
		var d =new Date(dateArray[1],dateArray[2]-1,dateArray[3]); 
		var bd =new Date(beginArray[1],beginArray[2]-1,beginArray[3]); 
		var ed =new Date(endArray[1],endArray[2]-1,endArray[3]); 
		if(d >= bd && d <= ed){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 比较日期是否在指定日期之前，即 cpDate < date
	 * 日期格式为yyyy-MM-dd
	 * @param date String 日期 参数必须 是
	 * @param cpDate String 指定日期 参数必须 是
	 * @return  合法的返回true，非法返回false
	 * @type boolean
	 */
	this.beforeDate = function(date,cpDate){
		var datePat = /^(\d{4})-(\d{1,2})-(\d{1,2})$/; 
		var startArray = date.match(datePat);
		var endArray = cpDate.match(datePat);
		var sd =new Date(startArray[1],startArray[2]-1,startArray[3],0,0,0,0); 
		var ed =new Date(endArray[1],endArray[2]-1,endArray[3],0,0,0,0); 
		if(Date.parse(sd) > Date.parse(ed)){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 比较日期是否在指定日期之后，即 date < cpDate
	 * 日期格式为yyyy-MM-dd
	 * @param date String 日期 参数必须 是
	 * @param cpDate String 指定日期 参数必须 是
	 * @return  合法的返回true，非法返回false
	 * @type boolean
	 */
	this.afterDate = function(date,cpDate){
		var datePat = /^(\d{4})-(\d{1,2})-(\d{1,2})$/; 
		var startArray = date.match(datePat);
		var endArray = cpDate.match(datePat);
		var sd =new Date(startArray[1],startArray[2]-1,startArray[3],0,0,0,0); 
		var ed =new Date(endArray[1],endArray[2]-1,endArray[3],0,0,0,0); 
		if(Date.parse(sd) < Date.parse(ed)){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 比较日期是否与指定日期相同，即 date = cpDate
	 * 日期格式为yyyy-MM-dd
	 * @param date String 日期 参数必须 是
	 * @param cpDate String 指定日期 参数必须 是
	 * @return  合法的返回true，非法返回false
	 * @type boolean
	 */
	this.equalDate = function(date,cpDate){
		var datePat = /^(\d{4})-(\d{1,2})-(\d{1,2})$/; 
		var startArray = date.match(datePat);
		var endArray = cpDate.match(datePat);
		var sd =new Date(startArray[1],startArray[2]-1,startArray[3],0,0,0,0); 
		var ed =new Date(endArray[1],endArray[2]-1,endArray[3],0,0,0,0); 
		if(Date.parse(sd) == Date.parse(ed)){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 与指定的日期进行比较，并返回比较的结果。
	 * 日期格式为yyyy-MM-dd  即：<br />
	 * date < cpDate 返回 -1 <br />
	 * date = cpDate 返回 0 <br />
	 * date > cpDate 返回 1 <br />
	 * 不是以上三种情况 返回 -2 <br />
	 * @param date String 日期 参数必须 是
	 * @param cpDate String 比较日期 参数必须 是
	 * @return  返回比较结果
	 * @type int
	 */
	this.compareToDate = function(date,cpDate){
		var datePat = /^(\d{4})-(\d{1,2})-(\d{1,2})$/; 
		var startArray = date.match(datePat);
		var endArray = cpDate.match(datePat);
		var sd =new Date(startArray[1],startArray[2]-1,startArray[3],0,0,0,0); 
		var ed =new Date(endArray[1],endArray[2]-1,endArray[3],0,0,0,0); 
		if(Date.parse(sd) == Date.parse(ed)){
			return 0;
		}else if(Date.parse(sd) > Date.parse(ed)){
			return 1;
		}else if(Date.parse(sd) < Date.parse(ed)){
			return -1;
		}else{
			return -2;
		}
	}
	/**
	 * 与指定的时间进行比较，并返回比较的结果。
	 * 时间格式为HH:mm:ss  即：<br />
	 * time < cpTime 返回 -1 <br />
	 * time = cpTime 返回 0 <br />
	 * time > cpTime 返回 1 <br />
	 * 不是以上三种情况 返回 -2 <br />
	 * @param time String 时间 参数必须 是
	 * @param cpTime String 比较时间 参数必须 是
	 * @return  返回比较结果
	 * @type int
	 */
	this.compareToTime = function(time,cpTime){
		var timePat = /^(\d{2}):(\d{1,2}):(\d{1,2})$/; 
		var startArray = time.match(timePat);
		var endArray = cpTime.match(timePat);
		var sd =new Date(2011,11,11,startArray[1],startArray[2],startArray[3],0); 
		var ed =new Date(2011,11,11,endArray[1],endArray[2],endArray[3],0); 
		if(Date.parse(sd) == Date.parse(ed)){
			return 0;
		}else if(Date.parse(sd) > Date.parse(ed)){
			return 1;
		}else if(Date.parse(sd) < Date.parse(ed)){
			return -1;
		}else{
			return -2;
		}
	}
	/**
	 * 与指定的日期时间进行比较，并返回比较的结果。
	 * 日期时间格式为yyyy-MM-dd HH:mm:ss  即：<br />
	 * datetime < cpDateTime 返回 -1 <br />
	 * datetime = cpDateTime 返回 0 <br />
	 * datetime > cpDateTime 返回 1 <br />
	 * 不是以上三种情况 返回 -2 <br />
	 * @param datetime String 日期时间 参数必须 是
	 * @param cpDateTime String 比较日期时间 参数必须 是
	 * @return  返回比较结果
	 * @type int
	 */
	this.compareToDatetime = function(datetime,cpDatetime){
		var datetimePat = /^(\d{4})-(\d{1,2})-(\d{1,2}) (\d{2}):(\d{1,2}):(\d{1,2})$/; 
		var startArray = datetime.match(datetimePat);
		var endArray = cpDatetime.match(datetimePat);
		var sd =new Date(startArray[1],startArray[2] - 1,startArray[3],startArray[4],startArray[5],startArray[6],0); 
		var ed =new Date(endArray[1],endArray[2] - 1,endArray[3],endArray[4],endArray[5],endArray[6],0); 
		if(Date.parse(sd) == Date.parse(ed)){
			return 0;
		}else if(Date.parse(sd) > Date.parse(ed)){
			return 1;
		}else if(Date.parse(sd) < Date.parse(ed)){
			return -1;
		}else{
			return -2;
		}
	}
	/**
	 * 将一个日期时间从一个格式转换到另一种格式
	 * 如 2008-10-23 转成 2008/10/23等。
	 * 即：
	 * yyyy 表示年 <br />
	 * MM 表示月 <br />
	 * dd 表示天 <br />
	 * HH 表示时 <br />
	 * mm 表示分 <br />
	 * ss 表示秒 <br />
	 * 通过以上的组合，可以格式化日期和时间的格式，出错时返回空。
	 * @param date String 有效日期时间  参数必须 是
	 * @param oFormat String 旧日期时间格式 参数必须 是
	 * @param nFormat String 新日期时间格式 参数必须 是
	 * @return 返回已经格式化的日期，出错返回空
	 * @type String
	 */
	this.formatDateTime = function(date,oFormat,nFormat){
		
		if(date == ''){
			return '';
		}
	   var y,M,d,H,m,s,yi,Mi,di,Hi,mi,si; 
	    yi = oFormat.indexOf("yyyy");  
	    Mi = oFormat.indexOf("MM");  
	    di = oFormat.indexOf("dd");
	    Hi = oFormat.indexOf("HH");  
    	mi = oFormat.indexOf("mm");  
    	si = oFormat.indexOf("ss");  
	    if(yi == -1 || Mi == -1 || di == -1){
	     	return '';  
	    }else{  
	        y = date.substring(yi, yi+4);  
	        M = date.substring(Mi, Mi+2);  
	        d = date.substring(di, di+2);  
	    }
	    
	    if(isNaN(y) || isNaN(M) || isNaN(d)){
	    	return '';
	    }
	    if(y.length != 4 || M.length != 2 || d.length != 2){
	    	return '';
	    }
	    var newDate = nFormat;
     	if(Hi == -1 || mi == -1 || si == -1){
		    if(nFormat.indexOf("yyyy")){
		    	newDate = newDate.replace(/yyyy/,y);
		    }
		    if(nFormat.indexOf("MM")){
		    	newDate = newDate.replace(/MM/,M);
		    }
		    if(nFormat.indexOf("dd")){
		    	newDate = newDate.replace(/dd/,d);
		    }
		    if(nFormat.indexOf("HH")){
		    	newDate = newDate.replace(/HH/,00);
		    }
		    if(nFormat.indexOf("mm")){
		    	newDate = newDate.replace(/mm/,00);
		    } 
		    if(nFormat.indexOf("ss")){
		    	newDate = newDate.replace(/ss/,00);
		    }
     	}else{
     		
         	H = date.substring(Hi, Hi+2);  
         	m = date.substring(mi, mi+2);  
         	s = date.substring(si, si+2);
         	if(isNaN(H) || isNaN(m) || isNaN(s)){
		    	return '';
		    }
         	if(H.length != 2 || m.length != 2 || s.length != 2){
		    	return '';
		    }
		    
         	if(nFormat.indexOf("yyyy")){
		    	newDate = newDate.replace(/yyyy/,y);
		    }
		    if(nFormat.indexOf("MM")){
		    	newDate = newDate.replace(/MM/,M);
		    }
		    if(nFormat.indexOf("dd")){
		    	newDate = newDate.replace(/dd/,d);
		    }
		    if(nFormat.indexOf("HH")){
		    	newDate = newDate.replace(/HH/,H);
		    }
		    if(nFormat.indexOf("mm")){
		    	newDate = newDate.replace(/mm/,m);
		    } 
		    if(nFormat.indexOf("ss")){
		    	newDate = newDate.replace(/ss/,s);
		    }
     	}
     	return newDate;
	}
	/**
	 * 获取某一日期前几天的日期，如：指定2008-10-29之前的3天，返回2008-10-26
	 * 日期格式为yyyy-MM-dd
	 * @param date String 日期 参数必须 是
	 * @param number int 数字 参数必须 是
	 * @return 返回指定日期的指定前几天日期
	 * @type String
	 */
	this.getPreDate = function(date,number){
		var datePat = /^(\d{4})-(\d{1,2})-(\d{1,2})$/; 
		var dateArray = date.match(datePat);
		var d =new Date(dateArray[1],dateArray[2]-1,dateArray[3]);
		d.setUTCDate(d.getUTCDate() - number);
		var year,month,day;
		year = d.getFullYear();
		month = d.getMonth() + 1;
		day = d.getDate();
		if(month < 10){
			month ="0" + month;
		}
		if(day < 10){
			day ="0" + day;
		}
		return "" + year + "-" + month + "-" + day;
	}
	/**
	 * 获取某一日期后几天的日期，如：指定2008-10-29之后的3天，返回2008-11-01
	 * 日期格式为yyyy-MM-dd
	 * @param date String 日期 参数必须 是
	 * @param number int 数字 参数必须 是
	 * @return 返回指定日期的指定后几天日期
	 * @type String
	 */
	this.getNextDate = function(date,number){
		var datePat = /^(\d{4})-(\d{1,2})-(\d{1,2})$/; 
		var dateArray = date.match(datePat);
		var d =new Date(dateArray[1],dateArray[2]-1,dateArray[3]);
		d.setUTCDate(d.getUTCDate() + number);
		var year,month,day;
		year = d.getFullYear();
		month = d.getMonth() + 1;
		day = d.getDate();
		if(month < 10){
			month ="0" + month;
		}
		if(day < 10){
			day ="0" + day;
		}
		return "" + year + "-" + month + "-" + day;
	}
	/**
	 * 获取某一日期的年份，如：2008-10-28 返回 2008
	 * 如果不指定日期格式，即使用默认的日期格式为：yyyy-MM-dd
	 * 出错返回空字符串
	 * @param date String 日期 参数必须 是
	 * @param format String 日期格式 参数必须 否
	 * @return 某一日期的年份，出错返回空字符串
	 * @type String
	 */
	this.getYearOfDate = function(date,format){
		var dformat = '';
		if(date == ''){
			return '';
		}
		if( ((format == null)) || (format == '')|| (format == "undefined")){
			dformat = "yyyy-MM-dd"; 
		}else{
			dformat = format;
		}
	    var year,month,day,yi,Mi,di; 
	    yi = dformat.indexOf("yyyy");  
	    Mi = dformat.indexOf("MM");  
	    di = dformat.indexOf("dd");
	    if(yi == -1 || Mi == -1 || di == -1){
	     	return '';  
	    }else{  
	        year = date.substring(yi, yi+4);  
	        month = date.substring(Mi, Mi+2);  
	        day = date.substring(di, di+2);  
	    }
	    
	    if(isNaN(year) || isNaN(month) || isNaN(day)){
	    	return '';
	    }
	    if(year.length != 4 || month.length != 2 || day.length != 2){
	    	return '';
	    }
		return year;
	}
	/**
	 * 获取某一日期的月份，如：2008-10-28 返回 10
	 * 如果不指定日期格式，即使用默认的日期格式为：yyyy-MM-dd
	 * 出错返回空字符串
	 * @param date String 日期 参数必须 是
	 * @param format String 日期格式 参数必须 否
	 * @return 某一日期的月份，出错返回空字符串
	 * @type String
	 */
	this.getMonthOfDate = function(date,format){
		var dformat = '';
		if(date == ''){
			return '';
		}
		if( ((format == null)) || (format == '')|| (format == "undefined")){
			dformat = "yyyy-MM-dd"; 
		}else{
			dformat = format;
		}
	    var year,month,day,yi,Mi,di; 
	    yi = dformat.indexOf("yyyy");  
	    Mi = dformat.indexOf("MM");  
	    di = dformat.indexOf("dd");
	    if(yi == -1 || Mi == -1 || di == -1){
	     	return '';  
	    }else{  
	        year = date.substring(yi, yi+4);  
	        month = date.substring(Mi, Mi+2);  
	        day = date.substring(di, di+2);  
	    }
	    
	    if(isNaN(year) || isNaN(month) || isNaN(day)){
	    	return '';
	    }
	    if(year.length != 4 || month.length != 2 || day.length != 2){
	    	return '';
	    }
		return month;
	}
	/**
	 * 获取某一日期的天数，如：2008-10-28 返回 28
	 * 如果不指定日期格式，即使用默认的日期格式为：yyyy-MM-dd
	 * 出错返回空字符串
	 * @param date String 日期 参数必须 是
	 * @param format String 日期格式 参数必须 否
	 * @return 某一日期的天数，出错返回空字符串
	 * @type String
	 */
	this.getDayOfDate = function(date,format){
		var dformat = '';
		if(date == ''){
			return '';
		}
		if( ((format == null)) || (format == '')|| (format == "undefined")){
			dformat = "yyyy-MM-dd"; 
		}else{
			dformat = format;
		}
	    var year,month,day,yi,Mi,di; 
	    yi = dformat.indexOf("yyyy");  
	    Mi = dformat.indexOf("MM");  
	    di = dformat.indexOf("dd");
	    if(yi == -1 || Mi == -1 || di == -1){
	     	return '';  
	    }else{  
	        year = date.substring(yi, yi+4);  
	        month = date.substring(Mi, Mi+2);  
	        day = date.substring(di, di+2);  
	    }
	    
	    if(isNaN(year) || isNaN(month) || isNaN(day)){
	    	return '';
	    }
	    if(year.length != 4 || month.length != 2 || day.length != 2){
	    	return '';
	    }
		return day;
	}
	
	/**
	 * @ignore
	 * Email地址有效性验证
	 */
	/**
	 * 判断是否是合法的Email地址
	 * @param email String Email地址 参数必须 是
	 * @return 合法的返回true，非法返回false
	 * @type boolean
	 */
	this.isEmail = function(email){
		if(email == ''){
			return false;
		}
		var emailReg = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
		if(emailReg.test(email)){
			return true;
		}
		return false;
	}
	/**
	 * 判断是否是合法的Email地址，并且是以某一字符开头的，
	 * 使用isEmail(email)函数判断Email地址的合法性。
	 * @see #isEmail
	 * @param email String Email地址 参数必须 是
	 * @param pre String 指定前缀 参数必须 是
	 * @return 合法的返回true，非法返回false
	 * @type boolean
	 */
	this.checkEmailPrefix = function(email,pre){
		if(!this.isEmail(email)){
			return false;
		}
		var i = email.indexOf(pre);
		if(i == 0){
			return true;
		}
		return false;
	}
	/**
	 * 判断是否是合法的Email地址，并且是以某一字符结尾的，
	 * 使用isEmail(email)函数判断Email地址的合法性。
	 * @see #isEmail
	 * @param email String Email地址 参数必须 是
	 * @param suf String 指定后缀 参数必须 是
	 * @return 合法的返回true，非法返回false
	 * @type boolean
	 */
	this.checkEmailSuffix = function(email,suf){
		if(!this.isEmail(email)){
			return false;
		}
		var i = email.lastIndexOf(suf);
		if((i + suf.length) == email.length){
			return true;
		}
		return false;
	}
	
	/**
	 * @ignore
	 * URL有效性验证
	 */
	/**
	 * 判断是否是是否是合法的URL
	 * @param url String URL 参数必须 是
	 * @return 合法的返回true，非法返回false
	 * @type boolean
	 */
	this.isURL = function(url){
		if(url == ''){
			return false;
		}
		var httpReg = /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/i;
		var ftpReg = /^ftp:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/i;
		var httpsReg = /^https:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/i;
		var urlReg = /^[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/i;
		var flag = false;
		flag = httpReg.test(url);
		if(flag){
			return flag;
		}
		flag = ftpReg.test(url);
		if(flag){
			return flag;
		}
		flag = httpsReg.test(url);
		if(flag){
			return flag;
		}
		flag = urlReg.test(url);
		return flag;
	}
	/**
	 * 判断是否是合法http协议URL，即URL必须是以http/HTTP开头的为合法的http协议URL
	 * @param url String URL 参数必须 是
	 * @return 合法的返回true，非法返回false
	 * @type boolean
	 */
	this.isHttpURL = function(url){
		if(url == ''){
			return false;
		}
		var urlReg = /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/i;
		if(urlReg.test(url)){
			return true;
		}
		return false;
	}
	/**
	 * 判断是否是合法https协议URL，即URL必须是以https/HTTPS开头的为合法的http协议URL
	 * @param url String URL 参数必须 是
	 * @return 合法的返回true，非法返回false
	 * @type boolean
	 */
	this.isHttpsURL = function(url){
		if(url == ''){
			return false;
		}
		var urlReg = /^https:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/i;
		if(urlReg.test(url)){
			return true;
		}
		return false;
	}
	/**
	 * 判断是否是合法FTP协议URL，即URL必须是以ftp/FTP开头的为合法的ftp协议URL
	 * @param url String URL 参数必须 是
	 * @return 合法的返回true，非法返回false
	 * @type boolean
	 */
	this.isFtpURL = function(url){
		if(url == ''){
			return false;
		}
		var urlReg = /^ftp:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/i;
		if(urlReg.test(url)){
			return true;
		}
		return false;
	}
	
	/**
	 * @ignore
	 * 字符转义
	 */
	
	
	/**
	 * 转义字符，按HTML标准转义字符，则返回其它转义的字符。
	 * 即对HTML定义的字符进行转义，如：“<” 转成 “&lt;”，“ ”（空格） 转成 “&nbsp;”
	 * @param str String 字符 参数必须 是
	 * @return 返回转义后的字符
	 * @type String
	 */
	this.getSafeHTML = function(str){
		var OutString = '';
		var i;
		for(i = 0; i < str.length; i++){
			var ch = str.charAt(i);
			if(ch == '>'){
				OutString += '&gt;';
			}else if (ch == '<'){
				OutString += '&lt;';
			}else if (ch == '&' ){
				OutString += '&amp;';
			}else if (ch == '"' ){
				OutString += '&quot;';
			}else if (ch == ' ' ){
				OutString += '&nbsp;';
			}else if (ch == '©' ){
				OutString += '&copy;';//版权符
			}else if (ch == '®' ){
				OutString += '&reg;';//注册符
			}else {
				OutString += ch;
			}
		}
		return OutString;
	}
	/**
	 * 转义字符，按WAP标准转义字符，则返回其它转义的字符。
	 * @param str String 字符 参数必须 是
	 * @return 返回转义后的字符
	 * @type String
	 */
	this.getSafeWAP = function(str){
		var OutString = '';
		var i;
		for(i = 0; i < str.length; i++){
			var ch = str.charAt(i);
			if(ch == '>'){
				OutString += '&gt;';
			}else if (ch == '<'){
				OutString += '&lt;';
			}else if (ch == '&' ){
				OutString += '&amp;';
			}else if (ch == '"' ){
				OutString += '&quot;';
			}else if (ch == '\'' ){
				OutString += '&apos;';
			}else {
				OutString += ch;
			}
		}
		return OutString;
	}
	/**
	 * 转义字符，按XHTML标准转义字符，则返回其它转义的字符。
	 * @param str String 字符 参数必须 是
	 * @return 返回转义后的字符
	 * @type String
	 */
	this.getSafeXHTML = function(str){
		var OutString = '';
		var i;
		for(i = 0; i < str.length; i++){
			var ch = str.charAt(i);
			if(ch == '>'){
				OutString += '&gt;';
			}else if (ch == '<'){
				OutString += '&lt;';
			}else if (ch == '&' ){
				OutString += '&amp;';
			}else if (ch == '"' ){
				OutString += '&quot;';
			}else if (ch == '\'' ){
				OutString += '&apos;';
			}else {
				OutString += ch;
			}
		}
		return OutString;
	}
	/**
	 * 转义字符，按XML标准转义字符，则返回其它转义的字符。
	 * @param str String 字符 参数必须 是
	 * @return 返回转义后的字符
	 * @type String
	 */
	this.getSafeXML = function(str){
		var OutString = '';
		var i;
		for(i = 0; i < str.length; i++){
			var ch = str.charAt(i);
			if(ch == '>'){
				OutString += '&gt;';
			}else if (ch == '<'){
				OutString += '&lt;';
			}else if (ch == '&' ){
				OutString += '&amp;';
			}else if (ch == '"' ){
				OutString += '&quot;';
			}else if (ch == '\'' ){
				OutString += '&apos;';
			}else {
				OutString += ch;
			}
		}
		return OutString;
	}
	
	/**
	 * @ignore
	 * IP地址有效性验证
	 */
	
	/**
	 * 判断IP是否合法
	 * 验证IP地址的有效性，十进制数的IP地址验证是否值在范围内，
	 * 还有IP地址的格式是否正确（由四个十进制数，每一个数之间由“.”区分。）
	 * @param ip String IP 参数必须 是
	 * @return 合法的返回true，非法返回false
	 * @type boolean
	 */
	this.isIP = function(ip){
		if(ip == ''){
			return false;
		}
	    var ipReg =/^(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])$/;
		if(ipReg.test(ip)){
			return true;
		}
		return false;
	}
	/**
	 * 判断ip地址是否是在一定的IP地址段中，即beginIp<=ip<=endIp，
	 * 对于IP的合法性进行判断使用isIP(ip)函数。
	 * @see #isIP
	 * @param ip String IP 参数必须 是
	 * @param beginIp String 开始IP 参数必须 是
	 * @param endIp String 结束IP 参数必须 是
	 * @return 合法的返回true，非法返回false
	 * @type boolean
	 */
	this.checkIPRange = function(ip,beginIp,endIp){
		if(ip == '' || beginIp == '' || endIp == ''){
			return false;
		}
		if(!(this.isIP(ip) && this.isIP(beginIp) && this.isIP(endIp))){
			return false
		}
		var ipArray = ip.split('.');
		var bIpArray = beginIp.split('.');
		var eIpArray = endIp.split('.');
		var i = 0;
		for(i = 0; i < 4; i ++){
			var tempIp = new Number(ipArray[i]);
			var tempBIp = new Number(bIpArray[i]);
			var tempEIp = new Number(eIpArray[i]);
			if(!(tempIp >= tempBIp && tempIp <= tempEIp)){
				return false;
			}
		}
		return true;
	}
	
}
/**
 * @ignore
 * 基本JavaScript表单验证类实例对象,即引入DValidate.js文件，
 * 可以通过DValidate.XXX()的方式使用通用的表单验证函数。
 */
var MValidate = new MValidateClass();
