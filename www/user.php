<?php
if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("logerror.inc.php");
include_once("func.inc.php");

session_start();

if(isset($_GET["write"]) &&  isset($_SESSION["access_write"])){
	if($_GET["write"]=="1")
		$_SESSION["write"]=true;
	else		 
		$_SESSION["write"]=false;
}

if (isset($_SERVER['HTTP_REFERER']))
	header("Location: ".$_SERVER['HTTP_REFERER']);
else 
	header("Location: index.php");		
	
?>