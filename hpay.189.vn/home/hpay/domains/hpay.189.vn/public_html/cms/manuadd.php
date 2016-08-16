<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	if($HTTP_POST_VARS["mode"] == "add" && isset($HTTP_POST_VARS["mode"])){
		if(!session_register('countadd')){
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}
                
		$com_name = convert_font($HTTP_POST_VARS["name"]);		
                                                     $com_nameeng = convert_font($HTTP_POST_VARS["name_eng"]);
                                                     $publish = $_POST["publish"];
                                                     $company_code = $_POST["company_code"];
                                                     $logo 	= isset($_FILES["logo"]["name"]) 		? $_FILES["logo"]["name"] : '';
		$message1 = $com_name == "" ? "Hãy nhập tên công ty" : "";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();                
                                                    
		if ( !empty($logo)){
			$filename = "";
	       	$start = strpos($logo,".");
			$type  = substr($logo,$start,strlen($logo));
			if ((strtolower($type)!=".gif")&&(strtolower($type)!=".jpg")){
				$message1 = "Tệp ảnh bìa phải có kiểu tệp là .jpg hoặc .gif";             
                                                        }
                                                                else{
                                                                if($message1==""){
                                                                        $filename = "logo".time().$type;
                                                                                if ( !(copy($_FILES['logo']['tmp_name'], $dir_imglogos.$filename)) ) die("Cannot upload file.");
                                                                     }
                                                                }
                                                    }
                                                    
		if($message1 ==""){		
			$insert_query = "INSERT INTO kien_company(name, name_eng,publish,company_code,logo) VALUES('$com_name','$com_nameeng','$publish','$company_code','$filename')";			
			if($sql->query($insert_query))	{
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;
				$message = "Thông tin công ty  th&#7913; ".$HTTP_SESSION_VARS['countadd']." &#273;&atilde; &#273;&#432;&#7907;c th&ecirc;m v&agrave;o CSDL";			
                                                                                                           unset($com_name,$com_nameeng,$company_code);
			}		
			$n = $sql->count_rows(DB_PREFIX."company");										
			$sql->close();	
		}
	}	
	else{
			$sql = new db_sql();
			$sql->db_connect();
			$sql->db_select();
			$n = $sql->count_rows(DB_PREFIX."company");
			$sql->close();
	}
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=manu">Thông tin nhà mạng</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Warning: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Success: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Nhà mạng</h1>
      
      <form action=index.php method=post enctype="multipart/form-data" id="Add" name="Add">
      <div class="buttons"><input type="submit" value="Thêm" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
      <div id="tab-general">
         <div id="language1">
            <table class="form">
              <tr>
                <td><span class="required">*</span> Tên nhà mạng:</td>
                <td><input type="text" name="name" size="100" id="name" value="<?=$com_name?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span> Tên tiếng anh:</td>
                <td><input type="text" name="name_eng" size="100" id="name_eng" value="<?=$com_nameeng?>" />
                  </td>
              </tr>
              <tr>
                <td>Mã nhà mạng:</td>
                <td><input type="text" name="company_code" size="100" id="company_code" value="<?=$company_code?>" />
                  </td>
              </tr>
               <tr>
                    <td>Logo</td>
                    <td>
                        <input name="logo" type="file" class="input_b2" id="logo" value="<?=$logo?>" size="32">
                    </td>
                </tr>
               <tr>
                <td><span class="required">*</span>Trạng thái:</td>
                <td><select name="publish">
                            <option value="1" selected="selected">Hiển thị</option>
                            <option value="0">Không hiển thị</option>
                    </select>
                </td>
              </tr>              
            
            </table>
          </div>
       </div>
        <input type="hidden" value="Add" name="submit">
        <input name="pages" type="hidden" id="pages" value="manu">
        <input name="mode" type="hidden" id="mode" value="add">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
