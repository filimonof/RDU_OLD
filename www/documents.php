<?php 
if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("face.inc.php");
include_once("func.inc.php");
include_once("lang/msg_ru.inc.php");

session_start();

function assemble_tree_documents($maindir,$dir,&$result,$iswrite, $findtema, $findstr){
	global $config, $dirimg;    
	$result = '';      
	if ($findstr==''){
		$dirlist=get_dirlist($maindir,$dir);		
		$dirlist=sort_dir($maindir,$dir,$dirlist);		
	}else{	
		$dirlist=array();	
		$fullnamedirlist=array();
        get_dirlist_find($maindir,$dir,$dirlist,$fullnamedirlist,$findtema,$findstr);
	}

    $result .= '<table border="0" align="left">'; 
	$di=0;
	foreach ($dirlist as $file){
		$di++;
  		if ($findstr=='')	
			$filen = $maindir."/".$dir."/".$file;
		else 
			$filen = $fullnamedirlist[$di-1];
        if ($file != "." && $file != "..") {		
			$result .= '<tr><td width="18" valign="top">';	

		    if(is_dir($filen)){
			    $result .= '<img src="'.$dirimg.'/dir.gif"  border="0">';
    		    $result .= '</td><td align="left"  valign="middle"><a href="'.$_SERVER["PHP_SELF"].'?dir='.$dir."/".$file.'" class="desktop_list_a">&nbsp;'.$file.'</a>'.(is_newdoc($filen)==true ? '&nbsp;<img src="'.$dirimg.'/newd.jpg"  border="0">' : '&nbsp;');				
				if ($iswrite)
					$result .= '&nbsp;<a href="'.$_SERVER["PHP_SELF"].'?action=editdir&dir='.$dir."/".$file.'"><img src="'.$dirimg.'/edit_small.jpg" alt='.$lang["edit"].'  border="0"></a>
								&nbsp;<a href="'.$_SERVER["PHP_SELF"].'?action=deldir&dir='.$dir."/".$file.'"><img src="'.$dirimg.'/del_small.jpg" alt='.$lang["del"].'  border="0"></a>';					  
				$result .= '</td></tr>';			  
			  
			} else {
				if( (strtolower(substr($filen,-3)) == "doc") || (strtolower(substr($filen,-3)) == "txt") || (strtolower(substr($filen,-3)) == "rtf") )
				  $result .= '<img src="'.$dirimg.'/word.gif" width="18" height="18" border="0">';			
				elseif( (strtolower(substr($filen,-3)) == "ppt") || (strtolower(substr($filen,-3)) == "pps") )  
				  $result .= '<img src="'.$dirimg.'/ppt.gif" width="18" height="18" border="0">';			
				elseif( (strtolower(substr($filen,-3)) == "xls") || (strtolower(substr($filen,-3)) == "csv") )  
				  $result .= '<img src="'.$dirimg.'/xls.gif" width="18" height="18" border="0">';
				elseif( (strtolower(substr($filen,-3)) == "zip") || (strtolower(substr($filen,-3)) == "rar") )  
				  $result .= '<img src="'.$dirimg.'/zip.gif" width="18" height="18" border="0">';
				elseif (strtolower(substr($filen,-3)) == "hlp") 
				  $result .= '<img src="'.$dirimg.'/hlp.gif" width="18" height="18" border="0">';
				else
				  $result .= '&nbsp;';  	 		
				$result .= '</td><td  align="left"><a href="'.strhex($filen).'" class="desktop_list_a" target="_blank">&nbsp;'.$file.'</a>'.(is_newdoc($filen)==true ? '&nbsp;<img src="'.$dirimg.'/newd.jpg"  border="0">' : '&nbsp;');
				if ($iswrite)
					$result .= '&nbsp;<a href="'.$_SERVER["PHP_SELF"].'?action=editdoc&dir='.$dir.'&doc='.$filen.'"><img src="'.$dirimg.'/edit_small.jpg" alt='.$lang["edit"].' width="16" height="16" border="0"></a>
								&nbsp;<a href="'.$_SERVER["PHP_SELF"].'?action=deldoc&dir='.$dir.'&doc='.$filen.'"><img src="'.$dirimg.'/del_small.jpg" alt='.$lang["del"].'  width="16" height="16" border="0"></a>';					  
				$result .= '</td></tr>';											
			}					

		}
	}
    $result .= '</table>';		
	
}

