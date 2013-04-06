<?
if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("lang/msg_ru.inc.php"); 
include_once("config.inc.php");
include_once("logerror.inc.php");

function QueryScript($script, &$result, &$connect){
	global $config;

	$connect = mysql_connect($config["dbhost"],$config["dbuser"],$config["dbpassword"] );

	mysql_query("SET CHARACTER SET utf8 ");
	mysql_query("SET NAMES utf8 ");

	mysql_select_db($config["database"],$connect);		
	$result = mysql_query($script,$connect);
	$error_dep = mysql_error(); 	
	if ($error_dep!=''){
		AddError(mysql_errno(),'',mysql_error());
		return false;
	}else{
		return true;
	}		
}

function ExecScript($script){
	if(QueryScript($script,$result,$connect)){
		mysql_close($connect);
		return true;	
	}else{
		return false;
	} 				
}

function is_access_write($str){
	if (isset($_SESSION["access_write"])){
		$write=false;
		foreach (explode(' ',$_SESSION["access_write"]) as $value)
 			foreach (explode(' ',$str) as $s)
				if ($value==$s || $value=='admin')
					$write=true;
	}else{
		$write=false;
	}
	return $write;
}

function get_username_to_id($userid){
	if(QueryScript("SELECT name from tblUser where id=".$userid,$result,$connect) && mysql_num_rows($result)>0){	
		$data = mysql_fetch_array($result);	
		return $data["name"];
	}else{
		return 'неизвестно';
	}
}

function autorize_to_ip_comp($ip_comp){
	if (!isset($_SESSION["userid"])){ 
		if (QueryScript("select * from tblUser where comp_ip='$ip_comp' ", $result_pas, $connect) && (mysql_num_rows($result_pas) > 0)){
			$dateuser = mysql_fetch_array($result_pas);
			$_SESSION['userid'] =  $dateuser['id'];		
			$_SESSION['name'] = $dateuser['name'];
			$_SESSION['access_read'] = $dateuser['access_read'];
			$_SESSION['access_write'] = $dateuser['access_write'];	
			$_SESSION['write'] = false;
		}					
		mysql_close($connect);
	}
}

/*172.23.84.244:*/

function copy_file_socket($host,$url,$output, $port=8081){
	$content = "";
	$fp = @fsockopen ($host, $port , $errno, $errstr, 30);
	if (!$fp) {
		return false;
	} else {		
	      $out = "GET $url HTTP/1.1\r\n\r\n";
	      $out .= "Host: $host\r\n";
	      $out .= "Connection: Close\r\n\r\n";
		fputs($fp,$out);		
		while ($header = fgets($fp,4096)){
			// пропускаем хедеры
			if($header == "\r\n")
				break;
		}
		while (!feof($fp)) 	{
			$content .= fread($fp, 4096);
		}
		fclose ($fp);

		$fo = fopen($output,"wb+");
		if(!$fo){
			return false;
		}else{
			if(flock($fo, LOCK_EX|LOCK_NB)){
				fwrite($fo,$content,strlen($content));
				flock($fo, LOCK_UN);				
			}
			fclose($fo);
			return true;
		}
	}
}

function copy_file($source,$dest){
	$fp = @fopen ($source, "r");
	if (!$fp){
		return false;
	}else{
		$buffer='';
		while (!feof ($fp)) 
			$buffer .= fgets($fp, 4096);
		fclose ($fp);
		$fd = fopen ($dest, "wb");
		if (flock($fd, LOCK_EX|LOCK_NB)){;
			fwrite ($fd, $buffer);
			flock($fd, LOCK_UN);
		}	
		fclose ($fd);
		return true;
	}
}

function file_cache($fcache,$host,$url,$timecache){
	if (file_exists($fcache))
   		$isload = ((time() - filemtime($fcache)) > $timecache);
	else
		$isload = true;
	
	if($isload){
		copy_file_socket($host,$url,$fcache);
	}
}

function first_last_day($xmonth,$xyear,&$firstday,&$lastday){
	if (($xmonth >= 1) && ($xmonth <= 12)){
		if ($xmonth==12){
			$firstday = mktime(0,0,0,$xmonth,1,$xyear);				
			$lastday = mktime(0,0,0,$xmonth,31,$xyear);
		}else{
			$firstday = mktime(0,0,0,$xmonth,1,$xyear);				
			$lastday = mktime(0,0,0,($xmonth+1),0,$xyear);
		}					
		return true;
	}else{
		return false;	
	}
}

