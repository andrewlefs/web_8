<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if ($HTTP_GET_VARS["mode"]=="del" && $HTTP_GET_VARS["pages"]=="video")
	{
		$id = $_GET["id"];
		$delete_query = "DELETE FROM videos WHERE vdid = '$id'";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();	
		$sql->query($select_query);	
		$row = $sql->fetch_array();
		$sql->query($delete_query);
		$sql->close();
		$message= "Xóa thành công !";
		require_once("video.php");
		exit();
	}
?>
