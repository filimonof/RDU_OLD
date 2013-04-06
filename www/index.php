<?php

if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("face.inc.php");
include_once("func.inc.php");
include_once("lang/msg_ru.inc.php");

session_start();


function outtext($s){
	return nl2br(str_replace("  ","&nbsp;",$s));
}


function assemble_self_warning(&$lst,$write_warning){
	global $lang;
	$lst='';
	if(QueryScript("SELECT * FROM tblWorkWarning where deleted=0 and date + liveday*1000000 >= NOW() ORDER BY date desc",$result_warning,$connect)){
		if(mysql_num_rows($result_warning) > 0){		
			$lst.='<table border="0"  align="left">';
			while($warning = mysql_fetch_array($result_warning)){			
				$lst.='<tr><td align="left">';				
				$lst .= ( $warning["colored"]==1 ? '<font color="#990000"> ' : ' ' )   .'<b>'.date("d.m.Y ",strtotime($warning["date"])).'</b>&nbsp;'.outtext($warning["text"]).   ( $warning["colored"]==1 ? '</font> ' : ' ' );							
				if($write_warning && $_SESSION["write"]){
					$lst.='&nbsp;<a href="selfwarning.php?edit='.$warning["id"].'"><img src="images1/edit_small.jpg" alt="'.$lang["edit"].'"  border="0"></a>&nbsp;<a href="selfwarning.php?action=del&del='.$warning["id"].'"><img src="images1/del_small.jpg" alt="'.$lang["del"].'"  border="0"></a>';					
				}
				$lst.='</td></tr>';
			}
			$lst.='</table>';
		}else{
			$lst = '';				
		} 				
		mysql_close($connect);			
	}	

}

function assemble_self_news($count_selfnews,&$lst,$write_news){
	global $lang;
	$lst = '';
	if(QueryScript("SELECT * FROM tblNews where deleted=0 ORDER BY date desc LIMIT 0,".$count_selfnews,$result_news,$connect)){
		if(mysql_num_rows($result_news) > 0){		
			$lst.='<table border="0" align="left">';
			while($news = mysql_fetch_array($result_news)){			
				$lst.='<tr><td>';
				$lst .= '<a href="selfnews.php?id='.$news["id"].'" class="desktop_text_a">'.( $news["colored"]==1 ? '<font color="#990000"> ' : ' ' ).'<b>'.date("d.m.Y H:i",strtotime($news["date"])).'</b>&nbsp;'.$news["name"].( $news["colored"]==1 ? '</font> ' : ' ' ).'</a>';							
				if($write_news && $_SESSION["write"]){
					$lst.='&nbsp;<a href="selfnews.php?edit='.$news["id"].'"><img src="images1/edit_small.jpg" alt="'.$lang["edit"].'"  border="0"></a>&nbsp;<a href="selfnews.php?action=del&del='.$news["id"].'"><img src="images1/del_small.jpg" alt="'.$lang["del"].'"  border="0"></a>';					
				}
				$lst.='</td></tr>';
			}
			$lst.='</table>';
		}else{
			$lst .= '<br><div align="center">'.$lang["no_news"].'</div><br>';				
		} 				
		mysql_close($connect);			
	}	
}
	

function assemble_news_rao($filename,&$lst){
	$f=@fopen($filename,"r");
	$lst='';
	if(!$f){
		return false;
	}else{
		$line = fread($f,filesize($filename));
		fclose($f);
		
		$po=strpos($line,'<body>');
		if ($po !== false)
			$line=substr_replace($line,'',0,$po);

		$line=strip_tags($line,'<a><br>');
		$line=str_replace('</a>','</a><br>',$line);
		$line=trim($line);
		$line=str_replace('<a href','<a target="_blank" class="desktop_text_a" href',$line);
		$line=str_replace('href="','href="http://www.rao-ees.ru/ru/',$line);		
		$lst.=$line;
	}
}

