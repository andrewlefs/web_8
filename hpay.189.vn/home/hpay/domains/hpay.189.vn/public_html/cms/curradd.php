<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}	
	if($HTTP_POST_VARS["mode"] == "add" && isset($HTTP_POST_VARS["mode"]) && $HTTP_POST_VARS["pages"] == "curr")
	{
		if(!session_register('countadd'))
		{
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}		
		$name = convert_font($_POST["name"]);
		$rate = convert_font($_POST["rate"]);
		$message1 = $name == "" ? "Hãy nhập tên đơn vị tiền tệ" : "";
		$message1.= $rate == "" ? "Hãy nhập tỷ giá" : "";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();	
		if($message1 =="")		
		{			
			$name = convert_font($_POST["name"],2);
			$insert_query = "INSERT INTO currency(name,rate) VALUES('$name',$rate)";			
			if($sql->query($insert_query))
			{			
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;				 
				$message = "Thông tin về  đơn vị tiền tệ thứ  ".$HTTP_SESSION_VARS['countadd']." đã được thêm vào CSDL";			
				unset($name);
			}	
							
		}
	}	
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=curr">Quản lý đơn vị tiền tệ</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Success: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Thêm đơn vị tiền tệ</h1>
      
      <form action=index.php method=post enctype="multipart/form-data" name="curradd" id="curradd" onSubmit="return numberValidation(document.getElementById('rate'))">
      <div class="buttons"><input type="submit" value="Thêm" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general">General</a></div>

        <div id="tab-general">
          <div id="languages" class="htabs">
                        <a href="#language1"><img src="images/gb.png" title="English" /> English</a>
                      </div>
                    <div id="language1">
            <table class="form">
              <tr>
                <td><span class="required">*</span> Tên đơn vị tiền tệ:</td>
                <td><input type="text" name="name" size="100" id="name" value="<?=$name?>" />
                  </td>
              </tr>
             <tr>
                <td><span class="required">*</span> Tỷ giá:</td>
                <td><input type="text" name="rate" size="100" id="rate" value="<?=$rate?>" />
                  </td>
              </tr>    
            </table>
          </div>
       </div>
        <input type="hidden" value="Add" name="submit">
        <input name="pages" type="hidden" id="pages" value="curr">
        <input name="mode" type="hidden" id="mode" value="add">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
