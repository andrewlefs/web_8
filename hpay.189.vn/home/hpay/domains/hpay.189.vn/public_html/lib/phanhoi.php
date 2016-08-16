<?php
      $noidung = $_GET['noidung'];
      if(!empty($noidung)){
          $conn = mysql_connect("localhost", "thanhchi_db", "y8YPEMtT");
          mysql_select_db("thanhchi_db",$conn);
          @mysql_query("SET NAMES utf8",$conn);
          $insert = "insert into about(content) values('$noidung')";
          mysql_query($insert);
          $message = "Gửi phản hồi thành công";
      }else{
          $message = "Bạn chưa nhập nội dung";
      }
      
      echo $message;
?>
