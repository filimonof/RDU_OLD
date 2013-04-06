<?php

if(false){ ?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("face.inc.php");
include_once("func.inc.php");
include_once("lang/msg_ru.inc.php");

session_start();

function assemble_blank(&$lst,$id,$write){
	global  $dirimg, $lang;
	
	if ((QueryScript("SELECT pe.id, pe.name, pe.email, pe.tel_in, pe.tel_out , pe.birthday, pe.fotosite, pe.foto34, pe.foto34bw, po.name as namepost , dp.name as namedepartament, pe.departid
					FROM tblPersons pe, tblPost po , tblDepartment dp
					WHERE pe.people = 1 and  po.id = pe.postid and pe.departid = dp.id and pe.id=$id",
					$rsl,$connect)) && (mysql_num_rows($rsl)>0) )
	{
	   	$person=mysql_fetch_array($rsl); 
		$lst .= '
			<TABLE WIDTH="654" BORDER="0" CELLPADDING="0" CELLSPACING="0">
				<TR><TD COLSPAN="13" background="'.$dirimg.'/person_01.jpg" WIDTH="654" HEIGHT="13"></TD>
				</TR>
				<TR><TD ROWSPAN="2" background="'.$dirimg.'/person_02.jpg" WIDTH="20" HEIGHT="162"></TD>
					<TD WIDTH="113" HEIGHT="147" >'.(empty($person["fotosite"])?'<img src="'.$dirimg.'/person_nofoto.jpg" WIDTH="113" HEIGHT="147" alt="'.$lang["person_nofoto"].'">':'<img src="img.php?id='.$id.'">').'</TD>
					<TD background="'.$dirimg.'/person_04.gif" WIDTH="9" HEIGHT="147"></TD>
					<TD COLSPAN="7" WIDTH="107" HEIGHT="147">
							<table width="107" height="147"  BORDER="0" CELLPADDING="0" CELLSPACING="0">
								<tr><td align="center"><font size="-1">'.$lang["person_FIO"].'</font></td></tr>
								<tr><td align="center"><font size="-1">'.$lang["person_dep"].'</font></td></tr>
								<tr><td align="center"><font size="-1">'.$lang["person_post"].'</font></td></tr>
								<tr><td align="center"><font size="-1">'.$lang["person_tel"].'</font></td></tr>
								<tr><td align="center"><font size="-1">'.$lang["person_email"].'</font></td></tr>
								<tr><td align="center"><font size="-1">'.$lang["person_birthday"].'</font></td></tr>
								</table></TD>
					<TD background="'.$dirimg.'/person_06.gif" WIDTH="9" HEIGHT="147"></TD>
					<TD WIDTH=372 HEIGHT="147">
							<table width="372" height="147"  BORDER="0" CELLPADDING="0" CELLSPACING="0">
								<tr><td align="left"><font size="-1">&nbsp;<a href="'.$_SERVER["PHP_SELF"].'?id='.$person["id"].'" class="desktop_list_a">'.$person["name"].'</a></font></td></tr>
								<tr><td align="left"><font size="-1">&nbsp;<a href="'.$_SERVER["PHP_SELF"].'?dep='.$person["departid"].'" class="desktop_list_a">'.$person["namedepartament"].'</a></font></td></tr>
								<tr><td align="left"><font size="-1">&nbsp;'.$person["namepost"].'</font></td></tr>
								<tr><td align="left"><font size="-1">&nbsp;'.$person["tel_in"].'&nbsp;&nbsp;'.$person["tel_out"].'</font></td></tr>
								<tr><td align="left"><font size="-1">&nbsp;<a href="mailto:'.$person["email"].'" class="desktop_list_a">'.$person["email"].'</a></font></td></tr>
								<tr><td align="left"><font size="-1">&nbsp;'.put_format_date($person["birthday"]).'</font></td></tr>
								</table></TD>
					<TD ROWSPAN="2" background="'.$dirimg.'/person_08.gif" WIDTH=24 HEIGHT="162"></TD>
				</TR>
				<TR><TD COLSPAN="2" background="'.$dirimg.'/person_09.jpg" WIDTH="122" HEIGHT="15"></TD>
					<TD background="'.$dirimg.'/person_10.gif" WIDTH="14" HEIGHT="15"></TD>
					  <TD background="'.$dirimg.'/person_11.jpg" WIDTH="17" HEIGHT="15"></TD>
					<TD background="'.$dirimg.'/person_12.gif" WIDTH="11" HEIGHT="15"></TD>
					  <TD background="'.$dirimg.'/person_13.jpg" WIDTH="17" HEIGHT="15"></TD>
					<TD background="'.$dirimg.'/person_14.gif" WIDTH="16" HEIGHT="15"></TD>';
					if($write && $_SESSION["write"]) 
						$lst .= '<TD WIDTH="15" HEIGHT="15"><a href="'.$_SERVER["PHP_SELF"].'?edit='.$person["id"].'"><img src="'.$dirimg.'/edit_small.jpg" WIDTH="15" HEIGHT="15" alt="'.$lang["edit"].'"  border="0"></a></TD>';
					else	
						$lst .= '<TD background="'.$dirimg.'/person_15.jpg" WIDTH="15" HEIGHT="15"></TD>';					  
				$lst .='<TD background="'.$dirimg.'/person_16.gif" WIDTH="17" HEIGHT="15"></TD>
					<TD background="'.$dirimg.'/person_17.jpg" WIDTH="9" HEIGHT="15"></TD>
					<TD background="'.$dirimg.'/person_18.gif" WIDTH="372" HEIGHT="15"></TD>
				</TR>
			</TABLE>		
		';	
	}else{
		$lst.='';
	}
	
}

function assemble_all_person(&$lst,$write){
	if ((QueryScript("SELECT id	FROM tblPersons WHERE people=1 ORDER BY departid,orders,name",
					$rsl,$connect)) && (mysql_num_rows($rsl)>0) ){
		while ($person=mysql_fetch_array($rsl)){
			assemble_blank($lst,$person["id"],$write);
		}	
	}	
}

function assemble_departament_person(&$lst,$depid,$write){
	if(QueryScript("select * from tblDepartment",$rsl_dep,$connect) && (mysql_num_rows($rsl_dep)>0) )
	{
		if ((QueryScript("SELECT id	FROM tblPersons where people=1 and departid=$depid order by orders,name",
			$rsl,$connect)) && (mysql_num_rows($rsl)>0) )
		{
			while ($person=mysql_fetch_array($rsl))
				assemble_blank($lst,$person["id"],$write);
		}
	}
}

function assemble_firstletter_person(&$lst,$ch,$write){
	if ((QueryScript("SELECT id	FROM tblPersons where people=1 and name like '$ch%' order by departid,orders,name",
		$rsl,$connect)) && (mysql_num_rows($rsl)>0) )
	{
		while ($person=mysql_fetch_array($rsl))
			assemble_blank($lst,$person["id"],$write);
	}
}

function assemble_find_leter(&$lst){
	global $lang;

	$alfavit = utf_cp($lang["alfavit"]);	
	//$alfavit = $lang["alfavit"];	
	$lst .= '
	<table BORDER="0" CELLPADDING="0" CELLSPACING="0" align="center"  bgcolor="'.def_color_desktop_chet_list.'"> 	 
	<tr><td>&nbsp;&nbsp;&nbsp;
	';		
	for($i=0; $i<strlen($alfavit); ++$i){
		$c = utf($alfavit[$i]);
		if ((QueryScript("SELECT id	FROM tblPersons where people=1 and name like '$c%'",$rsl,$connect)) && (mysql_num_rows($rsl)>0) ){
			$lst .= '<a href="'.$_SERVER["PHP_SELF"].'?ch='.$c.'" class="desktop_list_a">'.$c.'</a>&nbsp;';		
		}
	}
	$lst .= '&nbsp;<a href="'.$_SERVER["PHP_SELF"].'" class="desktop_list_a">('.$lang["person_all"].')</a>';
	$lst .= '&nbsp;&nbsp;&nbsp;</tr></td></table><br>';
}

function assemble_edit_person(&$lst,$id){
	global $month_str_vp,$lang;
	if ((QueryScript("SELECT pe.id, pe.name, pe.email, pe.tel_in, pe.tel_out , pe.birthday, pe.fotosite, pe.foto34, 
					pe.foto34bw, po.name as namepost , dp.name as namedepartament, pe.departid, pe.postid, pe.departid, pe.orders						
					FROM tblPersons pe, tblPost po , tblDepartment dp
					WHERE pe.people = 1 and  po.id = pe.postid and pe.departid = dp.id and pe.id=$id",
					$rsl,$connect)) && (mysql_num_rows($rsl)>0) && 
	    QueryScript("select * from tblDepartment order by orders,name",$result_dep,$connect) &&
		QueryScript("select * from tblPost order by orders,name",$result_post,$connect)  )					
	{
	   	$person=mysql_fetch_array($rsl); 
		if (!empty($person["birthday"])) {
			$birthlist=explode("-",$person["birthday"]);
//			return $lst[2].' '.strtolower($month_str_vp[$lst[1]]).' '.$lst[0].' '.$lang["person_year"];
		}else{
			$birthlist[]='';					
			$birthlist[]='';					
			$birthlist[]='';											
		}
		$lst .= '
			<table border="0" width="*" CELLPADDING="2" CELLSPACING="2	">
			<form enctype="multipart/form-data" method="post" action="'.$_SERVER["PHP_SELF"].'?edit='.$id.'&execute">
			<input type="hidden" name="MAX_FILE_SIZE" value="10485760"> 		
			<input name="id" type="hidden" value="'.$id.'">			
			<tr><td align="right" width="250">'.$lang["person_FIO"].'</td>
				<td align="left"><input type="text" value="'.$person["name"].'" name="name" style="'.def_style_form_font_size.'" size="70"></td></tr>
			<tr><td align="right" width="250">'.$lang["person_dep"].'</td>
				<td align="left"><select name="departid"  size="1" style="'.def_style_form_font_size.'">';						 			
			while ($departament=mysql_fetch_array($result_dep)){
				$lst .= '<option '.($departament["id"]==$person["departid"]?"selected":"").' value="'.$departament["id"].'">'.$departament["name"];
			}		
			
		$lst.='</select></td></tr>
			<tr><td align="right" width="250">'.$lang["person_post"].'</td>			
				<td align="left"><select name="postid"size="1" style="'.def_style_form_font_size.'">';
			while ($postid = mysql_fetch_array($result_post)){
				$lst .= '<option '.($postid["id"]==$person["postid"]?"selected":"").' value="'.$postid["id"].'">'.$postid["name"];
			}					 
		$lst .= '</select></td></tr>
			<tr><td align="right" width="250">'.$lang["person_telin"].'</td>
				<td align="left"><input type="text" value="'.$person["tel_in"].'" name="tel_in" style="'.def_style_form_font_size.'" size="70"></td></tr>
			<tr><td align="right" width="250">'.$lang["person_telout"].'</td>
				<td align="left"><input type="text" value="'.$person["tel_out"].'" name="tel_out" style="'.def_style_form_font_size.'" size="70"></td></tr>
			<tr><td align="right" width="250">'.$lang["person_email"].'</td>
				<td align="left"><input type="text" value="'.$person["email"].'" name="email" style="'.def_style_form_font_size.'" size="70"></td></tr>
			<tr><td align="right" width="250">'.$lang["person_birthday"].'</td>
				<td align="left"><input type="text" value="'.$birthlist[2].'" name="bday" style="'.def_style_form_font_size.'" size="2">
								<select name="bmonth"  size="1" style="'.def_style_form_font_size.'">';						 										
								for ($i=1; $i<=12; $i++)								
									$lst .= '<option '.($i==$birthlist[1]?"selected":"").' value="'.$i.'">'.strtolower($month_str_vp[$i]);
								$lst.='</select>				
								<input type="text" value="'.$birthlist[0].'" name="byear" style="'.def_style_form_font_size.'" size="4"></td></tr>				
			<tr><td align="right" width="250">'.$lang["person_num"].'</td>
				<td align="left"><input type="text" value="'.$person["orders"].'" name="orders" style="'.def_style_form_font_size.'" size="70"></td></tr>
			<tr><td align="right" width="250">'.$lang["person_foto"].'</td>		
				<td align="left"><input name="fotosite" type="file" style="'.def_style_form_font_size.'" size="70"></td></tr>			
			<tr><td>&nbsp;</td><td align="left"><input type="submit" value="'.$lang["person_savechange"].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$_SERVER["PHP_SELF"].'?del='.$id.'&execute" class="desktop_list_a">'.$lang["person_delperson"].'</a></td></tr>
			</form></table>	
			';
		}

}

function assemble_new_person(&$lst){
	global $month_str_vp,$lang;
	if  ( QueryScript("select * from tblDepartment order by orders,name",$result_dep,$connect) &&
		QueryScript("select * from tblPost order by orders,name",$result_post,$connect)  )					
	{
			$birthlist[]='';					
			$birthlist[]='';					
			$birthlist[]='';											
		$lst .= '
			<table border="0" width="*" CELLPADDING="2" CELLSPACING="2	">
			<form enctype="multipart/form-data" method="post" action="'.$_SERVER["PHP_SELF"].'?new&execute">
			<input type="hidden" name="MAX_FILE_SIZE" value="10485760"> 		
			<tr><td align="right" width="250">'.$lang["person_FIO"].'</td>
				<td align="left"><input type="text" value="" name="name" style="'.def_style_form_font_size.'" size="70"></td></tr>
			<tr><td align="right" width="250">'.$lang["person_dep"].'</td>
				<td align="left"><select name="departid"  size="1" style="'.def_style_form_font_size.'">';						 			
			while ($departament=mysql_fetch_array($result_dep)){
				$lst .= '<option value="'.$departament["id"].'">'.$departament["name"];
			}					 			
		$lst.='</select></td></tr>
			<tr><td align="right" width="250">'.$lang["person_post"].'</td>			
				<td align="left"><select name="postid"size="1" style="'.def_style_form_font_size.'">';
			while ($postid = mysql_fetch_array($result_post)){
				$lst .= '<option  value="'.$postid["id"].'">'.$postid["name"];
			}		
		$lst .= '</select></td></tr>
			<tr><td align="right" width="250">'.$lang["person_telin"].'</td>
				<td align="left"><input type="text" value="" name="tel_in" style="'.def_style_form_font_size.'" size="70"></td></tr>
			<tr><td align="right" width="250">'.$lang["person_telout"].'</td>
				<td align="left"><input type="text" value="" name="tel_out" style="'.def_style_form_font_size.'" size="70"></td></tr>
			<tr><td align="right" width="250">'.$lang["person_email"].'</td>
				<td align="left"><input type="text" value="@rdurm.odusv.so-cdu.ru" name="email" style="'.def_style_form_font_size.'" size="70"></td></tr>
			<tr><td align="right" width="250">'.$lang["person_birthday"].'</td>
				<td align="left"><input type="text" value="'.$birthlist[2].'" name="bday" style="'.def_style_form_font_size.'" size="2">
								<select name="bmonth"  size="1" style="'.def_style_form_font_size.'">';						 										
								for ($i=1; $i<=12; $i++)								
									$lst .= '<option value="'.$i.'">'.strtolower($month_str_vp[$i]);
								$lst.='</select>				
								<input type="text" value="'.$birthlist[0].'" name="byear" style="'.def_style_form_font_size.'" size="4"></td></tr>				
			<tr><td align="right" width="250">'.$lang["person_num"].'</td>
				<td align="left"><input type="text" value="1" name="orders" style="'.def_style_form_font_size.'" size="70"></td></tr>
			<tr><td align="right" width="250">'.$lang["person_foto"].'</td>		
				<td align="left"><input name="fotosite" type="file" style="'.def_style_form_font_size.'" size="70"></td></tr>			
			<tr><td>&nbsp;</td><td align="left"><input type="submit" value="'.$lang["person_savechange"].'"></td></tr>
			</form></table>	
			';
		}

}

function GetDataUploadFile($fname){
	global $X_desktop;
	$max_image_size= 64 * 1024;
	$valid_types =  array("gif","jpg", "png", "jpeg");	

	if (isset($_FILES[$fname])) {
		if (is_uploaded_file($_FILES[$fname]['tmp_name'])) {
			$filename = $_FILES[$fname]['tmp_name'];
			$ext = substr($_FILES[$fname]['name'], 
					1 + strrpos($_FILES[$fname]['name'], "."));
			if (filesize($filename) > $max_image_size) {
				$_SESSION['error'] = $lang["person_error_large"].' ( '.filesize($filename).' > '.$max_image_size.' ) ';
			} elseif (!in_array($ext, $valid_types)) {
				$_SESSION['error'] = $lang["person_error_type"];
			} else {
   				$h=fopen($filename,"rb");
				$data=&fread($h,filesize($filename));
				fclose($h);
				return $data;
			}
		}
	} 

}

// -----------------------------------------

$write = is_access_write("person");

if ($write && isset($_GET["edit"]) && $_SESSION["write"]){
	if( isset($_GET["execute"])){		
		if ( ($_POST['byear']=='') || ($_POST['bday']=='') )
			$birthday  = '';
		else			
			$birthday  = $_POST['byear'].'-'.$_POST['bmonth'].'-'. $_POST['bday'];
		ExecScript('UPDATE tblPersons SET name="'.$_POST['name'].'", postid='.$_POST['postid'].', email="'.$_POST['email'].
					'", tel_in="'.$_POST["tel_in"].'", tel_out="'.$_POST["tel_out"].'", departid='.$_POST['departid'].', orders='.$_POST['orders'].
					',birthday="'.$birthday.'"
					'.( ($_FILES["fotosite"]["name"] != '')?',fotosite="'.addslashes(GetDataUploadFile("fotosite")).'"':'' ).'
					 WHERE id='.$_GET["edit"]);						 
		header("Location: ".$_SERVER['PHP_SELF'].'?id='.$_GET["edit"]);						
	} else {
		assemble_edit_person($lst,$_GET["edit"]);
	}	
}elseif ($write && isset($_GET["new"]) && $_SESSION["write"]){	
	if( isset($_GET["execute"])){		
		if ( ($_POST['byear']=='') || ($_POST['bday']=='') )
			$birthday  = '';
		else			
			$birthday  = $_POST['byear'].'-'.$_POST['bmonth'].'-'. $_POST['bday'];
		ExecScript('insert into tblPersons (name, postid, email, tel_in, tel_out, departid, orders, birthday, fotosite, people) values 
			("'.$_POST['name'].'", '.$_POST['postid'].', "'.$_POST['email'].'", "'.$_POST["tel_in"].'", "'.$_POST["tel_out"].'", '
			.$_POST['departid'].', '.$_POST['orders'].', "'.$birthday.'" , "' .addslashes(GetDataUploadFile("fotosite")).'", 1 )');						 
		if ( QueryScript('select max(id) as id from tblPersons',$rsl,$connect) && (mysql_num_rows($rsl)>0) )
		{
	   		$person=mysql_fetch_array($rsl); 		
			header("Location: ".$_SERVER['PHP_SELF'].'?id='.$person["id"]);						
		}else{
			header("Location: ".$_SERVER['PHP_SELF']);						
		}	
	} else {
		assemble_new_person($lst);		
	}	
}elseif ($write && isset($_GET["del"]) && $_SESSION["write"]){	
	if( isset($_GET["execute"]))
		ExecScript("delete from tblPersons where id=".$_GET["del"]);	
	header("Location: ".$_SERVER['PHP_SELF']);								
}else{

	$lst = '';
	
	assemble_find_leter($lst);	
	
	if (isset($_GET["id"])){
		assemble_blank($lst,$_GET["id"],$write);
	}elseif (isset($_GET["dep"])){
		assemble_departament_person($lst,$_GET["dep"],$write);
	}elseif (isset($_GET["ch"])){
		assemble_firstletter_person($lst,$_GET["ch"],$write);
	}else{
		assemble_all_person($lst,$write);
	}
	
}

	$X_desktop[]=array(
		"caption"=>$lang["person_personal_title"],			
		"list"=>'<br>'.$lst.'<br>',
		"bottom"=>(($write && $_SESSION["write"])?'<a href="'.$_SERVER["PHP_SELF"].'?new" class="desktop_fun_a">'.$lang["person_addperson"].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>':'').
					'<a href="'.$_SERVER["PHP_SELF"].'" class="desktop_fun_a">'.$lang["person_list"].'</a>'
	);
	
draw_site($X_desktop);

unset($X_desktop);
?>
