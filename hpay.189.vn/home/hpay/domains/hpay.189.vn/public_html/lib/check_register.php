<?php
                if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                                        die("<a href='../index.php'>Home</a>");
                 }  
                 
                 
                 
                 if(isset($_GET["Webdesign"]) && $_GET["Webdesign"]=="check_register"){
                            // mã xác nhận lấy từ link 
                            $passkey=$_GET['passkey']; 
                            $cretedate = date("Y-m-d");
                            $tbl_name1= DB_PREFIX."temp_members"; 
                           $sql = new db_sql();
                            $sql->db_connect();
                            $sql->db_select();
                            // Lấy dòng dữ liệu phù hợp vơi passkey này trong database 
                            $sql1="SELECT * FROM $tbl_name1 WHERE confirm_code ='$passkey'"; 
                            $result1 = $sql->query($sql1);             

                            // Nếu có dữ liệu  
                            if($result1){ 

                                                // đếm xem có bao nhiêu  passkey này  
                                                $count=$sql->num_rows($result1); 

                                                // nếu tìm thấy, lấy dữ liệu từ table "temp_members_db" 
                                                if($count==1){ 
                                                            $rows  =  $sql->fetch_array(); 
                                                            $fullname   =$rows['fullname']; 
                                                            $email  =  $rows['email']; 
                                                            $password =  $rows['pass'];  
                                                            $phone =  $rows['phone']; 
                                                            $cmt  =  $rows['cmt']; 
                                                            $loaivi = $rows['id_loaivi'];
                                                            $adress = $rows['adress'];
                                                            $sexid = $rows["sexid"];
                                                            $tbl_name2  =  DB_PREFIX."member"; 
                                                            // chèn dữ liệu vừa lấy bên bảng "temp_members_db" đưa vào bảng "registered_members"  
                                                            $sql2 = "INSERT INTO   $tbl_name2(`pass` ,`user` ,`cmt` ,`fullname` ,`GroupID` ,`id_loaivi` ,`email` ,`signdate` ,`Published`,sexid,adress)
                                                                    VALUES ( '".$password."',  '".$phone."',  '".$cmt."',  '".$fullname."',  '2',  '".$loaivi."',  '".$email."',  '".$cretedate."',  '1','".$sexid."','".$adress."')";
                                                            $result2=$sql->query($sql2); 
                                                } 
                                                // nếu ko tìm thấy  passkey, hiễn thị thông báo "Sai Mã Xác Nhận"  
                                                else { 
                                                               
                                                                $message = "Sai mã xác nhận";                                                           
                                                } 

                                                // nếu di chuyển thành công  dữ liệu từ bảng "temp_members_db" sang bảng "registered_members" hiển thị thông báo "tài khoản của bạn đã được kích hoạt" và đừng quên để xóa mã xác nhận từ bảng "temp_members_db" 
                                                if($result2){
                                                                // Xoá thông tin của người dùng này từ bảng "temp_members_db" có passkey này 
                                                                $sql3="DELETE FROM $tbl_name1 WHERE confirm_code = '$passkey'"; 
                                                                $sql->query($sql3); 
                                                                 $message = "tài khoản của bạn đã được kích hoạt";          
                                                } 
                            }
                          
                             echo '<script type="text/javascript">alert("'.$message.'")
                                 window.location.href="'.WEB_DOMAIN.'"</script>';
                             
               }
               
                        function provider(){
                            global $company,$dir_imglogos1;
                            echo '<div class="title"></div>
                            <ul  id="carouse2">';
                                            for($i=1;$i<=count($company);$i++){
                                                        echo '<li><a href="'.WEB_DOMAIN.'/buy-card/'.  huu($company[$i]["name"]).'-'.$company[$i]["id_company"].'" title="'.$company[$i]["name"].'">
                                                                                    <div class="img_thecao">
                                                                                                <img src="'.WEB_DOMAIN.$dir_imglogos1.$company[$i]["logo"].'" alt="'.$company[$i]["name"].'" />
                                                                                     </div>
                                                                          </a>
                                                        </li>';
                                             }
                            echo '</ul>
                            <a href="#" id="prev"></a>
                            <a href="#" id="next"></a>';
            }
?>
