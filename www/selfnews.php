<?php

if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("face.inc.php");
include_once("func.inc.php");
include_once("lang/msg_ru.inc.php");

session_start();

function assemble_edit_news(&$lst,$id){
	global $lang;
	if(QueryScript("SELECT * from tblNews where deleted=0 and id=".$id,$result,$connect) && mysql_num_rows($result)>0){	
		$news=mysql_fetch_array($result);
		$lst='<table border="0" width="100%">';
		$lst.='<form action="'.$_SERVER["PHP_SELF"].'?action=edit&edit='.$id.'" method="post" name="editnews" id="editnews">';
		$lst.='<tr><td align="right">&nbsp;</td><td align="left"> 
			<input name="color" type="checkbox" value="1" '.( $news["colored"]==1 ? ' checked ' : ' ' ).' style="'.def_style_form_font_size.'"> '.$lang["self_news_checked"].'</td></tr>';
		$lst.='<tr><td align="right" valign="top">'.$lang["self_news_title"].'</td>
			<td align="left"><textarea name="name" cols="70" rows="3" style="'.def_style_form_font_size.'">'.$news["name"].'</textarea></td></tr>';
		$lst.='<tr><td align="right" valign="top">'.$lang["self_news_text"].'</td>
			<td align="left"><textarea name="text" cols="70" rows="15" style="'.def_style_form_font_size.'">'.$news["text"].'</textarea></td></tr>';
		$lst.='<tr><td>&nbsp;</td><td align="left"><input name="ok" type="submit" value="'.$lang["self_news_savechange"].'"></td></tr>';
		$lst.='</form></table>';	
		
	}else{
		$lst=$lang["self_news_not_found"];
	}

}

function assemble_new_news(&$lst){
	global $lang;
	$lst='<table border="0" width="100%">';
	$lst.='<form action="'.$_SERVER["PHP_SELF"].'?action=new" method="post" name="addnews" id="addnews">';
	$lst.='<tr><td align="right">&nbsp;</td>
	<td align="left"><input name="color" type="checkbox" value="1" style="'.def_style_form_font_size.'"> '.$lang["self_news_checked"].'</td></tr>';
	$lst.='<tr><td align="right" valign="top">'.$lang["self_news_title"].'</td>
		<td align="left"><textarea name="name" cols="70" rows="3" style="'.def_style_form_font_size.'"></textarea></td></tr>';
	$lst.='<tr><td align="right" valign="top">'.$lang["self_news_text"].'</td>
		<td align="left"><textarea name="text" cols="70" rows="15" style="'.def_style_form_font_size.'"></textarea></td></tr>';
	$lst.='<tr><td>&nbsp;</td><td align="left"><input name="ok" type="submit" value="'.$lang["self_news_addnews"].'"></td></tr>';
	$lst.='</form></table>';	
}

function assemble_one_news(&$lst_news,$id,$write_news){
	global $lang;
	$lst_news='';
	if(QueryScript("SELECT * from tblNews where deleted=0 and id=".$id,$result,$connect) && mysql_num_rows($result)>0){	
		$news=mysql_fetch_array($result);
		$lst_news.='<br><table border="0" width="100%">';
		$lst_news.='<tr bgcolor="'.def_color_desktop_chet_list.'"><td align="left"> '.$lang["self_news_date"].': <b>'.date("d.m.Y H:i",strtotime($news["date"])).'</b></td>';
		$lst_news.='<td align="left">'.$lang["self_news_created"].':<b> '.get_username_to_id($news["userid"]).'</b></td></tr>';
		$lst_news.='<tr bgcolor="'.def_color_desktop_chet_list.'"><td align="left" colspan="2">'.$lang["self_news_title"].': <b>'.$news["name"].'</b></td></tr>';		
		$lst_news.='<tr><td align="left" colspan="2">'.outtext($news["text"]);
		if($write_news && $_SESSION["write"])
			$lst_news.='&nbsp;<a href="selfnews.php?edit='.$news["id"].'"><img src="images1/edit_small.jpg" alt="'.$lang["edit"].'"  border="0"></a>&nbsp;<a href="selfnews.php?action=del&del='.$news["id"].'"><img src="images1/del_small.jpg" alt="'.$lang["del"].'"  border="0"></a>';		
		$lst_news.='<br></td></tr>';								
		$lst_news.='</table><br>';		
	}else{
		$lst_news.=$lang["self_news_errorlink"];
	}		
}

