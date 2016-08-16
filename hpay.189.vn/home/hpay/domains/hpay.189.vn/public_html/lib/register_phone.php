<?php
                                        if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                                        die("<a href='../index.php'>Home</a>");
                                        }
                                        
                                        require_once './extsource/nusaop/nusoap.php';                               
                                        
                                        $sql = new db_sql();
                                        $sql->db_connect();
                                        $sql->db_select();
                                        
                                        $phone_invalid 			= false;
                                        $phone_existing			= false;
                                         $email_invalid                                                                   = false;
                                         $captcha_invalid                                                                   = false;
                                     
                                        $msg='';                    

                                         if($_SERVER['REQUEST_METHOD']=='POST' && $_POST["mode"]=='send' && $_POST["module"]=='send_phone'){                                               
                                                    // mã xác nhận ngẫu nhiên 
                                                    $confirm_code = '';
                                                    $md5_hash = md5(rand(0,999)); 
                                                    $confirm_code = substr($md5_hash, 15, 5); 
                                                  
                                                    $phone = $_POST["phone_number"];
                                                    if($phone=="" || preg_match("/([a-z])+$/",$phone)){
                                                                    $phone_invalid =  true;
                                                    }
                                                    
                                                    if(empty($_SESSION['code'] ) ||
                                                             strcasecmp($_SESSION['code'], $_POST['code']) != 0) {
                                                             $captcha_invalid = true;
                                                     }
                                                     
                                                  $email = $_POST["email"];
                                                    
                                                  if($email=='' || !check_valid_email($email)){
                                                            $email_invalid = true;
                                                    }
                                                    
                                                    // kiểm tra so dien thoai da duoc dung hay chua
                                                    $select = "select user from ".DB_PREFIX."member where user = '".$phone."' ";
                                                    $sql->query($select);
                                                    $num = $sql->num_rows();
                                                    if($num >= 1){
                                                                    $phone_existing			= true;
                                                    }

                                                    if(!$phone_invalid && !$phone_existing && !$captcha_invalid && !$email_invalid) {
                                                            $sSQL = "INSERT INTO  ".DB_PREFIX."confirm_code (`phone_confirm` ,`code_confirm` ,`publish`,`email`)
                                                                                VALUES ('$phone',  '$confirm_code',  '0' ,'$email');";
                                                             $sql->query($sSQL);
                                                        // nếu chèn thành công sẽ gởi link xác nhận vào email người đăng ký    
                                                            
                                                                           ob_start();
                                                                           $mail_content = ob_get_contents();
                                                                           require_once 'extsource/phpmailer/class.phpmailer.php';
                                                                           $mail  = new PHPMailer();
                                                                           // nội dung mail 
                                                                           $body="Xác Nhận Tài Khoản \r\n"; 
                                                                           $body.="User : ".$phone." \r\n"; 
                                                                           $body.= "Mã xác nhận đăng ký : ".$confirm_code; 

                                                                           $body       = eregi_replace("[\]",'',$body);
                                                                           $mail->IsSMTP(); 
                                                                           $mail->SMTPAuth   = true;                
                                                                           $mail->SMTPSecure = "ssl";                 
                                                                           $mail->Host       = "smtp.gmail.com";      
                                                                           $mail->Port       = 465;                 
                                                                           $mail->Username   = "kienlv@hoanggia.biz";  
                                                                           $mail->Password   = "giadinhlatatca@123";          
                                                                           $mail->SetFrom('kienlv@hoanggia.biz', 'Lê văn kiên');                                                                           
                                                                           $mail->Subject    = "Thông tin xác nhận website ".WEB_DOMAIN."";
                                                                           $mail->CharSet = "utf-8";
                                                                           $mail->MsgHTML($body);
                                                                           $address = $email;
                                                                           $mail->AddAddress($address ,"Lê Văn Kiên");
                                                                           $mail->Send();  
                                                                           sentsmss("",$confirm_code);
                                                                           redirect(''.WEB_DOMAIN.'/register.html');        
                                                    }else if($phone_invalid){
                                                                    $msg = "Số điện thoai không đúng";
                                                    }  
                                                    else if($phone_existing){
                                                                    $msg = "Số điện thoai đã được sử dung";
                                                    }else if($captcha_invalid){
                                                                    $msg = "Mã bảo vệ không đúng";
                                                    }  else if($email_invalid){
                                                                    $msg = "Email không đúng";
                                                    }  
                                                    $sql->close();
                                            }

            function register_phone(){
                global $msg,$phone,$email;
                                     echo '<div class="register">
                                    <h1>Đăng kí tài khoản</h1>
                                    <div class="left">
                                        <h2>Lợi ích khi đăng kí làm thành viên</h2>
                                        <p>Với Hoanggia ID bạn có thể sử dụng tất cả dịch vụ của Hoanggia một cách dễ dàng</p>
                                    </div>
                                    <div class="right">
                                    <h2>Đăng kí thông tin</h2>';
                                                    echo '<h2 style="color: red">'.$msg.'</h2>';
                                        echo '<form method="post" action="'.WEB_DOMAIN.'/register-phone.html">
                                          <p><input type="text" name="phone_number"  placeholder="Số điện thoại đăng nhập" value="'.$phone.'"></p>                                         
                                          <p><input type="text" name="email"  placeholder="Email" value="'.$email.'"></p>                                          
                                          <p>
                                          <input type="text" class="input"  id="code" name="code" value="Mã kiểm tra"   title="searchfield"   onfocus="if(this.value==\'Mã kiểm tra\')this.value=\'\';" onblur="if(this.value==\'\')this.value=\'Mã kiểm tra\';"  style="width: 100px;vertical-align: top; float:left" />
                                        
                                                    <a href="javascript:;">
                                                                     <img   id="captcha"  alt="captcha" src="'.WEB_DOMAIN.'/extsource/get_captcha.php" style="width:120px; height:32px; border:0px;">
                                                    </a> 
                                                    <a href="javascript:refeshCapcha();">
                                                                    <img id="captcha-refresh"  alt="Refresh captcha" src="'.WEB_DOMAIN.'/extsource/refresh.jpg" style="width:25px; height:18px; border:0px; ">
                                                   </a>
                                            </p>
                                          <p class="submit">
                                                    <input type="submit"  value="Đăng kí">
                                                    <input name="module" type="hidden" value="send_phone">
                                                     <input name="mode"   type="hidden" value="send">
                                          </p>
                                        </form>
                                    </div>
                                  </div>';
            }


?>