function strhex($string){
	$hex="";
	for ($i=0;$i<strlen($string);$i++){
		if(ord($string[$i])>=184)
  			$hex.=(strlen(dechex(ord($string[$i])))<2)? "%0".dechex(ord($string[$i])): "%".dechex(ord($string[$i]));
		else	
 			$hex.=$string[$i];
	}   
	return $hex;
}

function ip_access($pasok){
	global $config;	
	if($pasok) 
		return true;
	else{
		$adr = $_SERVER["REMOTE_ADDR"];		
		foreach ($config["MASK_LOCAL_NET"] as $ips)		
  			if(substr($adr,0,strlen($ips))==$ips)
				return true;
		return false;		
	}	
}


function preddir($dir){
	if($dir[strlen($dir)-1]=='/')
		$dir = substr($dir, -1);
	return substr($dir, 0,strlen($dir)-strlen(strrchr($dir, "/")));
}

function doUpload($doc_root, $field_name, $dir){ 
	global $config, $lang;

	$dir = $_SERVER['DOCUMENT_ROOT']."/".$doc_root.$dir;

	// upload_max_filesize=??M в php.ini (2Мб)  post_max_size=??M (8Мб) 
	$maxsize=10485760; // 10M 

	$filename=$_FILES[$field_name]["name"]; 
	$filesize=$_FILES[$field_name]["size"]; 
	$fileext=strtolower(substr(strrchr($filename,"."),1)); 
	
	if(!in_array($fileext, $config["TRUE_EXT_DOC"])) 
		return $lang["error_type_file"]; 

	if($filesize>$maxsize) 
		return $lang["error_large_file"]; 

	$tmpfname=$_FILES[$field_name]['tmp_name']; 

	// исправляем имя файла, удаляем недопустимые символы, пробелы. 
	$filename = ereg_replace($config["TRUE_CHAR_FILENAME"], "", 
    	        str_replace("\"", "'", 
        	    str_replace("%20", " ", $filename ))); 	

/*	$filename = ereg_replace("[^a-z0-9._]", "", 
    	        str_replace(" ", "_", 
        	    str_replace("%20", "_", strtolower($filename)))); 
*/
	if ($filename=="") 
		return $lang["error_name_file"]; 

	if (file_exists($dir."/".$filename)) 
		return $lang["error_exist_file1"]." <b>".$dir."/".$filename."</b>".$lang["error_exist_file2"]; 
 	
	if (is_uploaded_file($tmpfname)) { 
 
		if (!move_uploaded_file($tmpfname, $dir."/".$filename))
			return $lang["error_load_file"].$dir."/".$filename; 

	// Если пользователь Апача и FTP разные, например nobody и pupkin, 
	// то чтобы иметь доступ по FTP (по умолчанию выставляется 0600) 
	// поставьте 0644 или 0666 если хотите также перезаписывать по FTP 
	   @chmod($lastname, 0644); 
	}
	   
	return true;
} 

function get_file($file){
	$fp = @fopen ($file, "r");		
	$buffer = "";
	while (!feof ($fp)) 
		$buffer .= fgets($fp, 4096);		
	fclose ($fp);		
	return $buffer;
}

function put_format_date($dt){
	global $month_str_vp, $lang;	
	if (!empty($dt) && ($dt > '1000-01-01')) {
		$lst=explode("-",$dt);
		if ($lst[2]<10)
			$lst[2] = substr($lst[2],1);
		if (($lst[1]>=1) && ($lst[1]<=12) && count($lst)==3 )
			return $lst[2].' '.strtolower($month_str_vp[(int)$lst[1]]).' '.$lst[0].' '.$lang["year"];
	}	
}

function get_list_file($dir){
	global $config;
	$filelist=array();	
	if ($dh=opendir($dir)) {
	    while (false !== ($filename = readdir($dh))) {			
			$fullfilename = $dir."/".$filename;
			if (is_file($fullfilename)) 
				$filelist[]=$filename;
		}
	    closedir($dh);
	}else{
		return false;
	}
  	return $filelist;	
}

function get_dirlist($maindir,$dir){
	global $config;
	$dirlist=array();
	if ($dh=opendir($maindir."/".$dir)) {
	    while (false !== ($filename = readdir($dh))) {
			$fullfilename = $maindir."/".$dir."/".$filename;
			if (is_file($fullfilename)) {
				$dirlist[]=$filename;
			}elseif (is_dir($fullfilename)){
				$dirlist[]=$filename;
			}else{
				$dirlist[]=$filename;	 
			}
		}
	   closedir($dh);
	}else{
		return false;
	}
  return $dirlist;
}

