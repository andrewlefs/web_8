<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
                       	
	session_start();
        $_SESSION["LANGUAGE"] = 1;
                          $album = array();
                          $CreateDate = date("Y-m-d");
	$sql = new db_sql();
	$sql->db_connect();	
	$sql->db_select();
	if($_POST["mode"] == "add" && isset($_POST["mode"]) && $_POST["pages"] == "product"){
		if(!session_register('countadd')){
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}
                
                                                    $catid                                            =  $_POST["cap_do"]; // ma danh muc cha
                                                    $catid                                            =  is_numeric($catid) ? $catid : 0;	
		
		$ten 		= isset($_POST["ten"])		? convert_font($_POST["ten"])		: '';
		$noibat                                        = isset($_POST["noibat"])                                 ? $_POST["noibat"]			: 0;
		$mota	 	= isset($_POST["mota"])		? convert_font($_POST["mota"])		: '';
                                                     $khuyenmai                                =  isset($_POST["km"])		? convert_font($_POST["km"])		: '';
                                                     $thongso                                    =  isset($_POST["thongso"])		? convert_font($_POST["thongso"])		: '';
                                                     $baohanh                                   =  isset($_POST["baohanh"])		? convert_font($_POST["baohanh"])		: '';
                                                     
		$anh 	                          = isset($_FILES["anh"]["name"])                       ? $_FILES["anh"]["name"]                                                            : '';
                                                     $album 	                          = isset($_FILES["album"]["name"])                     ? $_FILES["album"]["name"]                                                     : '';
                                                     $gia_goc                                     = isset($_POST["gia"])                                        ?$_POST["gia"]                                                                              :0;                                                     
                                                     $gia_goc                                    = is_numeric($gia_goc)                                         ?$gia_goc:0;
                                                     
                                                     $gia_km                                     = isset($_POST["giakm"])                                        ?$_POST["giakm"]                                                                              :0;                                                     
                                                     $gia_km                                     = is_numeric($gia_km)?$gia_km:0;
                                                     $publish                                    = isset($_POST["publish"])			? $_POST["publish"]			: '0';
                                                     
		if($ten== "") $message1          = $message1."Hãy nhập tên SP";
		if($mota== "") $message1 = $message1."Hãy nhập nội dung mô tả SP";
                                                     if($gia_goc== "") $message1 = $message1."Giá sản phẩm phải là số";
                                                    //  if($gia_km== "") $message1 = $message1."Giá sản phẩm phải là số";
                                                      
                                                      //ket thuc lay cac mang thong tin
		
		//bat dau thuc hien upload anh SP len thu muc tren may chu WEB		
		if ( !empty($anh)){
			$filename = "";
                                                                                $start = strpos($anh,".");
			$type  = substr($anh,$start,strlen($anh));
			if ((strtolower($type)!=".gif")&&(strtolower($type)!=".jpg")){
				$message1 = "Tệp ảnh phải có kiểu tệp là .jpg hoặc .gif";             
                                                                                }
			else{
                                                                                                    if($message1==""){
                                                                                                                            $filename = time().$type;
                                                                                                                            if (!copy($_FILES['anh']['tmp_name'], $dir_imgproducts."origin/".$filename)) die ("Cannot upload file.");
                                                                                                                            thumb($_FILES['anh']['tmp_name'], $dir_imgproducts.$filename, $ratio_image_width, $ratio_image_width, false);
                                                                                                         }
			}
                                                     }
                                                     
                                                     
                                                      //bat dau thuc hien upload anh chi tiết  len thu muc tren may chu WEB	    
                                                        if(!empty($album[0])){
                                                                                       $tenfile = "";
                                                                                       for($i=0;$i<count($album);$i++){
                                                                                                                   $temp = $_FILES["album"]["name"][$i];
                                                                                                                   $start = strpos($temp,".");
                                                                                                                   $type = substr($temp,$start,  strlen($temp));                                                                                                   
                                                                                                                   if(strtolower($type)!=".jpg" && strtolower($type)!=".gif"){
                                                                                                                                       $message1 = "Tệp ảnh phải có kiểu tệp là .jpg hoặc .gif"; 
                                                                                                                   }else{
                                                                                                                                       if($message1==""){
                                                                                                                                                                   $filename1 = time().$i.$type;
                                                                                                                                                                   if (!copy($_FILES['album']['tmp_name'][$i], $dir_imgproducts."origin/".$filename1)) die ("Cannot upload file.");
                                                                                                                                                                   thumb($_FILES['album']['tmp_name'][$i], $dir_imgproducts.$filename1, $ratio_image_width, $ratio_image_width, false);
                                                                                                                                        }
                                                                                                                                         $tenfile = $tenfile.$filename1.";";
                                                                                                                   }                                                                  
                                                                                       }
                                                                                       $temp_alb = explode(";", $tenfile);
                                                      }                                    
		//Bat dau chen DL vao CSDL		
		if($message1 ==""){			
			$ten 		= isset($_POST["ten"])		? convert_font($_POST["ten"],2)		: '';
                                                                                $mota	 	= isset($_POST["mota"])		? convert_font($_POST["mota"],2)	: '';
                                                                                
                                                                                $insert_query                            = "INSERT INTO  ".DB_PREFIX."product (`ten` ,`gia` ,`khuyenmai` ,`gia_km` ,`anh` ,`thongso` ,`mota` ,`noibat` ,`id_catalog` ,`publish` ,`create_date` ,`lang_id`,`baohanh`)
                                                                                                                                          VALUES ( '$ten',  '$gia_goc',  '$khuyenmai',  '$gia_km',  '$filename',  '$thongso',  '$mota',  '$noibat',  '$catid',  '$publish',   '$CreateDate',$_SESSION[LANGUAGE],'$baohanh')";
			if($sql->query($insert_query)){
                                                                                                        $select_query1 = "select id_product from ".DB_PREFIX."product where `ten`='$ten' and  `gia`='$gia_goc' and  `khuyenmai`='$khuyenmai' and  `gia_km`='$gia_km' and `anh`='$filename' 
                                                                                                            and  `thongso`='$thongso' and  `mota`='$mota' and  `baohanh`='$baohanh' and  `noibat`='$noibat' and `id_catalog`='$catid' and  `publish`='$publish' 
                                                                                                            and `create_date`='$CreateDate' and `lang_id`='$_SESSION[LANGUAGE]' order by id_product desc limit 1"   ;
                                                                                                        $sql->query($select_query1);
                                                                                                        if($r = $sql->fetch_array())
                                                                                                                $t123 = $r["id_product"];
                                                                                                                for($t=0;$t<=count($temp_alb)-2;$t++){
                                                                                                                    $insert_query1 = "insert into ".DB_PREFIX."proimg(images,id_pro) values('$temp_alb[$t]',$t123)";
                                                                                                                    $sql->query($insert_query1);
                                                                                                                }
				unset($ten, $mota,$thongso,$tenfile,$filename );	
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;
				$message 	= "Thông tin về sản phẩm thứ ".$HTTP_SESSION_VARS['countadd']." đã được thêm vào CSDL.";							
			}		
			$sql->close();	
                                                                                $_SESSION["cap_do___kkk"]=$_POST['cap_do'];
		}
	}		
