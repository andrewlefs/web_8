<?php
         define("qaz_wsxedc_qazxc0FD_123K",true);
        $phpbb_root_path = '../config/';
        include($phpbb_root_path."mysql.php");
        include($phpbb_root_path."config.php");
        $phone_number = $_GET["phone_number"];
        $method = $_GET["method"];
        $msg = "";    
        if($method=="check_method" && !empty($phone_number)){
                            $sql = new db_sql();
                            $sql->db_connect();
                            $sql->db_select();
                            $sSQL = "SELECT user   FROM ".DB_PREFIX."member   WHERE user='".$phone_number."' and Published='1' ";
                            $sql->query($sSQL);
                            if($sql->num_rows() > 0){                                                                 
                                    $msg = "Số điện thoại tồn tại ! Bạn có thể thực hiện giao dịch";
                            }
                            $sql->close();                          
        }
        
          echo $msg;
        
?>
