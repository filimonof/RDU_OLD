<?php

if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("face.inc.php");
include_once("func.inc.php");
include_once("lang/msg_ru.inc.php");


session_start();


function assemble_news_rbk($filename,&$lst){
	$f=@file($filename);
	$lst='';
	if(!$f){
		return false;
	}else{
		foreach ($f as $line){
			$line=str_replace('"><b>','" target="_blank" class="desktop_text_a"><b>',$line);
			$lst.=$line;
		}	
	}
}

function assemble_news_main_rbk($filename,&$lst){
	$f=@file($filename);
	$lst='';
	if(!$f){
		return false;
	}else{
		foreach ($f as $line){
			$line=str_replace('<a href','<a target="_blank" class="desktop_text_a" href',$line);
			$lst.=$line;
		}			
	}
}

if($config["DRAW_NEWS_MAIN_RBK"]==1){
    if($config["CACHE_NEWS"]==1)
		file_cache($config["CACHE_NEWS_MAIN_RBK"],$config["HOST_NEWS_MAIN_RBK"],$config["URL_NEWS_MAIN_RBK"],$config["TIME_REFRESH_NEWS_MAIN_RBK"]);
	if(file_exists($config["CACHE_NEWS_MAIN_RBK"])){
		assemble_news_main_rbk($config["CACHE_NEWS_MAIN_RBK"],$lst);
		$X_desktop[]=array(
			"caption"=>$lang["Main_News_rbk2"],			
			"list"=>'<div align="left">'.utf($lst).'</div>',
			"bottom"=>$lang["last_update"].'  '.date("d.m.Y H:i:s",filemtime($config["CACHE_NEWS_MAIN_RBK"])).' ('.$lang["timer_update"].' '.($config["TIME_REFRESH_NEWS_MAIN_RBK"] / 60).' '.$lang["min"].')'
		);
	}
}

if($config["DRAW_NEWS_RBK"]==1){
    if($config["CACHE_NEWS"]==1)
		file_cache($config["CACHE_NEWS_RBK"],$config["HOST_NEWS_RBK"],$config["URL_NEWS_RBK"],$config["TIME_REFRESH_NEWS_RBK"]);
	if(file_exists($config["CACHE_NEWS_RBK"])){
		assemble_news_rbk($config["CACHE_NEWS_RBK"],$lst);
		$X_desktop[]=array(
			"caption"=>$lang["Main_News_rbk1"],			
			"list"=>'<div align="left">'.utf($lst).'</div>',
			"bottom"=>$lang["last_update"].'  '.date("d.m.Y H:i:s",filemtime($config["CACHE_NEWS_RBK"])).' ('.$lang["timer_update"].' '.($config["TIME_REFRESH_NEWS_RBK"] / 60).' '.$lang["min"].')'
		);
	}
}

if($config["DRAW_GISMETEO"]==1){
    if($config["CACHE_BANNERS"]==1)
		file_cache($config["CACHE_GISMETEO10"],$config["HOST_GISMETEO10"],$config["URL_GISMETEO10"],$config["TIME_REFRESH_GISMETEO10"]);
    if($config["CACHE_BANNERS"]==1)
		file_cache($config["CACHE_KURS"],$config["HOST_KURS"],$config["URL_KURS"],$config["TIME_REFRESH_KURS"]);
	if(file_exists($config["CACHE_GISMETEO10"]))
		$X_desktop[]=array(
			"caption"=>$lang["banner_informer_title"],			
			"list"=>'<div align="center">
					<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="100" HEIGHT="100" id="100x100" ALIGN=""> <PARAM NAME=movie VALUE="http://img.gismeteo.ru/flash/100x100.swf"> <param name="FlashVars" value="noC=3&city0=27760&city1=27612&city2=28900&colorSet=pnc"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF><EMBED src="http://img.gismeteo.ru/flash/100x100.swf?noC=3&city0=27760&city1=27612&city2=28900&colorSet=pnc" quality=high bgcolor=#FFFFFF  WIDTH="100" HEIGHT="100" NAME="100x100" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"><a href="http://www.gismeteo.ru/towns/27612.htm"><!--img src="http://informer.gismeteo.ru/27612.GIF" border=0 width=100 height=100--></a></EMBED></OBJECT>			
					<a href="http://www.gismeteo.ru/towns/27760.htm"><img src="'.$config["CACHE_GISMETEO10"].'" border=0 width=234 height=120></a>
 					<img src="'.$config["CACHE_KURS"].' " WIDTH=88 HEIGHT="61" border="0">					
				</div>',
			"bottom"=>$lang["last_update"].'  '.date("d.m.Y H:i:s",filemtime($config["CACHE_GISMETEO10"])).' ('.$lang["timer_update"].' '.($config["TIME_REFRESH_GISMETEO10"] / 60).' '.$lang["min"].')'
		);
}

draw_site($X_desktop);

unset($X_desktop);
