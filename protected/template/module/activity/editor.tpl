<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>活动编辑器</title>
	<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
	<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
	<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/setTime.js"></script>
	<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
	<{ if $action eq 'view'}>
	<script type="text/javascript">
		$(document).ready(function(){
			$("input").attr('disabled', 'disabled');
			$("select").attr('disabled', 'disabled');
			$("textarea").attr('disabled', 'disabled');
		})
	</script>
	<{ /if }>
	
	
	<!-- start 支持as3 的富文本编辑器	-->
	
		<link rel="stylesheet" type="text/css" href="/static/richTextEditor/richTextEditor.css" />
        <script type="text/javascript" src="/static/richTextEditor/history/history.js"></script>
        <script type="text/javascript" src="/static/richTextEditor/swfobject.js"></script>
        <script type="text/javascript">
            var swfVersionStr = "10.0.0";
            var xiSwfUrlStr = "/static/richTextEditor/playerProductInstall.swf";
            var flashvars = {};
            var params = {};
            params.quality = "high";
            params.bgcolor = "#ffffff";
            params.allowscriptaccess = "sameDomain";
            params.allowfullscreen = "true";
            var attributes = {};
            attributes.id = "richTextEditor";
            attributes.name = "richTextEditor";
            attributes.align = "middle";
            swfobject.embedSWF(
                "/static/richTextEditor/richTextEditor.swf", "flashContent",
                "100%", "100%", 
                swfVersionStr, xiSwfUrlStr, 
                flashvars, params, attributes);
			swfobject.createCSS("#flashContent", "display:block;text-align:left;");
			
			function setHtmlToEditor(){
				var str = '<{$desc}>';
				return str;
			}
			
			function getHtmlFromEditor(strHtml){
				document.getElementById("activity_text").value = strHtml;
			}
        </script>
    
<!-- end 支持as3 的富文本编辑器 -->
</head>
	
