<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	if ($HTTP_GET_VARS["mode"]=="del" && $HTTP_GET_VARS["pages"] == "slider")
	{
		$id = $_GET["id"];
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$delete_query = "DELETE FROM ".DB_PREFIX."slider WHERE id_slider = $id";
		$select_query = "SELECT logo FROM ".DB_PREFIX."slider WHERE id_slider = $id";
		if(is_numeric($id)){	
			$sql->query($select_query);	
			$row = $sql->fetch_array();
			$logo = $row["logo"];
			if(!empty($logo)){
				$file_path = $dir_imgslider.$logo;
				if(file_exists($file_path))	unlink("$file_path");	
			}
			$sql->query($delete_query);
			if($sql->check_del()){
				$message= "Delete Successfull !";
				$sql->close();
				require_once("slider.php");
				exit();
			}
			else{
				$message= "Kh&ocirc;ng c&oacute; m&#7909;c b&#7841;n c&#7847;n x&oacute;a !";
				$sql->close();
				require_once("slider.php");
				exit();
			}				
		}else{
			$message= "Kh&ocirc;ng c&oacute; m&#7909;c b&#7841;n c&#7847;n x&oacute;a !";
			$sql->close();
			require_once("slider.php");
			exit();
		}
	}
?>
