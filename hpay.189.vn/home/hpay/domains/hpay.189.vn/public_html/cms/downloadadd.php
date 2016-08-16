<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	$sql = new db_sql();
	$sql->db_connect();	
	$sql->db_select();
        $module_name = 'Thư viện';
        $UserId         = $HTTP_SESSION_VARS['user_admin'];
	if($HTTP_POST_VARS[mode] == "add" && isset($HTTP_POST_VARS[mode])){
		if(!session_register('countadd')){
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}
		//lay thong tin ve cac danh muc				
		$title          = isset($_POST["title"])    ? convert_font($_POST["title"]) : '';
		$tieudeanh 	= isset($_POST["title"])    ? cut_space(catdau_admin($_POST["title"]))	: '';
                $content 	= isset($_POST["content"])  ? convert_font($_POST["content"]) : '';		
		$filename 	= isset($_POST["filename"]) ? $_POST["filename"] : '';
                $images 	= isset($_FILES["images"]["name"]) 	? $_FILES["images"]["name"]	: '';		
                $onHG           = $HTTP_POST_VARS["onHG"]==1?$HTTP_POST_VARS["onHG"]:0;
                $url            = isset($_POST["url"])      ? $_POST["url"] : '';
                $onUrl           = $HTTP_POST_VARS["onUrl"]==1?$HTTP_POST_VARS["onUrl"]:0;
		$publish 	= $HTTP_POST_VARS["publish"]==1?$HTTP_POST_VARS["publish"]:0;
		$downloadcat_id	= $_POST["downloadcat_id"];
		
		if($title == "") $message1 = $message1."Hãy nhập tiêu đề";
		if($downloadcat_id == 0) $message1 = $message1."Hãy chọn một nhóm";
                if ( !empty($images)){
			$filename_a = "";
                	$start = strpos($images,".");
			$type  = substr($images,$start,strlen($images));
			if ((strtolower($type)!=".gif")&&(strtolower($type)!=".jpg")){
				$message1 = "Tệp ảnh bìa phải có kiểu tệp là .jpg hoặc .gif";             
	        }
			else{
			if($message1==""){
		    	    	$filename_a = $tieudeanh."-".time().$type;
	        			if ( !(copy($_FILES['images']['tmp_name'], $dir_imgmdata.$filename_a)) ) die("Cannot upload file.");
			     }
			}
	    }
		//Bat dau chen DL vao CSDL		
		if($message1 == ""){			
			$title 	= isset($_POST["title"])            ? convert_font($_POST["title"],2)	: '';
			$tieudeanh 	= isset($_POST["title"])    ? cut_space(catdau_admin($_POST["title"]))	: '';
                        $intro 	= isset($_POST["intro"])            ? convert_font($_POST["intro"],2)	: '';
			$content = isset($_POST["content"])         ? convert_font($_POST["content"],2)	: '';
                        $UserId	 	= isset($_POST["UserId"])   ? convert_font($_POST["UserId"],2)		: '';
			
                        $insert_query = "INSERT INTO download(title, images, intro, filename, onHG, url, onUrl, content, publish, downloadcat_id) ";
			$insert_query = $insert_query." VALUES('$title', '$filename_a', '$intro', '$filename', $onHG, '$url', $onUrl, '$content', $publish, $downloadcat_id)";
			if($sql->query($insert_query)){			
				unset($title, $intro, $content);	
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;				
				$message 	= "Tin thứ ".$HTTP_SESSION_VARS['countadd']." đã được thêm vào CSDL.";							
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
      <div class="buttons"><input type="submit" value="Lưu" name="submit" class="submit1" ><input name="Reset" type="reset" class="submit1" value="Reset"></div>
    </div>
    <div class="content">
        <div id="tab-general">
          <div id="language1">
            <table class="form">
            <tr>
                <td><span class="required">*</span>Nhóm:</td>
                <td><select name="downloadcat_id" >
                          <option value="0"> -- Chọn một danh mục -- </option>
				  <?php
				  for($i=1;$i<=count($downloadcat);$i++)
						echo "<option value='".$downloadcat[$i]["id"]."'>".$downloadcat[$i]["title"]."</option>";
				  ?>
                    </select> 
                  </td>
              </tr>
                
                
                <tr>
                <td><span class="required">*</span>Tiêu đề:</td>
                <td><input type="text" name="title" size="100" value="<?=$title?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Ảnh:</td>
                <td><input name="images" type="file" size="60" value="<?=$images?>">
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Url:</td>
                <td><input type="text" name="url" size="80" value="<?=$url?>" />
                    <select name="onUrl">
                            <option value="0" selected="selected">Disabled</option>
                            <option value="1">Enabled</option>
                    </select>
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>File:</td>
                <td><?
				$used_files = array();
				$files_array = download_files_listing();
				$n = count($files_array);
				
				$sql = new db_sql();
				$sql->db_connect();	
				$sql->db_select();
				$str_sql = "SELECT filename FROM download WHERE filename IN(";
				for($i=0; $i<$n; $i++){
					$str_sql.="'".$files_array[$i]."'";
					if($i<$n-1)
						$str_sql.=",";
				}					
				$str_sql.=") ";
				$sql->query($str_sql);
				$i = 0;
				while($rows = $sql->fetch_array()){
					$used_files[$i++] = $rows["filename"];
				}
				$sql->close();
				$unused_files = array_merge(array_diff($used_files,$files_array),array_diff($files_array,$used_files));
				
				?>
				<select name="filename" id="filename" size="10">
				<optgroup label="Unused files">
				<?
					for($i=0; $i<count($unused_files); $i++)
						echo "<option value='$unused_files[$i]'>$unused_files[$i]</option>\n";
				?>
				</optgroup>
				<optgroup label="Files in use">
                <?
					for($i=0; $i<count($used_files); $i++)
						echo "<option value='$used_files[$i]'>$used_files[$i]</option>\n";
				?>
				</optgroup>
				</select>
                    <select name="onHG">
                            <option value="0" selected="selected">Disabled</option>
                            <option value="1">Enabled</option>
                    </select>
                  </td>
              </tr>
             <tr>
                <td></td>
                <td>
                    <input type="button" value="Refresh files list" onClick="document.location = 'index.php?pages=download&mode=add'">
                    <script language="javascript">
                    function OpenNewWindow(url,w,h) {
                            window.open(url,'new_page','toolbar=no,location=no,menubar=no,scrollbars=yes,width=' + w + ',height=' + h + ',top=60,left=100,resizeable=no,status=no');
                    }
                    </script>
                    <input type="button" value="Upload new files" onClick="OpenNewWindow('index.php?pages=upload_form',370,350)">
                </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Giới thiệu:</td>
                <td><textarea name="intro" rows="10" cols="80" style="width: 98%">
                <?=$intro?></textarea></td>
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
              <tr>
                <td><span class="required">*</span>Status:</td>
                <td><select name="publish">
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