function  assemble_path_document($maindir,$dir,&$pl){
	global $dirimg;
	$count = 0;
	$strdir='';
	$pl='<div align="left">';
	$pl.='&nbsp;&nbsp;<a href="'.$_SERVER["PHP_SELF"].'" class="desktop_list_a">'.$lang["doc_begin"].'</a><br>';
	if(!empty($dir)){
		$dirs = split('/',$dir);
		foreach ($dirs as $d){
			if (!empty($d)){
				for($i=0; $i<$count; $i++)
					$pl.='&nbsp;&nbsp;';
				$strdir.='/'.$d;
				$pl.='&nbsp;<img src="'.$dirimg.'/updir.gif" width="18" height="18" border="0">&nbsp;';
				$pl.='<a href="'.$_SERVER["PHP_SELF"].'?dir='.$strdir.'" class="desktop_list_a">'.$d.'</a><br>';				
				$count++;
			}	
		}		
		
	}		
	$pl.='</div>';	
}

function assemble_find_document($dir, &$find, $findtype='0', $findstr=''){
	global $config, $dirimg;
  
	$find = '<form action="'.$_SERVER["PHP_SELF"].'" method="get" name="find_form" id="find_form">
			<input type="hidden" name="dir" value="'.$dir.'">
			<table  bgcolor="'.def_color_desktop_bgcolor.'" width="560" border="0" cellpadding="3" cellspacing="0" align="center">
				<tr bgcolor="'.def_color_desktop_chet_list.'" align="center">
					<td width="80" align="center"><b>'.$lang["doc_find"].'</b></td>
					<td width="140" align="left"><select name="find_tema" width="140" size="1" style="'.def_style_form_font_size.'">
							<option '.(((int)$findtype==0)?' selected ':' ').' value="0">'.$lang["doc_all_catalog"].'
							<option '.(((int)$findtype==1)?' selected ':' ').' value="1">'.$lang["doc_curr_enter_catalog"].'
							<option '.(((int)$findtype==2)?' selected ':' ').' value="2">'.$lang["doc_curr_catalog"].'
						</select></td>
					<td width="260" align="left" valign="middle"><input type="text" name="find_str" size="38" width="260" maxlength="255" value="'.$findstr.'" style="'.def_style_form_font_size.'"></td>
					<td  width="80" align="center"><input type="submit" value="'.$lang["doc_go_find"].'" style="'.def_style_form_font_size.'"></td>					
				</tr>
			</table></form>';	
}
	
function  assemble_path_document_find($maindir,$dir,&$pathlstfind, $findtema, $findstr){
	$pathlstfind = '';
}	

function  assemble_no_access(&$lst){
  $lst = $lang["doc_not_found"];
}

function testdir(&$dir){
	if( (trim($dir)=='..') || (trim($dir)=='/..') || (trim($dir)=='../') || (trim($dir)=='/../') )
		$dir='';
	elseif ( !(strpos($dir,'/../') === false) || !(strpos($dir,'/..') === false) || !(strpos($dir,'../') === false) )		
		$dir='';
}

