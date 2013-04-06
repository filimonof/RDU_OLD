<?
if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }


$config = array(

// 1=on  0=off 1


//--------- поздравления -----------------------
//вывести поздравление ручками (в файле _happy.inc.php ) 1-да, 0-нет
"happy_manual" =>0,
//автоматическое поздравление  1-да, 0-нет
"AUTO_HAPPY" => 1,
//диретория с картинками
"DIR_IMG_HAPPY" => "images_happy",



//сделать снегопад 1-да, 0-нет
"SCRIPT_SNEGOPAD" => 0,

//Электронный адресс вебмастера сайта
"WebmasterMail"=>"fvv@rdurm.odusv.so-cdu.ru?subject=From_SITE",

//Использовать ли flush() при генерации страницы 1-да, 0-нет
"USE_FLASH"=>"0" ,

//время кэширования(устаревания) страницы
"CACHE_TIME_ALL"=>0,

// выводить ли главное меню
"DRAW_MENU" =>"1",
//уникальный идентификатор (id) главного меню в базе
"ID_MENU_TO_BASE"=>1,

//выводить ли меню авторизации 1-да, 0-нет
"DRAW_AUTORIZATION"=>"1",

//выводить ли меню с информерами и банерами  1-да, 0-нет
"DRAW_BANNERS"=>0,

// выводить ли меню с ссылками
"DRAW_LINKS" => 1,
//уникальный идентификатор (id) меню со ссылками в базе
"ID_LINKS_TO_BASE" => 2,


// Адреса нашей подсети (маска)
"MASK_LOCAL_NET" => array("10.106.1.","10.106.2.","172.23.84."),

//Использовать ли авторизацию по IP компьютера в заявках на автомобиль 1-да, 0-нет
"ZVK_IP_COMP"=>0,



//кэширование новостей включено-1 отключено-0
"CACHE_NEWS"=>1,
//кэширование банеров включено-1 отключено-0
"CACHE_BANNERS"=>1,


// -------------- Новости РАО "ЕЭС России" ---------
//выводить ли блок новостей РАО ЕЭС 1-да, 0-нет
"DRAW_NEWS_RAO"=>0,
//Хост
"HOST_NEWS_RAO"=>"172.23.84.244",
//файл
"URL_NEWS_RAO"=>"www.rao-ees.ru/ru/news.htm",
//кеш-файл новостей
"CACHE_NEWS_RAO"=>"cache/news_rao.cache",
// Частота обновления новостей с сайта  в секундах
"TIME_REFRESH_NEWS_RAO"=>86400,

// -------------- Новости ОДУ Средней Волги ---------
//выводить ли блок новостей  1-да, 0-нет
"DRAW_NEWS_ODUSV"=>1,
//Хост
"HOST_NEWS_ODUSV"=>"172.23.84.244",
//файл
"URL_NEWS_ODUSV"=>"http://www.odusv.so-cdu.ru/news/",
//"URL_NEWS_ODUSV"=>"http://www.cdo.ups.ru/newsso/",
//кеш-файл новостей
"CACHE_NEWS_ODUSV"=>"cache/news_odusv.cache",
// Частота обновления новостей с сайта  в секундах
"TIME_REFRESH_NEWS_ODUSV"=>86400,


// -------------- основные события ---------------
//выводить ли блок новостей от РБК 1-да, 0-нет
"DRAW_NEWS_RBK"=>1,
//Хост новостей РБК
"HOST_NEWS_RBK"=>"172.23.84.244",
//файл с новостями
"URL_NEWS_RBK"=>"www.rbc.ru/out/upnews.html",
//кеш-файл новостей
"CACHE_NEWS_RBK"=>"cache/news_rbk.cache",
// Частота обновления новостей с сайта РБК в секундах
"TIME_REFRESH_NEWS_RBK"=>86400,

// --------------- главные события ----------------
//выводить ли блок новостей от РБК 1-да, 0-нет
"DRAW_NEWS_MAIN_RBK"=>0,
//Хост новостей РБК
"HOST_NEWS_MAIN_RBK"=>"172.23.84.244",
//файл с новостями
"URL_NEWS_MAIN_RBK"=>"topadm.rbc.ru/include/dynamic/pub/news_titles.shtml",
//кеш-файл новостей
"CACHE_NEWS_MAIN_RBK"=>"cache/news_main_rbk.cache",
// Частота обновления новостей с сайта РБК в секундах
"TIME_REFRESH_NEWS_MAIN_RBK"=>86400,

// -------------- Банеры погоды 10дней с GisMeteo --------
//выводить ти блок погоды с GisMeteo 1-да, 0-нет
"DRAW_GISMETEO"=>1,
//Хост 
"HOST_GISMETEO10"=>"172.23.84.244",
//файл 
"URL_GISMETEO10"=>"informer.gismeteo.ru/graph/G27760.GIF",
//кеш-файл на нашей стороне
"CACHE_GISMETEO10"=>"cache/G27760.GIF",
// Частота обновления  в секундах
"TIME_REFRESH_GISMETEO10"=>86400,

// ------------ банеры погоды ----------------
// флэшка, загрузить не получится, так как она обращается к базе

// ------------ банеры курса валют ----------------
"HOST_KURS"=>"172.23.84.244",
//файл 
"URL_KURS"=>"pics.rbc.ru/img/grinf/usd/usd_dm_cb_127815_88x61.gif",
//кеш-файл на нашей стороне
"CACHE_KURS"=>"cache/usd_dm_cb_127815_88x61.gif.GIF",
// Частота обновления  в секундах
"TIME_REFRESH_KURS"=>86400,


// -------- объявления МРДУ ------------------
// выводить ли блок с объявлениями РДУ
"DRAW_SELF_WARNING"=>1,


// -------- новости МРДУ ---------------------
// выводить ли блок с новостями РДУ
"DRAW_SELF_NEWS"=>1,
// количество новостей отображающихся на экране
"COUNT_SELF_NEWS" => 5,

// -------- документы МРДУ ---------------------
//в какой директории находятся документы мордовского РДУ
"ROOTDIR_DOC" => "documents",
"TRUE_EXT_DOC" => array('csv', 'xls', 'jpeg', 'bmp', 'jpg', 'gif', 'png', 'pdf', 'doc', 'txt', 'rtf', 'pps', 'ppt','zip','rar','exe','hlp'),
"TRUE_CHAR_FILENAME" => "[^a-z0-9A-ZА-Яа-я[:space:],._№()-]",

// -------- Информация для руководящего состава-----------------
//в какой директории находятся документы мордовского РДУ предназначенные для начальства
"ROOTDIR_DOCHIDE" => "documents_hide",
"TRUE_EXT_DOCHIDE" => array('csv', 'xls', 'jpeg', 'bmp', 'jpg', 'gif', 'png', 'pdf', 'doc', 'txt', 'rtf', 'pps', 'ppt','zip','rar','exe','hlp'),
"TRUE_CHAR_FILENAMEHIDE" => "[^a-z0-9A-ZА-Яа-я[:space:],._№()-]",

// -------- Селекторные совещания МРДУ ---------------------
//в какой директории находятся документы по сеелкторному совещанию
"ROOTDIR_SS" => "documents_ss",
"TRUE_EXT_SS" => array('jpeg', 'bmp', 'jpg', 'gif', 'png'),
"TRUE_CHAR_FILENAME_SS" => "[^a-z0-9A-ZА-Яа-я[:space:],._№()-]",

// сколько дней документ считается новым
"TRUE_NEW_DOC" => 5,


// -------------- НТД -------------------------
//в какой директории находятся 
// Нормативно справочная документация
"ROOTDIR_NTD" => "ntd",

// --------------------------------------------

// -------- Блок "ближайшие дни рождения" ---------------------
// выводить ли блок с ближайшими днями рождения
"DRAW_HAPPY"=>1,
// количество дней до дня рождения
"COUNT_DAY_TO_HAPPY" => 7,

// -------- Фотоальбом ---------------------
//в какой директории находятся фотографии Мордовского РДУ
"ROOTDIR_FOTO" => "foto",


// Database configuration
"dbtype" => "mysql",  //mysql/pgsql
"dbhost" => "localhost",
"database" => "rdu",
"dbuser" => "web",
"dbpassword" => "qazxdrty"

);

//---------------- дизайн сайта ---------------

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
