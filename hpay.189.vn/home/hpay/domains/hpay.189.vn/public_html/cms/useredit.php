<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}	
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
                           $message1 = "";
             
	if($HTTP_GET_VARS["mode"] == "edit" && $HTTP_GET_VARS["pages"]=="user")
	{
		$id = $_GET["id"];
		$select_query = "SELECT fullname, user, pass,superuser, active FROM ".DB_PREFIX."users WHERE user = '$id'";
		$sql->query($select_query);
		$row = $sql->fetch_array();
		$fullname = $row["fullname"];
		$user = $row["user"];
		$superuser = $row["superuser"];
		$passtemp = $row["pass"];
		$active = $row["active"];					
	}
	
	if($HTTP_POST_VARS["mode"] == "edit" && isset($HTTP_POST_VARS["mode"]) && $HTTP_POST_VARS["pages"] == "user")
	{
		
		$id= $_POST["id"];
		$fullname 	= convert_font($_POST["fullname"]);
		$user 		= $_POST["user"];
		$oldpass 	= trim($_POST["oldpass"]);
		$pass 		= trim($_POST["pass"]);
		$repass 	= trim($_POST["repass"]);
		$passtemp   = $_POST["passtemp"];
		$superuser  = $_POST["superuser"];
		$active 	= isset($_POST["active"]) ? $_POST["active"] : 0;
		if($superuser==1) $active=1;
		
		if($fullname		== "") $message1 = $message1."<li/>Hãy nhập tên nhân viên quản trị";
		if($user 			== "") $message1 = $message1."<li/>Hãy nhập tên đăng nhập";

		if($message1=="" && $user!=$id)
		{
			$check_query = "SELECT user FROM ".DB_PREFIX."users WHERE user = '$user'";
			$sql->query($check_query);
			if($sql->num_rows()>0){
				$message1 = "<li/>Nhân viên quản trị này đã có. Nhập tên đăng nhập mới hoặc giữ tên đăng nhập cũ";			
				$user = $id;
			}
		}		

		if($HTTP_SESSION_VARS["super"]==0 || $superuser==1){
			if($oldpass == "") $message1 = $message1."<li/>Hãy nhập mật khẩu cũ để xác nhận việc cập nhật thông tin";	
				else	if(md5($oldpass) != $passtemp)
					$message1 = $message1."<li/>Mật khẩu cũ nhập không chính xác. Bạn hãy nhập lại";	
		}
		if(strlen($pass) <  4 && strlen($pass)) $message1 = $message1."<li/>Mật khẩu phải ít nhất là 4 ký tự";	
		if($pass		 != $repass && strlen($pass)>=4 ) $message1 = $message1."<li/>Mật khẩu mới nhập không chính xác. Bạn hãy nhập lại";	
		
		if($message1 == "" && $pass == $repass && strlen($pass)>=4)
			$pass = md5($pass);	
		else
			if($message1 == "") $pass= $passtemp;			
		if($message1 ==""){			
			$fullname = convert_font($_POST["fullname"],2);
			$update_query = "UPDATE ".DB_PREFIX."users SET fullname = '$fullname', user = '$user', pass = '$pass', active = $active WHERE user = '$id'";			
			if($sql->query($update_query)){
				$sql->close();
				$message = "<li>Update Successfull !";
				if($HTTP_SESSION_VARS['super']==0) $HTTP_SESSION_VARS['user'] = $user;				
				require_once("user.php");
				exit();
			}			
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
      <?php echo $update_query;?>
      <form action="index.php?pages=user&mode=edit&id=<?=$id?>" method="post" enctype="multipart/form-data" name="add" id="add">
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
                <td><span class="required">*</span>Old Password:</td>
                <td><INPUT name=oldpass type="password" class="input_f2" id="oldpass" value="<?=$oldpass?>">
                        <input name="passtemp" type="hidden" id="passtemp" value="<?=$passtemp?>">                    
                  </td>
              </tr> 
               <tr>
                <td><span class="required">*</span>New Password:</td>
                <td>
                    <input name="pass" type="password" size="50" value="<?=$pass?>" />
                  </td>
              </tr>        
              <tr>
                <td><span class="required">*</span>Re Password:</td>
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
        <input name="pages" type="hidden" id="pages" value="user">
        <input name="mode" type="hidden" id="mode" value="edit">
        <input name="id" type="hidden" id="id" value="<?=$id?>">
        <input name="superuser" type="hidden" id="superuser" value="<?=$superuser?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>