function assemble_list_of_month(&$lst_month,$month,$year,$write_news){
	global $lang;
	$lst_month='';
	
	first_last_day($month,$year,$firstday,$lastday);

	if(QueryScript("SELECT * from tblNews where deleted=0 and  date between '".date("Y-m-d H:i:s",$firstday)."' and '".date("Y-m-d H:i:s",$lastday)."' ORDER BY date desc ",$result_nmon,$connect)){	
		if (mysql_num_rows($result_nmon) > 0){
			$lst_month .= '<br><table border="0"  width="100%">';
			while( $news = mysql_fetch_array($result_nmon) ){
				$lst_month .= '<tr bgcolor="'.def_color_desktop_chet_list.'"><td align="left"> '.$lang["self_news_date"].': <b>'.date("d.m.Y H:i",strtotime($news["date"])).'</b></td>';
				$lst_month .= '<td align="left">'.$lang["self_news_created"].':<b> '.get_username_to_id($news["userid"]).'</b></tr>';
				$lst_month .= '<tr><td align="left" colspan="2">'.( $news["colored"]==1 ? '<font color="#990000">'.$news["name"].'</font>' : $news["name"] );
				if($write_news && $_SESSION["write"])
					$lst_month.='&nbsp;<a href="selfnews.php?edit='.$news["id"].'"><img src="images1/edit_small.jpg" alt="'.$lang["edit"].'"  border="0"></a>&nbsp;<a href="selfnews.php?action=del&del='.$news["id"].'"><img src="images1/del_small.jpg" alt="'.$lang["del"].'"  border="0"></a>';		
				$lst_month.='<br><div align="right"><a href="'.$_SERVER["PHP_SELF"].'?id='.$news["id"].'" class="desktop_list_a">'.$lang["self_news_dalee"].'</a></div></td></tr>';								
			}			
			$lst_month .= '</table>';
		}else{
			$lst_month.=$lang["self_news_not_news"];
		}
		mysql_close($connect);
	}	
}

function assemble_change_period(&$lst){
	global $month_str, $lang;
	$lst = '';
	
	if(QueryScript("SELECT min(date) as mindate, max(date) as maxdate from tblNews where deleted=0",$result_news,$connect)){
		if (mysql_num_rows($result_news) > 0){
			$newsdate=mysql_fetch_array($result_news);
			$minyear = date("Y",strtotime($newsdate["mindate"])); 
			$maxyear = date("Y",strtotime($newsdate["maxdate"]));
		}
		mysql_close($connect);		
	}
	
	if(isset($minyear)){
		$lst.='<table border="0">';
		for($y=$minyear; $y<=$maxyear; $y++){
			$lst.='<tr><td>'.$y.' '.$lang["self_news_year"].'&nbsp;&nbsp;</td>';
			for($i=1; $i<=12; $i++){			
				first_last_day($i,$y,$primaryday,$lastday);					
				if(QueryScript("SELECT * from tblNews where deleted=0 and date between '".date("Y-m-d H:i:s",$primaryday)."' and '".date("Y-m-d H:i:s",$lastday)."'",$result_n,$connect2) && mysql_num_rows($result_n)>0){
					$lst .= '<td><a href="'.$_SERVER["PHP_SELF"].'?month='.$i.'&year='.$y.'" class="desktop_list_a">'.$month_str[$i].'</a></td>';				
					mysql_close($connect2);							
				}else{
					$lst .= '<td>'.$month_str[$i].'</td>';								
				}				
			} 
			$lst.='</tr>';
		}
		$lst.='</table>';					
	}else{
		$lst .= $lang["self_news_no_data"];
	}	
}

function news_to_period($newsid,&$month,&$year){
	if(QueryScript("SELECT date from tblNews where deleted=0 and id=".$newsid,$result,$connect) && (mysql_num_rows($result) > 0)){
		$data=mysql_fetch_array($result);
		$year=(int)date("Y",strtotime($data["date"]));
		$month=(int)date("m",strtotime($data["date"]));		
	}
}

function cleartext($s){
	return strip_tags(addslashes(stripslashes( $s )),'<a><b><i><u>');
}

function outtext($s){
	return nl2br(str_replace("  ","&nbsp;",$s));
}

// -----------------------------------------

$write_news = is_access_write("news");

