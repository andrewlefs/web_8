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
                
                                                    $catid                                            =  $_POST["id_com_cat"]; // ma danh muc cha
                                                    $catid                                            =  is_numeric($catid) ? $catid : 0;	
                                                    $code_pro                                   =    $_POST["code_pro"];
                                                    $ten 		= isset($_POST["ten"])		? convert_font($_POST["ten"])		: '';
                                                    $anh 	                          = isset($_FILES["anh"]["name"])                       ? $_FILES["anh"]["name"]                                                            : '';
                                                    $gia_goc                                     = isset($_POST["gia"])                                        ?$_POST["gia"]                                                                              :0;                                                     
                                                    $gia_goc                                    = is_numeric($gia_goc)                                         ?$gia_goc:0;
                                                    $publish                                    = isset($_POST["publish"])			? $_POST["publish"]			: '0';
                                                    //$company_id         = $_POST["company_id"];
                                                     
		if($ten== "") $message1          = $message1."Hãy nhập tên SP";
                                                     if($gia_goc== "") $message1 = $message1."Giá sản phẩm phải là số";
                                                     if($code_pro== "") $message1 = $message1."Bạn chưa nhập mã sản phẩm";
                                                     if($catid== 0) $message1 = $message1."Bạn chưa chọn nhà cung cấp dịch vụ";
                                                      
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
                                                     
		//Bat dau chen DL vao CSDL		
		if($message1 ==""){			
			$ten 		= isset($_POST["ten"])		? convert_font($_POST["ten"],2)		: '';
                                                                                $insert_query                            = "INSERT INTO  ".DB_PREFIX."product (`ten` ,`gia` ,`anh` ,`id_com_cat` ,`publish` ,`create_date` ,`lang_id`,`code_pro`)
                                                                                                                                          VALUES ( '$ten',  '$gia_goc', '$filename', '$catid',  '$publish',   '$CreateDate',$_SESSION[LANGUAGE],'$code_pro')";
			if($sql->query($insert_query)){                                                                                                      
				unset($ten, $filename,$code_pro,$gia_goc );	
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
               <a href="#tab-general">Thông tin chung</a>
           </div>
     <div id="tab-general">
        <div id="language1">
            <table class="form">              
                  <tr>
                            <td>Mã sản phẩm (Nhập đúng mã của nhà cung cấp) <span class="required">*</span> :</td>
                            <td><input type="text" name="code_pro" size="30" value="<?=$code_pro?>" />
                              </td>
                </tr>
                <!--<tr>
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
                  <td>Danh mục nhà cung cấp <span class="required">*</span> :</td>
                  <td>                  
                        <select name="company_id">
                            <option value="0">-- Chọn danh mục nhà cung cấp --</option>
                            <?php for($i=1;$i<=count($company);$i++){?>
                                    <option value="<?=$company[$i]["id_company"]?>"><?=$company[$i]["name"]?></option>
                            <?}?>
                        </select>                      
                  </td>
              </tr>-->
              <tr>
                    <td>Chọn nhà cung cấp - dịch vụ <span class="required">*</span> :</td>
                    <td>
                            <?php 
                                        $sql = new db_sql();
                                        $sql->db_connect();	
                                        $sql->db_select();
                                        $select_query = "SELECT id, id_company, id_catalog FROM ".DB_PREFIX."company_catalog order by id ";		
                                        $sql->query($select_query);                                   	
                                        $i = 0;
                                        while($r = $sql->fetch_array()){
                                            $i = $i+1;
                                            $arr_cat[$i]["id"] = $r["id"];
                                            $arr_cat[$i]["id_company"] = $r["id_company"];
                                            $arr_cat[$i]["id_catalog"] = $r["id_catalog"];
                                        }	
                            ?>
                            <select name="id_com_cat" id="id_com_cat">
                                    <option value="0">-- Chọn danh mục nhà cung cấp - dịch vụ --</option>
                                    <?php for($j=1;$j<=count($arr_cat);$j++){?>
                                    <option value="<?=$arr_cat[$j]["id"]?>"><?=  get_cat($arr_cat[$j]["id_catalog"])?> - <?=  get_com($arr_cat[$j]["id_company"])?></option>
                                    <?php }?>
                            </select>
                    </td>
              </tr>
              <tr>
                <td>Tên sản phẩm <span class="required">*</span> :</td>
                <td><input type="text" name="ten" id="ten" size="100" value="<?=$ten?>" />
                  </td>
              </tr>
          
              <tr>
                <td>Ảnh trang chủ<span class="required">*</span> :<br />(Bạn chọn một ảnh làm hình hiển thị ngoài trang chủ)</td>
                <td> <input  name="anh"  type="file"  id="anh"  value="<?=$anh?>" size="32">
                  </td>
              </tr>  
            
               <tr>
                <td>Giá sản phẩm <span class="required">*</span> :</td>
                <td> <input name="gia" type="text" id="gia" value="<?=$gia_goc?>" size="32">
                  </td>
              </tr>  
          
           <tr>
              <td>Hiển thị:</td>
                    <td>  <input name="publish" value="1" checked="checked" type="radio">Có
                          <input name="publish" value="0" type="radio">Không
                </td>
            </tr>
            
            
            </table>
          </div>
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