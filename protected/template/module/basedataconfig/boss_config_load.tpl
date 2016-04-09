<!--
<script language="javascript">
    var itemArray = new Array();
    
function searchItem(){
//    document.getElementById('itemlist').style.display="block";
    $("#itemlist").css("display","block");
    var keyword = document.getElementById('wuwu').value 
    var onArray = new Array();
    for(kid in itemArray) {
            if(itemArray[kid].indexOf(keyword) !=-1 ){
                    onArray[kid] = itemArray[kid];
            }
    }
    var str='<ul><li style="text-align:right;"><a href="javascript:;" onclick="hiddenlist();">关闭</a></li>';
    for(iid in onArray) {
            str += '<li onclick="selectItem('+iid+');">'+onArray[iid]+'</li>';
    }
    str += '</ul>';
    document.getElementById('itemlist').innerHTML = str ;
}
function hiddenlist(){
     document.getElementById('itemlist').style.display="none";
}
function selectItem(iid){
     document.getElementById('item_id').value = iid;
     document.getElementById('wuwu').value = itemArray[iid];
     document.getElementById('itemlist').style.display="none";
}
</script>
-->

    <table height="" style="width:850px" cellspacing="0" border="0" class="DataGrid">
            <tr>
                <td><{$lang->bossconfig->confname}></td>
                <td>
                    <div style="float:left;margin-right: 10px;">
                    <form action="" id="bname" method="post" class="myform">
                    <input type="text" name="bossname" id="bossname" value="<{$info.name}>"/>
                    <input type="hidden" name="bossid" value="<{$bossid}>"/>
                    <input type="submit" value="<{$lang->bossconfig->rename}>" class="input2" name="xiu">
                    <span id="span" name="span"></span>
                        </form>
                    </div>
                    <div style="float:left"><font color="red" id="cssw" name="cssw"><{if $info.bossstatus==0}><{$lang->bossconfig->deal}><{else}><{$lang->bossconfig->birth}><{/if}></font></div>
                <div style="float:left;margin-right: 10px;">
                    <form id="sheng" action="?ac=status" method="post" class="myform">
                                <input type="hidden" value="1" name="stat"/>
                                <input type="hidden" name="bossid" value="<{$bossid}>"/>
                            <input type="submit" value="<{$lang->bossconfig->birth}>" class="input2" name="spawn">
                            <span id="span" name="span"></span>
                    </form>
                </div>
                    
                    <div style="float:left;margin-right: 10px;">
                        <form id="deal" action="?ac=status" method="post" class="myform">
                                <input type="hidden" value="2" name="stat"/>
                                <input type="hidden" name="bossid" value="<{$bossid}>"/>
                                <input type="submit" value="<{$lang->bossconfig->deal}>" class="input2" name="kill"/>
                                <span id="span" name="span"></span>
                        </form>
                    </div>
                    
                    <div style="float:left;">
                        <form id="qingkong" action="?ac=del" method="post" class="myform">
                                <input type="hidden" name="bossid" value="<{$bossid}>"/>
                                <input type="submit" value="<{$lang->bossconfig->delete}>"  name="qingkong"/>
                                <span id="span" name="span"></span>
                        </form>
                    </div>
                    
                </td>
            </tr>
            <tr>
                <td><{$lang->bossconfig->choice}></td>
                <td>
                 <form id="xboss" action="?ac=setbo" method="post">
                 <input type="text" class="bossiz" name="bossi" id="bossi" value="<{$bos}>"/>
                <!-- <select name="bossi">
                     <{html_options options=$bossdata selected=$info.bossID }>
                 </select>
                -->
                 <input type="hidden" name="bossid" value="<{$bossid}>"/>
                 <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                 <font color="red">*</font>
                 <span id="span" name="span"></span>
                    </form>
                </td>
                
            </tr>
            <tr>
                <td><{$lang->bossconfig->where}></td>
                <td>
                    <form id="cddd" action="?ac=setwhere" method="post">
                    <{$lang->bossconfig->bossmap}>:
                    <select name="mapdata">
                     <{html_options options=$mapdata selected=$info.mapID}>
                    </select>
                    <input type="hidden" name="bossid" value="<{$bossid}>"/>
                    x:<input type="text" name="x" value="<{$info.mapX}>"/> y:<input name="y" type="text" value="<{$info.mapY}>"/>
                        <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                        <font color="red">*</font>
                        <span id="span" name="span"></span>
                    </form>
                </td>
            </tr>
            <tr>
                <td><{$lang->bossconfig->birthday}></td>
                <td>
                <form id="cssj" action="?ac=setbirth" method="post">
                
               <div class = "timeset">
                <select id="birthtime" name="birthtime" class="time_type" >
                    <option value =0 selected ><{$lang->bossconfig->fix}></option>
                    <option value =1 ><{$lang->bossconfig->kfafter}></option>
                </select>
                </div>
                <div id="r_time_absolute" class="timeset ts_abs" >
                <{$lang->page->beginTime}>：<input type="text" class="Wdate" name="birtime" id="birtime" onfocus="WdatePicker({el:'birtime',dateFmt:'yyyy-MM-dd HH:mm:00',minDate:'',maxDate:''})"  value="<{$startd|date_format:"%Y-%m-%d %H:%M:%S"}>" />
                <{$lang->page->beginTime}>：<input type="text" class="Wdate" name="birtime2" id="birtime2" onfocus="WdatePicker({el:'birtime2',dateFmt:'yyyy-MM-dd HH:mm:00',minDate:'',maxDate:''})"  value="<{$endd|date_format:"%Y-%m-%d %H:%M:%S"}>" />
                </div>
                <div id="r_time_relative" class="timeset ts_rel" >
                <{$lang->bossconfig->di}><input type="text" name="birtimet" id="birtimet" value="" /> <{$lang->time->day2}>
                <input type="text" name="starttime" id="r_start_open_time" onfocus="_SetTime(this)"  value="" />
      ~ <{$lang->bossconfig->di}><input type="text" name="birtime2t" id="birtime2t" value="" /> <{$lang->time->day2}>
      			<input type="text" name="endtime" id="r_end_open_time" onfocus="_SetTime(this)"  value="" />
                </div>
                <input type="hidden" name="bossid" value="<{$bossid}>"/>
                <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                <font color="red">*</font>
                <span id="span" name="span"></span>
                </form>
                    <br/>
                <{$lang->bossconfig->csrqts}>
                </td>
            </tr>
            <tr>
                <td><{$lang->bossconfig->rebirth}></td>
                <td>
                <form id="cssj" action="?ac=csdate" method="post">
                <input type="text" name="cs" id="cs" onfocus="_SetTime(this)" value="<{$info.respawn.0.0}><{if $info.respawn.0.1}>:<{$info.respawn.0.1}><{/if}>"/>
                <input type="text" name="cs2" id="cs2" onfocus="_SetTime(this)" value="<{$info.respawn.1.0}><{if $info.respawn.1.1}>:<{$info.respawn.1.1}><{/if}>"/>
                
                </div>
                <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                <font color="red">*</font>
                <span id="span" name="span"></span>
                <input type="hidden" name="bossid" value="<{$bossid}>"/>
                </form>
                    <br/>
                <{$lang->bossconfig->csrqts2}>
                </td>
            </tr>
            
            <tr>
                <td><{$lang->bossconfig->modelling}></td>
                <td>
                 <form id="bszx" action="?ac=setzx" method="post">
                 <select name="zx">
                     <{html_options options=$zhaoxing selected=$info.bodyId}>
                 </select>
                 <input type="hidden" name="bossid" value="<{$bossid}>"/>
                 <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                 <span id="span" name="span"></span>
                </form>
                </td>
            </tr>
            <tr>
                <td><{$lang->bossconfig->lv}></td>
                <td>
                <form id="bsdj" action="?ac=setlv" method="post">
                <input type="text" name="lv" id="lv" value="<{$info.lv}>"/>
                <input type="hidden" name="bossid" value="<{$bossid}>"/>
                <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                <span id="span" name="span"></span>
                </form>
                </td>
                
            </tr>
            <tr>
                <td><{$lang->bossconfig->maxhp}></td>
                <td>
                <form id="bzxl" action="?ac=setxl" method="post">
                 <input type="text" name="xl" id="xl" value="<{$info.maxHP}>"/>
                 <input type="hidden" name="bossid" value="<{$bossid}>"/>
                <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                <span id="span" name="span"></span>
                </form>
                </td>
            </tr>
            <tr>
                <td><{$lang->bossconfig->attack}></td>
                <td>
                <form id="bgjl" action="?ac=setgj" method="post">
                <input type="text" name="gj" id="gj" value="<{$info.attack}>"/>
                <input type="hidden" name="bossid" value="<{$bossid}>"/>
                <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                <span id="span" name="span"></span>
                </form>
                </td>
            </tr>
            <tr>
                <td><{$lang->bossconfig->defensive}></td>
                <td>
                <form id="bfyl" action="?ac=setfy" method="post">
                <input type="text" name="fy" id="fy" value="<{$info.defense}>"/>
                <input type="hidden" name="bossid" value="<{$bossid}>"/>
                <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                <span id="span" name="span"></span>
                </form>
                </td>
                
            </tr>
        							
            <tr>
                <td><{$lang->bossconfig->suppress}></td>
                <td>
                    <form id="yazhi" action="?ac=setyz" method="post">
                <table cellspacing="0" border="0" class="DataGrid">
                <tr>
                  <th><{$lang->bossconfig->bosspower}></th>
                  <th><{$lang->bossconfig->bossstrength}></th>
                  <th><{$lang->bossconfig->bossforce}></th>
                  <th><{$lang->bossconfig->bossdex}></th>
                </tr>
                 
                    <tr>
                
                        <td><input type="text" name="power" id="power" value="<{$info.power}>"/></td>
                        <td><input type="text" name="phy" id="phy" value="<{$info.phy}>"/></td>
                        <td><input type="text" name="energy" id="energy" value="<{$info.energy}>"/></td>
                        <td><input type="text" name="steps" id="steps" value="<{$info.steps}>"/></td>
                        <input type="hidden" name="bossid" value="<{$bossid}>"/>
                       
                        </tr>
                    </form>     
                        <tr><td colspan="4" align="right"><input  type="submit" value="<{$lang->page->set}>" class="input2" name="input"></td></tr>
                
                    
                </table>
                        <span id="span" name="span"></span>
                        </form>
                </td>
            </tr>
            <tr>
                <td><{$lang->bossconfig->damage}></td>
                <td>
                    <form id="myForm1" action="?ac=setzdsh" method="post">
                     <input type="text" name="zdsh" id="zdsh" value="<{$info.leastDamage}>"/>
                     <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                     <input type="hidden" name="bossid" value="<{$bossid}>"/>
                     <span id="span" name="span"></span>
                    </form>
                </td>
            </tr>
            <tr>
                <td><{$lang->bossconfig->firstdrop}></td>
                <td>
                    <form id="dyd" action="?ac=setfirstconf" method="post">
                    <{$lang->bossconfig->goods}>：
                    
                    <input type="text" class="phh" name="wupin" id="wupin" value="<{$wupin[$info.firstHit.itemId]}>"/>
                 <{$lang->bossconfig->dropoutprobability}><input style="width:50px" name="diaoluo" id="diaoluo" type="text" value="<{$info.firstHit.rate}>"/>
                 <{$lang->bossconfig->bindprobability}><input style="width:50px" name="gailu" id="gailu" type="text" value="<{$info.firstHit.bindRate}>"/>%
                 &nbsp;<{$lang->bossconfig->count}><input  style="width:50px" name="shuliang" id="shuliang" type="text" value="<{$info.firstHit.count}>"/>
                 <{$lang->bossconfig->color}><input  style="width:50px" name="color" id="color" type="text" value="<{foreach from=$info.firstHit.color item=item}><{$item}>,<{/foreach}>"/>
                 <{$lang->bossconfig->broadcast}><input  style="width:50px" name="broadcast" id="broadcast" type="text" value="<{$info.firstHit.broadcast}>"/>
                 <input type="hidden" name="bossid" value="<{$bossid}>"/>
                 <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                 <span id="span" name="span"></span>
                 </form>
                </td>
            </tr>
            <tr>
                <td><{$lang->bossconfig->lastdrop}></td>
                <td>
                    
                    <form id="zhyd" action="?ac=setlastconf" method="post">
                    <{$lang->bossconfig->goods}>：<input type="text" class="phh" name="wupin" id="wupin" value="<{$wupin[$info.lastHit.itemId]}>"/>
                 <{$lang->bossconfig->dropoutprobability}><input style="width:50px" name="diaoluo" id="diaoluo" type="text" value="<{$info.lastHit.rate}>"/>
                 <{$lang->bossconfig->bindprobability}><input style="width:50px" name="gailu" id="gailu" type="text" value="<{$info.lastHit.bindRate}>"/>%
                 &nbsp;<{$lang->bossconfig->count}><input  style="width:50px" name="shuliang" id="shuliang" type="text" value="<{$info.lastHit.count}>"/>
                 <{$lang->bossconfig->color}><input  style="width:50px" name="color" id="color" type="text" value="<{foreach from=$info.lastHit.color item=item}><{$item}>,<{/foreach}>"/>
                 <{$lang->bossconfig->broadcast}><input  style="width:50px" name="broadcast" id="broadcast" type="text" value="<{$info.lastHit.broadcast}>"/>
                 <input type="hidden" name="bossid" value="<{$bossid}>"/>
                 <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                 <span id="span" name="span"></span>
                 </form>
                </td>
            </tr>
            <tr>
                <td><{$lang->bossconfig->everydrop}></td>
                <td>
                    <input  type="button" value="<{$lang->page->add}>" name="zj" id="zj"/>
                    <form id="myd" action="?ac=setmconf" method="post">
                <div id="diaopei">
                <{foreach from=$info.normalHit item=item}>
                <div>
                <{$lang->bossconfig->goods}>：<input type="text" class="phh" name="wupin[]" id="wupin" value="<{$wupin[$item.itemId]}>"/>
                 <{$lang->bossconfig->dropoutprobability}><input style="width:50px" name="diaoluo[]" id="diaoluo" type="text" value="<{$item.rate}>"/>
                 <{$lang->bossconfig->bindprobability}><input style="width:50px" name="gailu[]" id="gailu" type="text" value="<{$item.bindRate}>"/>%
                 &nbsp;<{$lang->bossconfig->count}><input  style="width:50px" name="shuliang[]" id="shuliang" type="text" value="<{$item.count}>"/>
                 <{$lang->bossconfig->color}><input  style="width:50px" name="color[]" id="color" type="text" value="<{foreach from=$item.color item=color}><{$color}>,<{/foreach}>"/>
                 <{$lang->bossconfig->broadcast}><input  style="width:50px" name="broadcast[]" id="broadcast" type="text" value="<{$item.broadcast}>"/>
                 <input type="button" onclick="javascript:$(this).parent().remove();" id="dels" name="dels" value="<{$lang->page->del}>"/>
                 <br/>
                </div>
                 <{/foreach}>
                 </div>
                 <input type="hidden" name="bossid" value="<{$bossid}>"/>
                 <input type="submit" value="<{$lang->page->set}>" onclick="" class="input2" name="input">
                 <span id="span" name="span"></span>
                 </form>
                </td>
                 
            </tr>
                 
                 <tr>
                <td><{$lang->bossconfig->additem}></td>
                <td>
                   <form id="ddwp" name="myform" action="?ac=setwu" method="post">
                    <select style="width:100px;" multiple name="list1" size="12" ondblclick="moveOption_one(document.myform.list1, document.myform.list2)">
                        <{html_options options=$wupin }>
                    </select>
                    <input type="button" value="<{$lang->page->add}>" onclick="moveOption_one(document.myform.list1, document.myform.list2)"/>
                    <input type="button" value="<{$lang->page->del}>" onclick="moveOption(document.myform.list2, document.myform.list1)"/>
                    <select style="width:100px;" multiple name="list2" size="12" ondblclick="moveOption(document.myform.list2, document.myform.list1)">
                        <{if $zhe}>
                            <{html_options options=$zhe }>
                        <{/if}>
                    </select>
                    <br/>
                    <{$lang->bossconfig->value}>：<input type="text" name="wu" size="40" value="<{$info.command}>" />
                    <input type="hidden" name="bossid" value="<{$bossid}>"/>
                    <input type="submit" value="<{$lang->page->set}>" class="input2" name="input">
                    <span id="span" name="span"></span>
                    </form>
                
                </td>
                
                </tr>
                 
                 <tr>
                <td><{$lang->bossconfig->bossdes}></td>
                <td>
                <form id="gwms" action="?ac=setmiao" method="post">
                    <textarea cols="70" name="miao"><{$info.desc}></textarea>
                    <input type="hidden" name="bossid" value="<{$bossid}>"/>
                <input type="submit" value="设置" class="input2" name="input">
                <font color="red">*</font>
                <span id="span" name="span"></span>
                </form>
                </td>
                
                </tr>
     </table>
