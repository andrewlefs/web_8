<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if ($HTTP_GET_VARS["mode"]=="del" && $HTTP_GET_VARS["pages"]=="user"){
		if($HTTP_SESSION_VARS["super"]==0){
			$message= "<li>Kh&ocirc;ng thể x&oacute;a Account quản trị hệ thống !";			
			require_once("user.php");
			exit();
		}
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();	
		$id = $_GET["id"];
		$select_query = "SELECT superuser FROM ".DB_PREFIX."users WHERE user ='$id'";
		$sql->query($select_query);
		$row = $sql->fetch_array();
		$super_del = $row['superuser'];
		if(is_string($id) && $super_del == 1){
					$message= "<li>Kh&ocirc;ng th&#7875; x&oacute;a Account Qu&#7843;n tr&#7883; h&#7879; th&#7889;ng !";
					$sql->close();
					require_once("user.php");
					exit();
		}		
		if(is_string($id) && $super_del==0 && $HTTP_SESSION_VARS["super"]==1){
			$delete_query = "DELETE FROM ".DB_PREFIX."users WHERE user = '$id'";
			$sql->query($delete_query);				
			if($sql->check_del()){
				$message= "<li>Delete Successfull !";
				$sql->close();
				require_once("user.php");
				exit();
			}
			else{
				$message= "<li>Kh&ocirc;ng c&oacute; m&#7909;c b&#7841;n c&#7847;n x&oacute;a !";
				$sql->close();
				require_once("user.php");
				exit();
			}				
		}	
	}	
?>