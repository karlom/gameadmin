<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">                                    
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />          
<title><{$lang->menu->qingDian}></title>
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/ip.js"></script>
	<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
	<script type="text/javascript" src="/static/js/global.js"></script>
<style type="text/css">                                                        
        .hr_red{                                                               
                background-color:red;                                          
                width:6px;                                                     
        }       
</style>        
</head> 

<body style="margin:0px;padding:20px;">
<div id="position"><b><{$lang->menu->class->payAndSpand}>:<{$lang->menu->qingDian}></b></div>
<div class='divOperation'>	
    <form name="myform" id="myform" method="post" action="<{$URL_SELF}>">
	&nbsp;<{$lang->page->beginTime}>：<input type='text' name='dateStart' id='startDay' size='12' value='<{$dateStart}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
	&nbsp;&nbsp;<{$lang->page->endTime}>：<input type='text' name='dateEnd' id='endDay' size='12' value='<{$dateEnd}>'  class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
        &nbsp;&nbsp;
	<input type="image" name='search' align="absmiddle" src="/static/images/search.gif" class="input2"  />
	</form>
</div>
<br />
&nbsp;土豪赠礼数据：
<{if $tuhao_data}>
<div>   
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:700px;">
		<tr>      
			<th width="230">达标阶段</th>                       
            <th width="230">达标人数</th>                    
		</tr>
        <{foreach from=$tuhao_data item=totalv key=key}>
		<tr align="center"> 
            <td>阶段<{$totalv.phase}></td>  
			<td><{$totalv.tuhao_person}></td>                                                                          
		</tr>
        <{/foreach}>  
	</table>	
       <br />      
</div>
<{else}>
<div class="red"><{$lang->page->noData}></div>
<{/if}>
<br />

<br />
<div>&nbsp;幸运转盘数据：</div>
<{if $lucky_data}>
<div  class="a" style="  width: 350px;float: left">
    <table height="" cellspacing="0" border="0"   class="DataGrid" style="width:350px; border-right-width: 0; border-right-color: #ffffff;">
		<tr>      
          <th>获得25%绑定仙石角色名/获得绑定仙石数量</th>
         
		</tr>                   
            <{foreach from=$lucky_data.1 item=item key=key}>           
                <tr align="center">   
			<td><{$item.role_name}>/<{$item.total}></td> 
                </tr>   
            <{/foreach}>   
	</table>	
       <br />
</div>
    <div class="b" style="  width: 350px;float: left">
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:350px; border-left-width: 0">
		<tr>      
          <th>获得50%绑定仙石角色名/获得绑定仙石数量</th>
         
		</tr>                   
            <{foreach from=$lucky_data.2 item=item key=key}>
                <tr align="center">   
			<td><{$item.role_name}>/<{$item.total}></td> 
                </tr> 
            <{/foreach}>   
	</table>	
       <br />
</div>
<{else}>
<div class="red"><{$lang->page->noData}></div>
<{/if}>
<br />
</body>
</html>