function assemble_form_adddir($dir,&$formdir){
	$formdir='
		<table border="0" width="100%">
		<form action="'.$_SERVER["PHP_SELF"].'?action=adddir&execute" method="get" name="adddir" id="adddir">
		<input name="action" type="hidden" value="adddir">
		<input name="execute" type="hidden" value="">	
		<input name="dir" type="hidden" value="'.$dir.'">	
		<tr><td align="right" width="100">'.$lang["doc_cat"].'</td>
			<td align="left"><input type="text" value="'.( ( (trim($dir)=='') || (trim($dir)=='/') || empty($dir) ) ? $lang["doc_begin_cat"] : $dir).'" readonly="true" style="'.def_style_form_font_size.'" size="90"></td></tr>
		<tr><td align="right" width="100">'.$lang["doc_new_cat"].'</td>		
			<td align="left"><input name="newdir" type="text" style="'.def_style_form_font_size.'" size="90"></td></tr>			
		<tr><td>&nbsp;</td><td align="left"><input type="submit" value="'.$lang["doc_create"].'"></td></tr>
		</form></table>
	';		
}

function assemble_rename_doc($doc,&$form){
	$path = pathinfo($doc);	
	$form='
		<table border="0" width="100%">
		<form action="'.$_SERVER["PHP_SELF"].'" method="get" name="editdoc" id="editdoc">
		<input name="action" type="hidden" value="editdoc">
		<input name="execute" type="hidden" value="">	
		<input name="doc" type="hidden" value="'.$doc.'">			
		<tr><td align="right" width="100">'.$lang["doc_namedoc"].'</td>
			<td align="left"><input type="text" value="'.$path["basename"].'" readonly="true" style="'.def_style_form_font_size.'" size="90"></td></tr>
		<tr><td align="right" width="100">'.$lang["doc_new_name"].'</td>		
			<td align="left"><input name="newdoc" type="text" style="'.def_style_form_font_size.'" size="90"></td></tr>			
		<tr><td>&nbsp;</td><td align="left"><input type="submit" value="'.$lang["doc_rename"].'"></td></tr>
		</form></table>
	';		
}

function assemble_rename_dir($dir,&$newdir){
	if($dir[strlen($dir)-1]=='/')
		$dir = substr($dir, -1);
	$name = substr(strrchr($dir, "/"),1);
	$newdir='
		<table border="0" width="100%">
		<form action="'.$_SERVER["PHP_SELF"].'" method="get" name="editdoc" id="editdoc">
		<input name="action" type="hidden" value="editdir">
		<input name="execute" type="hidden" value="">	
		<input name="dir" type="hidden" value="'.$dir.'">			
		<tr><td align="right" width="100">'.$lang["doc_name_cat"].'</td>
			<td align="left"><input type="text" value="'.$name.'" readonly="true" style="'.def_style_form_font_size.'" size="90"></td></tr>
		<tr><td align="right" width="100">'.$lang["doc_new_name"].'</td>		
			<td align="left"><input name="newdir" type="text" style="'.def_style_form_font_size.'" size="90"></td></tr>			
		<tr><td>&nbsp;</td><td align="left"><input type="submit" value="'.$lang["doc_rename"].'"></td></tr>
		</form></table>
	';		
}

function assemble_adddoc($dir,&$form){
	$form = '
		<table border="0" width="100%">
		<form enctype="multipart/form-data" method="post" action="'.$_SERVER["PHP_SELF"].'?action=adddoc&execute">
		<input type="hidden" name="MAX_FILE_SIZE" value="10485760"> 		
		<input name="dir" type="hidden" value="'.$dir.'">			
		<tr><td align="right" width="100">'.$lang["doc_go_cat"].'</td>
			<td align="left"><input type="text" value="'.( ( (trim($dir)=='') || (trim($dir)=='/') || empty($dir) ) ? $lang["doc_head_tree"] : $dir).'" readonly="true" style="'.def_style_form_font_size.'" size="90"></td></tr>
		<tr><td align="right" width="100">'.$lang["doc_doc"].'</td>		
			<td align="left"><input name="newdoc" type="file" style="'.def_style_form_font_size.'" size="75"></td></tr>			
		<tr><td>&nbsp;</td><td align="left"><input type="submit" value="'.$lang["doc_publish"].'"></td></tr>
		</form></table>	
	';
}

