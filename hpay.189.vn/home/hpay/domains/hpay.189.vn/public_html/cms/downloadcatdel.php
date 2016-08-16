<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if ($HTTP_GET_VARS["mode"]=="del" && $HTTP_GET_VARS["pages"]=="downloadcat" )
	{
		$anhsp = array();
		$id = $_GET["id"];
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
				
		$delete_query = "DELETE FROM download WHERE downloadcat_id = $id";
		$sql->query($delete_query);			
		for($i=1; $i<=count($anhsp);$i++){	
			$anhtin = $anhsp[$i]["anhtin"];		
			if(!empty($anhtin)){
				$file_path = $dir_imgproducts.$anhtin;
				if(file_exists($file_path))	unlink("$file_path");
				/*$small_file_path = $dir_imgproducts."small_".$anhtin;
				if(file_exists($small_file_path))	unlink("$small_file_path");*/
			}
		}
		$delete_query = "DELETE FROM downloadcat WHERE id = $id";
		$sql->query($delete_query);	
		$sql->close();
		$message= "<li>Xóa thành công !";
		require_once("downloadcat.php");
		exit();
	}
?>