<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();
	//lay  mang chu de sach
	if($HTTP_GET_VARS[mode] == "edit"){
		$id = $HTTP_GET_VARS["id"];
		$select_query = "SELECT * FROM linkseo WHERE id = '$id'";

		$sql->query($select_query);
		$row = $sql->fetch_array();
		$keyword 		= $row["keyword"];
		$publish 		= $row["publish"];
		$linkweb 		= $row["linkweb"]; 
		$list_order 	= $row["list_order"];
		$position_page 	= $_GET["position_page"];
		$n = $sql->count_rows("linkseo");	
	}	
	
	if($HTTP_POST_VARS[mode] == "edit"){

		$id 		= $_POST["id"];		
		$keyword	 	= isset($_POST["keyword"])		? convert_font($_POST["keyword"])		: '';
		$linkweb	 	= isset($_POST["linkweb"])		? convert_font($_POST["linkweb"])		: '';
		$position_page = $_POST["position_page"];				
		if($linkweb 		== "") $message1 = $message1."Hãy nhập liên kết";		
		
		//Bat dau chen DL vao CSDL		
		if($message1 ==""){			
			$linkweb 		= convert_font($_POST["linkweb"],2);
			$keyword 		= convert_font($_POST["keyword"],2);
			$publish		= $_POST["publish"]==1?$_POST["publish"]:0;
			$list_order		= $_POST["list_order"];
			
			$update_query = "UPDATE linkseo SET keyword='$keyword', linkweb='$linkweb', publish=$publish, list_order=$list_order WHERE id='$id'";		
			if($sql->query($update_query)){
				$sql->close();
				$message = $message."Cập nhật thành công !";
				include_once("linkseo.php");
				exit();
			}
		}
	}			
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
            <a href="/">Home</a>
            :: <a href="index.php?pages=linkseo">Quản lý từ khóa </a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" /> Sửa từ khóa </h1>
      
      <form action=index.php method=post enctype="multipart/form-data" name="addlinkseo" id="addlinkseo">
      <div class="buttons"><input type="submit" value="Cập nhật" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
      <div id="tab-general">
          <div id="languages" class="htabs"><a href="#language1"><img src="images/gb.png" title="English" /> English</a></div>
            <div id="language1">        
            <table class="form">
              <tr>
                <td><span class="required">*</span> Text:</td>
                <td><input type="text" name="keyword" size="100" id="keyword" value="<?=$keyword?>" />
                  </td>
              </tr>
            <tr>
                <td><span class="required">*</span>Link:</td>
                <td><input type="text" name="linkweb" size="100" id="linkweb" value="<?=$linkweb?>" />
                  </td>
              </tr>
              <tr>
              <td>Hiển thị:</td>
              <td>
                  <INPUT name="publish" type="checkbox" id="publish" style="FLOAT: left" value=1 <?=$publish==1?"checked":""?>>
              </td>
            </tr>
              <td>Order:</td>
              <td>
                  <SELECT name="list_order" size="1" id="list_order">
                         <?php  
                         for($i=1; $i<=$n; $i++){
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
        <input name="pages" type="hidden" id="pages" value="linkseo">
        <input name="mode" type="hidden" id="mode" value="edit">
        <input name="position_page" type="hidden" id="tinid_old" value="<?=$position_page?>">
        <input name="id" type="hidden" id="id" value="<?=$id?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>
