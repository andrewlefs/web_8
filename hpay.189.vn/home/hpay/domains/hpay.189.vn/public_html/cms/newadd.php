<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
                           $UserId = $HTTP_SESSION_VARS['user_admin'];
	$CreateDate = date("Y-m-d");
	$sql = new db_sql();
	$sql->db_connect();	
	$sql->db_select();
	
	if(isset($HTTP_POST_VARS[mode]) && $HTTP_POST_VARS[mode] == "add" ){
		if(!session_register('countadd')){
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}
		//lay thong tin ve cac danh muc				
		$tieude 	= isset($_POST["tieude"])		? convert_font($_POST["tieude"])	: '';		
		$trichdan 	= isset($_POST["trichdan"])		? convert_font($_POST["trichdan"])	: '';;			
		//$nguontin 	= isset($_POST["nguontin"])		? convert_font($_POST["nguontin"])	: '';;			
		//$tags 	= isset($_POST["tags"])			? convert_font($_POST["tags"])		: '';		
		$anhtin 	= isset($_FILES["anhtin"]["name"]) 	? $_FILES["anhtin"]["name"]		: '';		
		$newscat_id	= $_POST["cap_do"];
		
		if($tieude 	== "") $message1 = $message1."Hãy nhập tiêu đề tin";		
		if($newscat_id 	== 0) $message1 = $message1."Hãy chọn một nhóm tin";
	
		//bat dau thuc hien upload anh bia len thu muc tren may chu WEB		
		if ( !empty($anhtin)){
			$filename = "";
                                                                                $start = strpos($anhtin,".");
			$type  = substr($anhtin,$start,strlen($anhtin));
			if ((strtolower($type)!=".gif")&&(strtolower($type)!=".jpg")&&(strtolower($type)!=".png")){
				$message1 = "Tệp ảnh bìa phải có kiểu tệp là .jpg hoặc .gif hoặc .png";             
                                                                                }
			else{
                                                                                                            if($message1==""){
                                                                                                                                    $filename = time().$type;
                                                                                                                                      $filename = time().$type;
                                                                                                                            if (!copy($_FILES['anhtin']['tmp_name'], $dir_imgnews."origin/".$filename)) die ("Cannot upload file.");
                                                                                                                            thumb($_FILES['anhtin']['tmp_name'], $dir_imgnews.$filename, $ratio_image_width, $ratio_image_width, false);                                                                                                                                   
                                                                                                             }
			}
                                                       }
                                                       $create_date = date("Y-m-d");
		//Bat dau chen DL vao CSDL		
		if($message1 == ""){			
			$tieude 	= isset($_POST["tieude"])				? convert_font($_POST["tieude"],2)		: '';
			//$tieudeanh 	= isset($_POST["tieude"])				? cut_space(catdau_admin($_POST["tieude"]))		: '';
			$trichdan 	= isset($_POST["trichdan"])				? convert_font($_POST["trichdan"],2)		: '';
			//$nguontin 	= isset($_POST["nguontin"])				? convert_font($_POST["nguontin"],2)	: '';;			
			//$tags 	= isset($_POST["tags"])						? convert_font($_POST["tags"],2)		: '';
			$frontpage 	= isset($_POST["frontpage"])			? $_POST["frontpage"]					: '0';
			$insert_query = "INSERT INTO ".DB_PREFIX."tintuc(tieude,trichdan,  anhtin,ngaydang, publish, newscat_id,langid) ";
			$insert_query = $insert_query." VALUES('$tieude', '$trichdan', '$filename', '$create_date', $frontpage, $newscat_id,1)";
			if($sql->query($insert_query)){			
				unset($tieude,  $trichdan );				
				$message = "Cập nhật thành công .";							
			}
                          $_SESSION["cap_do___new_add"]=$_POST['cap_do'];
			$sql->close();						
		}
	}		
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>:: <a href="index.php?pages=new">Category</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Th&ecirc;m một bài viết</h1>
      
      <form action="index.php?pages=new&mode=add" method="post" enctype="multipart/form-data" name="add" id="add">
      <div class="buttons"><input type="submit" value="Lưu" name="submit" class="submit1" ><input name="Reset" type="reset" class="submit1" value="Reset"></div>
    </div>
    <div class="content">
        <div id="tab-general">
          <div id="language1">
            <table class="form">
                 <tr>
                        <td width="150px" >
                                Chọn danh mục tin tức <span class="required">*</span>:
                        </td>
                        <td>
                                <?php 
                                        function xac_dinh_menu_con__new_add($id_cha)
                                        {
                                                $sql = new db_sql();
                                                $sql->db_connect();	
                                                $sql->db_select();	                                          
                                                $tv_2= $sql->fetch_rows(DB_PREFIX."newscat", "newscat_parent", $id_cha);
                                                if($tv_2[0]==0)
                                                {
                                                        return "khong";
                                                }
                                                else 
                                                {
                                                        return "co";
                                                }
                                        }
                                        function de_quy_menu__new_add($id_cha,$kt="")
                                        {
                                                 $sql = new db_sql();
                                                $sql->db_connect();	
                                                $sql->db_select();
                                                $kt=$kt."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                $tv="select * from ".DB_PREFIX."newscat where newscat_parent='$id_cha'";
                                               $sql->query($tv);
                                                while($tv_2=$sql->fetch_array())
                                                {
                                                        if($_SESSION["cap_do___new_add"]==$tv_2['id_newscat'])
                                                        {
                                                                $select="selected";
                                                        }
                                                        else 
                                                        {
                                                                $select="";
                                                        }
                                                        echo "<option value='$tv_2[id_newscat]' $select >";
                                                                echo $kt;	
                                                                echo $tv_2['name'];												
                                                        echo "</option>";
                                                        $xac_dinh_menu_con__123=  xac_dinh_menu_con__new_add($tv_2['id_newscat']);
                                                        if($xac_dinh_menu_con__123=="co")
                                                        {
                                                                de_quy_menu__new_add($tv_2['id_newscat'],$kt);
                                                        }
                                                }	
                                        }
                                ?>
                                <?php 
                                                $sql = new db_sql();
                                                $sql->db_connect();	
                                                $sql->db_select();
                                        echo "<select name='cap_do' style='height:35px'>";
                                                  $tv="select * from ".DB_PREFIX."newscat where newscat_parent=0";
                                                $sql->query($tv);
                                                while($tv_2=$sql->fetch_array())
                                                {
                                                        if($_SESSION["cap_do___new_add"]==$tv_2['id_newscat'])
                                                        {
                                                                $select="selected";
                                                        }
                                                        else 
                                                        {
                                                                $select="";
                                                        }
                                                        echo "<option value='$tv_2[id_newscat]' $select >";
                                                                echo $tv_2['name'];						
                                                        echo "</option>";
                                                        $xac_dinh_menu_con__123=xac_dinh_menu_con__new_add($tv_2['id_newscat']);
                                                        if($xac_dinh_menu_con__123=="co")
                                                        {
                                                                de_quy_menu__new_add($tv_2['id_newscat']);
                                                        }
                                                }
                                        echo "</select>";
                                ?>
                        </td>
                </tr>
              <tr>
                <td><span class="required">*</span>Ti&ecirc;u &#273;&#7873; tin:</td>
                <td><input type="text" name="tieude" size="100" id="tieude" value="<?=$tieude?>" />
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Ảnh minh họa:</td>
                <td><input name="anhtin" type="file" class="input_b2" id="anhtin" value="<?=$anhtin?>" size="32">
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Mô tả ảnh:</td>
                <td><input type="text" name="tags" size="100" value="<?=$tags?>" />
                  </td>
              </tr>
               <tr>
                <td><span class="required">*</span>Trích dẫn:</td>
                <td><textarea id="elm2" name="trichdan" rows="20" cols="40" style="width:99%"><?=$trichdan?></textarea>
                  </td>
              </tr>
            
             <!-- <tr>
                <td><span class="required">*</span>Nguồn tin:</td>
                <td><input type="text" name="nguontin" size="40" value="<?=$nguontin?>" />
                  </td>
              </tr>-->
              
              <tr>
                <td><span class="required">*</span>Trạng thái:</td>
                <td><select name="frontpage">
                            <option value="1" selected="selected">Hiển thị</option>
                            <option value="0">Không hiển thị</option>
                    </select>
                </td>
              </tr>
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="new">        
        <input name="mode" type="hidden" id="mode" value="add">	
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
