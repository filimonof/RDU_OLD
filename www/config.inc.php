<?
if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }


$config = array(

// 1=on  0=off 1


//--------- ������������ -----------------------
//������� ������������ ������� (� ����� _happy.inc.php ) 1-��, 0-���
"happy_manual" =>0,
//�������������� ������������  1-��, 0-���
"AUTO_HAPPY" => 1,
//��������� � ����������
"DIR_IMG_HAPPY" => "images_happy",



//������� �������� 1-��, 0-���
"SCRIPT_SNEGOPAD" => 0,

//����������� ������ ���������� �����
"WebmasterMail"=>"fvv@rdurm.odusv.so-cdu.ru?subject=From_SITE",

//������������ �� flush() ��� ��������� �������� 1-��, 0-���
"USE_FLASH"=>"0" ,

//����� �����������(�����������) ��������
"CACHE_TIME_ALL"=>0,

// �������� �� ������� ����
"DRAW_MENU" =>"1",
//���������� ������������� (id) �������� ���� � ����
"ID_MENU_TO_BASE"=>1,

//�������� �� ���� ����������� 1-��, 0-���
"DRAW_AUTORIZATION"=>"1",

//�������� �� ���� � ����������� � ��������  1-��, 0-���
"DRAW_BANNERS"=>0,

// �������� �� ���� � ��������
"DRAW_LINKS" => 1,
//���������� ������������� (id) ���� �� �������� � ����
"ID_LINKS_TO_BASE" => 2,


// ������ ����� ������� (�����)
"MASK_LOCAL_NET" => array("10.106.1.","10.106.2.","172.23.84."),

//������������ �� ����������� �� IP ���������� � ������� �� ���������� 1-��, 0-���
"ZVK_IP_COMP"=>0,



//����������� �������� ��������-1 ���������-0
"CACHE_NEWS"=>1,
//����������� ������� ��������-1 ���������-0
"CACHE_BANNERS"=>1,


// -------------- ������� ��� "��� ������" ---------
//�������� �� ���� �������� ��� ��� 1-��, 0-���
"DRAW_NEWS_RAO"=>0,
//����
"HOST_NEWS_RAO"=>"172.23.84.244",
//����
"URL_NEWS_RAO"=>"www.rao-ees.ru/ru/news.htm",
//���-���� ��������
"CACHE_NEWS_RAO"=>"cache/news_rao.cache",
// ������� ���������� �������� � �����  � ��������
"TIME_REFRESH_NEWS_RAO"=>86400,

// -------------- ������� ��� ������� ����� ---------
//�������� �� ���� ��������  1-��, 0-���
"DRAW_NEWS_ODUSV"=>1,
//����
"HOST_NEWS_ODUSV"=>"172.23.84.244",
//����
"URL_NEWS_ODUSV"=>"http://www.odusv.so-cdu.ru/news/",
//"URL_NEWS_ODUSV"=>"http://www.cdo.ups.ru/newsso/",
//���-���� ��������
"CACHE_NEWS_ODUSV"=>"cache/news_odusv.cache",
// ������� ���������� �������� � �����  � ��������
"TIME_REFRESH_NEWS_ODUSV"=>86400,


// -------------- �������� ������� ---------------
//�������� �� ���� �������� �� ��� 1-��, 0-���
"DRAW_NEWS_RBK"=>1,
//���� �������� ���
"HOST_NEWS_RBK"=>"172.23.84.244",
//���� � ���������
"URL_NEWS_RBK"=>"www.rbc.ru/out/upnews.html",
//���-���� ��������
"CACHE_NEWS_RBK"=>"cache/news_rbk.cache",
// ������� ���������� �������� � ����� ��� � ��������
"TIME_REFRESH_NEWS_RBK"=>86400,

// --------------- ������� ������� ----------------
//�������� �� ���� �������� �� ��� 1-��, 0-���
"DRAW_NEWS_MAIN_RBK"=>0,
//���� �������� ���
"HOST_NEWS_MAIN_RBK"=>"172.23.84.244",
//���� � ���������
"URL_NEWS_MAIN_RBK"=>"topadm.rbc.ru/include/dynamic/pub/news_titles.shtml",
//���-���� ��������
"CACHE_NEWS_MAIN_RBK"=>"cache/news_main_rbk.cache",
// ������� ���������� �������� � ����� ��� � ��������
"TIME_REFRESH_NEWS_MAIN_RBK"=>86400,

// -------------- ������ ������ 10���� � GisMeteo --------
//�������� �� ���� ������ � GisMeteo 1-��, 0-���
"DRAW_GISMETEO"=>1,
//���� 
"HOST_GISMETEO10"=>"172.23.84.244",
//���� 
"URL_GISMETEO10"=>"informer.gismeteo.ru/graph/G27760.GIF",
//���-���� �� ����� �������
"CACHE_GISMETEO10"=>"cache/G27760.GIF",
// ������� ����������  � ��������
"TIME_REFRESH_GISMETEO10"=>86400,

// ------------ ������ ������ ----------------
// ������, ��������� �� ���������, ��� ��� ��� ���������� � ����

// ------------ ������ ����� ����� ----------------
"HOST_KURS"=>"172.23.84.244",
//���� 
"URL_KURS"=>"pics.rbc.ru/img/grinf/usd/usd_dm_cb_127815_88x61.gif",
//���-���� �� ����� �������
"CACHE_KURS"=>"cache/usd_dm_cb_127815_88x61.gif.GIF",
// ������� ����������  � ��������
"TIME_REFRESH_KURS"=>86400,


// -------- ���������� ���� ------------------
// �������� �� ���� � ������������ ���
"DRAW_SELF_WARNING"=>1,


// -------- ������� ���� ---------------------
// �������� �� ���� � ��������� ���
"DRAW_SELF_NEWS"=>1,
// ���������� �������� �������������� �� ������
"COUNT_SELF_NEWS" => 5,

// -------- ��������� ���� ---------------------
//� ����� ���������� ��������� ��������� ����������� ���
"ROOTDIR_DOC" => "documents",
"TRUE_EXT_DOC" => array('csv', 'xls', 'jpeg', 'bmp', 'jpg', 'gif', 'png', 'pdf', 'doc', 'txt', 'rtf', 'pps', 'ppt','zip','rar','exe','hlp'),
"TRUE_CHAR_FILENAME" => "[^a-z0-9A-Z�-��-�[:space:],._�()-]",

// -------- ���������� ��� ������������ �������-----------------
//� ����� ���������� ��������� ��������� ����������� ��� ��������������� ��� ����������
"ROOTDIR_DOCHIDE" => "documents_hide",
"TRUE_EXT_DOCHIDE" => array('csv', 'xls', 'jpeg', 'bmp', 'jpg', 'gif', 'png', 'pdf', 'doc', 'txt', 'rtf', 'pps', 'ppt','zip','rar','exe','hlp'),
"TRUE_CHAR_FILENAMEHIDE" => "[^a-z0-9A-Z�-��-�[:space:],._�()-]",

// -------- ����������� ��������� ���� ---------------------
//� ����� ���������� ��������� ��������� �� ������������ ���������
"ROOTDIR_SS" => "documents_ss",
"TRUE_EXT_SS" => array('jpeg', 'bmp', 'jpg', 'gif', 'png'),
"TRUE_CHAR_FILENAME_SS" => "[^a-z0-9A-Z�-��-�[:space:],._�()-]",

// ������� ���� �������� ��������� �����
"TRUE_NEW_DOC" => 5,


// -------------- ��� -------------------------
//� ����� ���������� ��������� 
// ���������� ���������� ������������
"ROOTDIR_NTD" => "ntd",

// --------------------------------------------

// -------- ���� "��������� ��� ��������" ---------------------
// �������� �� ���� � ���������� ����� ��������
"DRAW_HAPPY"=>1,
// ���������� ���� �� ��� ��������
"COUNT_DAY_TO_HAPPY" => 7,

// -------- ���������� ---------------------
//� ����� ���������� ��������� ���������� ����������� ���
"ROOTDIR_FOTO" => "foto",


// Database configuration
"dbtype" => "mysql",  //mysql/pgsql
"dbhost" => "localhost",
"database" => "rdu",
"dbuser" => "web",
"dbpassword" => "qazxdrty"

);

//---------------- ������ ����� ---------------

$list_dirimg = array(
	"0" => array("name"=>"2","dir"=>"images1"),
	"1" => array("name"=>"1","dir"=>"images2"),
	"2" => array("name"=>"3","dir"=>"images3"),
	"3" => array("name"=>"4","dir"=>"images4")

);

$max_dirimg = 3;
isset($_COOKIE["num_design_to_site_rdu"]) ? $cur_dirimg = $_COOKIE["num_design_to_site_rdu"] : $cur_dirimg = 0;
if ($cur_dirimg>$max_dirimg) 
	$cur_dirimg = 0;
$dirimg = $list_dirimg[$cur_dirimg]["dir"];
$nameimg = $cur_dirimg == $max_dirimg ? $list_dirimg[0]["name"] : $list_dirimg[($cur_dirimg+1)]["name"];

//------------------------------------------------

header( "Cache-Control: max-age=".$config["CACHE_TIME_ALL"].", must-revalidate" );
header( "Last-Modified: " . gmdate("D, d M Y H:i:s", time()-3600) . " GMT");
header( "Expires: " . gmdate("D, d M Y H:i:s", time()+$config["CACHE_TIME_ALL"])." GMT");
?>
