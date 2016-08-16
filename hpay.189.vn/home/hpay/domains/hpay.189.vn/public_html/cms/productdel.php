<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}	
	if ($_GET["mode"]=="del" && $_GET["pages"]="product")
	{
                                                     if($_GET["act"]=="del") {
                                                                                                   $id = $_GET["id"];                                                                                               
                                                                                                    $delete_query = "DELETE FROM ".DB_PREFIX."product WHERE id_product = '$id'";
                                                                                                    $select_query = "SELECT anh  FROM ".DB_PREFIX."product WHERE id_product = '$id'";
                                                                                                    $select_query1 = "SELECT images   FROM ".DB_PREFIX."proimg WHERE id_pro = '$id'";
                                                                                                    $album = array();
                                                                                                    $sql = new db_sql();
                                                                                                    $sql->db_connect();
                                                                                                    $sql->db_select();	
                                                                                                    $sql->query($select_query);	
                                                                                                   if($row = $sql->fetch_array()){
                                                                                                                $anh = $row["anh"];
                                                                                                    }                                                                                                  
                                                                                                   
                                                                                                    if(!empty($anh)) 
                                                                                                    {
                                                                                                                                    $file_path = $dir_imgproducts.$anh;                                                                                                                                    
                                                                                                                                    if(file_exists($file_path))	unlink("$file_path");
                                                                                                                                    $file_path = $dir_imgproducts."origin/".$anh;
                                                                                                                                    if(file_exists($file_path))	unlink("$file_path");                                                                                                          
                                                                                                    }
                                                                                                    
                                                                                                    $sql->query($select_query1);
                                                                                                    
                                                                                                    $t = 0;
                                                                                                    while($ro = $sql->fetch_array()){    
                                                                                                        $t = $t + 1;
                                                                                                        $album[$t]["images"]= $ro["images"];
                                                                                                    }
                                                                                                    
                                                                                                     for($i=1; $i<count($album);$i++){	
                                                                                                                                       $file_path = $dir_imgproducts."origin/".$album[$i]["images"];
                                                                                                                                        if(file_exists($file_path))	unlink("$file_path");
                                                                                                                                        $file_path1 = $dir_imgproducts.$album[$i]["images"];
                                                                                                                                        if(file_exists($file_path1))	unlink("$file_path1");                                                                                                                         
                                                                                                        }	
                                                                                                        $sql->query($delete_query);
                                                                                                        $sql->close();
                                                                                                        $message= " Xóa thành công !";
                                                                                                        include_once("product.php");
                                                                                                        exit();
                                                    }else if($_GET["act"]=="upd") {
                                                                                                    $id = $_GET["id"];
                                                                                                    $update_query = "UPDATE ".DB_PREFIX."product  SET publish='".$_REQUEST["s"]."' WHERE id_product = '$id'";
                                                                                                    $sql = new db_sql();
                                                                                                    $sql->db_connect();
                                                                                                    $sql->db_select();	
                                                                                                    $sql->query($update_query);
                                                                                                    $sql->close();
                                                                                                    $message= "Đổi trạng thái thành công !";
                                                                                                    require_once("product.php");
                                                                                                    exit();
                                                 }
	}
	
		
	
?>