<body>
<div id="position"><{$lang->menu->class->activity}>：<{$title}></div>
<{ if $title eq '排行榜类' }>
<form action="rankEdit.php?action=<{$action}>&id=<{$item.id}>" method="POST" >
<{ elseif $title eq '收集类' }>
<form action="collectEdit.php?action=<{$action}>&id=<{$item.id}>" method="POST" >
<{ elseif $title eq '充值类' }>
<form action="chargeEdit.php?action=<{$action}>&id=<{$item.id}>" method="POST" >
<{ /if }>

    <!-- <input type='hidden' value="<{$id}>" name='id' />
    <input type='hidden' value="<{$activity_type}>" name='activity_type' />
    <input type='hidden' value="submit" name='action' > -->
    
    <table class="DataGrid">
        <tr>
            <th>活动名称</th>
            <td><input type='text' name='activity_title' id='test' style="width:490px;" value="<{$item.name}>" class="require" /></td>
        </tr>
        <tr>
            <th>活动介绍</th>
	        <td valign="top">
	        <!-- start 支持as3 的富文本编辑器	-->
			<div id="richTextEditorDiv" style="width:497px; height:335px; float:left;">
        	<!-- start 若版本不支持 打印提示	-->
	        <div id="flashContent">
	        	<p>
		        	To view this page ensure that Adobe Flash Player version 
					10.0.0 or greater is installed. 
				</p>
				<script type="text/javascript"> 
					var pageHost = ((document.location.protocol == "https:") ? "https://" :	"http://"); 
					document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='"+ pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
				</script> 
			</div>
			<!-- end  若版本不支持 打印提示	-->
	   	 
	       	<noscript>
	            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="richTextEditor">
	                <param name="movie" value="richTextEditor.swf" />
	                <param name="quality" value="high" />
	                <param name="bgcolor" value="#ffffff" />
	                <param name="allowScriptAccess" value="sameDomain" />
	                <param name="allowFullScreen" value="true" />
	                <!--[if !IE]>-->
	                <object type="application/x-shockwave-flash" data="/static/richTextEditor/richTextEditor.swf" width="100%" height="100%">
	                    <param name="quality" value="high" />
	                    <param name="bgcolor" value="#ffffff" />
	                    <param name="allowScriptAccess" value="sameDomain" />
	                    <param name="allowFullScreen" value="true" />
	                <!--<![endif]-->
	                <!--[if gte IE 6]>-->
	                	<p> 
	                		Either scripts and active content are not permitted to run or Adobe Flash Player version
	                		10.0.0 or greater is not installed.
	                	</p>
	                <!--<![endif]-->
	                    <a href="http://www.adobe.com/go/getflashplayer">
	                        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" />
	                    </a>
	                <!--[if !IE]>-->
	                </object>
	                <!--<![endif]-->
	            </object>
		    </noscript>	
			</div>
			<!-- end 支持as3 的富文本编辑器	-->
	        <textarea style="display:none;" rows="6" cols="80" id="activity_text" name="activity_text" class="require"><{$item.desc|@stripslashes}></textarea>
	        <div style="display:inline; width:800px; float:left; color:red;">
			<h3>活动类型说明</h3><br/>
			（一）整合：同一活动下的所有子活动，只能领取其中一个，如排行榜只能领取一个名次的奖励。<br/>
			（二）独立：同一活动下的所有子活动，均可领取一次，如充值累计。<br/>
			（三）无限：同一活动下所有子活动，均可无限领取，如单笔充值。<br/>
			</div>
			<!-- <textarea style="width:490px; float:left;" rows="6" cols="80" id="activity_text" name="activity_text" class="require" ><{$item.desc}></textarea> -->
			<br/>
			</td>
        </tr>
        <tr>
            <th>可见时间</th>
            <td><div class = "timeset">
                <select id="v_time_state" name="v_time_state" class="time_type" >
                    <option value =0 selected >固定时间</option>
                    <option value =1 >开服</option>
                </select>
                </div>
                <div id="v_time_absolute" class="timeset ts_abs" >
                开始时间：<input type="text" class="Wdate" name="v_start_time" id="v_start_time" onfocus="WdatePicker({el:'v_start_time',dateFmt:'yyyy-MM-dd HH:mm:00',minDate:'',maxDate:''})"  value="<{$item.showTimeBegin}>" />
                结束时间：<input type="text" class="Wdate" name="v_end_time" id="v_end_time" onfocus="WdatePicker({el:'v_end_time',dateFmt:'yyyy-MM-dd HH:mm:00',minDate:'',maxDate:''})"  value="<{$item.showTimeEnd}>" />
                </div>
                <div id="v_time_relative" class="timeset ts_rel" >
                第<input type="text" name="v_start_open_day" id="v_start_open_day" value="<{$item.v_start_open_day}>" /> 天
                <input type="text" name="v_start_open_time" id="v_start_open_time" onfocus="_SetTime(this)" value="<{$item.v_start_open_time}>" />
      ~ 第<input type="text" name="v_end_open_day" id="v_end_open_day" value="<{$item.v_end_open_day}>" /> 天
      			<input type="text" name="v_end_open_time" id="v_end_open_time" onfocus="_SetTime(this)" value="<{$item.v_end_open_time}>" />
                </div>
            </td>
        </tr>
        <tr>
            <th>活动时间</th>
            <td><div class = "timeset">
                <select id="a_time_state" name="a_time_state" class="time_type" >
                    <option value =0 selected >固定时间</option>
                    <option value =1 >开服</option>
                </select>
                </div>
                <div id="a_time_absolute" class="timeset ts_abs" >
                开始时间：<input type="text" class="Wdate" name="a_start_time" id="a_start_time" onfocus="WdatePicker({el:'a_start_time',dateFmt:'yyyy-MM-dd HH:mm:00',minDate:'',maxDate:''})"  value="<{$item.actBegin}>" />
                结束时间：<input type="text" class="Wdate" name="a_end_time" id="a_end_time" onfocus="WdatePicker({el:'a_end_time',dateFmt:'yyyy-MM-dd HH:mm:00',minDate:'',maxDate:''})"  value="<{$item.actEnd}>" />
                </div>
                <div id="a_time_relative" class="timeset ts_rel" >
                第<input type="text" name="a_start_open_day" id="a_start_open_day" value="<{$item.a_start_open_day}>" /> 天
                <input type="text" name="a_start_open_time" id="a_start_open_time" onfocus="_SetTime(this)"  value="<{$item.a_start_open_time}>" />
      ~ 第<input type="text" name="a_end_open_day" id="a_end_open_day" value="<{$item.a_end_open_day}>" /> 天
      			<input type="text" name="a_end_open_time" id="a_end_open_time" onfocus="_SetTime(this)" value="<{$item.a_end_open_time}>" />
                </div>
            </td>
        </tr>
        <tr>
            <th>领奖时间</th>
            <td><div class = "timeset">
                <select id="r_time_state" name="r_time_state" class="time_type" >
                    <option value =0 selected >固定时间</option>
                    <option value =1 >开服</option>
                </select>
                </div>
                <div id="r_time_absolute" class="timeset ts_abs" >
                开始时间：<input type="text" class="Wdate" name="r_start_time" id="r_start_time" onfocus="WdatePicker({el:'r_start_time',dateFmt:'yyyy-MM-dd HH:mm:00',minDate:'',maxDate:''})"  value="<{$item.timeAwardBegin}>" />
                结束时间：<input type="text" class="Wdate" name="r_end_time" id="r_end_time" onfocus="WdatePicker({el:'r_end_time',dateFmt:'yyyy-MM-dd HH:mm:00',minDate:'',maxDate:''})"  value="<{$item.timeAwardEnd}>" />
                </div>
                <div id="r_time_relative" class="timeset ts_rel" >
                第<input type="text" name="r_start_open_day" id="r_start_open_day" value="<{$item.r_start_open_day}>" /> 天
                <input type="text" name="r_start_open_time" id="r_start_open_time" onfocus="_SetTime(this)"  value="<{$item.r_start_open_time}>" />
      ~ 第<input type="text" name="r_end_open_day" id="r_end_open_day" value="<{$item.r_end_open_day}>" /> 天
      			<input type="text" name="r_end_open_time" id="r_end_open_time" onfocus="_SetTime(this)"  value="<{$item.r_end_open_time}>" />
                </div>
            </td>
        </tr>
        <tr>
            <th>活动类型</th>
            <td>
            	<select name="subActivity" class="require" >
            		<{ if $title eq '排行榜类' }>
            			<{html_options options=$rankType selected=$item.cmd}>
            		<{ elseif $title eq '收集类' }>
            			<{html_options options=$collectType selected=$item.cmd}>
            		<{ elseif $title eq '充值类' }>
            			<{html_options options=$chargeType selected=$item.cmd}>
            		<{ /if }>
                </select>
                整合:<input type="radio" name="awardType" value="1" <{ if $item.awardType eq 1 }> checked="checked" <{ /if }> <{ if $item.awardType eq 0 }> checked="checked" <{ /if }> />
                独立:<input type="radio" name="awardType" value="2" <{ if $item.awardType eq 2 }> checked="checked" <{ /if }> />
                无限:<input type="radio" name="awardType" value="3" <{ if $item.awardType eq 3 }> checked="checked" <{ /if }> />
            </td>
        </tr>
        <tr>
            <td colspan=2>
                <table id="tblPrizes" class="SumDataGrid" width="auto" border="1" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                       <th>完成条件</th>
                       <!-- <th>奖励类型1:结果翻倍</th> -->
                       <th>奖励类型:奖励道具</th>
                       <th><input type="button" id="btnAddPrize" value="添加条件" style="color:green" /></th>
                   </tr>
                    </thead>
                   <tbody>

    <{foreach from=$item.conditionAward item=item key=key}>
        <tr>
            <{ if $title eq '排行榜类' }>
            	<td>第<input type="text" size="4" name="prizes[<{$key}>][startLevel]" value="<{$item.startLevel}>" class="require" />名~第<input type="text" size="4" name="prizes[<{$key}>][endLevel]" value="<{$item.endLevel}>" class="require" />名</td>
            <{ elseif $title eq '收集类' }>
              
            	<td>
                    <div style="text-align:right;">如果为道具，则不可选择装备来作为完成条件！<input type="button" style="color:green" class="add_condition" value="增加条件" /></div>
                   
                    <{foreach from=$item.collectEquip item=equip key=equip_key}>
                       <div class="award_condition">
                        收集物ID：<input type="text" name="prizes[<{$key}>][collectEquip][<{$equip_key}>]" value="<{$item.collectEquip[$equip_key]}>" class="require prizes changeindex <{$cmd}>" id="fromPrizes<{$key}>" /> 
                        件数：<input type="text" size="4" name="prizes[<{$key}>][collectNum][<{$equip_key}>]" value="<{$item.collectNum[$equip_key]}>" class="require changeindex" />
                         回收？：
                            <label>是<input type="radio" name="prizes[<{$key}>][collectRecycle][<{$equip_key}>]" value="1" class="changeindex" <{if $item.collectRecycle[$equip_key] == '1'}>checked<{/if}> /></label>
                            <label>否<input type="radio" name="prizes[<{$key}>][collectRecycle][<{$equip_key}>]" value="0" class="changeindex" <{if $item.collectRecycle[$equip_key] == '0'}>checked<{/if}> /></label>
                            <input type="button"  style="color:red" value="删除条件" class="delete_condition"/>
                        </div>
                     <{/foreach}>
                </td>
               
            <{ elseif $title eq '充值类' }>
            	<td>充值数额：<input type="text" size="8" name="prizes[<{$key}>][startLevel]" value="<{$item.startLevel}>" class="require" /> ~ <input type="text" size="8" name="prizes[<{$key}>][endLevel]" value="<{$item.endLevel}>" class="require" /></td>
            <{ /if }>
            <td class="items">
            <table class="tblItems" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th scope="col">物品ID</th>
                        <th scope="col">数量<font color='red'>(注:装备只能一件)</font></th>
                        <th scope="col">是否绑定</th>
                        <th scope="col">颜色</th>
                        <th scope="col">品质</th>
                        <th scope="col"><input type="hidden" class="prizeIndex" value="<{$key}>" /><input type="button" class="addItem" value="添加奖励" style="color:green" /></th>
                    </tr>
                </thead>
                <tbody>
                    <{foreach from=$item.items item=item2 key=key2}>
                    <tr>
                        <td><input type="text" value="<{$item2.type_id}>" name="prizes[<{$key}>][items][<{$key2}>][type_id]" class="require" id="fromItems<{$key}><{$key2}>" /></td>
                        <td><input type="text" size="2" value="<{$item2.number}>" name="prizes[<{$key}>][items][<{$key2}>][number]" class="require" /></td>
                        <td>
                        	绑定:<input type="radio" class="bind" <{ if $item2.bind eq 0 }><{ else }> checked="checked" <{ /if }> name="prizes[<{$key}>][items][<{$key2}>][bind]" value="1" />
                        	不绑定:<input type="radio" class="bind" <{ if $item2.bind eq 0 }> checked="checked" <{ /if }> name="prizes[<{$key}>][items][<{$key2}>][bind]" value="0" />
                        </td>
                        <td>
                        	<select name="prizes[<{$key}>][items][<{$key2}>][color]" class="color" >
                        		<option value='999'></option>
                        		<option value='6'>随机</option>
                                <{html_options options=$equipColor selected=$item2.color }>
                            </select>
                        </td>
                        <td>
                        	<select name="prizes[<{$key}>][items][<{$key2}>][quality]" class="quality" >
                        		<option value='999'></option>
                        		<option value='6'>随机</option>
                                <{html_options options=$equipQuality selected=$item2.quality }>
                            </select>
                        </td>
                        <td><input type="button" href="javascript:void(0);" class="delItem" value="删除奖励" style="color:red" /></td>
                    </tr>
                    <{/foreach}>
                   
                </tbody>
            </table>
            </td>
            <td><input type="button" href="javascript:void(0);" class="delPrize" value="删除条件" style="color:red" /></td>
        </tr>
    <{/foreach}>
                   </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan=2>
                 <input type="submit" name="submit" id="submit" value="提交" />
            </td>
        </tr>
    </table>
   </form>
