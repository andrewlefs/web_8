<?php
                            if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                            die("<a href='../index.php'>Trang ch&#7911;</a>");
                            }
                            if($Auth["memberid"] < 1){
                                    header("Location: /login.html");
                                    exit;
                            }

                        $sql = new db_sql();
                        $sql->db_connect();
                        $sql->db_select();
                        $firstname_invalid 				= false;
                        $email_invalid 					= false;
                        $email_existing					= false;

                         $code_invalid                                                                                                          = FALSE;
                        $msg =  '';
                        $msg2='';

                        $memberid =$Auth["memberid"];
                        $select = "SELECT `user`, `cmt`, `fullname`,`email`,`adress`,`sexid` FROM ".DB_PREFIX."member WHERE `memberid`=$memberid and `Published`=1 limit 1";
                        $sql->query($select);
                        
                        if($r = $sql->fetch_array()){                             
                                    $email = $r["email"];
                                    $adress = $r["adress"];
                                    $sexid = $r["sexid"];
                                    $fullname = $r["fullname"];
                        }


                    if($_SERVER['REQUEST_METHOD']=='POST'){
                            $action = $_POST["action"];
                            if($action=="edit"){
                                    $email = $_POST["email"];
                                                                        $adress = $_POST["adress"];
                                                                        $sexid = $_POST["sexid"];
                                                                         if(empty($_SESSION['code'] ) ||
                                                                            strcasecmp($_SESSION['code'], $_POST['code']) != 0) {
                                                                                       $code_invalid = TRUE;
                                                                           }

                                    if($email=='' || !check_valid_email($email)){
                                            $email_invalid = true;
                                    }else{
                                            $sSQL = "SELECT memberid
                                                            FROM ".DB_PREFIX."member
                                                            WHERE email='".$email."' AND memberid !='".$Auth["memberid"]."' ";
                                            $sql->query($sSQL);
                                            if($sql->num_rows()>0)
                                                    $email_existing = true;
                                    }

                                                                         $fullname = $_POST["fullname"];
                                    if($fullname=='')
                                            $firstname_invalid = true;

                                    if(!$firstname_invalid && !$email_invalid && !$email_existing && !$code_invalid ) {
                                            $sSQL = "UPDATE ".DB_PREFIX."member  SET `fullname`='".$fullname."',`email`='".$email."' WHERE memberid=".$Auth["memberid"];
                                            $sql->query($sSQL);                                                                            
                                            $msg = 'Cập nhật tài khoản thành công';                   
                                    } else {
                                            if($email_invalid)
                                                    $msg = "Xin vui lòng nhập E-mail hợp lệ.";			

                                            if($email_existing)
                                                    $msg = "E-mail này đang được sử dụng. Xin vui lòng chọn E-mail khác.";			

                                            if($firstname_invalid)
                                                    $msg = "Xin vui lòng nhập Họ tên của bạn.";
                                                                                                    if($code_invalid)
                                                    $msg = "Sai mã bảo vệ.";
                                    }

                                    $sql->close();        

                            } 

                    }

function editaccount(){
        global $Auth,$msg,$adress,$sexid,$fullname,$email;    
        if($sexid==1){
            $sex_sl = "selected";
        }else{
            $sex_sl = "";
        }
          if($sexid==0){
            $sex_sl1 = "selected";
        }else{
            $sex_sl1 = "";
        }
    echo '
                <div class="left_box_slide">
                	<div class="title"><h3>Thông tin cá nhân</h3></div>
                    <div class="content">
                            <div class="error_message">
                                        <h2 style="color: red">'.$msg.'</h2>
                            </div>
                    	<ul>
                        	<li>
                                <p class="text">Số điện thoại đăng nhập</p>
                                <p class="input">'.$Auth["user"].'</p>
                            </li>
                            <li>
                                <p class="text">Số CMND</p>
                                <p class="input">'.$Auth["cmt"].'</p>
                            </li>
                            <form action="'.WEB_DOMAIN.'/usercp.html" method="post">
                            <li>
                                <p class="text">Tên đầy đủ <span>*</span></p>
                                <p class="input"><input type="text" value="'.$fullname.'" name="fullname" /></p>
                            </li>
                             <li>
                                <p class="text">Giới tính<span>*</span></p>
                                <p class="input">
                                            <select name="sexid">
                                                        <option value="0" '.$sex_sl1.'>Nữ</option>
                                                        <option value="1" '.$sex_sl.'>Nam</option>
                                            </select>
                                </p>
                            </li>
                            <li>
                                <p class="text">Email<span>*</span></p>
                                <p class="input"><input type="text" value="'.$email.'" name="email"/></p>
                            </li>
                            <li>
                                <p class="text">Địa chỉ<span>*</span></p>
                                <p class="input"><input type="text" value="'.$adress.'" name="adress"/></p>
                            </li>
                            <li>
                                <p class="text">Mã xác nhận<span>*</span></p>
                                <p class="input"><input type="text" value="" placeholder="Mã xác nhận"  id="code" name="code" /></p>
                            </li>
                            <li>
                                <p class="text"></p>
                                <p class="input"><span class="img_capcha"><img  id="captcha"  alt="captcha" src="'.WEB_DOMAIN.'/extsource/get_captcha.php" alt="captcha" /></span>
                                    <span class="fresh"><img id="captcha-refresh"  src="'.WEB_DOMAIN.'/extsource/refresh.jpg" alt="Refresh captcha" /></span></p>
                            </li>
                            <li>
                                <p class="text"></p>
                                <p class="input"><input type="submit" value="Cập nhật" />
                                <input type="hidden" class="stbn" value="edit" name="action" /></p>
                            </li>
                        </ul>
                    </div>
                </div><!--left_box-->';
}

?>