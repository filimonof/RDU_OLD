<?php
// todo

if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("face.inc.php");
include_once("func.inc.php");
include_once("lang/msg_ru.inc.php");

$zvk_commit = array(
	0 => "&nbsp;",
	1 => "разрешено",
	2 => "отказано"
);
$zvk_color = array(
	0 => "#000000",
	1 => "#009933",
	2 => "#990033"
);



session_start();

function assemble_list_zvk(&$lst, $access, $acs_write){
	global $dirimg, $zvk_commit, $zvk_color;	
	if(QueryScript("SELECT * from tblZvk z, tblUser u where z.deleted=0 and z.TypeZvkID=1 and z.UserID=u.ID order by Date ",$result,$connect) && mysql_num_rows($result)>0){	
			
		$count_str = 1;
		$lst = '<table  bgcolor="'.def_color_desktop_bgcolor.'" width="660" border="0" cellpadding="3" cellspacing="0"  bordercolor="'.def_color_bg.'" align="center">
				<tr '.(($count_str % 2)?'bgcolor="'.def_color_desktop_chet_list.'"':" ").' >
					<td width="25" align="center"><b>№</b></td>
					<td width="70" align="center"><b>'.'Разрешение'.'</b></td>						
					<td width="20" align="center"  bgcolor="'.def_color_desktop_bgcolor.'"><b>'.'<img src="'.$dirimg.'/ok_small.jpg" alt="разрешить"  border="0">'.'</b></td>																		
					<td width="20" align="center"  bgcolor="'.def_color_desktop_bgcolor.'"><b>'.'<img src="'.$dirimg.'/no_small.jpg" alt="отказать"  border="0">'.'</b></td>																							
					<td width="145" align="center"><b>'.'На период'.'</b></td>
					<td width="220" align="center"><b>'.'Кто подал'.'</b></td>
					<td width="140" align="center"><b>'.'Дата подачи'.'</b></td>
					<td width="20" align="center"  bgcolor="'.def_color_desktop_bgcolor.'"><b>'.'<img src="'.$dirimg.'/edit_small.jpg" alt="править"  border="0">'.'</b></td>																		
				</tr>
				<tr '.(($count_str % 2)?'bgcolor="'.def_color_desktop_chet_list.'"':" ").'>
					<td colspan="7" width="640" align="center"><b>'.'Описание заявки'.'</b></td>									
					<td width="20" align="center"  bgcolor="'.def_color_desktop_bgcolor.'"><b>'.'<img src="'.$dirimg.'/del_small.jpg" alt="удалить"  border="0">'.'</b></td>																							
				</tr>
					';

					
		
		while ($zvk=mysql_fetch_array($result)){				
		    $count_str++;
			$lst .='
				<tr '.(($count_str % 2)?'bgcolor="'.def_color_desktop_chet_list.'"':" ").' >
					<td width="25" align="center"><b>'.$zvk['ID'].'</b></td>
					<td width="70" align="center"><b><font color="'.$zvk_color[$zvk['Commit']].'">'.$zvk_commit[$zvk['Commit']].'</font></b></td>';		
			if ($acs_write){
				$lst .='<td width="20" align="center" bgcolor="'.def_color_desktop_bgcolor.'"><b>'.'<a  href="'.$_SERVER["PHP_SELF"].'?action=enabled&id='.$zvk["ID"].'" ><img src="'.$dirimg.'/ok_small.jpg" alt="разрешить"  border="0"></a>'.'</b></td>																		
					   <td width="20" align="center" bgcolor="'.def_color_desktop_bgcolor.'"><b>'.'<a  href="'.$_SERVER["PHP_SELF"].'?action=disabled&id='.$zvk["ID"].'" ><img src="'.$dirimg.'/no_small.jpg" alt="отказать"  border="0"></a>'.'</b></td>';
			}else{
 				$lst .='<td width="20" align="center" ><b>'.'&nbsp;'.'</b></td>																		
					<td width="20" align="center" ><b>'.'&nbsp;'.'</b></td>';			
			}
			$lst .='<td width="145" align="center"><b>'.$zvk['DateBetween'].'</b></td>
					<td width="220" align="center"><b>'.$zvk['name'].'</b></td>
					<td width="140" align="center"><b>'.$zvk['Date'].'</b></td>';
			if ($acs_write || ($zvk["UserID"] == $_SESSION["userid"])) {
				$lst .='<td width="20" align="center" bgcolor="'.def_color_desktop_bgcolor.'"><b>'.'<a href="'.$_SERVER["PHP_SELF"].'?edit='.$zvk["ID"].'"><img src="'.$dirimg.'/edit_small.jpg" alt="править"  border="0"></a>'.'</b></td>';																				
			}else{
				$lst .='<td width="20" align="center" bgcolor="'.def_color_desktop_bgcolor.'"><b>'.'&nbsp;'.'</b></td>';																				
			}		
			$lst .='</tr>
			        <tr '.(($count_str % 2)?'bgcolor="'.def_color_desktop_chet_list.'"':" ").'>
					<td colspan="7" width="660" align="center"><b>'.$zvk['Text'].'</b></td>';			
			if ($acs_write || ($zvk["UserID"] == $_SESSION["userid"])) {					
				$lst .= '<td width="20" align="center" bgcolor="'.def_color_desktop_bgcolor.'"><b>'.'<a href="'.$_SERVER["PHP_SELF"].'?action=delete&id='.$zvk["ID"].'"><img src="'.$dirimg.'/del_small.jpg" alt="удалить"  border="0"></a>'.'</b></td>';
			}else{
				$lst .= '<td width="20" align="center" bgcolor="'.def_color_desktop_bgcolor.'"><b>'.'&nbsp;'.'</b></td>';
			}
			$lst .= '</tr>';		
		}
		$lst .= '</table>';	
	}else{
		$lst = "Нет данных";
	}		
}