</body>

<textarea style="display:none"  id="itemTpl">
 <tr>
  <td><input type="text" name="prizes[_index_][items][_itemIndex_][type_id]" class="require" id="items_index__itemIndex_" /></td>
  <td><input type="text" size="2" name="prizes[_index_][items][_itemIndex_][number]" class="require" /></td>
  <td>
  	绑定:<input type="radio" name="prizes[_index_][items][_itemIndex_][bind]" checked="checked" value="1" />
  	不绑定:<input type="radio" name="prizes[_index_][items][_itemIndex_][bind]" value="0" />
  </td>
  <td>
  	<select name="prizes[_index_][items][_itemIndex_][color]" class="color" >
  		<option value='999'></option>
  		<option value='6'>随机</option>
  		<{ html_options options=$equipColor }>
  	</select>
  </td>
  <td>
  	<select name="prizes[_index_][items][_itemIndex_][quality]" class="quality" >
  		<option value='999'></option>
  		<option value='6'>随机</option>
  		<{ html_options options=$equipQuality }>
  	</select>
  </td>  
  <td><input type="button" href="javascript:void(0);" class="delItem" value="删除奖励" style="color:red" /></td>
</tr>
</textarea>

<textarea style="display:none" id="prizeTpl">
    <tr>
    <{ if $title eq '排行榜类' }>
      <td>第<input type="text" size="2" name="prizes[_index_][startLevel]" class="require" />名~第<input type="text" size="4" name="prizes[_index_][endLevel]" class="require" />名</td>
    <{ elseif $title eq '收集类' }>
      <td>
         
        <div style="text-align:right;">如果为道具，则不可选择装备来作为完成条件！<input type="button" style="color:green" class="add_condition" value="增加条件" /></div>
        <div class="award_condition">
            收集物ID：<input type="text" name="prizes[_index_][collectEquip][_pindex_]" class="require prizes changeindex" id="prizes_index_"/> 
            件数：<input type="text" size="4" name="prizes[_index_][collectNum][_pindex_]" class="require changeindex" />
            回收？：
                <label>是<input type="radio" name="prizes[_index_][collectRecycle][_pindex_]" value="1" class="changeindex" /></label>
                <label>否<input type="radio" name="prizes[_index_][collectRecycle][_pindex_]" value="0" class="changeindex" /></label>
            <input type="button"  style="color:red" value="删除条件" class="delete_condition"/>
        </div>
    </td>
    <{ elseif $title eq '充值类' }>
      <td>充值金额：<input type="text" size="8" name="prizes[_index_][startLevel]" class="require" /> ~ <input type="text" size="8" name="prizes[_index_][endLevel]" class="require" /></td>
    <{ /if }>
      <td class="items">
      <table class="tblItems" width="100%" border="0" cellspacing="0" cellpadding="0">
      <thead>
      <tr>
      	<th scope="col">物品ID</th>
      	<th scope="col">数量<font color='red'>(注:装备只能一件)</font></th>
      	<th scope="col">是否绑定</th>
      	<th scope="col">颜色</th>
      	<th scope="col">品质</th>
      	<th scope="col"><input type="hidden" class="prizeIndex" value="_index_" /><input type="button" class="addItem" value="添加奖励" style="color:green" /></th>
      </tr>
      </thead>
      		<tbody>
                <tr>
                  <td><input type="text" name="prizes[_index_][items][0][type_id]" class="require" id="items_index_0" /></td>
                  <td><input type="text" size="2" name="prizes[_index_][items][0][number]" class="require" /></td>
                  <td>
                  		绑定:<input type="radio" name="prizes[_index_][items][0][bind]" checked="checked" value="1" />
                  		不绑定:<input type="radio" name="prizes[_index_][items][0][bind]" value="0" />
                  </td>
                  <td>
                  	<select name="prizes[_index_][items][0][color]" class="color" >
                  		<option value="999"></option>
                  		<option value='6'>随机</option>
                  		<{html_options options=$equipColor}>
                  	</select>
                  </td>
                  <td>
                  	<select name="prizes[_index_][items][0][quality]" class="quality" >
                  		<option value="999"></option>
                  		<option value='6'>随机</option>
                  		<{html_options options=$equipQuality}>
                  	</select>
                  </td>          
                  <td><input type="button" href="javascript:void(0);" class="delItem" value="删除奖励" style="color:red" /></td>
                </tr>
            </tbody>
        </table>
        <br />
        </td>
      <td><input type="button" href="javascript:void(0);" class="delPrize" value="删除条件" style="color:red" /></td>
    </tr>
