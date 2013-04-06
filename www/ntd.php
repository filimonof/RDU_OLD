<?php
if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("face.inc.php");
include_once("func.inc.php");
include_once("lang/msg_ru.inc.php");

session_start();

function correct_htm($dir,&$lst){
	$s = 'href="';
	$beg = 0;
	while (strpos($lst,$s,$beg) !== false){
		$pos = strpos($lst,$s,$beg);
		$beg = strpos($lst,'"',$pos+strlen($s));		
		if ($lst[$pos+strlen($s)]!='#'){
			$fullfilename = substr($lst,$pos+strlen($s),$beg-$pos-strlen($s));
			$fullfilename = 'ntd/'.$dir.'/'.$fullfilename;
			$lst = substr_replace($lst,strhex($fullfilename),$pos+strlen($s),$beg-$pos-strlen($s));						
		    $lst = substr_replace($lst,' class="desktop_text_a" target="_blank" ', $pos+strlen($s)+strlen(strhex($fullfilename))+1,0);
		}else{
			$lst = substr_replace($lst,' class="desktop_text_a" ',$beg+1 ,0);			
		}
	}		
}

function  assemble_ntd($dir,&$lst){
	$lst = "";  
	switch ($dir) {
	case "expl":
		$lst = get_file('ntd/'.$lang["ntd_per_expl"].'/index.htm');
		correct_htm($lang["ntd_per_expl"],$lst);			
		break;
	case "ot":
		$lst = get_file('ntd/'.$lang["ntd_per_ot"].'/index.htm');
		correct_htm($lang["ntd_per_ot"],$lst);		
		break;
	case "pb":
		$lst = get_file('ntd/'.$lang["ntd_per_pb"].'/index.htm');
		correct_htm($lang["ntd_per_pb"],$lst);			
		break;
	case "prombez":
		$lst = get_file('ntd/'.$lang["ntd_per_prombez"].'/index.htm');
		correct_htm($lang["ntd_per_prombez"],$lst);			
		break;
	default:
		$lst = get_file('ntd/index.htm'); 
		break;
	}
	
}

function  assemble_no_access(&$lst){
	$lst = $lang["ntd_notfound"];
}

// ---------------------------------------------------
// $config["ROOTDIR_NTD"] = "ndoc";

isset($_GET["dir"]) ? $dir=$_GET["dir"] : $dir = '';

if(!ip_access(false)){
	assemble_no_access($lst);
	$dir="_";
}else{
	if(!in_array($dir, array("expl","ot","pb","prombez"))) 
		$dir="";
	assemble_ntd($dir,$lst);	
}
	
$X_desktop[]=array(
	"caption"=>$lang["ntd_nsd"],
	"list"=>'<br>'.$lst.'<p>',
	"bottom"=>''.(($dir=="")?"":'<a href='.$_SERVER["PHP_SELF"].' class="desktop_fun_a">'.$lang["ntd_menu"].'</a>')
);
	
draw_site($X_desktop);

unset($X_desktop);
?> 