<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();

	if($_GET[mode] == "edit"){
		$id = $_GET["id"];
		$select_query = "SELECT memberid, user, pass, fullname, phone, workphone, email, address FROM member WHERE memberid = '$id'";

		$sql->query($select_query);
		$row = $sql->fetch_array();
		$memberid 	= $row["memberid"];
		$pass 		= $row["pass"]; 
		$user 		= $row["user"]; 
		$fullname 	= $row["fullname"]; 
		$phone 		= $row["phone"];
		$workphone 	= $row["workphone"]; 
		$email 		= $row["email"];
		$address 	= $row["address"];
		$position_page = $_GET["position_page"];
	}	
	
	if($_POST[mode] == "edit"){

		$id 		= $_POST["id"];		
		$pass 		= isset($_POST["pass"])			? ($_POST["pass"])			: '';
		$user 		= isset($_POST["user"])			? ($_POST["user"])			: '';
		$fullname 	= isset($_POST["fullname"])		? ($_POST["fullname"])		: '';
		$phone 		= isset($_POST["phone"])		? ($_POST["phone"])			: '';
		$workphone 	= isset($_POST["workphone"])	? ($_POST["workphone"])		: '';
		$email 		= isset($_POST["email"])		? ($_POST["email"])			: '';
		$address 	= isset($_POST["address"])		? ($_POST["address"])		: '';
		$position_page = $_POST["position_page"];
				
		if($user 		== "") $message1 = $message1."<li/>Hãy nhập tên đăng nhập";		
		if($pass 	== "") $message1 = $message1."<li/>Hãy nhập mật khẩu";
	
		if($message1 ==""){			
			$pass 		= $_POST["pass"];
			$user 		= $_POST["user"];
			$fullname 	= $_POST["fullname"];
			$phone 		= $_POST["phone"];
			$workphone 	= $_POST["workphone"];
			$email 		= $_POST["email"];
			$address 	= $_POST["address"];		

			$update_query = "UPDATE member SET pass='$pass', user='$user', 
							 fullname='$fullname', phone='$phone', workphone='$workphone', email='$email', address='$address' WHERE memberid='$id'";
		
			if($sql->query($update_query)){
				$sql->close();
				$message = $message."Cập nhật thành công !";
				include_once("member.php");
				exit();
			}
		}
	}			
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
            <a href="/">Home</a>
            :: <a href="index.php?pages=member">Quản lý thành viên</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" /> Thành viên</h1>
      
      <form action="index.php?pages=member&mode=edit" method="post" enctype="multipart/form-data" name="editmember" id="editmember" onSubmit="return submitForm();">
      <div class="buttons"><input type="submit" value="Cập nhật" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
      <div id="tab-general">
          <div id="languages" class="htabs"><a href="#language1"><img src="images/gb.png" title="English" /> English</a></div>
            <div id="language1">        
            <table class="form">
              <tr>
                <td><span class="required">*</span> Tên khách hàng:</td>
                <td><input type="text" name="fullname" cols="40" value="<?=$fullname?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Username:</td>
                <td><input type="text" name="user" cols="40" value="<?=$user?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Password:</td>
                <td><input type="password" name="pass" cols="40" value="<?=$pass?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Email:</td>
                <td><input type="text" name="email" size="40" id="email" value="<?=$email?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Mobile:</td>
                <td><input type="text" name="phone" size="40" id="phone" value="<?=$phone?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Phone number:</td>
                <td><input type="text" name="workphone" size="40" id="workphone" value="<?=$workphone?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Địa chỉ:</td>
                <td><textarea name="address" cols="60" rows="5" value="<?=$address?>"><?=$address?></textarea>
                  </td>
              </tr>
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="member">
        <input name="mode" type="hidden" id="mode" value="edit">
        <input name="position_page" type="hidden" id="position_page" value="<?=$position_page?>">
        <input name="id" type="hidden" id="id" value="<?=$id?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>
