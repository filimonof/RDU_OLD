<?
if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

include_once("config.inc.php");
include_once("lang/msg_ru.inc.php");
include_once("func.inc.php");
include_once($dirimg."/color.inc.php");

function draw_site($X_desktop=''){
	draw_header();
	draw_body_top();
	draw_body_center($X_desktop);
	draw_body_bottom();
	draw_footer();
}

// -----------------------------------------------------------------------
//                                Head
// -----------------------------------------------------------------------

function draw_header(){
	global $lang, $dirimg;
	print '
	   <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	   <html>
	   <head>	   		
			<title>'.$lang["TITLE_MAIN"].'</title>
			<meta http-equiv="Content-Type" content="text/html;'.$lang["CHARSET"].'">
			<meta http-equiv="KeyWords" content="'.$lang["KeyWordsCONTENT"].'">
			<META NAME="author" content="'.$lang["AuthorCONTENT"].'">
			<link rel="stylesheet" type="text/css" href="'.$dirimg.'/main.css">
			<META HTTP-EQUIV="Pragma" CONTENT="no-cache">			
			<link rel="StyleSheet" href="dtree/dtree.css" type="text/css">
		    <script type="text/javascript" src="dtree/dtree.js"></script>			
		</head>
		<script language="Javascript">
		<!-- 
			if (top.location != self.location) {
				top.location = self.location.href
			}
		//--> 
		</script>		
	';
}

function draw_footer(){
	print '</html>';	
}

// -----------------------------------------------------------------------
//                                Body
// -----------------------------------------------------------------------

function draw_body_top(){
	global $config, $dirimg;
	print '<BODY LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" >';

	if ($config["SCRIPT_SNEGOPAD"]=="1") 
		print '

<SCRIPT LANGUAGE="JavaScript1.2">
<!-- Begin
var no = 20; // количество снежинок
var speed = 20; // скорость снежинок
var snowflake = "1.gif";

var ns4up = (document.layers) ? 1 : 0;
var ie4up = (document.all) ? 1 : 0;
var dx, xp, yp; 
var am, stx, sty; 
var i, doc_width = 800, doc_height = 600;
if (ns4up) {
doc_width = self.innerWidth;
doc_height = self.innerHeight;
} else if (ie4up) {
doc_width = document.body.clientWidth;
doc_height = document.body.clientHeight;
}
dx = new Array();
xp = new Array();
yp = new Array();
am = new Array();
stx = new Array();
sty = new Array();
for (i = 0; i < no; ++ i) {  
dx[i] = 0;         
xp[i] = Math.random()*(doc_width-50); 
yp[i] = Math.random()*doc_height;
am[i] = Math.random()*20;         
stx[i] = 0.02 + Math.random()/10; 
sty[i] = 0.7 + Math.random();   
if (ns4up) {                  
if (i == 0) {
document.write("<layer name=\"dot"+ i +"\" left=\"15\" ");
document.write("top=\"15\" visibility=\"show\"><img src=\"");
document.write(snowflake + "\" border=\"0\"></layer>");
} else {
document.write("<layer name=\"dot"+ i +"\" left=\"15\" ");
document.write("top=\"15\" visibility=\"show\"><img src=\"");
document.write(snowflake + "\" border=\"0\"></layer>");
   }
} else if (ie4up) {
if (i == 0) {
document.write("<div id=\"dot"+ i +"\" style=\"POSITION: ");
document.write("absolute; Z-INDEX: "+ i +"; VISIBILITY: ");
document.write("visible; TOP: 15px; LEFT: 15px;\"><img src=\"");
document.write(snowflake + "\" border=\"0\"></div>");
} else {
document.write("<div id=\"dot"+ i +"\" style=\"POSITION: ");
document.write("absolute; Z-INDEX: "+ i +"; VISIBILITY: ");
document.write("visible; TOP: 15px; LEFT: 15px;\"><img src=\"");
document.write(snowflake + "\" border=\"0\"></div>");
      }
   }
}
function snowNS() { 
for (i = 0; i < no; ++ i) {  
yp[i] += sty[i];
if (yp[i] > doc_height-50) {
xp[i] = Math.random()*(doc_width-am[i]-30);
yp[i] = 0;
stx[i] = 0.02 + Math.random()/10;
sty[i] = 0.7 + Math.random();
doc_width = self.innerWidth;
doc_height = self.innerHeight;
}
dx[i] += stx[i];
document.layers["dot"+i].top = yp[i];
document.layers["dot"+i].left = xp[i] + am[i]*Math.sin(dx[i]);
}
setTimeout("snowNS()", speed);
}
function snowIE() { 
for (i = 0; i < no; ++ i) { 
yp[i] += sty[i];
if (yp[i] > doc_height-50) {
xp[i] = Math.random()*(doc_width-am[i]-30);
yp[i] = 0;
stx[i] = 0.02 + Math.random()/10;
sty[i] = 0.7 + Math.random();
doc_width = document.body.clientWidth;
doc_height = document.body.clientHeight;
}
dx[i] += stx[i];
document.all["dot"+i].style.pixelTop = yp[i];
document.all["dot"+i].style.pixelLeft = xp[i] + am[i]*Math.sin(dx[i]);
}
setTimeout("snowIE()", speed);
}
if (ns4up) {
snowNS();
} else if (ie4up) {
snowIE();
}
// End -->
</script>
';


	print '
	
	<!-- top -->	
	
	<TABLE WIDTH="983" height="131" BORDER="0" CELLPADDING="0" CELLSPACING="0" align="center">
		<tr  height="131"> 
			<td width="19" background="'.$dirimg.'/main_left_line.jpg">&nbsp;</td>
			<td width="945" background="'.$dirimg.'/main_top.jpg" WIDTH=945 HEIGHT=131 ALT="">&nbsp;</td>
			<td width="19" background="'.$dirimg.'/main_right_line.jpg">&nbsp;</td>	
		</tr>
	</table>
	';
	if ($config["USE_FLASH"]=="1") {
		flush();
	}
//			<td width="945"><IMG SRC="'.$dirimg.'/main_top.jpg" WIDTH=945 HEIGHT=131 ALT=""></td>
	
}

