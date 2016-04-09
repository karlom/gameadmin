<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
	<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
	<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("input[name=submit]").click(function(){
				$flag = 1;
				$.each($("input[class=required]"), function(){
					if("" == $(this).val()){
						alert($(this).attr("des")+"<{$lang->verify->isNotNull}>");
						$flag = 0;
						return false;
					}
				});
				if(!$flag){
					return false;
				}
			});
		});
	</script>
	<title><{$lang->menu->gameEntranceConfig}></title>
	</head>

	<body>
		<div id="position"><{$lang->menu->class->systemManage}>: <{$lang->menu->gameEntranceConfig}></div>
		<div class="red">
		<{$lang->page->gameEntranceConfigDes}>
		</div>
		
		<{if $msg}>
		<div style="margin: 5px; color: red; width: 60%;">
			<{foreach from=$msg item=item}>
			<div style="margin: 5px 0;"><{$item}></div>
			<{/foreach}>
		</div>
		<{/if}>
		
		<{if 0 <= $serverStatus}>
		<form action="<{$smarty.const.URL_SELF}>" method="post">
			<table class="table_list" style="width: 60%; margin: 10px 0;">
				<tr class="trEven">
					<td width="25%" align="right"><{$lang->page->gameEntrance}></td>
					<td>
						<input type="radio" value="1" name="switch" <{if 1 == $serverStatus}>checked="checked"<{/if}> /><{$lang->page->open}> 
						<input type="radio" value="2" name="switch" <{if 2 == $serverStatus}>checked="checked"<{/if}>  /><{$lang->page->close}>
						<input name="entranceUrl" type="hidden" value="<{$config.entranceUrl}>" />
						<input name="action" type="hidden" value="updateentrance" />
						<input name="entrancesubmit" type="submit" value="<{$lang->page->submit}>" />
					</td>
				</tr>
			</table>
		</form>
		<{/if}>
		<{if 0 <= $simulationLoginStatus}>
		<form action="<{$smarty.const.URL_SELF}>" method="post">
			<table class="table_list" style="width: 60%; margin: 10px 0;">
				<tr class="trEven">
					<td width="25%" align="right"><{$lang->page->loginPlayerBtn2}></td>
					<td>
						<input type="radio" value="1" name="switch" <{if 1 == $simulationLoginStatus}>checked="checked"<{/if}> /><{$lang->page->open}> 
						<input type="radio" value="2" name="switch" <{if 2 == $simulationLoginStatus}>checked="checked"<{/if}>  /><{$lang->page->close}>
						<input name="action" type="hidden" value="updatesimulationlogin" />
						<input name="entrancesubmit" type="submit" value="<{$lang->page->submit}>" />
					</td>
				</tr>
			</table>
		</form>
		<{/if}>
		<{if 0 <= $serverOnlineStatus}>
		<form action="<{$smarty.const.URL_SELF}>" method="post">
			<table class="table_list" style="width: 60%; margin: 10px 0;">
				<tr class="trEven">
					<td width="25%" align="right"><{$lang->page->serverIsOnline}></td>
					<td>
						<input type="radio" value="1" name="switch" <{if 1 == $serverOnlineStatus}>checked="checked"<{/if}> /><{$lang->page->payNormal}> 
						<input type="radio" value="2" name="switch" <{if 2 == $serverOnlineStatus}>checked="checked"<{/if}>  /><{$lang->page->bookingPay}>
						<input name="action" type="hidden" value="updateseveronline" />
						<input name="serveronlinesubmit" type="submit" value="<{$lang->page->submit}>" />
					</td>
				</tr>
			</table>
		</form>
		<{/if}>
		<{if 0 <= $cdnStatus}>
		<form action="<{$smarty.const.URL_SELF}>" method="post">
			<table class="table_list" style="width: 60%; margin: 10px 0;">
				<tr class="trEven">
					<td width="25%" align="right"><{$lang->page->webHost}></td>
					<td>
						<input type="radio" value="1" name="cdn" <{if 1 == $cdnStatus}>checked="checked"<{/if}> /><{$lang->page->open}> 
						<input type="radio" value="2" name="cdn" <{if 2 == $cdnStatus}>checked="checked"<{/if}>  /><{$lang->page->close}>
						<input name="action" type="hidden" value="updatecdn" />
						<input name="cdnsubmit" type="submit" value="<{$lang->page->submit}>" />
					</td>
				</tr>
			</table>
		</form>
		<{/if}>
		<{if 0 <= $fcmStatus}>
		<form action="<{$smarty.const.URL_SELF}>" method="post">
			<table class="table_list" style="width: 60%; margin: 10px 0;">
				<tr class="trEven">
					<td width="25%" align="right"><{$lang->page->fcm}></td>
					<td>
						<input type="radio" value="1" name="fcm" <{if 1 == $fcmStatus}>checked="checked"<{/if}> /><{$lang->page->open}> 
						<input type="radio" value="0" name="fcm" <{if 0 == $fcmStatus}>checked="checked"<{/if}>  /><{$lang->page->close}>
						<input name="action" type="hidden" value="updatefcm" />
						<input name="fcmsubmit" type="submit" value="<{$lang->page->submit}>" />
					</td>
				</tr>
			</table>
		</form>
		<{/if}>
		<{if 0 <= $maxNum && 0 <= $paidui}>
		<form action="<{$smarty.const.URL_SELF}>" method="post">
			<table class="table_list" style="width: 60%; margin: 10px 0;">
				<tr class="trEven">
					<td width="25%" align="right"><{$lang->page->serverMaxNum}></td>
					<td width="25%">
						<input type="text" value="<{$maxNum}>" name="maxNum" />
					</td>
					<td rowspan="2">
						<input name="action" type="hidden" value="updatemaxnum" />
						<input name="maxnumsubmit" type="submit" value="<{$lang->page->submit}>" />
					</td>
				</tr>
				<tr class="trOdd">
					<td align="right"><{$lang->page->paidui}></td>
					<td><input type="text" value="<{$paidui}>" name="paidui" /></td>
				</tr>
			</table>
		</form>
		<{/if}>
		<{* 结界
		<{if 0 <= $magicBoxStatus}>
		<form action="<{$smarty.const.URL_SELF}>" method="post">
			<table class="table_list" style="width: 60%; margin: 10px 0;">
				<tr class="trEven">
					<td width="25%" align="right"><{$lang->page->magicbox}></td>
					<td>
						<input type="radio" value="1" name="magicbox" <{if 1 == $magicBoxStatus}>checked="checked"<{/if}> /><{$lang->page->open}> 
						<input type="radio" value="0" name="magicbox" <{if 0 == $magicBoxStatus}>checked="checked"<{/if}>  /><{$lang->page->close}>
						<input name="action" type="hidden" value="updatemagicbox" />
						<input name="magicboxsubmit" type="submit" value="<{$lang->page->submit}>" />
					</td>
				</tr>
			</table>
		</form>
		<{/if}>
		*}>
		<form action="<{$smarty.const.URL_SELF}>" method="post">
			<table class="table_list" style="width: 60%">
				<tr class="table_list_head">
					<th width="25%">KEY NAME</th>
					<th width="25%"><{$lang->page->directions}></th>
					<th><{$lang->page->nowValue}></th>
				</tr>
				<!--tr class="trEven">
					<td>entranceUrl</td>
					<td><{$lang->page->entranceUrl}></td>
					<td><input size="40" name="entranceUrl" class="required" value="<{$config.entranceUrl}>" des="<{$lang->page->entranceUrl}>" /> <span class="red">*</span></td>
				</tr-->
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>websiteTitle</td>
					<td><{$lang->page->websiteTitle}></td>
					<td><input size="40" name="websiteTitle" class="required" value="<{$config.websiteTitle}>" des="<{$lang->page->websiteTitle}>" /> <span class="red">*</span></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>officialWebsite</td>
					<td><{$lang->page->officialWebsite}></td>
					<td><input size="40" name="officialWebsite" class="required" value="<{$config.officialWebsite}>" des="<{$lang->page->office}>" /> <span class="red">*</span></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>serviceHost</td>
					<td><{$lang->page->serviceHost}></td>
					<td><input size="40" name="serviceHost" class="required" value="<{$config.serviceHost}>" des="<{$lang->page->serviceHost}>" /> <span class="red">*</span></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>webHost</td>
					<td><{$lang->page->webHost}></td>
					<td><input size="40" name="webHost" class="required"  value="<{$config.webHost}>" des="<{$lang->page->webHost}>" /> <span class="red">*</span></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>resourceHost</td>
					<td><{$lang->page->resourceHost}></td>
					<td><input size="40" name="resourceHost" class="required"  value="<{$config.resourceHost}>" des="<{$lang->page->resourceHost}>" /> <span class="red">*</span></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>ip</td>
					<td><{$lang->page->serviceIp}></td>
					<td><input size="40" name="ip" class="required"  value="<{$config.ip}>" des="<{$lang->page->serviceIp}>" /> <span class="red">*</span></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>port</td>
					<td><{$lang->page->servicePort}></td>
					<td><input size="40" name="port" class="required" value="<{$config.port}>" des="<{$lang->page->servicePort}>" /> <span class="red">*</span></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>playerQQGroup</td>
					<td><{$lang->page->playerQQGroup}></td>
					<td><input size="40" name="playerQQGroup"  value="<{$config.playerQQGroup}>"  /></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>version</td>
					<td><{$lang->page->serviceVersion}></td>
					<td><input size="40" name="version" class="required" value="<{$config.version}>" des="<{$lang->page->serviceVersion}>" /> <span class="red">*</span></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>activateCodeUrl</td>
					<td><{$lang->page->activateCodeUrl}></td>
					<td><input size="40" name="activateCodeUrl"  value="<{$config.activateCodeUrl}>"  /></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>bbsUrl</td>
					<td><{$lang->page->bbsUrl}></td>
					<td><input size="40" name="bbsUrl" value="<{$config.bbsUrl}>" des="<{$lang->page->bbsUrl}>" /></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>firstPayTitle</td>
					<td><{$lang->page->firstPayTitle}></td>
					<td><input size="40" name="firstPayTitle"  value="<{$config.firstPayTitle}>"  /></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>firstPayUrl</td>
					<td><{$lang->page->firstPayUrl}></td>
					<td><input size="40" name="firstPayUrl" value="<{$config.firstPayUrl}>" des="<{$lang->page->firstPayUrl}>" /></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>gonglueUrl</td>
					<td><{$lang->page->gonglueUrl}></td>
					<td><input size="40" name="gonglueUrl"  value="<{$config.gonglueUrl}>"  /></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>jiHuoMaUrl</td>
					<td><{$lang->page->jiHuoMaUrl}></td>
					<td><input size="40" name="jiHuoMaUrl" value="<{$config.jiHuoMaUrl}>" des="<{$lang->page->jiHuoMaUrl}>" /></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>payUrl</td>
					<td><{$lang->page->payUrl}></td>
					<td><input size="40" name="payUrl"  value="<{$config.payUrl}>"  /></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>serverListUrl</td>
					<td><{$lang->page->serverListUrl}></td>
					<td><input size="40" name="serverListUrl" value="<{$config.serverListUrl}>" des="<{$lang->page->serverListUrl}>" /></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td>gmUrl</td>
					<td><{$lang->page->gmUrl}></td>
					<td><input size="40" name="gmUrl" value="<{$config.gmUrl}>" des="<{$lang->page->gmUrl}>" /></td>
				</tr>
				<tr class="<{cycle values="trOdd,trEven"}>">
					<td colspan="3" align="center">
						<input name="action" type="hidden" value="update" />
						<input name="submit" type="submit" value="<{$lang->page->submit}>" />
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>