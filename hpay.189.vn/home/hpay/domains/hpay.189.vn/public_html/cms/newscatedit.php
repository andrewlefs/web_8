<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();

	if($HTTP_GET_VARS[mode] == "edit")
	{
		$id = $_GET["id"];
		$select_query = "SELECT name, publish, list_order FROM ".DB_PREFIX."newscat WHERE id_newscat = $id";
		$sql->query($select_query);
		$row = $sql->fetch_array();
		$title = $row["name"];
		$publish = $row["publish"];
		$list_order = $row["list_order"];
		$n = $sql->count_rows(DB_PREFIX."newscat");	
	}
	
	if($HTTP_POST_VARS[mode] == "edit")
	{
		$id1232 = $_POST["id"];
		$title = convert_font($_POST["title"],2);
		$publish = $_POST[publish]==1?$_POST[publish]:0;
		$list_order = $_POST[list_order];
		$update_query = "UPDATE ".DB_PREFIX."newscat SET name='$title', publish=$publish, list_order=$list_order  WHERE id_newscat = $id1232";

		$sql->query($update_query);
		$sql->close();
		$message = "Cập nhật thành công !";
		require_once("newscat.php");
		exit();
	}	
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
            <a href="/">Home</a>
            :: <a href="index.php?pages=newscat">Quản lý Nhà sản xuất</a>
     </div>
    <?php if($message!="") echo "<div class='warning'>Warning: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" /> Nhà sản xuất</h1>
      
      <form action=index.php method=post enctype="multipart/form-data" name="nsxedit" id="nsxedit">
      <div class="buttons"><input type="submit" value="Cập nhật" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
     <div id="tab-general">
        <div id="language1">        
            <table class="form">
              <tr>
                <td><span class="required">*</span>Tên danh mục tin:</td>
                <td><input type="text" name="title" size="100" id="title" value="<?=$title?>" />
                  </td>
              </tr>
          
              <tr>
                <td><span class="required">*</span>Hiển thị: </td>
                <td><INPUT name="publish" type=checkbox id="publish" style="FLOAT: left" value=1 <?=$publish==1?"checked":""?>>
                  </td>
              </tr>
                <tr>
                <td><span class="required">*</span>Thứ tự hiển thị:</td>
                <td>
                    <SELECT name=list_order size=1 id="list_order">
                         <?php  
                         for($i=1; $i<$n+1; $i++){
                                if ($i == $list_order){
                         ?>
                            <OPTION value="<?=$i?>" selected><?=$i?></OPTION>                            
                         <?php }else { ?>
                            <OPTION value="<?=$i?>"><?=$i?></OPTION>
                         <?php }}?>
                    </SELECT>
                  </td>
              </tr>
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="newscat">
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
