<?php
if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("lang/msg_ru.inc.php"); 
include_once("func.inc.php");
include_once("logerror.inc.php");

session_start();

if((!isset($_POST["login"])) || (!isset($_POST["password"]))){ 

	if (isset($_SESSION["userid"])){ 
		$_SESSION = array();
		session_destroy();		
	}
	
} else {

	$login = strip_tags(substr($_POST["login"],0,20)); 
	$password = strip_tags(substr($_POST["password"],0,20)); 	
	$login = addslashes(stripslashes($login));
	$password = (addslashes(stripslashes($password)));

	if (QueryScript("select * from tblUser where login='$login' and password='$password'", $result_pas, $connect)){
		
		if (mysql_num_rows($result_pas) > 0){
	
			if (isset($_SESSION["userid"])){ 
				$_SESSION = array();
				session_destroy();
				session_start();
			}
			
			$dateuser = mysql_fetch_array($result_pas);
			
			$_SESSION['userid'] =  $dateuser['id'];		
			$_SESSION['name'] = $dateuser['name'];
			$_SESSION['access_read'] = $dateuser['access_read'];
			$_SESSION['access_write'] = $dateuser['access_write'];	
			$_SESSION['write'] = false;	
		
		}else{
			
			$_SESSION['error'] = $lang["session_error_nopassword"]."<br>";
		
		}
		mysql_close($connect);
		
	}		
	
}

if (isset($_SERVER['HTTP_REFERER']))
	header("Location: ".$_SERVER['HTTP_REFERER']);
else 
	header("Location: index.php");		
	
?>