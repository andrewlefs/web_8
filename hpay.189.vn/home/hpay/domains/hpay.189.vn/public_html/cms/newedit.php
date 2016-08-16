<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();
	$newscat = array();
        
	//get info of news category
//	$select_query = "SELECT id, title FROM newscat WHERE publish=1 ORDER BY list_order, title";
//	$sql->query($select_query);
//	$i = 0;
//	while($rows = $sql->fetch_array()){
//		$i = $i + 1;
//		$newscat[$i]["id"] 	= $rows["id"];
//		$newscat[$i]["title"] 	= $rows["title"];	
//	}
	//lay  mang chu de sach
	if($HTTP_GET_VARS[mode] == "edit"){
		$id = $HTTP_GET_VARS["id"];
		$select_query = "SELECT tieude, trichdan, anhtin,  publish FROM ".DB_PREFIX."tintuc WHERE tinid = '$id'";
		$sql->query($select_query);
		$row = $sql->fetch_array();
		$tieude 	= convert_font($row["tieude"]);
		$trichdan	= convert_font($row["trichdan"],2);
		
		$frontpage 	= $row['publish'];
		$anhcu 		= $row["anhtin"] <> "" ? "<img src='".$dir_imgnews.$row["anhtin"]."'  style='border: 1px solid #000000; padding-left: 0; padding-right: 0; padding-top: 0px; padding-bottom: 0px'>" : 'Tin này chưa có ảnh'; 	
		$imgtemp 	= $row["anhtin"];
		//$newscat_id	= $row["newscat_id"];
		$position_page = $_GET["position_page"];
	}	
	
	if($HTTP_POST_VARS[mode] == "edit"){

		$id 		= $_POST["id"];		
		$tieude 	= isset($_POST["tieude"])			? convert_font($_POST["tieude"])		: '';
		$tieudeanh 	= isset($_POST["tieude"])			? cut_space(catdau_admin($_POST["tieude"]))		: '';
		$trichdan	= isset($_POST["trichdan"])			? convert_font($_POST["trichdan"])		: '';		
//		$nguontin 	= isset($_POST["nguontin"])			? convert_font($_POST["nguontin"])		: '';	
//		$tags 		= isset($_POST["tags"])				? convert_font($_POST["tags"])			: '';		
		$anhtin 	= isset($_FILES["anhtin"]["name"]) 		? $_FILES["anhtin"]["name"]				: '';
		$frontpage 	= isset($_POST["frontpage"])			? $_POST["frontpage"]					: '0';
		$anhcu 		= $_POST["anhcu"] <> "" 			? stripslashes($_POST["anhcu"]) : '';
		$imgtemp 	= $_POST["imgtemp"];
		//$newscat_id	= $_POST["newscat_id"];
		$position_page = $_POST["position_page"];
				
		if($tieude 		== "") $message1 = $message1."Hãy nhập tiêu đề tin";		
		//if($newscat_id 	== 0) $message1 = $message1."Hãy chọn một nhóm tin";
	
		//bat dau thuc hien upload anh bia len thu muc tren may chu WEB		
		if ( !empty($anhtin)){
			$filename = "";
	       	$start = strpos($anhtin,".");
			$type  = substr($anhtin,$start,strlen($anhtin));
			if ((strtolower($type)!=".gif")&&(strtolower($type)!=".jpg")){
				$message1 = "<li/>Tệp ảnh bìa phải có kiểu tệp là .jpg hoặc .gif";             
	        }
			else{
				if($message1==""){
		    	    	$filename = $tieudeanh."-".time().$type;
	        			if ( !(copy($_FILES['anhtin']['tmp_name'], $dir_imgnews.$filename)) ) die("Cannot upload file.");
						$file_path = $dir_imgnews.$imgtemp;
						if($imgtemp!="" && file_exists($file_path))	unlink("$file_path");						
			     }
			}	
		}
		else{
			if(empty($anhtin)) $filename=$imgtemp;
		}   
		//Bat dau chen DL vao CSDL		
		if($message1 ==""){			
			$tieude 	= convert_font($_POST["tieude"],2);
			//$nguontin 	= convert_font($_POST["nguontin"],2);
			$trichdan 	= convert_font($_POST["trichdan"],2);			
			//$tags 		= convert_font($_POST["tags"],2);
			$update_query = "UPDATE ".DB_PREFIX."tintuc SET tieude='$tieude', trichdan='$trichdan', anhtin='$filename', 
							publish=$frontpage  WHERE tinid='$id'";
		
			if($sql->query($update_query)){
				$sql->close();
				$message = $message."Cập nhật thành công !";
				include_once("new.php");
				exit();
			}
		}
	}			
