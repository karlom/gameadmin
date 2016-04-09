<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><{$lang->menu->bossConfig}></title>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<script type="text/javascript" src="/static/js/jquery.form.js"></script>
<script type="text/javascript" src="/static/js/jquery.autocomplete.min.js"></script>
<script type="text/javascript" src="/static/js/setTime.js"></script>
<style type="text/css" mce_bogus="1">
#bosslist {width:300px; font-size:12px; display:inline; list-style: outside;margin: 0px;padding:0px;}  
#bosslist li {width:300px; height:22px; margin-left:20px;padding-top:5px; border-bottom: dotted 1px #999999;}  
#bosslist li .ldt { width:70px; float:right; text-align:left; color:#666; padding-top:3px;}  
#bosslist li a { height:22px; display:block; line-height:22px; color:#333; cursor:hand; }  
#bosslist li a:hover{ color:#03c; text-decoration: underline;}  
#bosslist li a .lbt {display:block; width:300px; float:left; text-indent:1px; text-decoration:none; white-space:nowrap; text-overflow:ellipsis; overflow: hidden; display:inline;}

.itemlist {
    background-color: #CCCCCC;
    display: block;
    height: 255px;
    margin: 0;
    max-height: 260px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    top: 0;
    width: 200px;
}

.ac_results{
    background-color: #FFFFFF;
/*    word-wrap:break-word;
    word-break:break-all;
    padding:1px 5px;*/
/*height:100px;*/
/*    overflow-y: scroll;*/
}

</style>
</head>


<body>
<div id="position">
<b><{$lang->menu->class->baseDataConfig}>：<{$lang->menu->bossConfig}></b>
</div>

<div id="list">
	<ul>
            <li><a href="?ac=create">【<{$lang->bossconfig->create}>】</a></li>
	</ul>
    
</div>

<div id="detail" style="width:1024px;">
    <div id="bossbar" style="float:left;">
        <ul id="bosslist">
            <{if $index}>
        <{foreach from=$index item=item }>
        <li class="item selected visibles" id="bosslist_<{$item.index}>">
				<span class="link">
					<span class="id">
						<{$item.index}>
					</span>
					<span style="cursor:pointer" onclick="toggleBossDetail(<{$item.index}>);" class="name">
						<{$item.name}>
					</span>
					<span class="copy"><a style="float:right;" href="?ac=copy&amp;type=<{$item.index}>">【<{$lang->bossconfig->copy}>】</a>
                                        <a style="float:right;" href="?ac=del&amp;bossid=<{$item.index}>">【<{$lang->bossconfig->delete}>】</a>
                                        </span>
				</span>
	</li>
            <{/foreach}>
            <{/if}>
        </ul>
        </div>
        
   <div id="test" style="float:right;width:400px;height:300px;">
    <a id="t"></a>
    </div>
</div>

     <script language="javascript">
         var ajax_load = "正在加载数据..."; 
       kk = <{$wupin|@json_encode}>;
       bossids = <{$bossdata2|@json_encode}>;
//        $("#t").click(function(){
//             $("#test").html(ajax_load).load("http://c.com/module/basedataconfig/boss_config.php?ac=kk&type=6");
//        })
        
        function toggleBossDetail(bossid) {
                var url = window.location.protocol + '//' + window.location.host + window.location.pathname + "?ac=kk&type=" + bossid;
                $("#test").html(ajax_load).load(url);
        }
        
   
</script>
                 
</body>
</html>
