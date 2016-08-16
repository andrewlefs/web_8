<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$ngaydang = time(); 
	$sql = new db_sql();
	$sql->db_connect();	
	$sql->db_select();
	$n = $sql->count_rows("linkseo");

	if($HTTP_POST_VARS[mode] == "add" && isset($HTTP_POST_VARS[mode])){
		if(!session_register('countadd')){
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}
		//lay thong tin ve cac danh muc				
		$keyword	= isset($_POST["keyword"])			? convert_font($_POST["keyword"])		: '';
		$linkweb 	= isset($_POST["linkweb"])			? convert_font($_POST["linkweb"])		: '';	
		$publish = $HTTP_POST_VARS["publish"]==1?$HTTP_POST_VARS["publish"]:0;
		$list_order = $HTTP_POST_VARS["list_order"];
		
		if($linkweb == "") $message1 = $message1."Hãy nhập liên kết";
		if($keyword	== "") $message1 = $message1."Hãy nhập từ khóa";	
		if($message1 ==""){			
			$linkweb 	= isset($_POST["linkweb"])			? convert_font($_POST["linkweb"],2)		: '';
			$keyword	= isset($_POST["keyword"])			? convert_font($_POST["keyword"],2)		: '';			
			
			$insert_query = "INSERT INTO linkseo(keyword, linkweb, publish, list_order) ";
			$insert_query = $insert_query." VALUES('$keyword', '$linkweb', $publish, $list_order)";
			if($sql->query($insert_query)){			
				unset($keyword, $linkweb);	
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;				
				$message 	= "Từ khóa thứ ".$HTTP_SESSION_VARS['countadd']." đã được thêm vào CSDL.";							
			}		
			$sql->close();						
		}
	}		
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=linkseo">Quản lý Nhà sản xuất</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Success: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Nhà sản xuất</h1>
      
      <form action=index.php method=post enctype="multipart/form-data" name="addlinkseo" id="addlinkseo">
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
                <td><span class="required">*</span> Từ khóa:</td>
                <td><input type="text" name="keyword" size="100" id="keyword" value="<?=$keyword?>" />
                  </td>
              </tr>
            <tr>
                <td><span class="required">*</span>Link website:</td>
                <td><input type="text" name="linkweb" size="100" id="linkweb" value="<?=$linkweb?>" />
                  </td>
              </tr>
              <tr>
              <tr>
              <td>Hiển thị:</td>
              <td><input name="publish" type="checkbox" id="publish" value="1" checked>
              </td>
            </tr>
              <td>Order:</td>
              <td>  <SELECT name=list_order size=1 id="list_order">
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
        <input name="pages" type="hidden" id="pages" value="linkseo">
        <input name="mode" type="hidden" id="mode" value="add">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
