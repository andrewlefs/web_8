<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if ($HTTP_GET_VARS["mode"]=="del")
	{
		$id = $_GET["id"];
		$delete_query = "DELETE FROM download WHERE id = '$id'";
//		$select_query = "SELECT filename FROM download WHERE id = '$id'";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();	
/*		$sql->query($select_query);	
		$row = $sql->fetch_array();
		$filename = $row["filename"];
		if(!empty($filename)) 
		{
			$file_path = $dir_download.$filename;
			if(file_exists($file_path))	unlink("$file_path");	
		}*/
		$sql->query($delete_query);
		$sql->close();
		$message= "<li>Xóa thành công !";
		require_once("download.php");
		exit();
	}
?>
