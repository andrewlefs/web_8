<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
		die("<a href='../index.php'>Home</a>");
}
if($Auth["memberid"] > 1){
	header("Location:".WEB_DOMAIN);
	exit;
}

$username_invalid 	= false;
$login_invalid 		= false;
$password_invalid 	= false;
$msg = '';
if($_SERVER['REQUEST_METHOD']=='POST'){	
	if(!eregi('^[a-zA-Z0-9_]+$', $_POST["user"]))
		$username_invalid = true;
	if($_POST["user"]=='' || strlen($_POST["user"]) < 4)
		$username_invalid = true;
	if($_POST["pass"]=='' || strlen($_POST["pass"]) < 6)
		$password_invalid = true;
	if(!$username_invalid && !$password_invalid) {
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
                                                    $uuser = $_POST["user"];
                                                    $mahoa = md5($_POST["pass"]);
                
		$sSQL = "SELECT memberid, user, cmt, fullname, id_loaivi,email,Gold, signdate, Published  from ".DB_PREFIX."member WHERE  pass='".$mahoa."' and  user='".$uuser."' and Published='1' ";
		$sql->query($sSQL);
		$count = $sql->num_rows();
		if($count > 0){
			if($row = $sql->fetch_array()){
				     $Auth["memberid"]                                   = $row["memberid"];
                                                                                                                $Auth["user"]                                             = $row["user"];
                                                                                                                $Auth["fullname"]                                     = $row["fullname"];                                   
                                                                                                                $Auth["cmt"]                                              = $row["cmt"];
                                                                                                                $Auth["id_loaivi"]                                     = $row["id_loaivi"];
                                                                                                                $Auth["email"] 	                          = $row["email"];
                                                                                                                $Auth["signdate"] 	                          = $row["signdate"];		
				//header("Location: ".WEB_DOMAIN);
                                                                                                             header("location:javascript:window.history.back()");
				exit();
                                                                                    }			
		}
		$sql->close();
	} 
	if($password_invalid)
		$msg='Vui lòng nhập Mật khẩu chính xác';
	if($username_invalid)
		$msg='Vui lòng nhập Tên đăng nhập chính xác';
	if($login_invalid)
		$msg='Tên đăng nhập hoặc Mật khẩu không chính xác';
}

function login(){
    global  $msg;
    echo '<div class="thecao login2">
                                <div class="left_login">
                                <h1>Đăng nhập hệ thống</h1>';
                                 echo $msg.'                                                                       
                                    <form method="post" action="'.WEB_DOMAIN.'/login.html">
                                      <!-- Login Fields -->
                                      <div id="login">Sử dụng thông tin bạn đăng kí để đăng nhập:<br/>
                                          <input type="text" name="user" placeholder="Số điện thoại" value="" class="login user"/>
                                          <input type=\'password\'  name="pass"  value=""  placeholder="Mật khẩu"  class="login password"/>
                                      </div>

                                      <!-- Green Button -->
                                      <div class="button green"><input type="submit" value="Đăng nhập"></div>
                                      <!-- Checkbox -->
                                    </form>
                               </div><!--left_login-->
                               <div class="right_login"><p>Nếu bạn chưa có tài khoản đăng nhập <a href="'.WEB_DOMAIN.'/register.html">Click vào đây</a> để đăng kí</p></div>
                    </div>
                 <div class="line_thecao"></div>';
}
            

?>