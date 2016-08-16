<?php  
session_cache_limiter('public, no-store');
session_set_cookie_params(0);
ob_start();
// 0982926813  hiệu đấu nối services  04393351330
define("qaz_wsxedc_qazxc0FD_123K",true);
define('WEB_DOMAIN', 'http://'.$_SERVER["HTTP_HOST"].'');


$site_domain = "http://hpay.189.vn";

include('./config/define.php');
error_reporting (E_WARNING);
@ini_set("display_errors", FALSE);
@ini_set("log_errors", TRUE);
error_reporting(E_ALL & ~E_NOTICE);
define('EXT', '.php');
$phpbb_root_path = './config/';
include($phpbb_root_path."mysql.php");
include($phpbb_root_path."setlang.php");
include($phpbb_root_path."config.php");
include($phpbb_root_path."session.php");
include($phpbb_root_path."global.php");
include($phpbb_root_path."function.php");
ini_set("session.cookie_domain", ".".$site_domain);
session_name( $site_domain );
if (get_cfg_var( 'session.auto_start' ) > 0) {
	session_write_close();
}
session_start();
session_register( 'Auth' );
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");	// Date in the past
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");	// always modified
header ("Cache-Control: no-cache, max-age=0, must-revalidate, no-store, post-check=0, pre-check=0");	// HTTP/1.1
header ("Pragma: no-cache");	// HTTP/1.0
if (!isset( $_SESSION['Auth'] ) || strtolower($_GET['Webdesign'])=='logout') {   
    if ($_GET['Webdesign']=='logout' && isset($_SESSION['Auth']['memberid'])){
        $Auth =& $_SESSION['Auth'];
    }
$abc=array("memberid"=>"","user"=>"","fullname"=>"","phone"=>"","workphone"=>"","email"=>"","address"=>"","signdate"=>"","cart"=>"","cmt" => "");
$_SESSION['Auth'] =$abc;
}
$Auth =& $_SESSION['Auth'];
$mycart = $_SESSION['mycart'];
if(!in_array($_GET['Webdesign'], array('logout', 'login', 'register', 'editaccount', 'forgotpass')) && $_SERVER['REQUEST_METHOD']!='POST'){
	$_SESSION["ref"] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];   
}
$Webdesign      = isset($_GET["Webdesign"])  ? $_GET["Webdesign"]  : (isset($_POST["Webdesign"]) ? $_POST["Webdesign"]  : "index");
$mode     	= isset($_GET["mode"])   ? $_GET["mode"]   : (isset($_POST["mode"])  ? $_POST["mode"]  : "");
$choice 	= array(
	"index"         => "index",
    	"news"          => "news",
    	"contact"	=> "contact",
	"register"	=> "register",
	"login"         => "login",
	"forgotpass"	=> "forgotpass",
	"editaccount"	=> "editaccount",
	"cart"          => "cart",
	"product"       => "product",
	"productdetail" => "productdetail",
                          "ajaxConfig"	=> "ajaxConfig",
                          "services"            => "services",
	"checkout"	=> "checkout",
                          "newspagin"     => "newspagin",
	"newdetail"	=> "newdetail",	
	"editaccount"	=> "editaccount",	
	"search"	=> "search",
                            "searchpagin"   => "searchpagin",
                            "intro"		=> "intro",
                            "topbuy"        => "topbuy",
                            "topbuypagin"   => "topbuypagin",
                            "productnews"   => "productnews",
                            "productnewspagin" => "productnewspagin",
                            "hoadon"                   => "hoadon",
                            "productnsxpagin" => "productnsxpagin",
                            "productnsx"    => "productnsx",

                        "register_phone" => "register_phone",
                        "check_register" => "check_register",
                        "changepass" => "changepass",
                        "bank" => "bank",
                        "bankadd" => "bankadd",
                        "addmoney" => "addmoney",
                        "addmoneycard" => "addmoneycard",
                        "addmoneybanking" => "addmoneybanking",
                        "check_add_money_bank" => "check_add_money_bank",
                        "request" => "request",
                        "sendTo" => "sendTo",
                        "tradding" => "tradding",
                        "buy_card" => "buy_card",
                           "guide"    => "guide",
	       "introdetail" => "introdetail",
	      "newscompany" => "newscompany",
);

$action = array(
	"detail"  => "detail",
);
if (!isset($choice[$Webdesign])) $Webdesign = "index";
require("lib/".$choice[$Webdesign].".php");
include("lib/fs_output.php");
do_html_header($title[$Webdesign]); 
include("theme/".$choice[$Webdesign].".tpl");
do_html_footer();
?>