<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$mode = $HTTP_POST_VARS[mode];
	if($mode == "login"){
		
		$user = trim($HTTP_POST_VARS[user]);
		$pass = trim($HTTP_POST_VARS[pass]);
		if($user == "") $message = $message."<li/>H&atilde;y nh&#7853;p t&ecirc;n t&agrave;i kho&#7843;n";
		if($pass == "") $message = $message."<li/>H&atilde;y nh&#7853;p m&#7853;t kh&#7849;u";	
		if($message ==""){
			$sql = new db_sql();
			$sql->db_connect();
			$sql->db_select();
			$select_query = "SELECT user, FullName,  pass, active, superuser FROM kien_users WHERE user ='$user' AND pass = md5('$pass') AND active=1";
			$sql->query($select_query);
			$row = $sql->fetch_array();
			$supperuser = $row["superuser"]==1 ? 1:0;
                        $FullName 	= $row["FullName"];
			if(($sql->num_rows()==1)){					
				$logon = time();
				session_register("login");
				$HTTP_SESSION_VARS['login']="true";
				$HTTP_SESSION_VARS['user_admin']=$user;
				$HTTP_SESSION_VARS['super']=$supperuser;
                                $HTTP_SESSION_VARS['FullName']=$FullName;
				$update_query = "UPDATE kien_users SET logon=$logon WHERE user='$user'";
				$sql->query($update_query);						
				include("welcome.php");
				$sql->close();
				exit();
			}else{
				$message = "Tên truy cập hoặc mật khẩu không đúng.";
			}		
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<title>Administration</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="en-us" />
<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
</head>
<body>
<div id="container">
<div id="header">
  <div class="div1">
    <div class="div2"><img src="images/logo.png" title="Administration" onclick="location = '#'" /></div>
      </div>
  </div>
<div id="content">
  <div class="box" style="width: 400px; min-height: 300px; margin-top: 40px; margin-left: auto; margin-right: auto;">
    <div class="heading">
      <h1><img src="images/lockscreen.png" alt="" /> Administrator Login.</h1>
    </div>
    <div class="content" style="min-height: 150px; overflow: hidden;">
        <form method="post" action="index.php">
        <table style="width: 100%;">
          <tr>
            <td style="text-align: center;" rowspan="4"><img src="images/login.png" alt="Đăng nhập quản trị." /></td>
          </tr>
          <tr>
            <td>Username:<br />
              <input type="text" name="user" value="<?php echo $user ?>" style="margin-top: 4px;" />
              <br />
              <br />
              Password:<br />
              <input type="password" name="pass" value="<?php echo $pass ?>" style="margin-top: 4px;" />
              <br /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: right;"><input name="Login" type="submit" class="button" id="Login" value="Login"></td>
          </tr>
        </table>
        <input type="hidden" value="login" name="mode">
       </form>
    <?php if($message!="") echo "<script> alert ('$message');location='index.php';</script>"; ?>
    </div>
  </div>
</div>
</div>
<?php include("footer.php")?>
</body>
</html>
