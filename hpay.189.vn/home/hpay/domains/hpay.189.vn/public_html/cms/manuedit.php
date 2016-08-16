<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}	
	if($HTTP_GET_VARS["mode"] == "edit" && $HTTP_GET_VARS["pages"]=="manu")
	{
		$id_manu = $_GET[id];
		$select_query = "SELECT  `name`, `name_eng`,`publish`,`company_code`,`logo` FROM ".DB_PREFIX."company where id_company=$id_manu ORDER BY name";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($select_query);
		$row 	= $sql->fetch_array();
		$name = $row["name"];
		$name_eng = $row["name_eng"];
                                                     $publish = $row["publish"];
                                                     $company_code = $row["company_code"];
                                                     $logocu = $row["logo"] <> "" ? "<img src='".$dir_imglogos.$row["logo"]."'  style='border: 1px solid #000000; padding: 0px; width:80px; height:90x;'>" : 'Nhà cung cấp này chưa có ảnh'; 	
		$imgtemp 	= $row["logo"];
	}
        
	if($HTTP_POST_VARS["mode"] == "edit" && $HTTP_POST_VARS["pages"]=="manu")
	{
		$id_manu_edit = $_POST["id"];
		$name = convert_font($_POST["name"],2);
		$name_eng = $_POST["name_eng"];
                                                     $publish = $_POST["publish"];
                                                     $company_code = $_POST["company_code"];
                                                     $logo1 	= isset($_FILES["logo1"]["name"]) 		? $_FILES["logo1"]["name"]		 : '';
		$logocu 		= $_POST["logocu"] <> "" 		? stripslashes($_POST["logocu"]) : '';
		$imgtemp 	= $_POST["imgtemp"];
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
                        
		$update_query = "UPDATE ".DB_PREFIX."company SET name='$name', name_eng='$name_eng',publish='$publish',company_code='$company_code',logo='$filename' WHERE id_company = $id_manu_edit";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($update_query);
		$sql->close();
		$message = "Cập nhật thông tin thành công !";		
		require_once("manu.php");
		exit();
	}
	
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
            <a href="/">Home</a>
            :: <a href="index.php?pages=manu">Quản lý Nhà sản xuất</a>
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
            <table class="form">
              <tr>
                <td><span class="required">*</span> Tên Nhà sản xuất:</td>
                <td><input type="text" name="name" size="100" id="name" value="<?=$name?>" />
                  </td>
              </tr>
            <tr>
                <td><span class="required">*</span> Tên quốc tế:</td>
                <td><input type="text" name="name_eng" size="100" id="name_eng" value="<?=$name_eng?>" />
                  </td>
              </tr>
              
                 <tr>
                <td>Mã nhà mạng:</td>
                <td><input type="text" name="company_code" size="100" id="company_code" value="<?=$company_code?>" />
                  </td>
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
                <td><span class="required">*</span>Trạng thái:</td>
                <td><select name="publish">
                            <option value="1" <?=$publish==1?"selected":""?>>Hiển thị</option>
                            <option value="0" <?=$publish==0?"selected":""?>>Không hiển thị</option>
                    </select>
                </td>
              </tr>              
            </table>         
       </div>
        <input name="pages" type="hidden" id="pages" value="manu">
        <input name="mode" type="hidden" id="mode" value="edit">
        <input name="logocu" type="hidden" id="mode3" value="<?=$logocu?>">
        <input name="imgtemp" type="hidden" id="mode3" value="<?=$imgtemp?>">
        <input name="id" type="hidden" id="id" value="<?=$id_manu?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>
