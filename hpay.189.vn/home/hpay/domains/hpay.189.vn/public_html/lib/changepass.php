<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
		die("<a href='../index.php'>Trang ch&#7911;</a>");
}
if($Auth["memberid"] < 1){
	header("Location: /login.html");
	exit;
}

//Var
$old_password_invalid 			= false;
$new_password_invalid 			= false;
$confirm_new_password_invalid 	= false;
 $code_invalid                                                                                                          = FALSE;
$msg2='';

if($_SERVER['REQUEST_METHOD']=='POST'){
	$action = $_POST["action"];
	if($action=="changepass"){ 
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
                                                        if(empty($_SESSION['code'] ) ||
                                                        strcasecmp($_SESSION['code'], $_POST['code']) != 0) {
                                                                   $code_invalid = TRUE;
                                                       }
		$oldpass = $_POST["oldpass"];
		$newpass = $_POST["newpass"];
		$renewpass = $_POST["renewpass"];
		if($oldpass=='' || strlen($oldpass) < 6){
			$old_password_invalid = true;
			$oldpass = '';
			$newpass = '';
			$renewpass = '';
		} else {
			$sSQL = "SELECT pass
					FROM ".DB_PREFIX."member
					WHERE memberid=".$Auth["memberid"];
			$result = $sql->query($sSQL);
			if($sql->num_rows()>0){
				while($row = mysql_fetch_assoc($result))
				if($row["pass"]!=md5 ($oldpass))
					$old_password_invalid = true;
			}
		}
		if($newpass=='' || strlen($newpass) < 6){
			$new_password_invalid = true;
			$newpass = '';
			$renewpass = '';
		}
		
		if($newpass!=$renewpass){
			$confirm_new_password_invalid = true;
			$arrUserInfo["pass"] = '';
			$arrUserInfo["repass"] = '';
		}
                                                    $mahoamatkhau = md5($newpass);
		if(!$old_password_invalid && !$new_password_invalid && !$confirm_new_password_invalid && !$code_invalid){
			$sSQL = "UPDATE ".DB_PREFIX."member SET `pass`='".$mahoamatkhau."' WHERE memberid=".$Auth["memberid"];
			$sql->query($sSQL);
			$msg2 = 'Mật khẩu đã được thay đổi';
			$oldpass = '';
			$newpass = '';
			$renewpass = '';
		} else {
				
			if($confirm_new_password_invalid)
				$msg2 = "Nhập lại mật khẩu mới không chính xác";
			
			if($new_password_invalid)
				$msg2 = "Mật khẩu mới không hợp lệ";
				
			if($old_password_invalid)
				$msg2 = "Mật khẩu cũ không chính xác";		
                                                                                if($code_invalid)
				$msg2 = "Mã bảo vệ không chính xác";	
		}
		$sql->close();
	}
}

function change_pass(){
     global $msg2;
            echo '<div class="left_box_slide">
                	<div class="title"><h3>Đổi mật khẩu</h3></div>
                    <div class="content"><p style="color: red"><h2>'.$msg2.'</h2></p>
                    	<ul>                                          
                                        <form action="'.WEB_DOMAIN.'/change-pass.html" method="post">
                                        <li>
                                            <p class="text">Mật khẩu cũ<span>*</span></p>
                                            <p class="input"> <input name="oldpass" type="password" maxlength="100" placeholder="Mã xác nhận"  /></p>
                                        </li>
                                        <li>
                                            <p class="text">Mật khẩu mới<span>*</span></p>
                                            <p class="input">
                                                        <input name="newpass"  type="password" maxlength="100" placeholder="Mã xác nhận"  />
                                            </p>
                                        </li>
                                          <li>
                                            <p class="text">Xác nhận mật khẩu mới<span>*</span></p>
                                            <p class="input">
                                                        <input name="renewpass"  type="password" maxlength="100" placeholder="Mã xác nhận"  />
                                            </p>
                                        </li>
                                        <li>
                                            <p class="text">Mã xác nhận<span>*</span></p>
                                            <p class="input"><input type="text" value="" placeholder="Mã xác nhận"  id="code" name="code" /></p>
                                        </li>
                                        <li>
                                            <p class="text"></p>
                                            <p class="input">
                                                        <span class="img_capcha">
                                                                    <img  id="captcha"  alt="captcha" src="'.WEB_DOMAIN.'/extsource/get_captcha.php" />
                                                       </span>
                                                       <span class="fresh">
                                                                    <img  id="captcha-refresh"  alt="Refresh captcha" src="'.WEB_DOMAIN.'/extsource/refresh.jpg" />
                                                       </span>
                                            </p>
                                        </li>
                                        <li>
                                            <p class="text"></p>
                                            <p class="input"><input type="submit" value="Đổi mật khẩu" />
                                                              <input type="hidden" class="stbn" value="changepass" name="action" />
                                            </p>
                                        </li>
                                        </form>
                        </ul>
                    </div>
                </div><!--left_box-->';
}
?>