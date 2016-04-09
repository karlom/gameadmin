<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<title><{$lang->menu->petDetail}></title>
</head>

<body>
<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->petDetail}></div>

<{if $pet.petid}>
<table class="DataGrid" cellspacing="0">
	<tr><th colspan="8"><{$lang->menu->petDetail}></th></tr>
    <tr>
		<td align="right"><{$lang->pet->petName}>：</td>                  <td><{ $pet.name }></td>
        <td align="right"><{$lang->pet->master}>:</td>                  <td><{ $roleName }></td>
        <td align="right"><{$lang->pet->petUID}>：</td>                <td><{ $pet.uid }></td>
    </tr>
    <tr class="odd">
		<td align="right"><{$lang->pet->petID}>：</td>              <td><{ $pet.petid }></td>
		<td align="right"><{$lang->page->level}>：</td>                  <td><{ $pet.lv }></td>
		<td align="right"><{$lang->pet->advanceLevel}>：</td>                <td><{ $pet.advanceLv }></td>
    </tr>
    <tr>
    	<td align="right"><{$lang->page->sex}>：</td>                <td><{ if $pet.sex eq '1'}><{$lang->player->male}><{ else }><{$lang->player->female}><{ /if }></td>
		<td align="right"><{$lang->pet->advanceNum}>：</td>               <td><{ $pet.advanceNum }></td>
		<td align="right"><{$lang->pet->grow}>：</td>           <td><{ $pet.grow }></td>
    </tr>
    <tr class="odd">
       <td align="right"><{$lang->pet->tianfu}>：</td>  			<td><{ $pet.tianfu }></td>
       <td align="right"><{$lang->pet->zizhi}>：</td>             <td><{ $pet.zizhi }></td>
       <td align="right"><{$lang->pet->power}>：</td>           <td><{ $pet.power }></td> 
    </tr>
     <tr>
       <td align="right"><{$lang->pet->phy}>：</td>               <td><{ $pet.phy }></td>
       <td align="right"><{$lang->pet->energy}>：</td>           <td><{ $pet.energy }></td>
       <td align="right"><{$lang->pet->steps}>：</td>             <td><{ $pet.steps }></td>
    </tr>
     <tr class="odd">
       <td align="right"><{$lang->pet->atkFactor}>：</td>               <td><{ $pet.atkFactor }></td>
       <td align="right"><{$lang->pet->defFactor}>：</td>           <td><{ $pet.defFactor }></td>
       <td align="right"><{$lang->pet->hitFactor}>：</td>             <td><{ $pet.hitFactor }></td>
    </tr>
     <tr>
       <td align="right"><{$lang->pet->dodgeFactor}>：</td>               <td><{ $pet.dodgeFactor }></td>
       <td align="right"><{$lang->pet->baojiFactor}>：</td>           <td><{ $pet.baojiFactor }></td>
       <td align="right"><{$lang->pet->jianrenFactor}>：</td>             <td><{ $pet.jianrenFactor }></td>
    </tr>
     <tr class="odd">
       <td align="right"><{$lang->pet->exp}>：</td>                <td><{ $pet.exp }></td>
       <td align="right"><{$lang->pet->bind}>：</td>            <td><{ if $pet.bind eq '1' }><{$lang->player->yes}><{else}><{$lang->player->no}><{/if}></td>
       <td align="right"><{$lang->pet->dieTime}>：</td>             <td><{ $pet.dieTime }></td>
    </tr>
     <tr>
       <td align="right"><{$lang->pet->skill}>：</td>                <td><{ $skill }></td>
       <td align="right"><{$lang->pet->color}>：</td>  			<td><{ $pet.color }></td>
       <td align="right"><{$lang->pet->bless}>：</td>              <td><{ $pet.wishDetail }></td>
    </tr>
</table>
<br />
<a href="pet_info.php?roleName=<{$roleName}>" style="color:red;"><{$lang->page->back}></a>
<{/if}>
</body>
</html>