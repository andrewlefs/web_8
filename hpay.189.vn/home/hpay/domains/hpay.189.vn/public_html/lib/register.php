<?php
                                        if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                                        die("<a href='../index.php'>Home</a>");
                                        } 
                                        
                                        $sql = new db_sql();
                                        $sql->db_connect();
                                        $sql->db_select();                                    
                                        $password_invalid 			= false;
                                        $confirm_password_invalid                                            = false;
                                        $firstname_invalid 			= false;
                                        $email_invalid 			= false;                                                                              
                                        $email_existing			= false;
                                        $phone_invalid 			= false;
                                        $codephone_invalid 			= false;
                                        $phone_existing 			= false;
                                          $cmt_invalid 			= false;                                                                              
                                        $cmt_existing			= false;
                                        
                                       
                                        $msg='';
                                  
                                       if($_SERVER['REQUEST_METHOD']=='POST' && $_POST["Webdesign"]=="register" && $_POST["mode"]=="send"){
                                            $confirm_code=md5(uniqid(rand()));
                                                       $code_phone = $_POST["code_phone"];
                                                       if($code_phone == ""){
                                                                $codephone_invalid = true;
                                                            }
                                              
                                                            $sSQL = "SELECT phone_confirm,email
                                                                        FROM ".DB_PREFIX."confirm_code   WHERE code_confirm='".$code_phone."'";
                                                                        $sql->query($sSQL);
                                                                        
                                                            $total = $sql->num_rows();
                                                            if($total !=1)
                                                                   $phone_existing = true;
                                                            if($r = $sql->fetch_array()){
                                                                    $phone = $r["phone_confirm"];
                                                                    $email = $r["email"];
                                                    }
                                                    
                                                  if($email=='' || !check_valid_email($email)){
                                                            $email_invalid = true;
                                                    }
                                                    
                                                       if($email=='' || !check_valid_email($email)){
                                                                $email_invalid = true;
                                                        }else{
                                                                $sSQL = "SELECT memberid
                                                                                FROM ".DB_PREFIX."member
                                                                                WHERE email='".$email."' ";
                                                                $sql->query($sSQL);
                                                                if($sql->num_rows()>0)
                                                                        $email_existing = true;
                                                        }
                                                    
                                                    if($phone=="" || preg_match("/([a-z])+$/",$phone)){
                                                                    $phone_invalid =  true;
                                                    }
                                                      $cmt = $_POST["cmt"];
                                                     if($cmt=="" || preg_match("/([a-z])+$/",$cmt) || !is_numeric($cmt) || strlen($cmt) < 9){
                                                                    $cmt_invalid =  true;
                                                    }else{
                                                                $sSQL = "SELECT memberid
                                                                                FROM ".DB_PREFIX."member
                                                                                WHERE cmt='".$cmt."' ";
                                                                $sql->query($sSQL);
                                                                if($sql->num_rows()>0)
                                                                        $cmt_existing = true;
                                                        }
                                                    
                                                    $pass = $_POST["pass"];
                                                    $repass = $_POST["repass"];

                                                    if($pass=='' || strlen($pass) < 6){
                                                            $password_invalid = true;
                                                           $pass = '';
                                                           $repass = '';
                                                    }

                                                    if($pass!=$repass){
                                                            $confirm_password_invalid = true;
                                                           $pass = '';
                                                           $repass = '';
                                                    }
                                                    
                                                    $fullname = $_POST["fullname"];
                                                    if($fullname=='')
                                                            $firstname_invalid = true;  
                                               
                                                     $id_loaivi = $_POST["loaivi"];          
                                                    
                                                      $seex = $_POST["sexid"];
                                                      $adre = $_POST["diachi"];
                                                 
                                                    $mahoamatkhau = md5($pass);
                            
                                                    
                                                   if(!$phone_invalid && !$phone_existing && !$codephone_invalid && !$email_invalid && !$password_invalid && !$confirm_password_invalid && !$firstname_invalid && !$email_existing ){                                                            
                                                       $sSQL = "INSERT INTO  ".DB_PREFIX."temp_members (`confirm_code` ,`pass` ,`cmt` ,`fullname` ,`id_loaivi` ,`phone` ,`email`,`sexid`,`adress`)
                                                                        VALUES ('".$confirm_code."',  '".$mahoamatkhau."',  '".$cmt."',  '".$fullname."',  '".$id_loaivi."',  '".$phone."',  '".$email."','".$seex."','".$adre."')  ";                                                    
                                                          if($sql->query($sSQL)){
                                                              $delete_query = "delete from ".DB_PREFIX."confirm_code WHERE phone_confirm='".$phone."' and code_confirm='".$code_phone."'";
                                                              $sql->query($delete_query);
                                                              unset($phone,$code_phone);
                                                          }
                                                                                                                  
                                                        // nếu chèn thành công sẽ gởi link xác nhận vào email người đăng ký 
                                                                        ob_start();
                                                                           $mail_content = ob_get_contents();
                                                                           require_once 'extsource/phpmailer/class.phpmailer.php';
                                                                           $mail  = new PHPMailer();
                                                                           // nội dung mail 
                                                                           $body="Xác Nhận Tài Khoản \r\n"; 
                                                                           $body.="Vui lòng bấm vào link dưới đề hoàn tất việc đăng ký \r\n"; 
                                                                           $body.= "".WEB_DOMAIN."/confirmation/passkey=$confirm_code.htm"; 

                                                                           $body       = eregi_replace("[\]",'',$body);
                                                                           $mail->IsSMTP(); 
                                                                           $mail->SMTPAuth   = true;                
                                                                           $mail->SMTPSecure = "ssl";                 
                                                                           $mail->Host       = "smtp.gmail.com";      
                                                                           $mail->Port       = 465;                 
                                                                           $mail->Username   = "kienlv@hoanggia.biz";  
                                                                           $mail->Password   = "giadinhlatatca@123";          
                                                                           $mail->SetFrom($email, 'Lê văn kiên');                                                                          
                                                                           $mail->Subject    = "Thông tin xác nhận website ".WEB_DOMAIN."";
                                                                           $mail->CharSet = "utf-8";
                                                                           $mail->MsgHTML($body);
                                                                           $address = $email;
                                                                           $mail->AddAddress($address ,$fullname);
                                                                           $mail->AddBCC($address,  $fullname);
                                                                           $mail->Send();     
                                                                                   echo '<script>alert("Đăng ký thành công ! Thông tin kích hoạt đã được gửi tới mail của bạn");
                                                                                            window.location.href = "'.WEB_DOMAIN.'";</script>';
                                                                            //     redirect(''.WEB_DOMAIN.'/dang-ky-thanh-cong.htm');     
                                                                           }
                                                                           else if($phone_invalid){
                                                                    $msg = "Số điện thoại không tồn tại";         
                                                                    }  else if($codephone_invalid || $phone_existing ){
                                                                                    $msg = "Mã kích hoạt không chính xác";
                                                                    }
                                                         
                                                            else if($firstname_invalid){
                                                                    $msg = "Xin vui lòng nhập Họ tên của bạn.";
                                                                    }
                                                            else if($password_invalid){
                                                                    $msg = "Xin vui lòng nhập Mật khẩu hợp lệ.";							
                                                                    }
                                                            else if($confirm_password_invalid){
                                                                    $msg = "Mật khẩu xác nhận  không chính xác. Xin vui lòng nhập lại";
                                                                    }  else if($email_existing){
                                                                          $msg = "Email này đã được sử dụng. Mời bạn chọn email khác";
                                                                    }     else if($cmt_invalid){
                                                                          $msg = "Số chứng minh phải lớn hơn 9 ký tự";
                                                                        }  else if($email_existing){
                                                                          $msg = "Số chứng minh  này đã được sử dụng. Mời bạn chọn email khác";
                                                                    }
                                                                     $sql->close();
                                                    }
                    
                     
