<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();
	if($HTTP_SESSION_VARS['login']="true"){		
		$user = $HTTP_SESSION_VARS['user_admin'];
		$logout = time();
		$update_query = "UPDATE users SET logout=$logout WHERE user='$user'";
		$sql->query($update_query);
		$sql->close();
		session_destroy();
		unset($user);
		include_once("login.php");		
		exit();
	}
	else
	echo "H&atilde;y <a href='index.php'>dang nh?p</a> &#273;&#7875; qu&#7843;n l&yacute; n&#7897;i dung !";	
?>	