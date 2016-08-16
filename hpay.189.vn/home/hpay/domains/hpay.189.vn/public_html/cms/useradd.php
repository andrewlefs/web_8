<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
                            $module_name = 'Quản trị';
	if($HTTP_POST_VARS["mode"] == "add" && isset($HTTP_POST_VARS["mode"]) && $HTTP_POST_VARS["pages"] == "user" && $HTTP_SESSION_VARS["super"]==1)
	{
		if(!session_register('countadd'))
		{
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}				
		$fullname = convert_font($_POST["fullname"]);
		$user = 	trim($_POST["user"]);
		$pass = 	trim($_POST["pass"]);
		$repass = 	trim($_POST["repass"]);
		$active = 	isset($_POST["active"]) ? $_POST["active"] : 0;
		
		if($fullname		== "") $message1 = $message1."Hãy nhập tên nhân viên quản trị";
		if($user 			== "") $message1 = $message1."Hãy nhập tên đăng nhập";
		if($pass 			== "") $message1 = $message1."Hãy nhập mật khẩu";
		if($repass		 	== "") $message1 = $message1."Hãy nhập lại mật khẩu";
		if(strlen($pass)	<  4 ) $message1 = $message1."Mật khẩu phải ít nhất là 4 ký tự";
		if($pass		 != $repass) $message1 = $message1."Mật khẩu nhập không chính xác. Bạn hãy nhập lại";
		
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();	
		if($massage1=="")
		{
			$check_query = "SELECT user FROM ".DB_PREFIX."users WHERE user = '$user'";
			$sql->query($check_query);
			if($sql->num_rows()>0) $message1 = "Nhân viên quản trị này đã có. Yêu cầu bạn nhập tên đăng nhập khác";			
		}
		if($message1 =="")		
		{			
			$fullname = convert_font($_POST["fullname"],2);
			$insert_query = "INSERT INTO ".DB_PREFIX."users(fullname, tmpname, user, pass, active) VALUES('$fullname', '$fullname','$user', md5('$pass'), $active)";			
			if($sql->query($insert_query))
			{			
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;				 
				$message = "Thông tin về nhân viên quản trị thứ  ".$HTTP_SESSION_VARS['countadd']." đã được thêm vào CSDL";			
				unset($fullname, $user, $pass, $repass);
			}	
							
		}
	}	
	else{
		unset($fullname, $user, $pass, $repass);
		if($HTTP_SESSION_VARS["super"]==0){
			$message ="Bạn không có quyền thêm các nhân viên sử dụng !<br>";
			require_once("user.php");
			exit();		
		}
	}
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>:: <a href="index.php?pages=<?= $pages ?>"><?= $module_name ?></a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Thêm <?= $module_name ?></h1>
      
      <form action="index.php?pages=<?= $pages ?>&mode=add" method="post" enctype="multipart/form-data" name="add" id="add">
      <div class="buttons"><input type="submit" value="Lưu" name="submit" class="submit1" ><input name="Reset" type="reset" class="submit1" value="Reset"></div>
    </div>
    <div class="content">
        <div id="tab-general">
          <div id="language1">
            <table class="form">
            <tr>
                <td><span class="required">*</span>Full Name:</td>
                <td><input type="text" name="fullname" size="50" value="<?=$fullname?>" />
                  </td>
              </tr>

             <tr>
                <td><span class="required">*</span>User Name:</td>
                <td><input type="text" name="user" size="50" value="<?=$user?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Password:</td>
                <td><input name="pass" type="password" size="50" value="<?=$pass?>" />
                  </td>
              </tr>             
              <tr>
                <td><span class="required">*</span>Re Pass:</td>
                <td><input name="repass" type="password" size="50" value="<?=$repass?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Active:</td>
                <td><input name="active" type="checkbox" id="active" value="1" checked>
                  </td>
              </tr>
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="<?= $pages ?>">        
        <input name="mode" type="hidden" id="mode" value="add">	
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