function draw_body_center($X_desktop){
	draw_body_center_1();
	draw_menus();		
	draw_body_center_2();
	draw_desktop($X_desktop);
	draw_body_center_3();
}

function draw_body_center_1(){
	global $dirimg;
	print '
	<!-- center -->
	
	<TABLE WIDTH="983" BORDER="0" CELLPADDING="0" CELLSPACING="0" align="center">
		<tr> 
			<td width="19" background="'.$dirimg.'/main_left_line.jpg">&nbsp;</td>
			<td width="248" align="center" valign="top"> 
	';
}

function draw_body_center_2(){
	print '</td>		
	<td width="697" align="center" valign="top">';
}

function draw_body_center_3(){
	global $config, $dirimg;
	print '</td>		
			<td width="19" background="'.$dirimg.'/main_right_line.jpg">&nbsp;</td>			
		</tr>
	</table>	
	';	
	if ($config["USE_FLASH"]=="1") {
		flush();
	}
}

function draw_body_bottom(){
	global $lang, $config, $dirimg;
	print '
	<!-- bottom -->
	
	<TABLE WIDTH="983" height="48" BORDER="0" CELLPADDING="0" CELLSPACING="0" align="center">
		<tr  height="52"> 
			<td width="19" background="'.$dirimg.'/main_left_line.jpg">&nbsp;</td>
			<td width="945" background="'.$dirimg.'/main_bottom.jpg"><div align="right" class="bottom_line1">'.$lang["Bottom_CopyRight"].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
				<div align="right" class="bottom_line2">'.$lang["Bottom_WriteToWebMaster"].' <a href="mailto:'.$config["WebmasterMail"].'" class="bottom_line2_a">'.$lang["Bottom_NameWebmaster"].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
			<td width="19" background="'.$dirimg.'/main_right_line.jpg">&nbsp;</td>	
		</tr>
	</table>	
</body>
	';
	if ($config["USE_FLASH"]=="1") {
		flush();
	}
}


// -----------------------------------------------------------------------
//                                Menus
// -----------------------------------------------------------------------

function draw_menus(){
	global $config, $lang;
	
	if ($config["DRAW_MENU"] =="1"){
		draw_one_menu($config["ID_MENU_TO_BASE"]);
	};
	
	if ($config["DRAW_AUTORIZATION"] =="1"){
		draw_autorization();
	};	

	if ($config["DRAW_BANNERS"] =="1"){
		draw_banners();
	};	

	if ($config["DRAW_LINKS"] =="1"){
		draw_one_menu($config["ID_LINKS_TO_BASE"]);	
	};	

	
};		

function draw_one_menu($id){
	global $config, $lang, $dirimg;

	if(QueryScript("select * from tblMenus where id=$id",$result_menu,$connect_menu)){
	
		$menu=mysql_fetch_array($result_menu);

		if(QueryScript("select * from tblRowMenu where menuid=$id order by orders,name",$result_row_menu,$connect_menu)){
		
			draw_menu_begin($menu["name"]);	
			print '
					<table  bgcolor="'.def_color_menu_bgcolor.'" width="222" border="0" cellpadding="0" cellspacing="0" align="left">
			';
			while ($row_menu=mysql_fetch_array($result_row_menu)){
				print '
					<tr>
						<td width="27" align="left" valign="top" background="'.$dirimg.'/main_menu_arrow.jpg" class="bg_norepeat">&nbsp;</td>
						<td width="195" align="left"><a href="'.$row_menu["href"].'" class="menu_list">'.$row_menu["name"].'</a></td>
					</tr>
					<tr>
						<td colspan="2" background="'.$dirimg.'/spacer.gif" height="5"></td>
					</tr>
				';	
//	<td width="27" align="left" valign="top"><img src="'.$dirimg.'/main_menu_arrow.jpg"></td>				
			}
			print '
				</table>
			';
			draw_menu_end($menu["bottom_fun"],$menu["bottom_fun_href"]);

		}

	} 

	mysql_close($connect_menu);

}