// ---------------------------------------------

$write = is_access_write("documents");
isset($_GET["dir"]) ? $dir=$_GET["dir"] : $dir = '';
	
if($write && isset($_GET["action"])){
	switch($_GET["action"]){
		case 'deldir':		
			if(!@rmdir($config["ROOTDIR_DOC"]."/".$dir))
				$_SESSION['error'] = $lang["doc_error_del_catalog"]."<br>".$lang["doc_error_del_catalog2"].".<br>";
			else
				header("Location: ".$_SERVER["PHP_SELF"].'?dir='.preddir($dir));	
			break;				
		case 'editdir':	
			if (isset($_GET["execute"]) && isset($_GET["newdir"]) ){
				$newdir= $_GET["newdir"];
				testdir($dir);				
				if (strpos($newdir,"/") === false){
					if(!@rename($config["ROOTDIR_DOC"]."/".$dir,$config["ROOTDIR_DOC"]."/".preddir($dir)."/".$newdir))
						$_SESSION['error'] = $lang["doc_error_rename_catalog"].".<br>";
					else
						header("Location: ".$_SERVER["PHP_SELF"].'?dir='.preddir($dir));						
				}else{
					$_SESSION['error'] = $lang["doc_error_format_catalog"].".<br>";
				}
				$dir=preddir($dir);			
			}else{
				assemble_rename_dir($dir,$form);
				$dir=preddir($dir);
				$X_desktop[]=array(
					"caption"=>$lang["doc_rename_catalog"],
					"list"=>$form,
					"bottom"=>'<a href="'.$_SERVER["PHP_SELF"].'?dir='.$dir.'" class="desktop_fun_a">'.$lang["cancel"].'</a>&nbsp;'
				);
			}	
			break;	
		case 'deldoc': 		
			if(isset($_GET["doc"])) 
				if(is_file($_GET["doc"])) 
				   unlink($_GET["doc"]); 		
			if(file_exists($_GET["doc"])) 	   
				$_SESSION['error'] = $lang["doc_error_del_doc"].".<br>";				
			else
				header("Location: ".$_SERVER["PHP_SELF"].'?dir='.$dir);
			break;				
		case 'editdoc': 
			if (isset($_GET["execute"]) && isset($_GET["newdoc"]) && isset($_GET["doc"])){
				testdir($doc);
				if( strpos($doc,$config["ROOTDIR_DOC"])<1){				
					$doc= $_GET["doc"];
					$newdoc = $_GET["newdoc"];
					$fileext=strtolower(substr(strrchr($newdoc,"."),1));
					if(!in_array(strtolower($fileext), $config["TRUE_EXT_DOC"])) 
						$newdoc.='.bak'; 					
					$path = pathinfo($doc);					
					if(!@rename($doc,$path["dirname"]."/".$newdoc))
						$_SESSION['error'] = $lang["doc_error_rename_doc"].".<br>";
					else
						header("Location: ".$_SERVER["PHP_SELF"].'?dir='.$dir);						
				}else						
					$_SESSION['error'] = $lang["doc_error_format_doc"].".<br>";
			}else{
				if(isset($_GET["doc"])){
					assemble_rename_doc($_GET["doc"],$form);
					$X_desktop[]=array(
						"caption"=>$lang["doc_rename_doc"],
						"list"=>$form,
						"bottom"=>'<a href="'.$_SERVER["PHP_SELF"].'?dir='.$dir.'" class="desktop_fun_a">'.$lang["cancel"].'</a>&nbsp;'
					);
				}else{
					header("Location: ".$_SERVER["PHP_SELF"].'?dir='.$dir);
				}
			}
			break;	
		case 'adddir': 		
			if (isset($_GET["execute"]) && isset($_GET["newdir"])){
				if(!@mkdir($config["ROOTDIR_DOC"]."/".$dir."/".$_GET["newdir"],0777))
					$_SESSION['error'] = $lang["doc_error_create_catalog"].".<br>";
				else
					header("Location: ".$_SERVER["PHP_SELF"].'?dir='.$dir);	
			}else{
				assemble_form_adddir($dir,$formdir);
				$X_desktop[]=array(
					"caption"=>$lang["doc_created_catalog"],
					"list"=>$formdir,
					"bottom"=>'<a href="'.$_SERVER["PHP_SELF"].'?dir='.$dir.'" class="desktop_fun_a">'.$lang["cancel"].'</a>&nbsp;'
				);
			}
			break;				
		case 'adddoc': 
			if (isset($_GET["execute"]) && isset($_FILES["newdoc"])){				
				$res = doUpload($config["ROOTDIR_DOC"],"newdoc", $_POST["dir"]); 
				if (  $res !== true )
					$_SESSION['error'] = $res."<br>";	
				else
					header("Location: ".$_SERVER["PHP_SELF"].'?dir='.$_POST["dir"]);	
			}else{
				assemble_adddoc($dir,$form);
				$X_desktop[]=array(
					"caption"=>$lang["doc_download_doc"],
					"list"=>$form,
					"bottom"=>'<a href="'.$_SERVER["PHP_SELF"].'?dir='.$dir.'" class="desktop_fun_a">'.$lang["cancel"].'</a>&nbsp;'
				);
			}		
			break;				
	}
}

