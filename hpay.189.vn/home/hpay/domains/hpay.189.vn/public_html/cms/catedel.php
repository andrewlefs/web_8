<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
                            $sql->db_connect();
                            $sql->db_select();
	if ($_GET["mode"]=="del" && $_GET["pages"]=="cate" )
	{
                                        if($_GET["act"]=="del") {                                                   
                                                    $id = $_GET["id"];
                                                    $message= delete_images($id);
                                                    $delete_query = "delete from ".DB_PREFIX."company_catalog where id_catalog= $id";
                                                    $sql->query($delete_query);
                                                   
                                                    require_once("cate.php");
                                                    exit();                                                  
                                          }else if($_GET["act"]=="upd") {
			$id = $_GET["id"];
			$update_query = "UPDATE  ".DB_PREFIX."catalog  SET publish='".$_GET["s"]."' WHERE  id_catalog = '$id'";				
			$sql->query($update_query);		
			$message= "Đổi trạng thái thành công !";
			require_once("cate.php");
			exit();
		}
                
                                         $sql->close();
	}
?>
