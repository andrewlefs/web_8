<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}	
	if($HTTP_GET_VARS["mode"] == "edit" && $HTTP_GET_VARS["pages"]=="curr")
	{
		$id = $_GET[id];
		$select_query = "SELECT name, rate FROM currency WHERE currencyid = $id";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($select_query);
		$row 	= $sql->fetch_array();
		$name = $row["name"];
		$rate = $row["rate"];
	}
	if($HTTP_POST_VARS["mode"] == "edit" && $HTTP_POST_VARS["pages"]=="curr")
	{
		$id = $_POST["id"];
		$name = convert_font($_POST["name"],2);
		$rate = $_POST["rate"];
		$update_query = "UPDATE currency SET name='$name', rate='$rate' WHERE currencyid = $id";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($update_query);
		$sql->close();
		$message = "Cập nhật thông tin thành công !";		
		require_once("curr.php");
		exit();
	}
	
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
            <a href="/">Home</a>
            :: <a href="index.php?pages=curr">Quản lý đơn vị tiền tệ </a>
     </div>
    <?php if($message!="") echo "<div class='warning'>Warning: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Sửa đơn vị tiền tệ</h1>
      
      <form action=index.php method=post enctype="multipart/form-data" name="nsxedit" id="nsxedit" onSubmit="return numberValidation(document.getElementById('rate'))">
      <div class="buttons"><input type="submit" value="Cập nhật" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
         <div id="tab-general">
          <div id="languages" class="htabs"><a href="#language1"><img src="images/gb.png" title="English" /> English</a></div>
            <div id="language1">        
            <table class="form">
              <tr>
                <td><span class="required">*</span> Tên loại tiền:</td>
                <td><input type="text" name="name" size="100" id="name" value="<?=$name?>" />
                  </td>
              </tr>
                <tr>
                <td><span class="required">*</span>Tỷ giá so với USD:</td>
                <td><input type="text" name="rate" size="100" id="rate" value="<?=$rate?>" />
                  </td>
              </tr>
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="curr">
        <input name="mode" type="hidden" id="mode" value="edit">
	<input name="id" type="hidden" id="id" value="<?=$id?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>
