<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}	
                          $sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();
	if($HTTP_GET_VARS[mode] == "edit"){
		$n = $sql->count_rows(DB_PREFIX."slider");
		$id = $_GET["id"];
		$select_query = "SELECT * FROM ".DB_PREFIX."slider WHERE id_slider = '$id'";
		$sql->query($select_query);
		$row 		= $sql->fetch_array();
		$link 		= $row["link"]; 
		$content 	= $row["content"];                                                
		$thutu 		= $row["list_order"]; 
		$logocu 	= $row["logo"] <> "" ? "<img src='".$dir_imgslider.$row["logo"]."'  width='400' style='border: 1px solid #000000; padding-left: 0; padding-right: 0; padding-top: 0px; padding-bottom: 0px'>" : 'Tin này chưa có ảnh'; 	
		$imgtemp 	= $row["logo"];		
		$publish  	= $row["publish"];
	}
        
	if($HTTP_POST_VARS["mode"] == "edit" && isset($HTTP_POST_VARS["mode"]) && $HTTP_POST_VARS["pages"] == "slider")
	{
		$n = $sql->count_rows(DB_PREFIX."slider");
		$id 		= $_POST["id"];								
		$link           = convert_font(trim($_POST["link"]));
		$content 	= isset($_POST["content"])			? convert_font($_POST["content"]): '';                                                   
		$thutu          = isset($_POST['thutu']) 			? $_POST["thutu"] : 1;
		$logo           = isset($_FILES["logo"]["name"]) 		? $_FILES["logo"]["name"]		 : '';
		$logocu 		= $_POST["logocu"] <> "" 		? stripslashes($_POST["logocu"]) : '';
		$imgtemp 	= $_POST["imgtemp"];		
		$publish  = isset($_POST['publish']) 			? $_POST["publish"] : "1";
		if($link == "") $message1 = $message1."Hãy nhập liên kết cho logo";
		//bat dau thuc hien upload logo len thu muc tren may chu WEB		
		if ( !empty($logo)){
			$filename = "";
	       	$start = strpos($logo,".");
			$type  = substr($logo,$start,strlen($logo));
			if ((strtolower($type)!=".gif")&&(strtolower($type)!=".jpg")){
				$message1 = "Tệp ảnh bìa phải có kiểu tệp là .jpg hoặc .gif";             
	        }
			else
				if($message1==""){
		    		$filename = "slider".time().$type;
		        	if ( !(copy($_FILES['logo']['tmp_name'], $dir_imgslider.$filename)) ) die("Cannot upload file.");
					$file_path = $dir_imgslider.$imgtemp;
					if($imgtemp!="" && file_exists($file_path))	unlink("$file_path");						
				}			
		}
		else
			if(empty($anhtin)) $filename=$imgtemp;
		
		if($message1 =="")		
		{			
			$update_query = "UPDATE ".DB_PREFIX."slider SET logo='$filename', link='$link', content='$content', list_order = $thutu, publish = $publish WHERE id_slider='$id'";
		
			if($sql->query($update_query)){
				$sql->close();
				$message = $message."Update Successfull !";
				include_once("slider.php");
				exit();
			}			
		}
	}
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
            <a href="/">Home</a>
            :: <a href="index.php?pages=slider">Quảng lý ảnh Slider </a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Sửa ảnh Slider </h1>
      
      <form action=index.php method=post enctype="multipart/form-data" name="nsxedit" id="nsxedit">
      <div class="buttons"><input type="submit" value="Cập nhật" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
      <div id="tab-general">
         <div id="language1">        
            <table class="form">
              <tr>
                <td><span class="required">*</span>Logo cũ:</td>
                <td><?=$logocu?></td>
              </tr>
            <tr>
                <td><span class="required">*</span>Chọn logo mới:</td>
                <td><input name="logo" type="file"  id="logo" value="<?=$logo?>"></td>
              </tr>
            <tr>
                <td><span class="required">*</span>Link:</td>
                <td><input name=link id="link" value="<?=$link?>" size=55 maxlength=85></td>
              </tr>  
              
             <tr>
                <td><span class="required">*</span>Content:</td>
                <td><input name=content  value="<?=$content?>" size=55 maxlength=85></td>
              </tr> 
               <tr>
              <td>Publish:<select name=publish size=1 id="publish">
                          <option value="1" <? echo ($publish=="1"?"selected":"") ?>>Có</option>
                          <option value="0" <? echo ($publish=="0"?"selected":"") ?>>Không</option>
                        </select>
              
              </td>
             <td> Order:  <SELECT name=thutu size=1 id="thutu">
                        <?php  
						 for($i=1; $i<$n+1; $i++) 
						 {
						 	if ($i == $thutu){
						 ?>
                        <OPTION value=<?=$i?> selected>
                        <?=$i?>
                        </OPTION>
                        <?php }else { ?>
                        <OPTION value=<?=$i?>>
                        <?=$i?>
                        </OPTION>
                        <?php }}?>
                      </SELECT>
              </td>
              
            </table>
          </div>
       </div>
         <input name="pages" type="hidden" id="pages" value="slider">
        <input name="mode" type="hidden" id="mode" value="edit">
        <input name="logocu" type="hidden" id="mode3" value="<?=$logocu?>">
        <input name="imgtemp" type="hidden" id="mode3" value="<?=$imgtemp?>">
        <input name="id" type="hidden" id="id" value="<?=$id?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>