function assemble_new(&$lst){
	$lst = '<table border="0" width="660">
		<form action="'.$_SERVER["PHP_SELF"].'?action=new" method="post" name="add" id="add">
		<tr>
			<td align="right" valign="center">Машина требуется на период</td>
			<td align="left" valign="center"><input type="text" name="DateBetween" style="'.def_style_form_font_size.'"></td>
		</tr>
		<tr>
			<td align="right" valign="top">Описание заявки (маршрута)</td>
			<td align="left"><textarea name="Text" cols="55" rows="7" style="'.def_style_form_font_size.'"></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="left"><input name="ok" type="submit" value="Подать заявку"></td>
		</tr>
	</form></table>';		
}

function assemble_edit(&$lst,$id){

	if(QueryScript("SELECT * from tblZvk where id=".$id,$result,$connect) && mysql_num_rows($result)>0){	
		$zvk=mysql_fetch_array($result);

		$lst = '<table border="0" width="100%">
			<form action="'.$_SERVER["PHP_SELF"].'?action=edit&edit='.$id.'" method="post" name="add" id="add">
			<tr>
				<td align="right" valign="center">Машина требуется на период</td>
				<td align="left" valign="center"><input type="text" name="DateBetween" style="'.def_style_form_font_size.'" value="'.$zvk['DateBetween'].'"></td>
			</tr>
			<tr>
				<td align="right" valign="top">Описание заявки (маршрута)</td>
				<td align="left"><textarea name="Text" cols="55" rows="7" style="'.def_style_form_font_size.'">'.$zvk['Text'].'</textarea></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="left"><input name="ok" type="submit" value="Сохранить изменения"></td>
			</tr>
		</form></table>';		
	}else{
		$lst = 'Заявка не найдена';
	}
}


function  assemble_no_access(&$lst){
	$lst = 'У вас нет прав для просмотра. <br> Введите логин и пароль.<br>';
}

function get_owner_zvk($id){
	if(QueryScript("SELECT UserID from tblZvk where ID=".$id,$result,$connect) && mysql_num_rows($result)>0){	
		$user=mysql_fetch_array($result);
		return $user['UserID'];
	}else{
		return 0;
	}	
}