function draw_autorization(){
	global $config, $lang;

	if( (isset($_SESSION["userid"])) && ($_SESSION["userid"]>0) ){
		draw_menu_begin($lang["draw_autorize_user"]);	
		print '<table bgcolor="'.def_color_menu_bgcolor.'" width="222" border="0" cellpadding="1" cellspacing="0" align="left">';
		print '<tr rowspan="2">
				<td colspan="2" width="212" align="center" valign="center"><span class="menu_list" align="center">'.$lang["draw_autorize_name"].$_SESSION["name"].'<br><a href="#" class="menu_list">'.$lang["draw_autorize_property"].'</a>';
		if(strlen(trim($_SESSION["access_write"]))>0)
			$_SESSION["write"] ? print '<a href="user.php?write=0" class="menu_list">'.$lang["draw_autorize_readdata"].'</a>' : print '<a href="user.php?write=1" class="menu_list">'.$lang["draw_autorize_writedata"].'</a>';	
		print '</span></td></tr>';
		print '</table>';	

		draw_menu_end($lang["draw_autorize_exit"],"autorize.php");
	
	} else {
		draw_menu_begin($lang["draw_autorize_autorize"]);	
		print '<form action="autorize.php" name="autorization" id="autorization" method="post">';
		print '<table bgcolor="'.def_color_menu_bgcolor.'" width="222" border="0" cellpadding="1" cellspacing="0" align="left">';
		print '<tr>
				<td width="72" align="right" valign="center"><span class="menu_list" align="right">'.$lang["draw_autorize_login"].'</span></td>
				<td width="140" align="left" valign="center"><input type="text" name="login" size="20" style="'.def_style_form_login.'"></td>
			</tr>';
		print '<tr>
				<td width="72" align="right" valign="center"><span class="menu_list" align="right">'.$lang["draw_autorize_password"].'</span></td>
				<td width="140" align="left" valign="center"><input type="password" name="password" size="20"  style="'.def_style_form_login.'"></td>
			</tr>';
		print '</table>';	
		print '</form>	';
		draw_menu_end($lang["draw_autorize_enter"],"javascript:autorization.submit();");	
	}
}

function draw_banners(){
	global $lang, $config;
	draw_menu_begin($lang["draw_banners_name"]);

	require_once("banner.inc.php");	

	draw_menu_end("","");	
}

function draw_menu_begin($caption){	
		global $dirimg;
		print '		
		<!-- menu -->  
		
					<table  bgcolor="'.def_color_menu_bgcolor.'" width="248" border="0" cellpadding="0" cellspacing="0">
						<tr height="39">
							<td colspan="2" width="44" height="39" background="'.$dirimg.'/main_menu_1.jpg" WIDTH="44" HEIGHT="39" ALT="">&nbsp;</td>
							<td colspan="2" width="204" height="39" background="'.$dirimg.'/main_menu_2.jpg" align="left" valign="center"><span class="menu_caption">'.$caption.'</span></td>
						</tr>	
						<tr>
							<td width="14" background="'.$dirimg.'/main_menu_3.jpg">&nbsp;</td>
							<td colspan="2">';		
//	<td colspan="2" width="44" height="39"><IMG SRC="'.$dirimg.'/main_menu_1.jpg" WIDTH="44" HEIGHT="39" ALT=""></td>							
}	
	
function draw_menu_end($fun,$funhref){
	global $dirimg;
		print '</td>
					<td width="12" background="'.$dirimg.'/main_menu_4.jpg">&nbsp;</td>										
				</tr>	
				<tr height="41">
					<td colspan="4" width="248" height="41" background="'.$dirimg.'/main_menu_5.jpg"><div align="right"><a href="'.$funhref.'" class="menu_fun">'.$fun.'</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
				</tr>	
				<tr  BGCOLOR="'.def_color_bg.'">
					<td><IMG SRC="'.$dirimg.'/spacer.gif" WIDTH="14" HEIGHT="1" ALT=""></TD>
					<TD><IMG SRC="'.$dirimg.'/spacer.gif" WIDTH="30" HEIGHT="1" ALT=""></TD>
					<TD><IMG SRC="'.$dirimg.'/spacer.gif" WIDTH="192" HEIGHT="1" ALT=""></TD>
					<TD><IMG SRC="'.$dirimg.'/spacer.gif" WIDTH="12" HEIGHT="1" ALT=""></TD>
				</tr>															
			</table>		
		<!-- end menu -->			
		';	
}	


