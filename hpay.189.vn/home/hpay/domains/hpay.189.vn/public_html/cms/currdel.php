<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if ($HTTP_GET_VARS["mode"]=="del" && $HTTP_GET_VARS["pages"]=="curr")
	{
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();	
		$id = $_GET["id"];
		if(is_numeric($id)){
			$delete_query = "DELETE FROM currency WHERE currencyid = $id";
			$sql->query($delete_query);				
			if($sql->check_del()){
				$message= "Xóa thành công !";
				$sql->close();
				require_once("curr.php");
				exit();
			}
			else{
				$message= "Kh&ocirc;ng c&oacute; m&#7909;c b&#7841;n c&#7847;n x&oacute;a !";
				$sql->close();
				require_once("curr.php");
				exit();
			}			
		}
		else{
			$message= "Kh&ocirc;ng c&oacute; m&#7909;c b&#7841;n c&#7847;n x&oacute;a !";
			$sql->close();
			require_once("curr.php");
			exit();
		}			
	}
?>