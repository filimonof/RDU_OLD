<?php

if(false){ ?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("face.inc.php");
include_once("func.inc.php");

if (isset($_GET["id"])){
	if ((QueryScript("SELECT pe.id, pe.fotosite, pe.foto34, pe.foto34bw
					FROM tblPersons pe
					WHERE pe.people = 1 and  pe.id=".$_GET['id'],
					$rsl,$connect)) && (mysql_num_rows($rsl)>0) )
	{
	   	$person=mysql_fetch_array($rsl); 
		if (isset($_GET["f"])){
			switch($_GET["f"]){
			case 0: echo $person["fotosite"]; break;
			case 1: echo $person["foto34"]; break;			
			case 2: echo $person["foto34bw"]; break;			
			} 		
		}else{
			echo $person["fotosite"];		
		}	
	}
}

?>