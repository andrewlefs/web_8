<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();	
	$sql->db_select();		
        $module_name = 'Video Clip';
        $UserId         = $HTTP_SESSION_VARS['user_admin'];
	
        if($HTTP_POST_VARS["mode"] == "add" && isset($HTTP_POST_VARS["mode"]) && $HTTP_POST_VARS["pages"] == "video"){
		if(!session_register('countadd')){
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}
		$vdname 	= isset($_POST["vdname"])	? convert_font($_POST["vdname"])	: '';
                $creator 	= isset($_POST["creator"])	? convert_font($_POST["creator"])	: '';		
		$videos 	= isset($_POST["videos"])	? convert_font($_POST["videos"])	: '';	
		$Correlate	= $_POST["Correlate"];
		$sort 		= isset($_POST["sort"]) 	? $_POST["sort"]						: 1;				
		
		if($vdname 		== "") $message1 = $message1."Hãy nhập tên clip";				
		$n = $sql->count_rows("videos") + 1;
                if($message1 ==""){			
			$vdname 	= isset($_POST["vdname"])	? convert_font($_POST["vdname"],2)	: '';
                        $creator 	= isset($_POST["creator"])	? convert_font($_POST["creator"],2)	: '';
			$videos 	= isset($_POST["videos"])	? convert_font($_POST["videos"],2)	: '';
			$insert_query = "INSERT INTO videos(vdname, Correlate, videos, creator, author, sort) ";
			$insert_query = $insert_query." VALUES('$vdname',$Correlate, '$videos', '$creator', '$UserId', $sort)";
			if($sql->query($insert_query)){			
				unset($vdname, $creator, $UserId, $videos, $content);	
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;				
				$message 	= "Video thứ ".$HTTP_SESSION_VARS['countadd']." đã được thêm vào CSDL.";							
			}		
			$n = $sql->count_rows("videos") + 1;										
			$sql->close();	
		}
	}else{			
			$n = $sql->count_rows("videos") + 1;
			$sql->close();
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
      <div class="buttons"><input type="submit" value="Lưu" name="submit" class="submit1" ><input name="Reset" type="reset" class="submit1" value="Reset"></div>
    </div>
    <div class="content">
        <div id="tab-general">
          <div id="language1">
            <table class="form">
                <tr>
                <td><span class="required">*</span>Danh mục bài:</td>
                <td><select name="Correlate" >
                          <option value="0"> -- Chọn một danh mục -- </option>
				  <?php
				  for($i=1;$i<=count($newscat);$i++)
                                        echo "<option value='".$newscat[$i]["id"]."'>".$newscat[$i]["title"]."</option>";
				  ?>
		</select> 
                  </td>
              </tr>
            <tr>
                <td><span class="required">*</span>Video Name:</td>
                <td><input type="text" name="vdname" size="100" value="<?=$vdname?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Biểu diễn:</td>
                <td><input type="text" name="creator" size="100" value="<?=$creator?>" />
                  </td>
              </tr>
              
              <tr>
                <td><span class="required">*</span>Link:</td>
                <td><input type="text" name="videos" size="100" value="<?=$videos?>" />
                  </td>
              </tr>
             <tr>
                <td><span class="required">*</span>Status:</td>
                <td><select name="sort">
                            <option value="0" selected="selected">Disabled</option>
                            <option value="1">Enabled</option>
                    </select>
                </td>
              </tr>
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="<?= $pages ?>">        
        <input name="mode" type="hidden" id="mode" value="add">	
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
