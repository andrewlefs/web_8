<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
		if ($_GET["mode"]=="del"){
		if($_GET["act"]=="del") {
			
//	if ($HTTP_GET_VARS["mode"]=="del")
//	{
		$id = $_GET["id"];
		$delete_query = "DELETE FROM ".DB_PREFIX."tintuc WHERE tinid = '$id'";
		$select_query = "SELECT anhtin FROM ".DB_PREFIX."tintuc WHERE tinid = '$id'";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();	
		$sql->query($select_query);	
		$row = $sql->fetch_array();
		$anhtin = $row["anhtin"];
		if(!empty($anhtin)) 
		{
			$file_path = $dir_imgnews.$anhtin;
			if(file_exists($file_path))	unlink("$file_path");	
		}
		$sql->query($delete_query);
		$sql->close();
		$message= "Xóa thành công !";
		require_once("new.php");
		exit();
	}
	else if($_GET["act"]=="upd") {
			$id = $_GET["id"];
			$update_query = "UPDATE ".DB_PREFIX."tintuc  SET frontpage='".$_REQUEST["s"]."' WHERE tinid = '$id'";
			$sql = new db_sql();
			$sql->db_connect();
			$sql->db_select();	
			$sql->query($update_query);
			$sql->close();
			$message= "Đổi trạng thái thành công !";
			require_once("new.php");
			exit();
		}
	}
?>