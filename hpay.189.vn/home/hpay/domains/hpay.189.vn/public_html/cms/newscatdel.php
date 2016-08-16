<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if ($HTTP_GET_VARS["mode"]=="del" && $HTTP_GET_VARS["pages"]=="newscat" )
	{
                                                    $id = $_GET["id"];
                                                    $sql = new db_sql();
                                                    $sql->db_connect();
                                                    $sql->db_select();
                                                   if($_GET["act"]=="del") {             
                                                                                $message= delete_images_newcat($id);
                                                                                require_once("newscat.php");
                                                                                exit();                                                  
                                                    }else if($_GET["act"]=="upd") {
			$update_query = "UPDATE  ".DB_PREFIX."newscat   SET publish='".$_GET["s"]."' WHERE  id_newscat = '$id'";			
			$sql->query($update_query);
			$sql->close();
			$message= "Đổi trạng thái thành công !";
			require_once("newscat.php");
			exit();
		}							
	}
?>