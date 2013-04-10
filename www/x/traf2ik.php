<?php

if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

$file_limit = '/usr/local/stc/etc/traffic.users';
$file_current_traffic = '/usr/local/stc/etc/cur_tr.users';
$file_tmp_lim = '/var/www/html/x/traff.users.tmp';
$file_tmp_cur = '/var/www/html/x/cur_tr.users.tmp';

// скриптик для добавления трафика в squid
// благодаря ему у меня был безлимит ))))))

function get_conf_file($name){
	$f = file($name);	
  	if(!$f) 
  		echo("������ �������� �����");
	else
    	for($i=0; $i < count($f); $i++)
			printf("%s<br>", $f[$i]);		
}

function edit_conf_file($file,$file_tmp,$user,$add){
	if ($add < 1000000) $add *= 1000000;
		
	// ���������, �� ���� �� ���� � ���������� ������� �������
	if(file_exists($file_tmp)) die("fatal error, call administrator!");	

//       printf("copy $file to $file_tmp");

	// �������� ���������� ����� � tmp
	if(copy($file, $file_tmp)){

//	        printf("ok copy");

		 // ������ ������������, ����� �������������� �������� ����
		 if($w=fopen($file,"w"))
		 {
     		  //�������� ����
			  flock($w,LOCK_EX);   			
			  if(!$r=fopen($file_tmp,"r")) die("can't open file");
			  flock($r,LOCK_SH);
                       printf("search");
			  while($str_r = fgets($r,10240)) // ������ ���������
			  {
					$str = explode(" ", $str_r);
					if ($str[0] == $user){
						printf(" user %s old value %s new value %s <br> ",$str[0],$str[1],$str[1]+$add);
						$str[1] += $add;
						fputs($w,$str[0]." ".$str[1]." \n"); // ����� ���������						 
					}else{
						fputs($w,$str_r); // ����� ���������
					}			
			   		
			  }
			  flock($r,LOCK_UN );
			  fclose($r);
			  flock($w,LOCK_UN );
			  fclose($w);
			  unlink($file_tmp);
		 }
	}	
}	


if(isset($_GET["list"])){
	echo "����������<br>";
	get_conf_file($file_current_traffic);
	echo "<hr>";
}

if(isset($_GET["limit"])){
	echo "������<br>";
	get_conf_file($file_limit);
	echo "<hr>";
}

if(isset($_GET["add"]) && isset($_GET["user"])){
	$add = $_GET["add"];
	$user = $_GET["user"];	
			
	echo "add limit $add Mb user $user  <br>";
	edit_conf_file($file_limit,$file_tmp_lim,$user,$add);	
	
}

if(isset($_GET["addcur"]) && isset($_GET["user"])){
	$add = $_GET["addcur"];
	$user = $_GET["user"];
	
	echo "add currency $add user $user  <br>";	
	edit_conf_file($file_current_traffic,$file_tmp_cur,$user,$add);	
}
