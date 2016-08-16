<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();	
	$sql->db_select();	
        $module_name    = 'Gói website';
        $UserId         = $HTTP_SESSION_VARS['user_admin'];
	if($HTTP_GET_VARS[mode] == "edit"){
		$id = $HTTP_GET_VARS["id"];
		$select_query = "SELECT * FROM ".DB_PREFIX."intro WHERE id_intro = '$id'";

		$sql->query($select_query);
		$row = $sql->fetch_array();
		$menu_title 	= $row["title_menu"];
		$publish 	= $row["publish"];
               		$title 		= $row["title"]; 
		$content 	= $row["content"]; 
		$list_order 	= $row["list_order"];
		$position_page 	= $_GET["position_page"];
		$n = $sql->count_rows(DB_PREFIX."intro");	
	}	
	
	if($HTTP_POST_VARS[mode] == "edit"){

		$id 		= $_POST["id"];		
		$menu_title	= isset($_POST["menu_title"])	? convert_font($_POST["menu_title"])	: '';
		$title	 	= isset($_POST["title"])	? convert_font($_POST["title"])		: '';
		$content 	= isset($_POST["content"])	? convert_font($_POST["content"])	: '';
		
		$position_page = $_POST["position_page"];
				
		if($title 		== "") $message1 = $message1."Hãy nhập tiêu đề";		
		if($content 	== "") $message1 = $message1."Hãy nhập nội dung";
	
		
		//Bat dau chen DL vao CSDL		
		if($message1 ==""){			
			$title 		= convert_font($_POST["title"],2);
			$content	= convert_font($_POST["content"],2);
			$menu_title     = convert_font($_POST["menu_title"],2);
			$publish        = $_POST["publish"]==1?$_POST["publish"]:0;
                    
			$list_order     = $_POST["list_order"];
                        $UserId 	= $_POST["UserId"];
			
			$update_query = "UPDATE ".DB_PREFIX."intro SET title='$title',content='$content', title_menu='$menu_title', publish='$publish', list_order='$list_order' WHERE id_intro='$id'";		
			if($sql->query($update_query)){
				$sql->close();
				$message = $message."Cập nhật thành công !";
				include_once("intro.php");
				exit();
			}
		}
	}			
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=<?= $pages ?>"><?= $module_name ?></a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Sửa <?= $module_name ?></h1>
      <form action="index.php?pages=<?= $pages ?>&mode=edit" method="post" enctype="multipart/form-data" name="edit" id="edit">
      <div class="buttons"><input type="submit" value="Lưu" name="submit" class="submit1" ><input name="Reset" type="reset" class="submit1" value="Reset"></div>
    </div>
    <div class="content">
        <div id="tab-general">
          <div id="language1">
            <table class="form">
          
              <tr>
                <td><span class="required">*</span>Tiêu đề trên Menu:</td>
                <td><input type="text" name="menu_title" size="50" value="<?=$menu_title?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Tiêu đề:</td>
                <td><input type="text" name="title" size="100" value="<?=$title?>" />
                  </td>
              </tr>
                  <tr>
                <td><span class="required">*</span>Bài viết:</td>
                <td><textarea id="elm2" name="content" rows="15" cols="80" style="width: 98%"><?=$content?></textarea>
                  </td>
              </tr>
             <tr>
                <td><span class="required">*</span>Status:</td>
                <td>
                    <select name="publish" size=1 id="publish">
                        <option value="1"<? echo ($publish==1?"selected":"") ?>>Yes</option>
                        <option value="0"<? echo ($publish==0?"selected":"") ?>>No</option>
                    </select>
                  </td>
              </tr>
           <!--   <tr>
                <td><span class="required">*</span>Giới thiệu:</td>
                <td>
                    <select name="Gioithieu" size=1 id="publish">
                        <option value="1"<? echo ($Gioithieu==1?"selected":"") ?>>Yes</option>
                        <option value="0"<? echo ($Gioithieu==0?"selected":"") ?>>No</option>
                    </select>
                  </td>
              </tr> -->
              <tr>
                <td><span class="required">*</span>Thứ tự:</td>
                <td>
                    <SELECT name="list_order">
                  <?php  
                     for($i=1; $i<$n+1; $i++){
                            if ($i == $thutu){
                     ?>
                  <OPTION value=<?=$i?> selected><?=$i?></OPTION>
                  <?php }else { ?>
                  <OPTION value=<?=$i?>><?=$i?></OPTION>
                  <?php }}?>
                </SELECT>
                </td>
              </tr>
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="<?= $pages ?>">
        <input name="mode" type="hidden" id="mode" value="edit">
        <input name="UserId" type="hidden" id="UserId" value="<?=$UserId?>">
        <input name="id" type="hidden" id="id" value="<?=$id?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