// -----------------------------------------------------------------------
//                                Desktop
// -----------------------------------------------------------------------

function draw_desktop($X_desktop){
	global $lang;
	
	if(isset($_SESSION['error'])){
		if (isset($_SERVER["PHP_SELF"]))
			$bot='<a href="'.$_SERVER["PHP_SELF"].'" class="desktop_fun_a">'.$lang["draw_desktop_remove"].'</a>';
		else	
			$bot="";		
		draw_one_desktop($lang["draw_desktop_error"],"<br><center>".$_SESSION['error']."</center><br>",$bot);
		unset($_SESSION['error']);		
	}	
	 
	if (isset($X_desktop)){
		for ($i = 0; $i < sizeof($X_desktop); $i++){
			draw_one_desktop($X_desktop[$i]["caption"],$X_desktop[$i]["list"],$X_desktop[$i]["bottom"]);
		}		
	}else{
		draw_one_desktop($lang["draw_desktop_nodata"],'<br><br><center>'.$lang["draw_desktop_nodesktop"].'</center><br><br>','');
	}	
	
};	

function draw_one_desktop($caption='',$list='',$bottom=''){
	draw_begin_desktop($caption);
	print $list;
	draw_end_desktop($bottom);
};

function draw_begin_desktop($caption=''){
	global $dirimg;	
	
	print '
<!-- desktop -->		
			<table  bgcolor="'.def_color_desktop_bgcolor.'" width="697" border="0" cellpadding="0" cellspacing="0">
				<tr height="38">
					<td width="40" colspan="2" background="'.$dirimg.'/main_desktop_1.jpg" WIDTH="40" HEIGHT="38" ALT="">&nbsp;</td>
					<td height="38" background="'.$dirimg.'/main_desktop_2.jpg" align="left"><span class="desktop_caption">'.$caption.'</span></td>
					<td width="28" colspan="2" background="'.$dirimg.'/main_desktop_3.jpg" WIDTH="28" HEIGHT="38" ALT="">&nbsp;</td>										
				</tr>				
				<tr>
				    <td width="14" background="'.$dirimg.'/main_desktop_4.jpg">&nbsp;</td>				    
					<td colspan="3"><span class="desktop_list">';					
//					<td width="40" colspan="2"><IMG SRC="'.$dirimg.'/main_desktop_1.jpg" WIDTH="40" HEIGHT="38" ALT=""></td>
//					<td width="28" colspan="2"><IMG SRC="'.$dirimg.'/main_desktop_3.jpg" WIDTH="28" HEIGHT="38" ALT=""></td>					
};

function draw_end_desktop($bottom_str=''){
	global $dirimg;

	print '</span></td>
 				    <td width="18" background="'.$dirimg.'/main_desktop_5.jpg">&nbsp;</td>				
				</tr>				
				<tr height="33">
					<td width="40"  colspan="2" background="'.$dirimg.'/main_desktop_6.jpg" WIDTH="40" HEIGHT="33" ALT="">&nbsp;</td>
					<td height="33"  background="'.$dirimg.'/main_desktop_7.jpg"><div align="right" class="desktop_fun">'.$bottom_str.'</div></td>
					<td width="28" colspan="2" background="'.$dirimg.'/main_desktop_8.jpg" WIDTH="28" HEIGHT="33" ALT="">&nbsp;</td>
				</tr>	
				<tr  BGCOLOR="'.def_color_bg.'">
					<td><IMG SRC="'.$dirimg.'/spacer.gif" WIDTH="14" HEIGHT="1" ALT=""></TD>
					<TD><IMG SRC="'.$dirimg.'/spacer.gif" WIDTH="26" HEIGHT="1" ALT=""></TD>
					<TD><IMG SRC="'.$dirimg.'/spacer.gif" WIDTH="629" HEIGHT="1" ALT=""></TD>
					<TD><IMG SRC="'.$dirimg.'/spacer.gif" WIDTH="10" HEIGHT="1" ALT=""></TD>
					<TD><IMG SRC="'.$dirimg.'/spacer.gif" WIDTH="18" HEIGHT="1" ALT=""></TD>
				</tr>											
			</table>				
<!-- end desktop -->
	';
//	<td width="40"  colspan="2"><IMG SRC="'.$dirimg.'/main_desktop_6.jpg" WIDTH="40" HEIGHT="33" ALT=""></td>
//	<td width="28" colspan="2"><IMG SRC="'.$dirimg.'/main_desktop_8.jpg" WIDTH="28" HEIGHT="33" ALT=""></td>
	
};



?>