function assemble_news_odusv($filename,&$lst){
	$f=@fopen($filename,"r");
	$lst='';
	if(!$f){
		return false;
	}else{
		$line = fread($f,filesize($filename));
		fclose($f);
		
		// выбираем токо данные между 
		// <!--begin ВЕСЬ КОНТЕНТ-->
		// <!--end ВСЕГО КОНТЕНТА-->
		$line = substr($line,strpos($line,"<!--begin ВЕСЬ КОНТЕНТ-->"));
		$line = substr($line,0,strpos($line,"<!--end ВСЕГО КОНТЕНТА-->"));
		
		$po=strpos($line,'<body>');
		if ($po !== false)
			$line=substr_replace($line,'',0,$po);

		//$line=strip_tags($line,'<a><br>');
		//$line=strip_tags($line,'<div class="txt14">');
		//$line=str_replace('</a>','</a><br>',$line);
		$line=trim($line);
		$line=str_replace('<a href','<a target="_blank" class="desktop_text_a" href',$line);
		$line=str_replace('href="','href="http://www.odusv.so-cdu.ru',$line);		
		
		$lst.=$line;		
	}
}


function assemble_happy(&$lst){
    global  $config;
	$lst = '';
	$ret = false;
	
	if ((QueryScript("SELECT pe.id, pe.name, pe.birthday, SUBSTRING(pe.birthday,6,10) as dm ,
	        mod(dayofyear(concat(SUBSTRING(NOW(),1,4),'-',SUBSTRING(pe.birthday,6,10)))-DAYOFYEAR(NOW())+DAYOFYEAR('2004-12-31'), DAYOFYEAR('2004-12-31')) as countday
			FROM tblPersons pe
        	WHERE pe.people = 1
	        ORDER BY dm",  $rsl,$connect)) && (mysql_num_rows($rsl)>0) )
	{
		$lst .= '<table border="0" cellpadding="0" cellspacing="0" align = "center">';
	   	while ($person=mysql_fetch_array($rsl)){
			if ( $person["countday"] <= $config["COUNT_DAY_TO_HAPPY"] && $person["countday"] != 0){			
				$ret = true;
				$lst .= '							
				<tr>
					<td width = "260" align = "left">'.$person["name"].'</td>
					<td width = "90" align = "center">'.substr(put_format_date($person["birthday"]),0,-9).'</td>	
				</tr>';				
			}						
		}
		$lst .= '</table>';
	}
	return $ret;	
}

function assemble_auto_happy(&$lst){
	global $config;
	$lst = '';	
	$img_alt=utf('Попугаев: ');
	if ((QueryScript("SELECT pe.id, pe.name, pe.birthday, year( current_date( )  ) - year( pe.birthday ) AS let
						FROM tblPersons pe
						WHERE pe.people =1
						AND month( pe.birthday ) = month( current_date( )  ) 
						AND dayofmonth( pe.birthday ) = dayofmonth( current_date( )  ) 
						ORDER BY let DESC",  $rsl,$connect)) && (mysql_num_rows($rsl)>0) )
	{
		$lst .= '<table border="0" cellpadding="0" cellspacing="0" align = "center">';
		$lst .= '<tr>
			<td width = "300" align = "left" valign="center">';
		$lst .= '&nbsp;&nbsp;<b>'.utf('Сегодняшние именинники:').'</b>';
	   	while ($person=mysql_fetch_array($rsl)){	   		
	   		if ((($person["let"]) % 5) == 0)
	   			$lst .= '<br><br><font color="#990000">'.$person["name"].'</font>';
	   		else 
	   			$lst .= '<br><br>'.$person["name"];
	   		$img_alt.=' '.$person["let"].' ';	
		}		
		$lst .= '</td>					
				<td width = "350" align = "left" valign="center">';
		$filelist = get_list_file($config["DIR_IMG_HAPPY"]);
		if ($filelist != false){	
			$img_num = rand(0,sizeof($filelist)-1);
			$lst .= '<IMG width="350" alt="'.$img_alt.'" SRC="'.$config["DIR_IMG_HAPPY"].'/'.$filelist[$img_num].'">';
		}
		$lst .= '</td></tr>';
		$lst .= '</table>';		
	}
	return $lst;
}

//------------------------------------

$write_news = is_access_write("news");
$write_warning = is_access_write("warning");


if($config["happy_manual"]==1)
	include("_happy.inc.php");
	
if($config["AUTO_HAPPY"]==1){
	if (assemble_auto_happy($lst) && $lst!=""){
		$X_desktop[]=array(
			"caption"=>utf("Поздравляем С Днём Рождения!!!"), //$lang["afisha_birthday"],			
			"list"=>'<div align="left">'.$lst.'</div>',
			"bottom"=>utf('поздравление формируется автоматически, картинка выбирается случайным образом')		
		);
	}	
}

if($config["DRAW_HAPPY"]==1){
	if (assemble_happy($lst)){
		$X_desktop[]=array(
			"caption"=>$lang["afisha_birthday"],			
			"list"=>'<div align="left">'.$lst.'</div>',
			"bottom"=>''		
		);
	}
}

if($config["DRAW_SELF_WARNING"]==1){
	assemble_self_warning($lst,$write_warning);
	if(strlen($lst)>1 || ($write_news && $_SESSION["write"]) ){ 
		$X_desktop[]=array(
			"caption"=>$lang["self_warning_title"],			
			"list"=>'<div align="left">'.$lst.'</div>',
			"bottom"=>( ($write_warning && $_SESSION["write"]) ? '<a href="selfwarning.php?new" class="desktop_fun_a">'.$lang["self_warning_add"].'</a>&nbsp;&nbsp;&nbsp;'	: '' )		
		);
	}
}

if($config["DRAW_SELF_NEWS"]==1){
	assemble_self_news($config["COUNT_SELF_NEWS"],$lst,$write_news);
	$X_desktop[]=array(
		"caption"=>$lang["self_news_title_mrdu"],			
		"list"=>'<div align="left">'.$lst.'</div>',
		"bottom"=>( ($write_news && $_SESSION["write"]) ? '<a href="selfnews.php?new" class="desktop_fun_a">'.$lang["self_news_add"].'</a>&nbsp;&nbsp;&nbsp;'	: '' ).'<a href="selfnews.php" class="desktop_fun_a">'.$lang["self_news_arhiv"].'</a>'		
	);
}

if($config["DRAW_NEWS_RAO"]==1){
    if($config["CACHE_NEWS"]==1)
		file_cache($config["CACHE_NEWS_RAO"],$config["HOST_NEWS_RAO"],$config["URL_NEWS_RAO"],$config["TIME_REFRESH_NEWS_RAO"]);
	if(file_exists($config["CACHE_NEWS_RAO"])){
		assemble_news_rao($config["CACHE_NEWS_RAO"],$lst);
		$X_desktop[]=array(
			"caption"=>$lang["rao_news_title"],			
			"list"=>'<div align="left">'.utf($lst).'</div>',
			"bottom"=>$lang["last_update"].'  '.date("d.m.Y H:i:s",filemtime($config["CACHE_NEWS_RAO"])).' ('.$lang["timer_update"].' '.($config["TIME_REFRESH_NEWS_RAO"] / 60).' '.$lang["min"].')'
		);
	}
}


if($config["DRAW_NEWS_ODUSV"]==1){
    if($config["CACHE_NEWS"]==1)
		file_cache($config["CACHE_NEWS_ODUSV"],$config["HOST_NEWS_ODUSV"],$config["URL_NEWS_ODUSV"],$config["TIME_REFRESH_NEWS_ODUSV"]);
	if(file_exists($config["CACHE_NEWS_ODUSV"])){
		assemble_news_odusv($config["CACHE_NEWS_ODUSV"],$lst);
		$X_desktop[]=array(
			"caption"=>$lang["odusv_news_title"],			
			"list"=>'<div align="left">'.utf($lst).'</div>',
			"bottom"=>$lang["last_update"].'  '.date("d.m.Y H:i:s",filemtime($config["CACHE_NEWS_ODUSV"])).' ('.$lang["timer_update"].' '.($config["TIME_REFRESH_NEWS_ODUSV"] / 60).' '.$lang["min"].')'
		);
	}
}

draw_site($X_desktop);

unset($X_desktop);
?>