<br/><br/>

<script language="javascript">
    
         
         
         function moveOption(e1, e2){
            try{
                for(var i=0;i<e1.options.length;i++){
                    if(e1.options[i].selected){
                        var e = e1.options[i];
//                        e2.options.add(new Option(e.text, e.value));
                        e1.remove(i);
                        i=i-1
                    }
                }
                document.myform.wu.value=getvalue(document.myform.list2);
            }
            catch(e){}
        }
        
        function moveOption_one(e1, e2){
            try{
                for(var i=0;i<e1.options.length;i++){
                    if(e1.options[i].selected){
                        var e = e1.options[i];
                        e2.options.add(new Option(e.text, e.value));
//                        e1.remove(i);
//                        i=i-1
                    }
                }
                document.myform.wu.value=getvalue(document.myform.list2);
            }
            catch(e){}
        }
        
        function getvalue(geto){
    var allvalue = "";
    for(var i=0;i<geto.options.length;i++){
        allvalue +=geto.options[i].value + ";";
    }
    return allvalue;
}
         var ajax_load = "Loading..."; 
         
         $("#zj").click(function(){
             $("#diaopei").append("<div><{$lang->bossconfig->goods}>：<input type='text' class='phh' name='wupin[]' id='wupin' value=''/>&nbsp;<{$lang->bossconfig->dropoutprobability}>&nbsp;<input style='width:50px' name='diaoluo[]' id='diaoluo' type='text' value=''/>&nbsp;<{$lang->bossconfig->bindprobability}><input style='width:50px' name='gailu[]' id='gailu' type='text' value=''/>%&nbsp;&nbsp;<{$lang->bossconfig->count}><input  style='width:50px' name='shuliang[]' id='shuliang' type='text' value=''/>&nbsp;<{$lang->bossconfig->color}><input  style='width:50px' name='color[]' id='color' type='text' value=''/>&nbsp;<{$lang->bossconfig->broadcast}><input  style='width:50px' name='broadcast[]' id='broadcast' type='text' value=''/>&nbsp;<input type='button' id='dels' onclick='javascript:$(this).parent().remove();' name='dels' value='<{$lang->page->del}>'/><br/></div>");
        })
