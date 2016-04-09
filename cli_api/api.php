<?php
//todo:这是一个自动发布的接口，包括关入口，踢人下线，停服，发版本开服的功能，具体逻辑有待实现
/*
关入口
method=close_game_entrance   有接口
踢所有人下线
method=kill_all_player 有接口
修改入口的版本号
method=update_version value=`cat /data/c4compile/server/release/version.log`   有待开发
开入口
method=open_game_entrance 有接口
*/
$method = $_REQUEST['method'];
$value = $_REQUEST['value'];
switch ($method) {
    case close_game_entrance:
        echo "close_game_entrance";
        break;
    case kill_all_player:
        echo "kill_all_player";
        break;
    case update_version:
        echo "update_version";
        break;
    case open_game_entrance:
        echo "open_game_entrance";
        break;    
}