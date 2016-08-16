<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}	
	if($HTTP_GET_VARS["mode"] == "edit" && $HTTP_GET_VARS["pages"]=="yahoo")
	{
		$id = $_GET[id];
		$select_query = "SELECT yahooname, nickname FROM ".DB_PREFIX."yahoo WHERE id = $id";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($select_query);
		$row 	= $sql->fetch_array();
		$yahooname  = $row["yahooname"];
		$nickname   = $row["nickname"];
	}
	if($HTTP_POST_VARS["mode"] == "edit" && $HTTP_POST_VARS["pages"]=="yahoo")
	{
		$id = $_POST["id"];
		$yahooname  = convert_font($_POST["yahooname"],2);
		$nickname   = convert_font($_POST["nickname"],2);
		$update_query = "UPDATE ".DB_PREFIX."yahoo SET yahooname='$yahooname', nickname='$nickname' WHERE id = $id";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($update_query);
		$sql->close();
		$message = "Cập nhật thông tin thành công !";		
		require_once("yahoo.php");
		exit();
	}
	
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=yahoo">Yahoo</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Success: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Yahoo</h1>
      
      <form action=index.php method=post enctype="multipart/form-data" name="yahooedit" id="yahooedit">
      <div class="buttons"><input type="submit" value="Thêm" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
      <div id="tab-general">
        <div id="language1">
            <table class="form">
              <tr>
                <td><span class="required">*</span>Yahoo name:</td>
                <td><input type="text" name="yahooname" size="40"  value="<?=$yahooname?>" />
                  </td>
              </tr>
                <tr>
                <td><span class="required">*</span>Nick name:</td>
                <td><input type="text" name="nickname" size="40"  value="<?=$nickname?>" />
                  </td>
              </tr>
              
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="yahoo">
        <input name="mode" type="hidden" id="mode" value="edit">
        <input name="id" type="hidden" id="id" value="<?=$id?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
