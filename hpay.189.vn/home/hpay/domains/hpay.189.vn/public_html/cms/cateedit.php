<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();

	if($_GET[mode] == "edit" && $_GET["pages"]=="cate")
	{
		$id = $_GET["id"];
		$select_query = "SELECT name  FROM ".DB_PREFIX."catalog  WHERE id_catalog = $id";
		$sql->query($select_query);
		$row = $sql->fetch_array();
		$catname = $row["name"];		
		$n = $sql->count_rows(DB_PREFIX."catalog");	
	}
	
	if($_POST[mode] == "edit"  && $_POST["pages"]=="cate")
	{
		$id = $_POST["id"];	
                                                    $catname = convert_font($_POST["catname"],2);
		$update_query = "UPDATE  ".DB_PREFIX."catalog  SET name='$catname' WHERE  id_catalog = $id";
		$sql->query($update_query);
		$sql->close();
		$message = "Cập nhật thành công !";
                                                     require_once("cate.php");
                                                    exit();
	}	
?>

<?php include("lib/header.php")?>
<div id="content">
<div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=cate">Quản lý danh mục </a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='success'>Success: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" /> Danh mục sản phẩm</h1>
      <form action=index.php method=post enctype="multipart/form-data" name="cateedit" id="cateedit">
      <div class="buttons">
            <input type="submit" value="Update" name="submit" class="submit1" > 
            <a onclick="javascript: window.history.back();" class="button">Cancel</a></div>
    </div>
    <div class="content">
       <div id="tab-general">
       <div id="language1">
            <table class="form">
              <tr>
                <td><span class="required">*</span> Tên danh mục:</td>
                <td><input type="text" name="catname" size="100" id="catname" value="<?=$catname?>" />
                  </td>
              </tr>           
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="cate">
        <input name="mode" type="hidden" id="mode" value="edit">
        <input name="id" type="hidden" id="id" value="<?=$id?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>

