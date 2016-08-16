<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();
	
	if($_GET[mode] == "edit"){
		$n = $sql->count_rows(DB_PREFIX."bankinfo");
		$id1 = $_GET["id"];
		$select_query = "SELECT * FROM ".DB_PREFIX."bankinfo WHERE Id = '$id1' ";

		$sql->query($select_query);
		$row = $sql->fetch_array();
		$link 	= $row["url"];
		$tieude = $row["Title"];
		$logocu = $row["Logo"] <> "" ? "<img src='".$dir_imglogos.$row["Logo"]."'  style='border: 1px solid #000000; padding: 0px; width:200px; height:100x;'>" : 'Ngân hàng này chưa có ảnh'; 	
		$imgtemp 	= $row["Logo"];	
		$hienthi  = $row["Published"];
	}	

        
	if($_POST["mode"] == "edit" && isset($_POST["mode"]) && $_POST["pages"] == "network")
	{
		$n = $sql->count_rows(DB_PREFIX."bankinfo");
		$id 	= $_POST["id1"];								
		$link 	= convert_font(trim($_POST["link"]));
		$tieude = convert_font($_POST["tieude"],2);
		$logo1 	= isset($_FILES["logo1"]["name"]) 		? $_FILES["logo1"]["name"]		 : '';
		$logocu 		= $_POST["logocu"] <> "" 		? stripslashes($_POST["logocu"]) : '';
		$imgtemp 	= $_POST["imgtemp"];
		$hienthi  = isset($_POST['hienthi']) ? $_POST["hienthi"] : "1";
		if($tieude == "") $message1 = $message1."Hãy nhập tiêu đề cho logo";
                
		//bat dau thuc hien upload logo len thu muc tren may chu WEB		
		if ( !empty($logo1)){
			$filename = "";
	       	$start = strpos($logo1,".");
			$type  = substr($logo1,$start,strlen($logo1));
			if ((strtolower($type)!=".gif")&&(strtolower($type)!=".jpg")  &&(strtolower($type)!=".png")){
				$message1 = "Tệp ảnh bìa phải có kiểu tệp là .jpg hoặc .gif hoặc .png";             
	        }
			else
				if($message1==""){
		    		$filename = time().$type;
                                                                                                                    if ( !(copy($_FILES['logo1']['tmp_name'], $dir_imglogos.$filename)) ) die("Cannot upload file.");
                                                                                                                            $file_path = $dir_imglogos.$imgtemp;
                                                                                                                            if($imgtemp!="" && file_exists($file_path))	unlink("$file_path");						
				}			
		}
		else
			if(empty($logo1)) $filename=$imgtemp;
		
		if($message1 =="")		
		{			
			$update_query = "UPDATE ".DB_PREFIX."bankinfo SET Logo='$filename', url='$link', Title='$tieude', Published = $hienthi WHERE Id='$id'";
			if($sql->query($update_query)){
				$sql->close();
				$message = $message."Update Successfull !";
				include_once("network.php");
				exit();
			}			
		}
	}	
?>

<?php include("lib/header.php")?>
<div id="content">
<div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=network">Quản lý danh mục </a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='success'>Success: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" /> Danh mục ngân hàng</h1>
      <form action=index.php method=post enctype="multipart/form-data" name="cateedit" id="cateedit">
      <div class="buttons">
            <input type="submit" value="Update" name="submit" class="submit1" > 
            <a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
       <div id="tab-general">
       <div id="language1">
            <table class="form">
            <tr>
                    <td><span class="required">*</span>Tên ngân hàng</td>
                    <td><input type="text" name='tieude'  id="tieude" value="<?=$tieude?>" size="100" /></td>
                </tr>
                <tr>
                    <td>Logo cũ</td>
                    <td>
                        <?=$logocu?>
                    </td>
                </tr>
                <tr>
                    <td>Logo mới</td>
                    <td>
                        <input name="logo1" type="file" class="input_b2" id="logo1" value="<?=$logo1?>" size="32">
                    </td>
                </tr>
                <tr>
                    <td><span class="required">*</span>Link</td>
                    <td>
                        <input name="link" type="text" id="link" value="<?=$link?>" size="32" >
                    </td>
                </tr>
            <tr>
              <td>Hiển thị:</td>
              <td><input name="hienthi" type="checkbox" id="hienthi" value="1" <?=$hienthi==1?"checked":""?> />
              </td>
            </tr>
          
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="network">
        <input name="mode" type="hidden" id="mode" value="edit">
          <input name="logocu" type="hidden" id="mode3" value="<?=$logocu?>">
        <input name="imgtemp" type="hidden" id="mode3" value="<?=$imgtemp?>">
        <input name="id1" type="hidden" id="id1" value="<?=$id1?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>

