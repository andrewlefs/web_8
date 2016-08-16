<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
		die("<a href='../index.php'>Trang ch&#7911;</a>");
}
$email_invalid 			= false;
$email_notexisting 			= false;
$code_invalid = FALSE;
$msg = '';
$status = 0;
if($_SERVER['REQUEST_METHOD']=='POST'){
	$email = strip_tags(addslashes($_POST["email"]));
	if($email=='' || !check_valid_email($email))
		$email_invalid = true;
        
                             if(empty($_SESSION['code'] ) ||
                                                        strcasecmp($_SESSION['code'], $_POST['code']) != 0) {
                                                                   $code_invalid = TRUE;
                                                       }
		
	if(!$email_invalid && !$code_invalid) {
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sSQL = "SELECT `user`,`pass`,`fullname`
				 FROM ".DB_PREFIX."member
				 WHERE email='".mysql_escape_string($email)."'";
		$result = $sql->query($sSQL);
		$num_rows = mysql_num_rows($result);
		if($num_rows > 0){
                
                    
                       // nếu chèn thành công sẽ gởi link xác nhận vào email người đăng ký 
                                                                        ob_start();
                                                                           $mail_content = ob_get_contents();
                                                                           require_once 'extsource/phpmailer/class.phpmailer.php';
                                                                           $mail  = new PHPMailer();
                                                                           // nội dung mail 
                                                                           $body="Chào".$row[fullname]."<br /><br />Theo yêu cầu của bạn, chúng tôi gởi đến bạn thông tin tài khoản của bạn trên website
                                                                               <a href='".WEB_DOMAIN."/localhost/ketnoiviettrung' target='_bank'>ketnoidviettrung</a><br  />
                                                                            ---------------------------
                                                                            <br  />
                                                                            THÔNG TIN TÀI KHOẢN CỦA BẠN
                                                                            <br  />
                                                                            ---------------------------
                                                                            <br />
                                                                            <br />
                                                                            Tên đăng nhập: <strong>".$row[user]."</strong>
                                                                            <br />
                                                                            Mật khẩu: <strong>".$row[pass]."</strong>
                                                                            <br />
                                                                            <br />
                                                                            Ngay bây giờ bạn có thể <a href='".WEB_DOMAIN."/localhost/ketnoiviettrung' target='_bank'>đăng nhập</a> và sử dụng website.
                                                                            <br />
                                                                            <br />
                                                                            ketnoiviettrung"; 
                                                                           $body       = eregi_replace("[\]",'',$body);
                                                                           $mail->IsSMTP(); 
                                                                           $mail->SMTPAuth   = true;                
                                                                           $mail->SMTPSecure = "ssl";                 
                                                                           $mail->Host       = "smtp.gmail.com";      
                                                                           $mail->Port       = 465;                 
                                                                           $mail->Username   = "kienlv@hoanggia.biz";  
                                                                           $mail->Password   = "giadinhlatatca@123";          
                                                                           $mail->SetFrom($email, 'Lê văn kiên');
                                                                           //$mail->AddReplyTo("kienlv@hoanggia.biz","lê văn kiên");
                                                                           $mail->Subject    = "Thông tin xác nhận website ".WEB_DOMAIN."";
                                                                           $mail->CharSet = "utf-8";
                                                                           $mail->MsgHTML($body);
                                                                           $address = $email;
                                                                           $mail->AddAddress($address ,$fullname);
                                                                           $mail->AddBCC($address,  $fullname);
                                                                           $mail->Send();        
                                                                                 redirect(''.WEB_DOMAIN.'/dang-ky-thanh-cong.htm');     
                                                                           }				
			
		} else {
			$email_notexisting = true;
		}
		$sql->close();
	} 
	
	if($email_invalid)
		$msg='Vui lòng nhập E-mail chính xác';
	if($email_notexisting)
		$msg='Không tìm thấy E-mail này trong hệ thống';
//}

function publish(){
    global $msg,$status;
    echo '<div class="fLeft sub-right sub-cont-r">
        <span class="fLeft tl">&nbsp;</span>
        <span class="fLeft tc tcr">Hỗ trợ &raquo; lấy lại mật khẩu</span>
        <span class="fLeft tl tr">&nbsp;</span>';
        if($status==1){
            echo '';
            }else{
        echo '<div class="fLeft sub-right s-c-r cont-sub-right">
            <div class="fLeft contNews">
                <form id="forgot-form" action="'.WEB_DOMAIN.'/forgotpass.html" method="post">
<div style="display:none"><input type="hidden" value="020618562ddc2c7dd338436f92d38d7aed929b8e" name="YII_CSRF_TOKEN" /></div>                                <ul class="laylaimk">
                    <li class="inputName">Email(<span class="red">*</span>)</li>
                    <li class="inputName inputText">
                        <input name="email"  type="text" maxlength="255" /><br />
                                            </li>
                  <li class="inputName">Mã xác nhận (<span class="red">*</span>)</li>
                                                                <li class="inputName inputText">     
                                                                            <input class="verifyCode" maxlength="10"  name="code" type="text" id="captcha-code">                                                                         
                                                                            <span class="verifyCode">
                                                                                <img src="'.WEB_DOMAIN.'/extsource/get_captcha.php" alt="" id="captcha">
                                                                            </span>
                                                                            <span class="captcha_img"><img src="'.WEB_DOMAIN.'/extsource/refresh.jpg" alt="captcha"  id="captcha-refresh"></span>
                                                                 </li>
                </ul>
                <div class="clear margin-top">&nbsp;</div>
                <hr class="dots" />
                <p align="right">
                    <input type="submit" class="stbn" value="Lấy lại mật khẩu" />
                    <input type="button" class="stbn buttonCancel" value="Hủy bỏ" />
                </p>
                </form>            </div>
        </div>
        <span class="fLeft bc bc-r">&nbsp;</span>';
        }
        echo '</div>';
}
?>