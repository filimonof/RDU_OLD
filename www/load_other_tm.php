<?
if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("func.inc.php");
include_once("lang/msg_ru.inc.php");

function load_other_telmail(){	
	if(QueryScript("SELECT * FROM tblLoadOtherContact l, tblOtherCompany c 
		where l.OtherCompanyID = c.ID and l.OtherCompanyID is not null and l.Enabled = 1 
		and l.cachefile is not null and l.url is  not  null 
		ORDER BY l.OtherCompanyID ",$result,$connect)){
		while ($fetch=mysql_fetch_array($result)){		
			
/*!*/		echo  "<br><b>".$fetch["name"]." </b><br>"	;	
				
			//нужно загрузить страницу и пропарсить		
			if (copy_file_socket($fetch["host"],$fetch["url"],$fetch["cachefile"],$fetch["port"]))			
				parse_file_to_departament($fetch["OtherCompanyID"],$fetch["cachefile"],$fetch["host"],$fetch["port"],$fetch["TypeLoader"]);	
			
			//удаляем файл чтоб не мусорить		
			if (file_exists($fetch["cachefile"]))
				unlink($fetch["cachefile"]);
				
		}
		@mysql_close($connect);
	}			
}

function parse_file_to_departament($companyid,$cachefile,$host,$port,$type_parse){
	// парсим файл с подразделениями
	
	global  $lang;				
	
	$site = file_get_contents($cachefile);  

	// узнаем кодировку charset=KOI8-R
	preg_match("|[\s]*charset[\s]*=[\s]*([^\"]*)|i",$site,$encodi);
	if (!isset($encodi[1]))
		$chars = "KOI8-R";
	else	
		$chars = $encodi[1];
	
	// выбираем токо таблицу с подразделениями
	$site_podr = substr($site,strpos($site,"<TABLE width=100% cols=1 cellpadding=0>"));
	$site_podr = substr($site_podr,0,strpos($site_podr,"</table>"));

	if (isset($site_podr) && strlen($site_podr)>0){	

		// находим ссылки на подразделения	
		preg_match_all("|<a href=\"([^\"]*)[^>]*>([^(<\/a>)]+)|i",$site_podr,$out); 

		for($i = 0; $i < count($out[1]); $i ++){ 	    	
			
			// преобразовать кодировку	
			$dep_name = convert_cyr_string_larg($out[2][$i],$chars,$lang["CHARSET_NAME"]);
			
			//проверить есть ли такое подразделение, взять id
			$dep_id = get_departament_id($dep_name);				
			
/*!*/		echo  "<br> $dep_name <br>"	;
			

			$cachefile_pers = $cachefile.".tmp";				
			
			//загрузить страничку и пропарсить
			if (copy_file_socket($host,'http://domino.cdo.ups.ru'.$out[1][$i],$cachefile_pers,$port)){
				switch ($type_parse){
					case "cdo.ups.ru_1" : parse_file_to_person($cachefile_pers,$companyid,$dep_id); break;
					default             : echo $lang["load_other_tm_type_no_exist"]; 
				}
			}
			
			//удаляем файл чтоб не мусорить
			if (file_exists($cachefile_pers))
				unlink($cachefile_pers);

	  	}  
	}
}

function get_departament_id($dep){	
	if (isset($dep) && strlen($dep)>0){				
		if(QueryScript("SELECT * FROM tblDepartment where name =\"$dep\"",$result,$connect)){			
			$fetch=mysql_fetch_array($result);			
			if (isset($fetch["id"])){				
				return $fetch["id"];
			} else {
				ExecScript("insert into tblDepartment (name,shortname,orders) values (\"$dep\",\"$dep\",1) ");
				return get_departament_id($dep);			
			}
			mysql_close($connect);
		}		
	}
}

function get_post_id($postname){	
	if (isset($postname) && strlen($postname)>0){				
		if(QueryScript("SELECT * FROM tblPost where name =\"$postname\"",$result,$connect)){			
			$fetch=mysql_fetch_array($result);			
			if (isset($fetch["id"])){				
				return $fetch["id"];
			} else {
				ExecScript("insert into tblPost (name,orders) values (\"$postname\",1) ");
				return get_post_id($postname);			
			}
			mysql_close($connect);
		}		
	}
}

function tel_no_code($t){
	if (isset($t) && strlen($t)>0){			
		if (strpos($t,")")>0)
			return substr($t,strpos($t,")")+1);		
	} else {
		return "";
	}
}

function tel_perenos($t){
	if (isset($t) && strlen($t)>0){			
		$t = trim($t);
		$t = str_replace(","," ",$t);
		$t = str_replace(";"," ",$t);
		return $t;
	} else {
		return "";
	}
}

function parse_file_to_person($cachefile,$companyid,$dep_id){
	
	global  $lang;
	
	// парсим файл с людьми	
	$site = file_get_contents($cachefile);  	
	
	// узнаем кодировку charset=KOI8-R
	preg_match("|[\s]*charset[\s]*=[\s]*([^\"]*)|i",$site,$encodi);
	if (!isset($encodi[1]))
		$chars = "KOI8-R";
	else	
		$chars = $encodi[1];		
		
	// выбираем токо таблицу с людями
	$site_pers = substr($site,strpos($site,"<TABLE width=100% cols=4 cellpadding=0>"));
	$site_pers = substr($site_pers,0,strpos($site_pers,"</table>"));
	
	if (isset($site_pers) && strlen($site_pers)>0){	
		
		/*	парсим вот эту хрень
	   <TR valign=top align=left>
	      <TD nowrap>имя<FONT size=1>&nbsp;&nbsp;&nbsp;<BR><A href="mailto:sa@ch-rdu.ru">email</a></font></td>
	      <TD nowrap><FONT color=#000080>тел город</td>
	      <TD nowrap><FONT color=#FF0000>тел</td>
	      <TD nowrap><FONT color=#000080>пост</td>
	   </tr>			
		*/	  
		preg_match_all("|<TR valign=top align=left>[\s]*<[^>]+>([^<]*)<[^<]+<BR><[^>]+>([^<]*)<[^<]+<[^<]+<[^<]+<[^<]+<[^>]+>([^<]*)<[^<]+<[^<]+<[^>]+>([^<]*)<[^<]+<[^<]+<[^>]+>([^<]*)|i",$site_pers,$p_out); 		
		//                                                       имя                    email                                тел город                   тел                       пост 
		
		for($i = 0; $i < count($p_out[1]); $i ++){ 	    	
						
			// преобразовать кодировку	
			$post_name = convert_cyr_string_larg($p_out[5][$i],$chars,$lang["CHARSET_NAME"]);
			// узнать должность по имении и взять id
			$post_id = get_post_id($post_name);	
			
			$name = convert_cyr_string_larg($p_out[1][$i],$chars,$lang["CHARSET_NAME"]);
			$email = $p_out[2][$i];		
			$tel_gor = convert_cyr_string_larg($p_out[3][$i],$chars,$lang["CHARSET_NAME"]);
			$tel = convert_cyr_string_larg($p_out[4][$i],$chars,$lang["CHARSET_NAME"]);			
			$tel_gor = str_replace("-","",tel_perenos(tel_no_code($tel_gor)));
			$tel = tel_perenos(tel_no_code($tel));			

			// проверить есть ли такой человек и если нет добавить 
			if (isset($name) && strlen($name)>0){				
				if(QueryScript("SELECT * FROM tblPersonOtherCompany where name =\"$name\" and companyid=$companyid and departid=$dep_id ",$result,$connect)){			
					$fetch=mysql_fetch_array($result);			
					if (isset($fetch["id"])){				
/*!*/					echo " update ";
						mysql_close($connect);
						ExecScript("update  tblPersonOtherCompany set postid=$post_id,email=\"$email\" , tel_in=\"$tel\", tel_out=\"$tel_gor\" ,orders=$i where  name =\"$name\" and companyid=$companyid and departid=$dep_id ");
					} else {					
/*!*/					echo " insert ";
						mysql_close($connect);
						ExecScript("insert into tblPersonOtherCompany (name,postid,email,tel_in,tel_out,departid,companyid,orders) values (\"$name\",$post_id,\"$email\",\"$tel\",\"$tel_gor\",$dep_id,$companyid,$i) ");
					}				
				}
			}
			
/*!*/		echo " $name | $email | $tel | $tel_gor | post=$post_id dep=$dep_id company=$companyid <br>";
			
		}  
	}
}

load_other_telmail();
echo "<br><br><b>Finito la comediya.</b>";
