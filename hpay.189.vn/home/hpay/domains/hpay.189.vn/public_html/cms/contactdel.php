<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if ($HTTP_GET_VARS["mode"]=="del" && $HTTP_GET_VARS["pages"]=="contact")
	{
		$id = $_GET["id"];
		$delete_query = "DELETE FROM ".DB_PREFIX."contact WHERE contactid = '$id'";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();	
		$sql->query($delete_query);
		$sql->close();
		$message= "Delete Successfull !";
		require_once("contact.php");
		exit();
	}
?>
