<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();		
	if($_POST[mode] == "add" && isset($_POST[mode])){
		if(!session_register('countadd')){
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}
		$tieude = convert_font($HTTP_POST_VARS["tieude"]);
		$logo 	= isset($_FILES["logo"]["name"]) 		? $_FILES["logo"]["name"] : '';	
		$link 	= convert_font(trim($_POST["link"]));
		
		$hienthi  = isset($_POST['hienthi']) ? $_POST["hienthi"] : "1";
		if($logo == "") $message1 = $message1."Bạn chưa chọn logo";
		if($link == "") $message1 = $message1."Hãy nhập liên kết cho logo";
		if($tieude == "") $message1 = $message1."Bạn chưa nhập tiêu đề";
		if ( !empty($logo)){
			$filename = "";
	       	$start = strpos($logo,".");
			$type  = substr($logo,$start,strlen($logo));
			if ((strtolower($type)!=".gif")&&(strtolower($type)!=".jpg")&&(strtolower($type)!=".png")){
				$message1 = "Tệp ảnh bìa phải có kiểu tệp là .jpg hoặc .gif hoặc .png";             
	        }
			else{
			if($message1==""){
		    	    	$filename = "logo".time().$type;
	        			if ( !(copy($_FILES['logo']['tmp_name'], $dir_imglogos.$filename)) ) die("Cannot upload file.");
			     }
			}
	    }
		$n = $sql->count_rows(DB_PREFIX."bankinfo") + 1;
		
		if($message1 =="")		
		{			
			$insert_query = "INSERT INTO ".DB_PREFIX."bankinfo(Logo, url, Title, Published) VALUES('$filename', '$link', '$tieude', $hienthi)";
			if($sql->query($insert_query))
			{			
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;
				$message 	= "Thông tin ngân hàng  thứ ".$HTTP_SESSION_VARS['countadd']." đã được thêm vào CSDL.";			
				unset($logo,$link);
			}	
			$n = $sql->count_rows(DB_PREFIX."bankinfo") + 1;	
			
		}
	}else{
			$sql = new db_sql();
			$sql->db_connect();
			$sql->db_select();
			$n = $sql->count_rows(DB_PREFIX."bankinfo") + 1;
			
	}
       
?>
<?php include("lib/header.php")?>
<div id="content">
<div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=network">Quản lý danh mục đối tác</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='success'>Success: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" /> Danh mục đối tác</h1>
      <form action=index.php method=post enctype="multipart/form-data" name="cateadd" id="cateadd">
      <div class="buttons"><input type="submit" value="Thêm" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
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
                    <td><span class="required">*</span>Logo</td>
                    <td>
                        <input name="logo" type="file" class="input_b2" id="logo" value="<?=$logo?>" size="32">
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
              <td><input name="hienthi" type="checkbox" id="hienthi" value="1" checked></td>
            </tr>
        
            </table>
          </div>
       </div>
        <input type="hidden" value="Add" name="submit">
        <input name="pages" type="hidden" id="pages" value="network">
        <input name="mode" type="hidden" id="mode" value="add">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>

