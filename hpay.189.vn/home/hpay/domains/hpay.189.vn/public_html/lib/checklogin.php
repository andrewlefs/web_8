<?php  
session_start();
define("qaz_wsxedc_qazxc0FD_123K",true);
include('../config/define.php');
$phpbb_root_path = '../config/';
include($phpbb_root_path."mysql.php");
include($phpbb_root_path."config.php");
include($phpbb_root_path."function.php");
$msg = "";

$uuser = $_GET["user123"];
$paass = $_GET["pass123"];
session_register( 'Auth' );
        
$mahoa = md5($paass);//
if(!empty($uuser) && !empty($paass)){    
    $sql = new db_sql();
    $sql->db_connect();
    $sql->db_select();
    $select = "SELECT memberid, user, cmt, fullname, id_loaivi,email, signdate, Published  from ".DB_PREFIX."member WHERE  pass='".$mahoa."' and  user='".$uuser."' and Published='1' " ;   
    $sql->query($select);
    $num = $sql->num_rows();        
                if($num > 0){
                                  if($row = $sql->fetch_array()){
                                                  $Auth["memberid"]                                   = $row["memberid"];
                                                  $Auth["user"]                                             = $row["user"];
                                                  $Auth["fullname"]                                     = $row["fullname"];

                                                  $Auth["cmt"]                                              = $row["cmt"];
                                                  $Auth["id_loaivi"]                                     = $row["id_loaivi"];
                                                  $Auth["email"] 	                          = $row["email"];
                                                  $Auth["signdate"] 	                          = $row["signdate"];	
                                  }
                  }else{
                      $msg = "User không tồn tại";
                  }    
                  $sql->close();    
}else{
    $msg = "Thông tin không chính xác";
}

echo $msg;

?>