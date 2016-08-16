<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
        
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();		
	if($HTTP_POST_VARS[mode] == "add" && isset($HTTP_POST_VARS[mode]))
	{
		if(!session_register('countadd'))
		{
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}
		$logo           = isset($_FILES["logo"]["name"]) 		? $_FILES["logo"]["name"]				: '';		
		$link           = convert_font(trim($_POST["link"]));                                               
		$content	= isset($_POST["content"])		? convert_font($_POST["content"]): '';	
		$thutu          = isset($_POST['thutu']) ? 			$_POST["thutu"] : 1;		
		$publish        = isset($_POST['publish']) ? 			$_POST["publish"] : "1";

		if($logo == "") $message1 = $message1."Bạn chưa chọn logo";
		if($link == "") $message1 = $message1."Hãy nhập liên kết cho logo";		
		if ( !empty($logo)){
			$filename = "";
                                                                                $start = strpos($logo,".");
                                                                                $type  = substr($logo,$start,strlen($logo));
                                                                                if ((strtolower($type)!=".gif")&&(strtolower($type)!=".jpg")){
                                                                                                $message1 = "Tệp ảnh bìa phải có kiểu tệp là .jpg hoặc .gif";             
                                                                                }
                                                                                else{
                                                                                if($message1==""){
                                                                                        $filename = "slider".time().$type;
                                                                                                if ( !(copy($_FILES['logo']['tmp_name'], $dir_imgslider.$filename)) ) die("Cannot upload file.");
                                                                                     }
                                                                                }
                                                    }
                                                    
		$n = $sql->count_rows("kien_slider") + 1;
		
		if($message1 =="")		
		{			
			$insert_query = "INSERT INTO kien_slider(logo, link, content, list_order,publish) VALUES('$filename', '$link', '$content', $thutu,  $publish)";
			if($sql->query($insert_query))
			{			
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;
				$message 	= "Logo thứ ".$HTTP_SESSION_VARS['countadd']." đã được thêm vào CSDL.";			
				unset($logo,$link);
			}	
			$n = $sql->count_rows("kien_slider") + 1;	
			$sql->close();	
		}
	}else{
			$sql = new db_sql();
			$sql->db_connect();
			$sql->db_select();
			$n = $sql->count_rows("kien_slider") + 1;
			$sql->close();
	}		
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=slider">Quản lý banner giữa</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Success: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Thêm banner</h1>
      
      <form action=index.php method=post enctype="multipart/form-data" name="slideradd" id="slideradd">
      <div class="buttons"><input type="submit" value="Thêm" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
      <div id="tab-general">
         <div id="language1">
            <table class="form">
              <tr>
                <td><span class="required">*</span>Logo:</td>
                <td><input name="logo" type="file" id="logo" value="<?=$logo?>" size="32">
                  </td>
              </tr>
             <tr>
                <td><span class="required">*</span> Link:</td>
                <td><input type="text" name="link" size="100" id="link" value="<?=$link?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>content:</td>
                <td><input type="text" name="content" size="100" value="<?=$content?>" />
                  </td>
              </tr>
              <tr>
              <td>Publish:<select name=publish size=1 id="publish">
                        <option value="1" selected>Có</option>
                        <option value="0">Không</option>
                      </select>
              
              </td>  
                  <td>  Order:<SELECT name=thutu size=1 id="thutu">
                     <?php  
                     for($i=1; $i<=$n; $i++){
                     ?>
                            <OPTION value="<?=$i?>"><?=$i?></OPTION>
                     <?php }
                     ?>
                             <OPTION value="<?=$n+1?>" selected><?=$n+1?></OPTION>
                      </SELECT>
              </td>
            </tr>
            </table>
          </div>
       </div>
        <input type="hidden" value="Add" name="submit">
        <input name="pages" type="hidden" id="pages" value="slider">
        <input name="mode" type="hidden" id="mode" value="add">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
