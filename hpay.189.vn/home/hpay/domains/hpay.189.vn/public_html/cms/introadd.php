<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();	
	$sql->db_select();		
        $module_name = 'Bài viết ngoài';
        $UserId         = $HTTP_SESSION_VARS['user_admin'];
	
        $n = $sql->count_rows(DB_PREFIX."intro");

	if($HTTP_POST_VARS[mode] == "add" && isset($HTTP_POST_VARS[mode])){
		if(!session_register('countadd')){
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}
		$menu_title	= isset($_POST["menu_title"])	? convert_font($_POST["menu_title"])	: '';
		$title 		= isset($_POST["title"])	? convert_font($_POST["title"])		: '';
		$content	= isset($_POST["content"])	? convert_font($_POST["content"])	: '';		
		$publish = $HTTP_POST_VARS["publish"]==1?$HTTP_POST_VARS["publish"]:0;               
		$list_order = $HTTP_POST_VARS["list_order"];

		
		if($title 	== "") $message1 = $message1."Hãy nhập tiêu đề";
		if($menu_title	== "") $message1 = $message1."Hãy nhập tiêu đề cho Menu";
		if($content 	== "") $message1 = $message1."Hãy nhập nội dung";
	
		//Bat dau chen DL vao CSDL		
		if($message1 ==""){			
			$title 		= isset($_POST["title"])	? convert_font($_POST["title"],2)	: '';
			$menu_title	= isset($_POST["menu_title"])	? convert_font($_POST["menu_title"],2)	: '';			
			$content 	= isset($_POST["content"])	? convert_font($_POST["content"],2)	: '';
                
			
			$insert_query = "INSERT INTO intro(menu_title, title, content, publish,  list_order) ";
			$insert_query = $insert_query." VALUES('$menu_title', '$title', '$content', $publish, $list_order)";
			if($sql->query($insert_query)){			
				unset($menu_title, $title, $content);	
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;				
				$message 	= "Thông tin  thứ ".$HTTP_SESSION_VARS['countadd']." đã được thêm vào CSDL.";							
			}		
			$sql->close();						
		}
	}		
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>:: <a href="index.php?pages=<?= $pages ?>"><?= $module_name ?></a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Thêm <?= $module_name ?></h1>
      
      <form action="index.php?pages=<?= $pages ?>&mode=add" method="post" enctype="multipart/form-data" name="add" id="add">
      <div class="buttons"> <input type="submit" value="Lưu" name="submit" class="submit1" >
                            <input name="Reset" type="reset" class="submit1" value="Reset"></div>
    </div>
    <div class="content">
        <div id="tab-general">
          <div id="language1">
            <table class="form">
            <tr>
                <td><span class="required">*</span>Tiêu đề trên Menu:</td>
                <td><input type="text" name="menu_title" size="50" value="<?=$menu_title?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Tiêu đề:</td>
                <td><input type="text" name="title" size="100" value="<?=$title?>" />
                  </td>
              </tr>          
              <tr>
                <td><span class="required">*</span>Bài viết:</td>
                <td><textarea id="elm2" name="content" rows="20" cols="80" style="width: 98%">
                <?=$content?></textarea></td>
              </tr>
              <tr>
                <td><span class="required">*</span>Thứ tự:</td>
                <td><SELECT name="list_order">
                    <?php  
                             for($i=1; $i<$n+1; $i++){
                                    if ($i == 1){
                             ?>
                    <OPTION value=<?=$i?> selected><?=$i?></OPTION>
                    <?php }else { ?>
                    <OPTION value=<?=$i?>><?=$i?></OPTION>
                    <?php }}?>
                    </SELECT>
                </td>
              </tr>
             <!--  <tr>
                <td><span class="required">*</span>Giới thiệu:</td>
                <td><select name="Gioithieu">
                            <option value="0" selected="selected">No</option>
                            <option value="1">Yes</option>
                    </select>
                </td>
              </tr>-->
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="<?= $pages ?>">
        <input name="UserId" type="hidden" id="UserId" value="<?=$UserId?>">
        <input name="mode" type="hidden" id="mode" value="add">	
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