function cleartext($s){
	return strip_tags(addslashes(stripslashes( $s )),'<a><b><i><u>');
}

//---------------------------------------------------------

/*
_ENV["USERDOMAIN"] RDURM 
_ENV["USERNAME"] dupakfvv 

*/

if ($config["ZVK_IP_COMP"]==1)
	autorize_to_ip_comp($_SERVER['REMOTE_ADDR']);
$access = is_access_write("zvk");
$acs_write = is_access_write("zvk_wr");

if( ($acs_write || $access ) && isset($_GET["action"]) ) {

	switch($_GET["action"]){
		case 'delete':	
			if(isset($_GET["id"]) && ($acs_write || (get_owner_zvk($_GET["id"])==$_SESSION["userid"])))
				ExecScript("UPDATE tblZvk SET deleted=1 where id=".$_GET["id"]);	
     		$refere=$_SERVER["PHP_SELF"];				
			break;	
		case 'new':			
			ExecScript('INSERT INTO tblZvk (Date,UserID,TypeZvkID,DateBetween,Text) VALUES ("'.date("Y-m-d H:i:s").'",'.$_SESSION["userid"].',1'.',"'.cleartext($_POST['DateBetween']).'","'.cleartext($_POST["Text"]).'")');
			$refere=$_SERVER["PHP_SELF"];			
			break;	
		case 'edit': 		
			if(isset($_GET["edit"])){
				ExecScript('UPDATE tblZvk SET DateBetween="'.cleartext($_POST['DateBetween']).'", Text="'.cleartext($_POST["Text"]).'" WHERE id='.$_GET["edit"]);	
				$refere=$_SERVER["PHP_SELF"];				
			}
			$refere=$_SERVER["PHP_SELF"];					
			break;	
		case 'enabled':
			if ($acs_write && isset($_GET["id"]))
				ExecScript('UPDATE tblZvk SET Commit=1 where ID='.$_GET["id"]);					
			$refere=$_SERVER["PHP_SELF"];								
			break;	
		case 'disabled':
			if ($acs_write && isset($_GET["id"]))
				ExecScript('UPDATE tblZvk SET Commit=2 where ID='.$_GET["id"]);					
			$refere=$_SERVER["PHP_SELF"];								
			break;	
		default:
			$refere=$_SERVER["PHP_SELF"];												
	}
	header("Location: ".$refere);	
	
}

if (($access || $acs_write) && isset($_GET["new"])){
	assemble_new($lst);
	$X_desktop[]=array(
		"caption"=>"Подача заявки",			
		"list"=>"<br>".$lst."<br>",
		"bottom"=>'<a href="'.$_SERVER["PHP_SELF"].'" class="desktop_fun_a">отмена &nbsp;&nbsp;&nbsp;&nbsp;</a>'
	);
}elseif (($access || $acs_write) && isset($_GET["edit"])){
	assemble_edit($lst, $_GET["edit"]);
	$X_desktop[]=array(
		"caption"=>"Редактирование заявки",			
		"list"=>"<br>".$lst."<br>",
		"bottom"=>'<a href="'.$_SERVER["PHP_SELF"].'" class="desktop_fun_a">отмена &nbsp;&nbsp;&nbsp;&nbsp;</a>'
	);
}

if (!$access && !$acs_write){	

	assemble_no_access($lst);
	$X_desktop[]=array(
		"caption"=>"Заявки",			
		"list"=>"<br>".$lst."<br>",
		"bottom"=>""
	);
	
} else {

	assemble_list_zvk($lst, $access, $acs_write);
	$X_desktop[]=array(
		"caption"=>"Заявки на автотранспорт",			
		"list"=>"<br>".$lst."<br><br>",
		"bottom"=>'<a href="'.$_SERVER["PHP_SELF"].'?new" class="desktop_fun_a">подать заявку &nbsp;&nbsp;&nbsp;&nbsp;</a>'
	);

}

draw_site($X_desktop);

unset($X_desktop);

?>