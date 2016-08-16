<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if ($_GET["mode"]=="del" && $_GET["pages"]=="manu")
	{
                                            
                                                    $sql = new db_sql();
                                                    $sql->db_connect();
                                                    $sql->db_select();	
                                                    $id_manu_del  = $_GET["id"];
                                                    if($_GET["act"]=="del") {
                                                                    if(is_numeric($id_manu_del)){
                                                                            $delete_query = "DELETE FROM ".DB_PREFIX."company WHERE id_company = $id_manu_del";
                                                                            $select_query = "SELECT logo FROM ".DB_PREFIX."company WHERE id_company = $id";
                                                                            $sql->query($select_query);
                                                                            if($r = $sql->fetch_array()){
                                                                                $logo = $r["logo"];
                                                                            }
                                                                            if(!empty($logo)){
                                                                                        $file_path = $dir_imglogos.$logo;
                                                                                        if(file_exists($file_path))	unlink("$file_path");	
                                                                            }
                                                                            $sql->query($delete_query);	
                                                                            if($sql->check_del()){
                                                                                    
                                                                                    $delete_query1 = "delete from ".DB_PREFIX."company_catalog where id_company= $id_manu_del";
                                                                                    $sql->query($delete_query1);
                                                                                    $message= "Xóa thành công !";
                                                                                    $sql->close();
                                                                                    require_once("manu.php");
                                                                                    exit();
                                                                            }
                                                                            else{
                                                                                    $message= "Kh&ocirc;ng c&oacute; m&#7909;c b&#7841;n c&#7847;n x&oacute;a !";
                                                                                    $sql->close();
                                                                                    require_once("manu.php");
                                                                                    exit();
                                                                            }			
                                                                    }
                                                                    else{
                                                                            $message= "Kh&ocirc;ng c&oacute; m&#7909;c b&#7841;n c&#7847;n x&oacute;a !";
                                                                            $sql->close();
                                                                            require_once("manu.php");
                                                                            exit();
                                                                    }
                                                    }else if($_GET["act"]=="upd") {			
			$update_query = "UPDATE ".DB_PREFIX."company  SET publish='".$_REQUEST["s"]."' WHERE id_company = '$id_manu_del'";				
			$sql->query($update_query);
			$sql->close();
			$message= "Đổi trạng thái thành công !";
			require_once("manu.php");
			exit();
		}
	}
?>