//         $("input:image").click(function(){
//             $(this).parent().remove();
//         })
         $("form").submit(function(){
         })
        $("#test").load(function(){
        })
       
          $(document).ready(function() {
            var options = {
                target:        '#output1',   // target element(s) to be updated with server response
                beforeSubmit:  showRequest,  // pre-submit callback
                success:       showResponse,  // post-submit callback
                dataType:       'json'
            };
            $('form').ajaxForm(options);
//            arrusername = ["\u94dc\u5e01","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r"];
        changeTimeStatus('#birthtime');

        });
        
        $(".bossiz").autocomplete(bossids,{
		minChars:0,
                max:200,
	})
        
        $(".phh").autocomplete(kk,{
		minChars:0,
                max:200,
	})
        
        $("#zj").bind("click", function(){
              $(".phh").autocomplete(kk,{
		minChars:0,
                max:200,
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


        $(".time_type").change(function(){ //事件發生  
                    changeTimeStatus(this);
        });
        
        
        function showRequest(formData, jqForm, options) {
//            var queryString = $.param(formData);
//            alert('About to submit: \n\n' + queryString);
            return true;
        }
        function showResponse(responseText, statusText, xhr, $form)  {
                if($($form).attr("id") == "sheng"){$("#cssw").html("<{$lang->bossconfig->birth}>")}
                if($($form).attr("id") == "deal"){$("#cssw").html("<{$lang->bossconfig->deal}>")}
                if($($form).attr("id") == "qingkong"){
                    window.location.href="boss_config.php";
//                    $("#test").html("");
                }
                if(responseText.ret == -1)
                {
                    $($form).find("#span").html("<font color='red'><{$lang->bossconfig->argvnull}></font>");
                }
                
                if(responseText.ret == 1)
                {
                    $($form).find("#span").html("<font color='red'><{$lang->bossconfig->indexnotexist}></font>");
                }
                
                if(responseText.ret == 2)
                {
                    $($form).find("#span").html("<font color='red'><{$lang->bossconfig->confnone}></font>");
                }
                
                if(responseText.ret == 0)
                {
                    $($form).find("#span").html("<font color='red'><{$lang->bossconfig->confsucess}></font>");
                }
                
//             alert("已经设置");
//                if($($form).id=="sheng"){alert('kk');}
//                $("#cssw").val()="kk";
        }   
</script>
