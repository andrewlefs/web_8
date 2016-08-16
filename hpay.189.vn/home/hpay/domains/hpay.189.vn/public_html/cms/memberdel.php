<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if ($_GET["mode"]=="del")
	{
		$id = $_GET["id"];
		$delete_query = "DELETE FROM member WHERE memberid = '$id'";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($delete_query);
		$sql->close();
		$message= "Xóa thành công !";
		require_once("member.php");
		exit();
	}
?>