function publish(){
    global $msg,$loaivi;
            echo '<div class="register">
              <h1>Đăng kí tài khoản</h1>
              <div class="left">
                  <h2>Lợi ích khi đăng kí làm thành viên</h2>
                  <p>Với Hoanggia ID bạn có thể sử dụng tất cả dịch vụ của Hoanggia một cách dễ dàng</p>
              </div>
              <div class="right">';
                            echo '<h2>Đăng kí thông tin</h2>
                                    <h2 style="color: re">'.$msg.'</h2>
                                <form method="post" action="'.WEB_DOMAIN.'/register.html">
                                       <select name="loaivi">';
                                    for($i=1;$i<=count($loaivi);$i++){
                                        echo '
                                                    <option value="'.$loaivi[$i]["id"].'">'.$loaivi[$i]["name"].'</option>';
                                     }
                            echo ' </select> 
                                <p><input type="text" name="user_intro" value="" placeholder="Mã người giới thiệu"></p>
                                   <p><input type="text" name="fullname" value="" placeholder="Họ tên đầy đủ"></p>
                                    <p>
                                         <select name="sexid">

                                                                  <option value="0">Nữ</option>
                                                                  <option value="1" selected>Nam</option>

                                          </select>
                                  </p>
                                  <p><input type="password" name="pass" value="" placeholder="Mật khẩu"></p>
                                  <p><input type="password" name="repass" value="" placeholder="Nhập lại mật khẩu"></p>
                                  <p><input type="text" name="cmt" value="" placeholder="Số chứng minh thư"></p>
                                  <p><input type="text" name="diachi" value="" placeholder="Địa chỉ"></p>
                                  <p><input type="text" name="code_phone" value="" placeholder="Mã số gửi tới điện thoại"></p>                   
                                  <p class="checked"><input type="checkbox" id="check_regis" onclick="check_reis();">Tôi đồng ý với <a href=""> các điều khoản của website</a></p>
                                  <p class="submit">
                                    <input name="Webdesign" type="hidden" id="Webdesign" value="register" /> 
                                               <input name="mode" type="hidden" id="mode" value="send"></p>
                                               <input type="submit"  value="Đăng kí"  id="id_of_your_button" disabled="disabled">
                                </form>';
                                      
              echo '</div>
                          
            </div>';
}


?>