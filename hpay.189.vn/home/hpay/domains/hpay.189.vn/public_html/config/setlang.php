<?
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='../index.php'>Login</a> to Web Contents Manager !");
	}
                             session_start();
	if($_POST['set_language'] == 'true'){
	if(!isset($_SESSION['LANGUAGE']) || $_SESSION['LANGUAGE'] == NULL){
		session_register('LANGUAGE');
		$_SESSION['LANGUAGE'] = $_POST['LANGUAGE'];
	}else{
		$_SESSION['LANGUAGE'] = $_POST['LANGUAGE'];
	}
                            }else{
	if(!isset($_SESSION['LANGUAGE']) || $_SESSION['LANGUAGE'] == NULL){
		session_register('LANGUAGE');
		$_SESSION['LANGUAGE'] = 1;
	}
}
if($_SESSION['LANGUAGE']==1) $_lang="vn";
else $_lang = "en";
if($_SESSION['LANGUAGE']>0){
	include("language/".$_lang.".Front-end". EXT);
}

?>