</textarea>

<script language="javascript" > 
var added = false;
jQuery(document).ready(function(){
		$('#v_time_state').val("<{$v_status}>");
        $('#a_time_state').val("<{$a_status}>");
        $('#r_time_state').val("<{$r_status}>");
        changeTimeStatus('#v_time_state');
        changeTimeStatus('#a_time_state');
        changeTimeStatus('#r_time_state');

        window.prizeIndex = $("#tblPrizes>tbody>tr").size();
        window.itemIndex = $(".tblItems>tbody>tr").size();

        var itemList = <{$itemList|@json_encode}>;
        var suitList = <{$suitList|@json_encode}>;
        
        $("#btnAddPrize").click(function(){

            if ( $('select[name=subActivity]').val() == '' ) {
                alert( '请先选择二级活动!' );
                return;
            };

            if( !added ){
                $('select[name=subActivity]').change(function(e){
                    console.log(e);
                    console.log(this)
                })
            }


            var strTrPrize =  $("#prizeTpl").text();
            strTrPrize = strTrPrize.replace(/_index_/g,window.prizeIndex);
            strTrPrize = strTrPrize.replace(/_pindex_/g,0);
            $("#tblPrizes>tbody").append(strTrPrize);
            $("#tblPrizes>tbody>tr:last>td .delPrize").bind("click",delPrize);
            $("#tblPrizes>tbody>tr:last>td .addItem").bind("click",addItem);
            $("#tblPrizes>tbody>tr:last>td .delItem").bind("click",delItem);

            $.autolist({
        		bind: "items" + window.prizeIndex + "0",
        		options: <{$itemList|@json_encode}>,
        		onItemClick: function(key, item, sth){
            		sth.val(key);
        		},
        		onReset: function(){
        		}
        	});

        	if ( '<{$title}>' == '收集类' ){
            	if ( $('select[name=subActivity]').val() == 'collect_suit' ){
            		$.autolist({
                		bind: "prizes" + window.prizeIndex,
                		options: <{$suitList|@json_encode}>,
                		onItemClick: function(key, item, sth){
                    		sth.val(key);
                		},
                		onReset: function(){
                		}
                	});
            	} else {
            		$.autolist({
                		bind: "prizes" + window.prizeIndex,
                		options: <{$itemList|@json_encode}>,
                		onItemClick: function(key, item, sth){
                    		sth.val(key);
                		},
                		onReset: function(){
                		}
                	});
            	}
        	};
            
            window.itemIndex +=1;
            window.prizeIndex +=1;
            added = true;
            return false;
        });
        $("#tblPrize>tbody>tr>td:not(.items)").click(textFocus);
        $(".delPrize").click(delPrize);
        $(".delItem").click(delItem);
        $(".addItem").click(addItem);

        $(".time_type").change(function(){ //事件發生  
            changeTimeStatus(this);
        });

        $("#submit").click(function(){ // 验证是否留空白

            if ( $("#v_time_state").val() == 0 ){
                if ( $("#v_start_time").val() == '' || $("#v_end_time").val() == '' ){
                    alert('活动可见时间不能为空！');
                    return false;
                }
            } else if ( $("#v_time_state").val() == 1 ){
                if ( $("#v_start_open_day").val() == '' || $("#v_start_open_time").val() == '' || $("#v_end_open_day").val() == '' || $("#v_end_open_time").val() == '' ){
                    alert('活动可见时间不能为空！');
                    return false;
                }
            };
            
            if ( $("#a_time_state").val() == 0 ){
                if ( $("#a_start_time").val() == '' || $("#a_end_time").val() == '' ){
                    alert('活动开始时间不能为空！');
                    return false;
                }
            } else if ( $("#a_time_state").val() == 1 ){
                if ( $("#a_start_open_day").val() == '' || $("#a_start_open_time").val() == '' || $("#a_end_open_day").val() == '' || $("#a_end_open_time").val() == '' ){
                    alert('活动开始时间不能为空！');
                    return false;
                }
            };

            if ( $("#r_time_state").val() == 0 ){
                if ( $("#r_start_time").val() == '' || $("#r_end_time").val() == '' ){
                    alert('活动领奖时间不能为空！');
                    return false;
                }
            } else if ( $("#r_time_state").val() == 1 ){
                if ( $("#r_start_open_day").val() == '' || $("#r_start_open_time").val() == '' || $("#r_end_open_day").val() == '' || $("#r_end_open_time").val() == '' ){
                    alert('活动领奖时间不能为空！');
                    return false;
                }
            };
            
            var color = true;
            $(".color").each(function(){
            	var isEquip = $(this).parent().parent().find("input[id*=items]").val().substring(0, 1);
                if( $.trim(this.value) == '999' && isEquip == '2' ){
                    alert('装备颜色不能为空！');
                    color=false;
                    return false;
                };
            });
            if ( color == false ){
                return color;
            };

            var quality = true;
            $(".quality").each(function(){
            	var isEquip = $(this).parent().parent().find("input[id*=items]").val().substring(0, 1);
                if( $.trim(this.value) == '999' && isEquip == '2' ){
                    alert('装备品质不能为空！');
                    quality=false;
                    return false;
                };
            });
            if ( quality == false ){
                return quality;
            };

            var ret = true;
            $(".require").each(function(){
                if( $.trim(this.value) == '' ){
                    alert('还有空没填！');
                    ret=false;
                    return false;
                };
            });
            return ret;
        });

        $("input[id^='fromPrizes']").bind('click' , function(){
            var tmp = this.id;
            var list = $(this).hasClass('collect_item')? itemList: suitList;
        	$.autolist({
        		bind: tmp,
        		options: list,
        		onItemClick: function(key, item, sth){
            		sth.val(key);
        		},
        		onReset: function(){
        		}
        	});
        	$(this).unbind('click')
        	$(this).trigger('focusin')
        })
        $("input[id^='fromItems']").bind('click' , function(){
            var tmp = this.id;
            var list = $(this).hasClass('collect_item')? itemList: suitList;
        	$.autolist({
        		bind: tmp,
        		options:  itemList,
        		onItemClick: function(key, item, sth){
            		sth.val(key);
        		},
        		onReset: function(){
        		}
        	});
        	$(this).unbind('click')
        	$(this).trigger('focusin')
        })

    $('input.add_condition').live('click', function(){
        var c = $(this).parent().parent().find('div.award_condition');
        c = c[c.length - 1];
        c = $(c).clone();
        
        var id = 'prizes_' +  Math.floor(Math.random()*1000000000);
    //    console.log(id);
        c.find('input[type=text]').val('');
        c.find('input.prizes').attr('id', id);
        c.find('.changeindex').each(function(){
            var name = $(this).attr('name');
            var k = parseInt( name.substring(name.lastIndexOf('[') + 1, name.lastIndexOf(']')) ) + 1;
            name = name.substring(0, name.lastIndexOf('[') );
            name = name + '[' + k + ']';
            $(this).attr('name', name);
        })
        $(this).parent().parent().append(c);
        $.autolist({
            bind: id,
            options: <{$itemList|@json_encode}>,
            onItemClick: function(key, item, sth){
                sth.val(key);
                //$("input[id*=prizes]").val(key);
            },
            onReset: function(){
                //$("input[id*=prizes]").val('');
            }
        });
   //     console.log();
   //     console.log( $(this).parent().parent().find('div.award_condition'))
    })

    $('input.delete_condition').live('click', function(){
        if(confirm('确认删除该条件？')){
             $(this).parent().remove();
        }
    })
});

