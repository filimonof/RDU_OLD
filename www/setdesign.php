<?php
if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");

session_start();

if(isset($_COOKIE["num_design_to_site_rdu"]))
	$cur_dirimg = $_COOKIE["num_design_to_site_rdu"];
if (++$cur_dirimg>$max_dirimg) 
	$cur_dirimg = 0;	
setcookie("num_design_to_site_rdu",$cur_dirimg, time()+360000);

if (isset($_SERVER['HTTP_REFERER']))
	header("Location: ".$_SERVER['HTTP_REFERER']);
else 
	header("Location: index.php");		
	
?>