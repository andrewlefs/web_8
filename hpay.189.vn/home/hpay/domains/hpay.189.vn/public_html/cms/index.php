<?php
ob_start();
define("qaz_wsxedc_qazxc0FD_123K",true);
$phpbb_root_path = '../config/';
include($phpbb_root_path."mysql.php");
include($phpbb_root_path."config.php");
include($phpbb_root_path."function.php");
include($phpbb_root_path."function_cat.php");
include($phpbb_root_path."function_newcat.php");

$pages   = isset($_GET["pages"])  ? $_GET["pages"]  : (isset($_POST["pages"]) ? $_POST["pages"]  : "login");
$mode    = isset($_GET["mode"])   ? $_GET["mode"]   : (isset($_POST["mode"])  ? $_POST["mode"]  : "");	
$choice = array(
 	"login"=>"login", "logout"=>"logout", "welcome"=> "welcome",
	"manu"		=> "manu",    
 	"curr"		=> "curr",   
        "linkseo"	=> "linkseo",
        "slider"	=> "slider",
        "member" 	=> "member",
        "yahoo"	   	=> "yahoo",
        "productimg"    => "productimg",
        "cate"          => "cate",
        "settings"      => "settings",	 
	"member" 	=> "member",
	"media"  	=> "media",
	"seoweb"	=> "seoweb",
	"service"	=> "service",
	"blockinfo"	=> "blockinfo",
	"cate"	   	=> "cate",
	"subcate"	=> "subcate", 
	"product"	=> "product",
	"newscat"  	=> "newscat",	
	"downloadcat"   => "downloadcat",
	"download"	=> "download",
	"upload_form"   => "upload_form",
	"new"	   	=> "new",
	"user"	   	=> "user",
	"link"	   	=> "link",
	"faq"	   	=> "faq",
	"contact"	=> "contact",
	"story"	   	=> "story",
	"intro"	   	=> "intro",	
	"vote"	   	=> "vote",
	"configuration" => "configuration",
	"video"		=> "video",
	"weblink"	=> "weblink",
                           "yeucau"         => "yeucau",
                           "network"        => "network",
                           "company_catalog" => "company_catalog",
      
);
$action = array(
	"edit"         	=> "edit",
	"add"          	=> "add",              
	"del"           => "del",							
	"detail"	=> "detail",
	"search"	=> "search",
);

session_start();
session_name("sid");
if (!isset($choice[$pages]) || check_admin_user()==false ){
	$pages = "login";                
	include("login.php");
	exit();
}
include("./".$choice[$pages].$action[$mode].".php");
?>