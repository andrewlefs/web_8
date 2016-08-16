<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if ($HTTP_GET_VARS["mode"]=="del" && $HTTP_GET_VARS["pages"]=="yahoo")
	{
		$id = $_GET["id"];
		$delete_query = "DELETE FROM yahoo WHERE id = '$id'";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();	
		$sql->query($delete_query);
		$sql->close();
		$message= "Xóa thành công !";
		require_once("yahoo.php");
		exit();
	}
?>
