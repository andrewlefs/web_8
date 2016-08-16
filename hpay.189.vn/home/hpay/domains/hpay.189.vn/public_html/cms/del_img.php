<?php
        define("qaz_wsxedc_qazxc0FD_123K",true);
        $phpbb_root_path = '../config/';
        $web_domain = 'http://localhost/ketnoidvietrung';
        define('WEB_DOMAIN_EDIT',$web_domain);
        include($phpbb_root_path."mysql.php");
        include($phpbb_root_path."config.php");
       $id_xoa = $_GET["id"];
       if(!empty($id_xoa)){
                        $sql = new db_sql();
                        $sql->db_connect();
                        $sql->db_select();
                        $id123 = explode(",", $id_xoa);
                        for($i = 1;$i<=count($id123);$i++){
                                            $delete_query = "delete from ".DB_PREFIX."proimg  where id_proimg='$id123[$i]' ";
                                            $sql->query($delete_query);
                                            $file_path = WEB_DOMAIN_EDIT.$dir_imgproducts.$id123[$i];                                      
                                            if(file_exists($file_path))	unlink("$file_path");
                                            $file_path = WEB_DOMAIN_EDIT.$dir_imgproducts."origin/".$id123[$i];
                                            if(file_exists($file_path))	unlink("$file_path");
                        }
                        echo "Xóa thành công";
       }else{   
                        echo "error";
       }
      
?>
