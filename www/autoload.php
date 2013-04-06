<?php

if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("func.inc.php");

global $config;

if($config["DRAW_NEWS_RAO"]==1 && $config["CACHE_NEWS"]==1){
	copy_file_socket($config["HOST_NEWS_RAO"],$config["URL_NEWS_RAO"],$config["CACHE_NEWS_RAO"]);
}

if($config["DRAW_NEWS_ODUSV"]==1 && $config["CACHE_NEWS"]==1){
	copy_file_socket($config["HOST_NEWS_ODUSV"],$config["URL_NEWS_ODUSV"],$config["CACHE_NEWS_ODUSV"]);
}

if($config["DRAW_NEWS_MAIN_RBK"]==1 && $config["CACHE_NEWS"]==1){
	copy_file_socket($config["HOST_NEWS_MAIN_RBK"],$config["URL_NEWS_MAIN_RBK"],$config["CACHE_NEWS_MAIN_RBK"]);
}

if($config["DRAW_NEWS_RBK"]==1 && $config["CACHE_NEWS"]==1){
	copy_file_socket($config["HOST_NEWS_RBK"],$config["URL_NEWS_RBK"],$config["CACHE_NEWS_RBK"]);
}

/*
if($config["CACHE_BANNERS"]==1){
	copy_file_socket($config["HOST_GISMETEO10"],$config["URL_GISMETEO10"],$config["CACHE_GISMETEO10"]);
	copy_file_socket($config["HOST_KURS"],$config["URL_KURS"],$config["CACHE_KURS"]);
}
*/

// <script>window.close();</script>
?>



