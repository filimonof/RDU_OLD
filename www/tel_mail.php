<?php
if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("face.inc.php");
include_once("func.inc.php");

session_start();

function assemble_table_tel_email(&$lst,$findtema='0',$findstr='',$write=false){
	global $config, $lang;
	
	$tema_mas[]="pe.name";
	$tema_mas[]="po.name";
	$tema_mas[]="pe.email";	
	$tema_mas[]="pe.tel_in";		
	$tema_mas[]="pe.tel_out";			
	
	if($findtema<0 || $findtema>4) 
		$findtema=0;
	
	$count_str = 1;
	$lst = '<table  bgcolor="'.def_color_desktop_bgcolor.'" width="660" border="0" cellpadding="3" cellspacing="0"  bordercolor="'.def_color_bg.'" align="center">
			<tr '.(($count_str++ % 2)?'bgcolor="'.def_color_desktop_chet_list.'"':" ").' ><td width="10" align="center"><b>'.$lang["num"].'</b></td>
				<td width="210" align="center"><b>'.$lang["tel_mail_TableFIO"].'</b></td>
				<td width="195" align="center"><b>'.$lang["tel_mail_TablePost"].'</b></td>
				<td width="180" align="center"><b>'.$lang["tel_mail_TableEmail"].'</b></td>
				<td width="35" align="center"><b>'.$lang["tel_mail_TableTelIn"].'</b></td>
				<td width="30" align="center"><b>'.$lang["tel_mail_TableTelOut"].'</b></td>								
			</tr>
			';
	
	if(QueryScript("select * from tblDepartment order by orders,name",$result_dep,$connect)){

		$number=0;
		while ($departament=mysql_fetch_array($result_dep)){
		
			if(QueryScript("SELECT pe.id, pe.name, pe.email, pe.tel_in,pe.tel_out ,po.name as namepost , pe.people
							FROM tblPersons pe, tblPost po 
							WHERE po.id = pe.postid and pe.departid = ".$departament["id"]." and ".$tema_mas[(int)$findtema]." like '".$findstr."%' 
							ORDER BY pe.orders, pe.name	",$result_te,$connect))
			{

				if ( (mysql_num_rows($result_te) > 0)  && !empty($departament["name"]) )
					$lst.='<tr '.(($count_str++ % 2)?'bgcolor="'.def_color_desktop_chet_list.'"':" ").'><td colspan="6" align="center"><a name="dep'.$departament["id"].'"></a><b>'.$departament["name"].'</b></td></tr>';		
					
				while ($temail=mysql_fetch_array($result_te)){
				
					$lst.='<tr '.(($count_str++ % 2)?'bgcolor="'.def_color_desktop_chet_list.'"':" ").'><td  width="10" align="center">';
					if($write && $_SESSION['write']) 
						$lst.='<a href="'.$_SERVER["PHP_SELF"].'?edit='.$temail["id"].'" class="desktop_list_a">'.++$number.'</a>';		
					else
						$lst.= ++$number;
					$lst.='</td>
						   <td width="210" align="left">';
					
					if ($temail["people"]==1)	   
						$lst.='<a href="person.php?id='.$temail["id"].'" class="desktop_list_a">'.$temail["name"].'</a>';								
					else	
						$lst.=$temail["name"];					
/*
					if($write && $_SESSION['write']) {
						$lst.='<a href="'.$_SERVER["PHP_SELF"].'?edit='.$temail["id"].'" class="desktop_list_a">'.$temail["name"].'</a>';		
					}else{
						$lst.=$temail["name"];
					}						
*/
					$lst.='</td>
								<td width="195" align="left" >'.$temail["namepost"].'</td>
								<td width="180" align="left" nowrap><a href="mailto:'.$temail["email"].'" class="desktop_list_a">'.$temail["email"].'</a></td>						
								<td width="35" align="left" >'.$temail["tel_in"].'</td>
								<td width="30" align="left" >'.$temail["tel_out"].'</td>
							</tr>';							
				}
			}
		}	
	
		mysql_close($connect);
	}

	$lst.='</table>';
	
	if($count_str == 2)
		$lst.='<br><center>'.$lang["tel_mail_nodata"].'</center>';
		
	$lst.='<br><center><a href="'.$_SERVER["PHP_SELF"].'" class="desktop_list_a">'.($findstr==''? '' : $lang["tel_mail_alllist"]).'</a></center><br>';		

}

function assemble_temas(&$tems,$findtema='0',$findstr=''){
	global $config, $lang;
	
	$tema_mas[]="pe.name";
	$tema_mas[]="po.name";
	$tema_mas[]="pe.email";	
	$tema_mas[]="pe.tel_in";		
	$tema_mas[]="pe.tel_out";			
	
	if($findtema<0 || $findtema>4) 
		$findtema=0;
	
	$tems='<table  bgcolor="'.def_color_desktop_bgcolor.'" width="600" border="0" cellpadding="3" cellspacing="0"  bordercolor="'.def_color_bg.'" align="center">';
	
	if(QueryScript("select * from tblDepartment order by orders,name",$result_dep,$connect)){

		$number=0;
		while ($departament=mysql_fetch_array($result_dep)){
		
			if(QueryScript("SELECT pe.id, pe.name, pe.email, pe.tel_in,pe.tel_out ,po.name as namepost 
							FROM tblPersons pe, tblPost po 
							WHERE po.id = pe.postid and pe.departid = ".$departament["id"]." and ".$tema_mas[(int)$findtema]." like '".$findstr."%' 
							ORDER BY pe.orders, pe.name	",$result_te,$connect))
			{

				if (mysql_num_rows($result_te) > 0 && strlen(trim($departament["name"]))) 
					$tems.='<tr align="left"><td><li type="square"><a href="#dep'.$departament["id"].'" class="desktop_list_a">'.$departament["name"].'</a></li></td></tr>';		

			}
		}	
		
		mysql_close($connect);	
	}

	$tems.='</table>';

}

function assemble_form_search(&$fnd,$findtema='0',$findstr=''){
	global $lang;
	
	$fnd = '<form action="'.$_SERVER["PHP_SELF"].'" method="get" name="find_form" id="find_form">
			<table  bgcolor="'.def_color_desktop_bgcolor.'" width="560" border="0" cellpadding="3" cellspacing="0" align="center">
				<tr bgcolor="'.def_color_desktop_chet_list.'" align="center">
					<td width="80" align="center"><b>'.$lang["tel_mail_find_find"].'</b></td>
					<td width="140" align="left"><select name="find_tema" width="140" size="1" style="'.def_style_form_font_size.'">
							<option '.(((int)$findtema==0)?' selected ':' ').' value="0">'.$lang["tel_mail_find_fio"].'
							<option '.(((int)$findtema==1)?' selected ':' ').' value="1">'.$lang["tel_mail_find_post"].'
							<option '.(((int)$findtema==2)?' selected ':' ').' value="2">'.$lang["tel_mail_find_email"].'
							<option '.(((int)$findtema==3)?' selected ':' ').' value="3">'.$lang["tel_mail_find_intel"].'
							<option '.(((int)$findtema==4)?' selected ':' ').' value="4">'.$lang["tel_mail_find_outtel"].'
						</select></td>
					<td width="260" align="left" valign="middle"><input type="text" name="find_str" size="38" width="260" maxlength="255" value="'.$findstr.'" style="'.def_style_form_font_size.'"></td>
					<td  width="80" align="center"><input type="submit" value="'.$lang["tel_mail_find_submit"].'" style="'.def_style_form_font_size.'"></td>					
				</tr>
			</table></form>';	
}

function assemble_new_tel_email(&$editemail){
	global $config, $lang;

	if(QueryScript("select * from tblDepartment order by orders,name",$result_dep,$connect) &&
		QueryScript("select * from tblPost order by orders,name",$result_post,$connect)  ){

		$editemail='<table  bgcolor="'.def_color_desktop_bgcolor.'" width="500" border="0" cellpadding="3" cellspacing="0"  align="center">
					<form action="'.$_SERVER["PHP_SELF"].'?action=new" method="post" name="new" id="new">
					<input type="hidden" name="action" value="new">';
		$editemail.='<tr><td width="200" align="right">'.$lang["tel_mail_name"].'</td>
						 <td width="300" align="left"><input type="text" size="35" maxlength="255" name="name" style="'.def_style_form_font_size.'"></td></tr>
					<tr><td width="200" align="right">'.$lang["tel_mail_post"].'</td>					
						 <td width="300" align="left"><select name="postid" width="200" size="1" style="'.def_style_form_font_size.'">';
		while ($postid=mysql_fetch_array($result_post)){
			$editemail.='<option value="'.$postid["id"].'">'.$postid["name"];
		}					 
		 $editemail.='</select></td></tr>
					<tr><td width="200" align="right">'.$lang["tel_mail_email"].'</td>
						 <td width="300" align="left"><input type="text" size="35" maxlength="255" name="email" value="@rdurm.odusv.so-cdu.ru" style="'.def_style_form_font_size.'"></td></tr>
					<tr><td width="200" align="right" nowrap>'.$lang["tel_mail_tel_in"].'</td>
						 <td width="300" align="left"><input type="text" size="35" maxlength="255" name="tel_in" style="'.def_style_form_font_size.'"></td></tr>
					<tr><td width="200" align="right" nowrap>'.$lang["tel_mail_tel_out"].'</td>
						 <td width="300" align="left"><input type="text" size="35" maxlength="255" name="tel_out" style="'.def_style_form_font_size.'"></td></tr>
					<tr><td width="200" align="right">'.$lang["tel_mail_depart"].'</td>
						 <td width="300" align="left"><select name="departid" width="200" size="1" style="'.def_style_form_font_size.'">';
	
		while ($departament=mysql_fetch_array($result_dep)){
			$editemail.='<option value="'.$departament["id"].'">'.$departament["name"];
		}					 
		
		$editemail.='</select></td></tr>					 					 					 
					<tr><td width="200" align="right">'.$lang["tel_mail_orders"].'</td>
						 <td width="300" align="left"><input type="text" size="35" maxlength="3" name="orders" value="1" style="'.def_style_form_font_size.'"></td></tr>					 					 					 
					<tr><td  colspan="2" width="500" align="center"><input type="submit" value="'.$lang["tel_mail_save"].'" style="'.def_style_form_font_size.'"></td></tr>';
		
		$editemail.='</form></table>';

		mysql_close($connect);
	
	}		
}

function assemble_edit_tel_email(&$editemail){
	global $config, $lang;

	if( QueryScript("select * from tblDepartment order by orders,name",$result_dep,$connect) &&
		QueryScript("select * from tblPost order by orders,name",$result_post,$connect)  &&
		QueryScript("select * from tblPersons where id=".$_GET["edit"]." order by orders,name",$result_te,$connect) )
	{

		if (mysql_num_rows($result_te) != 1){
		
			$editemail="<br><center>".$lang["tel_mail_editerror"]."</center><br>";
			
		} else {
		
			$email=mysql_fetch_array($result_te);
			$editemail='<table  bgcolor="'.def_color_desktop_bgcolor.'" width="500" border="0" cellpadding="3" cellspacing="0" align="center">
						<form action="'.$_SERVER["PHP_SELF"].'?edit='.$_GET["edit"].'&action=edit" method="post" name="edit" id="edit">
						<input type="hidden" name="action" value="editemail">';
			$editemail.='<tr><td width="200" align="right">'.$lang["tel_mail_name"].'</td>
							 <td width="300" align="left"><input type="text" size="35" maxlength="255" name="name" value="'.$email["name"].'" style="'.def_style_form_font_size.'"></td></tr>
						<tr><td width="200" align="right">'.$lang["tel_mail_post"].'</td>
							 <td width="300" align="left"><select name="postid" width="200" size="1" style="'.def_style_form_font_size.'">';
			
			while ($postid=mysql_fetch_array($result_post)){
				$editemail.='<option '.($postid["id"]==$email["postid"]?"selected":"").' value="'.$postid["id"].'">'.$postid["name"];
			}					 

			$editemail.='</select></td></tr>
						<tr><td width="200" align="right">'.$lang["tel_mail_email"].'</td>
							 <td width="300" align="left"><input type="text" size="35" maxlength="255" name="email" value="'.$email["email"].'" style="'.def_style_form_font_size.'"></td></tr>
						<tr><td width="200" align="right" nowrap>'.$lang["tel_mail_tel_in"].'</td>
							 <td width="300" align="left"><input type="text" size="35" maxlength="255" name="tel_in" value="'.$email["tel_in"].'" style="'.def_style_form_font_size.'"></td></tr>
						<tr><td width="200" align="right" nowrap>'.$lang["tel_mail_tel_out"].'</td>
							 <td width="300" align="left"><input type="text" size="35" maxlength="255" name="tel_out" value="'.$email["tel_out"].'" style="'.def_style_form_font_size.'"></td></tr>
						<tr><td width="200" align="right">'.$lang["tel_mail_depart"].'</td>
							 <td width="300" align="left"><select name="departid" width="200" size="1" style="'.def_style_form_font_size.'">';						 
			
			while ($departament=mysql_fetch_array($result_dep)){
				$editemail.='<option '.($departament["id"]==$email["departid"]?"selected":"").' value="'.$departament["id"].'">'.$departament["name"];
			}					 
			
			$editemail.='</select></td></tr>					 					 					 
						<tr><td width="200" align="right">'.$lang["tel_mail_orders"].'</td>
							 <td width="300" align="left"><input type="text" size="35" maxlength="3" name="orders" value="'.$email["orders"].'" style="'.def_style_form_font_size.'"></td></tr>					 					 					 
						<tr><td  colspan="2" width="500" align="center"><input type="submit" value="'.$lang["tel_mail_save"].'" style="'.def_style_form_font_size.'"></td></tr>';
			
			$editemail.='</form></table>';
		}

		mysql_close($connect);			

	}
}


// ---------------------------------------------

$write = is_access_write("email tel");

if($write && isset($_GET["action"])){
	switch($_GET["action"]){
		case 'del':	
			if(isset($_GET["edit"]))
				ExecScript("delete from tblPersons where id=".$_GET["edit"]);	
			break;	
		case 'new':	
			ExecScript('INSERT INTO tblPersons (name, postid, email, tel_in, tel_out, departid, orders) VALUES ("'.$_POST['name'].'",'.$_POST['postid'].',"'.$_POST['email'].'","'.$_POST["tel_in"].'","'.$_POST["tel_out"].'",'.$_POST['departid'].','.$_POST['orders'].')');
			break;	
		case 'edit': 
			if(isset($_GET["edit"]))
				ExecScript('UPDATE tblPersons SET name="'.$_POST['name'].'", postid='.$_POST['postid'].', email="'.$_POST['email'].'", tel_in="'.$_POST["tel_in"].'", tel_out="'.$_POST["tel_out"].'", departid='.$_POST['departid'].', orders='.$_POST['orders'].'  WHERE id='.$_GET["edit"]);	
			break;	
	}
	header("Location: ".$_SERVER['PHP_SELF']);	
}



if($write && $_SESSION["write"]){
	if(!isset($_GET["edit"]) || $_GET["edit"]<1){ 	
		assemble_new_tel_email($editemail);
		$X_desktop[]=array(
			"caption"=>$lang["tel_mail_caption_form_input"],			
			"list"=>$editemail,
			"bottom"=>""
		);		
	}else{
		$editemail='edit';
		assemble_edit_tel_email($editemail);
		$X_desktop[]=array(
			"caption"=>$lang["tel_mail_caption_form_edit"],
			"list"=>$editemail,
			"bottom"=>'<a href="'.$_SERVER["PHP_SELF"].'" class="desktop_fun_a">'.$lang["tel_mail_form_insert"].'</a>&nbsp;&nbsp;&nbsp;
			<a href="'.$_SERVER["PHP_SELF"].'?edit='.$_GET["edit"].'&action=del" class="desktop_fun_a">'.$lang["tel_mail_delete_custom"].'</a>'
		);		
	}
}


isset($_GET["find_tema"]) ? $findtema=strip_tags(substr($_GET["find_tema"],0,10)) : $findtema='0';
isset($_GET["find_str"]) ? $findstr=strip_tags(substr($_GET["find_str"],0,255)) : $findstr='';
 
$X_desktop[]=array(
	"caption"=>$lang["tel_mail_CaptionDesktop"],
	"list"=>"",
	"bottom"=>""	
);

assemble_form_search($formfind,$findtema,$findstr);
assemble_temas($tems,$findtema,$findstr);
assemble_table_tel_email($mainlist,$findtema,$findstr,$write);

$X_desktop[sizeof($X_desktop)-1]["list"] = '<br>'.$formfind.$tems.'<br>'.$mainlist;


draw_site($X_desktop);

unset($X_desktop);
?> 