function changeTimeStatus(dom){
    if($(dom).children('option:selected').val()==0){
            $(dom).parent().parent().children('.ts_abs').css('display','block');
            $(dom).parent().parent().children('.ts_rel').css('display','none');
        
        }else{
            $(dom).parent().parent().children('.ts_abs').css('display','none');
            $(dom).parent().parent().children('.ts_rel').css('display','block');
        }
}
    
    function textFocus(){
        $(this).find(":text").focus();
        return false;
    }
    
    function delPrize(){
        $(this).parent().parent().remove();
        return false;
    }
    
    function delItem(){
        $(this).parent().parent().remove();
        return false;
    }
    
    function addItem(){
        var strTrItem = $("#itemTpl").text();
        var condIndex = $(this).parent().find(".prizeIndex").val();
        strTrItem = strTrItem.replace(/_index_/g,condIndex);
        strTrItem = strTrItem.replace(/_itemIndex_/g,window.itemIndex); 
        var tbody = $(this).parent().parent().parent().parent().find("tbody");
        tbody.append(strTrItem);

        $.autolist({
    		bind: "items" + condIndex + window.itemIndex,
    		options: <{$itemList|@json_encode}>,
    		onItemClick: function(key, item, sth){
        		sth.val(key);
    			//$("input[id*=prizes]").val(key);
    		},
    		onReset: function(){
    			//$("input[id*=prizes]").val('');
    		}
    	});
     
        window.itemIndex += 1;
        tbody.find("tr:last .delItem").bind("click",delItem);
   
        return false;
    }
</script>

</html>