?>
<?php include("lib/header.php")?>
<!-- TinyMCE -->
<script type="text/javascript" src="/extsource/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/extsource/tiny_mce/tiny_mce_menu.js"></script>
<!-- /TinyMCE -->
<div id="content">
  <div class="breadcrumb">
     <a href="/">Home</a>
         :: <a href="index.php?pages=product">Danh mục sản phẩm</a>
        </div>
        <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/product.png" alt="" /> Thêm sản phẩm</h1>
      <form action=index.php method=post enctype="multipart/form-data" name="addproduct" id="addproduct">
      <div class="buttons"><input type="submit" value="Thêm" name="submit" class="submit1" ><input type="reset" value="Làm lại" name="submit2" class="submit1" ><a onclick="location = '';" class="button">Cancel</a></div>
    </div>
    <div class="content">
           <div id="tabs" class="htabs">
               <a href="#tab-general">Thông tin chung</a><a href="#tab-data">Thống số</a>
           </div>
     <div id="tab-general">
        <div id="language1">
            <table class="form">
                <tr>
                        <td width="150px" >
                                Chọn danh mục sản phẩm <span class="required">*</span>:
                        </td>
                        <td>
                                <?php 
                                        function xac_dinh_menu_con__123_add($id_cha)
                                        {
                                                $sql = new db_sql();
                                                $sql->db_connect();	
                                                $sql->db_select();	                                          
                                                $tv_2= $sql->fetch_rows(DB_PREFIX."catalog", "catalog_parent", $id_cha);
                                                if($tv_2[0]==0)
                                                {
                                                        return "khong";
                                                }
                                                else 
                                                {
                                                        return "co";
                                                }
                                        }
                                        function de_quy_menu__fff_add($id_cha,$kt="")
                                        {
                                                 $sql = new db_sql();
                                                $sql->db_connect();	
                                                $sql->db_select();
                                                $kt=$kt."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                $tv="select * from ".DB_PREFIX."catalog where catalog_parent='$id_cha'";
                                               $sql->query($tv);
                                                while($tv_2=$sql->fetch_array())
                                                {
                                                        if($_SESSION["cap_do___kkk"]==$tv_2['id_catalog'])
                                                        {
                                                                $select="selected";
                                                        }
                                                        else 
                                                        {
                                                                $select="";
                                                        }
                                                        echo "<option value='$tv_2[id_catalog]' $select >";
                                                                echo $kt;	
                                                                echo $tv_2['name'];												
                                                        echo "</option>";
                                                        $xac_dinh_menu_con__123=  xac_dinh_menu_con__123_add($tv_2['id_catalog']);
                                                        if($xac_dinh_menu_con__123=="co")
                                                        {
                                                                de_quy_menu__fff_add($tv_2['id_catalog'],$kt);
                                                        }
                                                }	
                                        }
                                ?>
                                <?php 
                                                $sql = new db_sql();
                                                $sql->db_connect();	
                                                $sql->db_select();
                                        echo "<select name='cap_do' style='height:35px'>";
                                                  $tv="select * from ".DB_PREFIX."catalog where catalog_parent=0";
                                                $sql->query($tv);
                                                while($tv_2=$sql->fetch_array())
                                                {
                                                        if($_SESSION["cap_do___kkk"]==$tv_2['id_catalog'])
                                                        {
                                                                $select="selected";
                                                        }
                                                        else 
                                                        {
                                                                $select="";
                                                        }
                                                        echo "<option value='$tv_2[id_catalog]' $select >";
                                                                echo $tv_2['name'];						
                                                        echo "</option>";
                                                        $xac_dinh_menu_con__123=xac_dinh_menu_con__123_add($tv_2['id_catalog']);
                                                        if($xac_dinh_menu_con__123=="co")
                                                        {
                                                                de_quy_menu__fff_add($tv_2['id_catalog']);
                                                        }
                                                }
                                        echo "</select>";
                                ?>
                        </td>
                </tr>
              <tr>
                <td>Tên sản phẩm <span class="required">*</span> :</td>
                <td><input type="text" name="ten" name="ten" size="100" value="<?=$ten?>" />
                  </td>
              </tr>
          
              <tr>
                <td>Ảnh trang chủ<span class="required">*</span> :<br />(Bạn chọn một ảnh làm hình hiển thị ngoài trang chủ)</td>
                <td> <input  name="anh"  type="file"  id="anh"  value="<?=$anh?>" size="32">
                  </td>
              </tr>  
                <tr>
                <td>Ảnh chi tiết :<br />(Bạn có thể chọn nhiều hình để hiển thị tại trang chi tiết của sản phẩm)</td>
                <td> <input name="album[]" type="file" id="album" value="<?=$album?>" size="32" multiple="true">
                  </td>
              </tr>  
               <tr>
                <td>Giá sản phẩm <span class="required">*</span> :</td>
                <td> <input name="gia" type="text" id="gia" value="<?=$gia_goc?>" size="32">
                  </td>
              </tr>  
             <tr>
                <td>Giá khuyến mại  :</td>
                <td> <input name="giakm" type="text" id="giakm" value="<?=$gia_km?>" size="32">
                  </td>
              </tr> 
               <tr>
                <td>Thông tin bảo hành:</td>
                <td><textarea  name="baohanh" rows="8" cols="30" style="width:50%"><?=$baohanh?></textarea></td>
              </tr>
           <tr>
              <td>Hiển thị:</td>
                    <td>  <input name="publish" value="1" checked="checked" type="radio">Có
                          <input name="publish" value="0" type="radio">Không
                </td>
            </tr>
            
              <tr>
                    <td>Sản phẩm  nổi bật:</td>
                    <td>  <input name="noibat" value="1" checked="checked" type="radio">Đúng
                          <input name="noibat" value="0" type="radio">Sai
                      </td>
            </tr>
            
            </table>
          </div>
     </div>     
         <div id="tab-data">
          <table class="form">
               <tr>
                <td>Thông tin khuyến mại:</td>
                <td><textarea  name="km" rows="8" cols="30" style="width:50%"><?=$khuyenmai?></textarea></td>
              </tr>
                <tr>
                <td>Mô tả:</td>
                <td><textarea id="elm1" name="mota" rows="20" cols="40" style="width:99%"><?=$mota?></textarea></td>
              </tr>
             <tr>
                <td>Thông số:</td>
                <td><textarea id="elm2" name="thongso" rows="20" cols="40" style="width:99%"><?=$thongso?></textarea></td>
              </tr>
          </table>
        </div>
      <input name="pages" type="hidden" id="pages" value="product">        
      <input name="mode" type="hidden" id="mode" value="add">     
      </form>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
    $('#tabs a').tabs(); 
    $('#vtab-option a').tabs();
    </script> 
</div>
<?php include("lib/footer.php")?>
</body></html>