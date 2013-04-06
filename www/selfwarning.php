<?php

if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("face.inc.php");
include_once("func.inc.php");
include_once("lang/msg_ru.inc.php");

session_start();

function assemble_edit_warning(&$lst,$id){
	global $lang;
	if(QueryScript("SELECT * from tblWorkWarning where deleted=0 and id=".$id,$result,$connect) && mysql_num_rows($result)>0){	
	
		$warning=mysql_fetch_array($result);
		$lst='<table border="0" width="100%">';
		$lst.='<form action="'.$_SERVER["PHP_SELF"].'?action=edit&edit='.$id.'" method="post" name="edit" id="edit">';
		$lst.='<tr><td align="right">&nbsp;</td><td align="left"> 
			<input name="color" type="checkbox" value="1" '.( $warning["colored"]==1 ? ' checked ' : ' ' ).' style="'.def_style_form_font_size.'">'.$lang["self_warning_checked"].'</td></tr>';
		$lst.='<tr><td align="right" valign="center">'.$lang["self_warning_actuality"].'</td>
			<td align="left"><input type="text" name="liveday" style="'.def_style_form_font_size.'" value="'.$warning["liveday"].'"></td></tr>';
		$lst.='<tr><td align="right" valign="center">'.$lang["self_warning_date"].'</td>
			<td align="left"><input type="text" name="date" disabled style="'.def_style_form_font_size.'" value="'.$warning["date"].'"></td></tr>';
		$lst.='<tr><td align="right" valign="top">'.$lang["self_warning_text"].'</td>
			<td align="left"><textarea name="text" cols="65" rows="15" style="'.def_style_form_font_size.'">'.$warning["text"].'</textarea></td></tr>';
		$lst.='<tr><td>&nbsp;</td><td align="left"><input name="ok" type="submit" value="'.$lang["self_warning_savechange"].'"></td></tr>';
		$lst.='</form></table>';	
		
	}else{
		$lst=$lang["self_warning_not_found"];
	}
}

function assemble_new_warning(&$lst){
	global $lang;
	$lst='<table border="0" width="100%">';
	$lst.='<form action="'.$_SERVER["PHP_SELF"].'?action=new" method="post" name="add" id="add">';
	$lst.='<tr><td align="right">&nbsp;</td>
	<td align="left"><input name="color" type="checkbox" value="1" style="'.def_style_form_font_size.'"> '.$lang["self_warning_checked"].'</td></tr>';
	$lst.='<tr><td align="right" valign="center">'.$lang["self_warning_actuality"].'</td>
		<td align="left" valign="center"><input type="text" name="liveday" style="'.def_style_form_font_size.'" value="3"> '.$lang["self_warning_in_day"].'</td></tr>';
	$lst.='<tr><td align="right" valign="top">'.$lang["self_warning_text"].'</td>
		<td align="left"><textarea name="text" cols="65" rows="15" style="'.def_style_form_font_size.'"></textarea></td></tr>';
	$lst.='<tr><td>&nbsp;</td><td align="left"><input name="ok" type="submit" value="'.$lang["self_warning_add_news"].'"></td></tr>';
	$lst.='</form></table>';	
}

function assemble_self_warning(&$lst,$write_warning){
	global $lang;
	$lst='';
	if(QueryScript("SELECT * FROM tblWorkWarning where deleted=0 and date + liveday*1000000 >= NOW() ORDER BY date desc",$result_warning,$connect)){
		if(mysql_num_rows($result_warning) > 0){		
			$lst.='<table border="0" align="left">';
			while($warning = mysql_fetch_array($result_warning)){			
				$lst.='<tr><td align="left">';				
//				$lst .= ( $warning["colored"]==1 ? '<font color="#990000"> ' : ' ' )   .'<b>'.date("d.m.Y H:i",strtotime($warning["date"])).'</b>&nbsp;'.outtext($warning["text"]).   ( $warning["colored"]==1 ? '</font> ' : ' ' );							
				$lst .= ( $warning["colored"]==1 ? '<font color="#990000"> ' : ' ' )   .'&nbsp;'.outtext($warning["text"]).   ( $warning["colored"]==1 ? '</font> ' : ' ' );							
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

function cleartext($s){
	return strip_tags(addslashes(stripslashes( $s )),'<a><b><i><u>');
}

function outtext($s){
	return nl2br(str_replace("  ","&nbsp;",$s));
}

// -----------------------------------------

$write_warning = is_access_write("warning");

if($write_warning && isset($_GET["action"])){
	switch($_GET["action"]){
		case 'del':	
			if(isset($_GET["del"])){
				ExecScript("UPDATE tblWorkWarning SET deleted=1  where id=".$_GET["del"]);	
				$refere=" index.php";				
			}	
			break;	
		case 'new':	
			ExecScript('INSERT INTO tblWorkWarning (date,colored,text,userid,liveday,deleted) VALUES ("'.date("Y-m-d H:i:s").'",'.(int)isset($_POST["color"]).',"'.cleartext($_POST["text"]).'",'.$_SESSION["userid"].','.$_POST["liveday"].',0)');
			$refere=" index.php";			
			break;	
		case 'edit': 
			if(isset($_GET["edit"])){
				ExecScript('UPDATE tblWorkWarning SET colored='.(int)isset($_POST["color"]).', text="'.cleartext($_POST["text"]).'", userid='.$_SESSION["userid"].' , liveday='.$_POST["liveday"].'  WHERE id='.$_GET["edit"]);	
				$refere=" index.php";				
			}
			break;	
	}
	header("Location: ".$refere);	
}

if ($write_warning && isset($_GET["new"]) && $_SESSION["write"]){
	assemble_new_warning($lst);
	$X_desktop[]=array(
		"caption"=>$lang["self_warning_add_warn1"],			
		"list"=>$lst,
		"bottom"=>'<a href="index.php" class="desktop_fun_a">'.$lang["self_warning_na_glavn"].'</a>'
	);
} elseif ($write_warning && isset($_GET["edit"]) && $_SESSION["write"]){
	$editid=$_GET["edit"];
	assemble_edit_warning($lst,$editid);
	$X_desktop[]=array(
		"caption"=>$lang["self_warning_edit_warn"],			
		"list"=>$lst,
		"bottom"=>'<a href="index.php" class="desktop_fun_a">'.$lang["self_warning_na_glavn"].'</a>'
	);

}else{

	assemble_self_warning($lst,$write_warning);
	
	if(strlen($lst)>1){ 
		$X_desktop[]=array(
			"caption"=>$lang["self_warning_warn"],			
			"list"=>'<div align="left">'.$lst.'</div>',
			"bottom"=>( ($write_warning && $_SESSION["write"]) ? '<a href="selfwarning.php?new" class="desktop_fun_a">'.$lang["self_warning_add_warn2"].'</a>&nbsp;&nbsp;&nbsp;'	: '' ).'<a href="index.php" class="desktop_fun_a">'.$lang["self_warning_na_glavn"].'</a>'		
		);
	}

}

draw_site($X_desktop);

unset($X_desktop);