isset($_GET["find_tema"]) ? $findtema=strip_tags(substr($_GET["find_tema"],0,10)) : $findtema='0';
isset($_GET["find_str"]) ? $findstr=strip_tags(substr($_GET["find_str"],0,255)) : $findstr='';

if( (ip_access(false)) && $write && $_SESSION["write"] ){

  	testdir($dir);
	assemble_path_document($config["ROOTDIR_DOC"],$dir,$pathlst);
	assemble_find_document($dir,$find, $findtema, $findstr);	
	assemble_tree_documents($config["ROOTDIR_DOC"],$dir,$lst,$write && $_SESSION["write"], $findtema, $findstr); 	 

	$X_desktop[]=array(
		"caption"=>$lang["doc_title_doc"],
		"list"=>"<br>".$find.($findstr==''?$pathlst:'<a href="'.$_SERVER["PHP_SELF"].'?dir='.$dir.'" class="desktop_list_a">'.$lang["doc_clear_find"].'</a>')."<hr>".$lst,
		"bottom"=>'<a href="'.$_SERVER["PHP_SELF"].'?action=adddir&dir='.$dir.'" class="desktop_fun_a">'.$lang["doc_create_catalog"].'</a>&nbsp;&nbsp;&nbsp;&nbsp;
				   <a href="'.$_SERVER["PHP_SELF"].'?action=adddoc&dir='.$dir.'" class="desktop_fun_a">'.$lang["doc_download_doc"].'</a>'
	);


}elseif( ip_access(false) ){
  	testdir($dir);
	assemble_path_document($config["ROOTDIR_DOC"],$dir,$pathlst,$findtema, $findstr);
	assemble_find_document($dir,$find, $findtema, $findstr);		
	assemble_tree_documents($config["ROOTDIR_DOC"],$dir,$lst,false, $findtema, $findstr); 	 
	$X_desktop[]=array(
		"caption"=>$lang["doc_title_doc"],
		"list"=>"<br>".$find.($findstr==''?$pathlst:'<a href="'.$_SERVER["PHP_SELF"].'?dir='.$dir.'" class="desktop_list_a">'.$lang["doc_clear_find"].'</a>')."<hr>".$lst,
		"bottom"=>$lang["doc_otvetstv"]
	);

} else  {

	assemble_no_access($lst);
	$X_desktop[]=array(
		"caption"=>$lang["doc_title_doc"],
		"list"=>"<br>".$lst."<p>",
		"bottom"=>''	
	);
	
}

draw_site($X_desktop);

unset($X_desktop);
?> 