?>
<?php include("lib/header.php")?>
<script language="javascript">
function validateForm(){
	if (document.getElementById("newscat_id").value > 0)
		return true;
	else
	{
		alert("Xin hãy chọn một Nhóm tin");
		return false;
	}
}
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=new">Category</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Sửa nội dung bài viết</h1>
      <form action="index.php?pages=new&mode=edit" method="post" enctype="multipart/form-data" name="edit" id="edit">
      <div class="buttons"><input type="submit" value="Lưu" name="submit" class="submit1" ><input name="Reset" type="reset" class="submit1" value="Reset"></div>
    </div>
    <div class="content">
        <div id="tab-general">
          <div id="language1">
            <table class="form">
            <!--    <tr>
                <td><span class="required">*</span>Sub Danh mục tin:</td>
                <td><? if(!empty($subnews)){ ?>
			<select name="sn_id" class="input_b3" id="sn_id" >
                                <?php
				for($i=1;$i<=count($newscat);$i++)
				if($newscat_id == $newscat[$i]["id"])
				echo "<option selected value='".$newscat[$i]["id"]."' >".$newscat[$i]["title"]."</option>";
				else
				echo "<option value='".$newscat[$i]["id"]."'>".$newscat[$i]["title"]."</option>";
				?>
                        </select>  
                  <? }?> 
                  </td>
              </tr>-->
              <tr>
                <td><span class="required">*</span>Ti&ecirc;u &#273;&#7873; tin:</td>
                <td><input type="text" name="tieude" size="100" id="tieude" value="<?=$tieude?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Ảnh cũ:</td>
                <td><?=$anhcu?></td>
              </tr>
              <tr>
                <td><span class="required">*</span>Ảnh minh họa:</td>
                <td><input name="anhtin" type="file" class="input_b2" id="anhtin" value="<?=$anhbia?>" size="32">
                  </td>
              </tr>
               <tr>
                <td><span class="required">*</span>Trích dẫn:</td>
                <td><textarea id="elm2" name="trichdan" rows="20" cols="40" style="width:99%"><?=$trichdan?></textarea>
                  </td>
              </tr>
          <!--    <tr>
                <td><span class="required">*</span>Tags:</td>
                <td><input type="text" name="tags" size="100" id="tags" value="<?=$tags?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Nguồn tin:</td>
                <td><input type="text" name="nguontin" size="100" id="nguontin" value="<?=$nguontin?>" />
                  </td>
              </tr>-->
              
              <tr>
                <td><span class="required">*</span>Trạng thái:</td>
                <td>
                    <select name="frontpage" size=1 id="frontpage">
                        <option value="1"<? echo ($frontpage==1?"selected":"") ?>>Yes</option>
                        <option value="0"<? echo ($frontpage==0?"selected":"") ?>>No</option>
                    </select>
                  </td>
              </tr>
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="new">
        <input name="mode" type="hidden" id="mode" value="edit">
      <!--  <input name="newscat_id" type="hidden" id="newscat_id" value="<?=$newscat_id?>">-->
        <input name="anhcu" type="hidden" id="mode3" value="<?=$anhcu?>">
        <input name="imgtemp" type="hidden" id="mode3" value="<?=$imgtemp?>">
        <input name="position_page" type="hidden" id="tinid_old" value="<?=$position_page?>">
        <input name="id" type="hidden" id="id" value="<?=$id?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