function sort_dir($maindir,$dir,$dirlist){
	$dirlistnew=array();
	$files=array();	
	if(!empty($dirlist)){
		foreach ($dirlist as $dl){
	        if (is_file($maindir."/".$dir."/".$dl)) {
		       $key = filemtime($maindir."/".$dir."/".$dl).md5($dl);
       		   $files[$key] = $dl;	
			}
			ksort($files);
		}		

		for($i=0; $i<sizeof($dirlist);$i++)
			if(is_dir($maindir."/".$dir."/".$dirlist[$i]))
				$files[]=$dirlist[$i];			
	}
    return array_reverse($files);
}

function get_dirlist_find($maindir,$dir,&$dirlist,&$fullnamedirlist,$type,$str){
	global $config;
/*
    0 - во всех разделах
	1 - в текущем и входящих
	2 - только в текущем разделе
*/	

	if ($dh=opendir($maindir."/".$dir)) {
	    while (false !== ($filename = readdir($dh))) {
            if ($filename == ".") continue;
            if ($filename == "..") continue;			
			$fullfilename = $maindir."/".$dir."/".$filename;
			if (is_file($fullfilename)) {
				if (strpos(toLower($filename),toLower($str)) !== FALSE){
					$dirlist[]=$filename;
					$fullnamedirlist[]=$fullfilename;
				}	
			}elseif (is_dir($fullfilename)){
				if (strpos(toLower($filename),toLower($str)) !== FALSE){				
					$dirlist[]=$filename;
					$fullnamedirlist[]=$fullfilename;
				}	
				if (($type==1) || ($type==0))
					get_dirlist_find($maindir,$dir."/".$filename,$dirlist,$fullnamedirlist,$type,$str);					
			}
		}
	   closedir($dh);
	}else{
		return false;
	}
}

function is_newdoc($filen){
global $config;
	if(is_dir($filen)){
		if ( is_newdoc_in_dir($filen) )
			return true;	
	}else{
		$tmp = explode('.', date("d.m.Y "));   
		$a1 = ($tmp[2]*12+$tmp[1])*31+$tmp[0];   
		$tmp2 = explode('.', date("d.m.Y ",filectime($filen)));   
		$a2 = ($tmp2[2]*12+$tmp2[1])*31+$tmp2[0];   
		if ( $a1 - $a2 < $config["TRUE_NEW_DOC"]  )
			return true;		
		else	
			return false;				
	}
}

function is_newdoc_in_dir($filen){
	global $config;
	$dirlist=array();
	if ($dh=opendir($filen)) {
	    while (false !== ($filename = readdir($dh))) {
			$fullfilename = $filen."/".$filename;
			if (is_file($fullfilename)) {
				if (is_newdoc($fullfilename)){
					return true;
				}
			}elseif (is_dir($fullfilename) && $filename!='.' && $filename!='..' ){
				if (is_newdoc_in_dir($fullfilename))
					return true;
			}
		}
	   closedir($dh);
	   return false;
	}else{
		return false;
	}
}

function toLower($content) { 
	$content = strtr($content, "АБВГДЕЁЖЗИЙКЛМHОРПСТУФХЦЧШЩЪЬЫЭЮЯ", "абвгдеёжзийклмнорпстуфхцчшщъьыэюя"); 
  	return strtolower($content); 
} 


function convert_cyr_string_larg($s,$from,$to){

	if (strtolower($to) == "utf-8"){
		return iconv($from,"UTF-8",$s);
	}
	else
	{
		switch (strtolower(trim($from))){
			case "koi8-r"         : $from="k"; break;
			case "windows-1251"   : $from="w"; break;
			case "iso8859-5"      : $from="i"; break;
			case "x-cp866"        : $from="a"; break;
			case "x-cp866"        : $from="d"; break;
			case "x-mac-cyrillic" : $from="m"; break;
			default				  : $from="w";
		}
	
		switch (strtolower(trim($to))){
			case "koi8-r"         : $to="k"; break;
			case "windows-1251"   : $to="w"; break;
			case "iso8859-5"      : $to="i"; break;
			case "x-cp866"        : $to="a"; break;
			case "x-cp866"        : $to="d"; break;
			case "x-mac-cyrillic" : $to="m"; break;
			default				  : $to="w";		
		}
		
		return convert_cyr_string($s,$from,$to);
	}
}

function utf($s){
	return iconv("CP1251","UTF-8",$s);
}

function utf_cp($s){
	return iconv("UTF-8","CP1251",$s);
}

?>