if($write_news && isset($_GET["action"])){
	switch($_GET["action"]){
		case 'del':	
			if(isset($_GET["del"])){
				ExecScript("UPDATE tblNews SET deleted=1  where id=".$_GET["del"]);	
			if (strpos($_SERVER['HTTP_REFERER'], "id") === false)
				$refere=$_SERVER['HTTP_REFERER'];
			else
				$refere=" index.php";				
			}	
			break;	
		case 'new':	
			ExecScript('INSERT INTO tblNews (date,colored,name,text,userid,deleted) VALUES ("'.date("Y-m-d H:i:s").'",'.(int)isset($_POST["color"]).',"'.cleartext($_POST['name']).'","'.cleartext($_POST["text"]).'",'.$_SESSION["userid"].',0)');
			$refere=" index.php";			
			break;	
		case 'edit': 
			if(isset($_GET["edit"])){
				ExecScript('UPDATE tblNews SET date="'.date("Y-m-d H:i:s").'", colored='.(int)isset($_POST["color"]).', name="'.cleartext($_POST['name']).'", text="'.cleartext($_POST["text"]).'", userid='.$_SESSION["userid"].'  WHERE id='.$_GET["edit"]);	
				$refere=$_SERVER["PHP_SELF"].'?id='.$_GET["edit"];				
			}
			break;	
	}
	header("Location: ".$refere);	
}

if ($write_news && isset($_GET["new"]) && $_SESSION["write"]){
	assemble_new_news($lst_new);
	$X_desktop[]=array(
		"caption"=>$lang["self_news_addnews2"],			
		"list"=>$lst_new,
		"bottom"=>'<a href="index.php" class="desktop_fun_a">'.$lang["self_news_na_glavn"].'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="selfnews.php" class="desktop_fun_a">'.$lang["self_news_arhivnews"].'</a>'
	);
} elseif ($write_news && isset($_GET["edit"]) && $_SESSION["write"]){
	$editid=$_GET["edit"];
	assemble_edit_news($lst_edit,$editid);
	$X_desktop[]=array(
		"caption"=> $lang["self_news_editnews"],			
		"list"=>$lst_edit,
		"bottom"=>'<a href="index.php" class="desktop_fun_a">'.$lang["self_news_na_glavn"].'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="selfnews.php" class="desktop_fun_a">'.$lang["self_news_arhivnews"].'</a>'
	);

}else{

	if (isset($_GET["id"])){
		
		$id=$_GET["id"];
		assemble_one_news($lst_news,$id,$write_news);
		news_to_period($id,$month,$year);
		$X_desktop[]=array(
			"caption"=>$lang["self_news_news"],			
			"list"=>$lst_news,
			"bottom"=>( ($write_news && $_SESSION["write"]) ? '<a href="selfnews.php?new" class="desktop_fun_a">'.$lang["self_news_addnews"].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'	: '' ).'<a href="index.php" class="desktop_fun_a">'.$lang["self_news_na_glavn"].'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="selfnews.php?month='.$month.'&year='.$year.'" class="desktop_fun_a">'.$lang["self_news_news_za"].' '.strtolower($month_str[$month]).'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="selfnews.php" class="desktop_fun_a">'.$lang["self_news_arhivnews"].'</a>'
		);
		
		
	}elseif (isset($_GET["month"]) && isset($_GET["year"])){
	
		$month=$_GET["month"];
		$year=$_GET["year"];
		if(($month<1) || ($month>12))
			header("Location: ".$_SERVER["PHP_SELF"]);
		assemble_list_of_month($lst_month,$month,$year,$write_news);
		$X_desktop[]=array(
			"caption"=>$lang["self_news_arhivnewsmrdu"]." ".$lang["self_news_za"].strtolower($month_str[$month])." ".$year." ".$lang["self_news_year"],			
			"list"=>$lst_month,
			"bottom"=>( ($write_news && $_SESSION["write"]) ? '<a href="selfnews.php?new" class="desktop_fun_a">'.$lang["self_news_addnews"].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'	: '' ).'<a href="selfnews.php" class="desktop_fun_a">'.$lang["self_news_arhivnews"].'</a>'
		);
		
	}else{
	
		assemble_change_period($lst_cp);
		$X_desktop[]=array(
			"caption"=> $lang["self_news_arhivnewsmrdu"],			
			"list"=>''.$lst_cp,
			"bottom"=>( ($write_news && $_SESSION["write"]) ? '<a href="selfnews.php?new" class="desktop_fun_a">'.$lang["self_news_addnews"].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'	: '' )
		);
		
	}
	
}

draw_site($X_desktop);

unset($X_desktop);