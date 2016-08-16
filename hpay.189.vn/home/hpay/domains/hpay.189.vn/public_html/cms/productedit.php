<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	$alb = array();	
	$id = isset($_GET["id"]) ? $_GET["id"] : $_POST["id"];		
	$sql = new db_sql();
	$sql->db_connect();	
	$sql->db_select();		
	if($_GET["mode"] == "edit" && $_GET["pages"]=="product" && isset($_GET["id"])){
		$id = $_GET["id"];                                                   
		$select_query = "SELECT `ten`, `gia`,`anh`,  `publish`, `id_com_cat`, `code_pro`  FROM ".DB_PREFIX."product WHERE id_product = '$id' ";
		$sql->query($select_query);
		$row = $sql->fetch_array();		
		$ten                                             = $row["ten"]; 	
		$id_com_cat 		= $row["id_com_cat"];	                                                     
		$gia 		= $row["gia"]; 	
                                                     $code_pro 		= $row["code_pro"]; 	                                                 
                                                     $publish                                      = $row["publish"]; 
		$anhcu 		= $row["anh"] <> "" ? "<img src='".$dir_imgproducts.$row["anh"]."' style='border: 1px solid #000000; padding-left: 0; padding-right: 0; padding-top: 0px; padding-bottom: 0px' onClick=OpenNewWindow('../comm/imagesviewer.php?img=".$dir_imgproducts."origin/".$row["anh"]."&mode=back',500,500)>" : 'Chưa có ảnh SP';
		$imgtemp                                    = $row["anh"];                                                   
		$position_page                          = $_GET["position_page"];
                                                  
	}
        
                           
	if($_POST["mode"] == "edit" && isset($_POST["mode"]) && $_POST["pages"] == "product" ){
                                                     $id_edit  = $_POST["id"];
		$ten 		= isset($_POST["ten"])		? convert_font($_POST["ten"])		: '';
		$gia_goc                                     = isset($_POST["gia"])                                        ?$_POST["gia"]                                                                              :0;                                                     
                                                     $gia_goc                                    = is_numeric($gia_goc)                                         ?$gia_goc: 0;                                                     
                                                     $code_pro                                     = isset($_POST["code_pro"])                                        ?$_POST["code_pro"]                                                    :"";                                                                                                     
		$anh 		= isset($_FILES["anh"]["name"]) 		? $_FILES["anh"]["name"]			: '';		
		$anhcu 		= $_POST["anhcu"] <> "" 				? stripslashes($_POST["anhcu"]) : '';
		$imgtemp                                    = $_POST["imgtemp"];
                                                      $id_com_cat                             = $_POST["id_com_cat"];
		$position_page                         = $_POST["position_page"];                                                
		if($ten		== "") $message1 = $message1."Hãy nhập tên SP";
		if($gia 		== 0 || !is_numeric($gia)) $message1 = $message1."Hãy nhập giá SP hoặc dữ liệu nhập chưa đúng kiểu";		
		if($code_pro		== "") $message1 = $message1."Hãy nhập mã sản phẩm";
		
	
		//bat dau thuc hien upload anh SP len thu muc tren may chu WEB		
		if (!empty($anh)){
			$filename = "";
	       	$start = strpos($anh,".");
			$type  = substr($anh,$start,strlen($anh));
			if ((strtolower($type)!=".gif")&&(strtolower($type)!=".jpg")){
			$message1 = "Tệp ảnh phải có kiểu tệp là .jpg hoặc .gif";             
                                                    }
			if($message1==""){
	    	   	$filename = time().$type;
				if (!copy($_FILES['anh']['tmp_name'], $dir_imgproducts."origin/".$filename)) die ("Cannot upload file.");
				thumb($_FILES['anh']['tmp_name'], $dir_imgproducts.$filename, $ratio_image_width, $ratio_image_width, false);
				$file_path = $dir_imgproducts."origin/".$imgtemp;
				if($imgtemp!="" && file_exists($file_path))	unlink($file_path);
				$file_path = $dir_imgproducts.$imgtemp;
				if($imgtemp!="" && file_exists($file_path))	unlink($file_path);
		 	}
                                                    }else{
			if(empty($anh)) $filename=$imgtemp;
                                                    }
                                                    
		//Bat dau chen DL vao CSDL		
		if($message1 ==""){			
			$ten 		= isset($_POST["ten"])			? convert_font($_POST["ten"],2)			: '';                                                                         
			
			$update_query = "UPDATE ".DB_PREFIX."product SET ten='$ten',   gia=$gia,publish='$publish',  anh='$filename', code_pro='$code_pro',id_com_cat = '$id_com_cat'
			WHERE id_product = $id_edit";						
			if($sql->query($update_query)){
				$sql->close();
				$message = $message."Cập nhật thành công !";
				include_once("product.php");
				exit();
			}			
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
     <a href="/">Home</a>:: <a href="index.php?pages=product&cat=<?=$catid?>">Danh mục sản phẩm</a>
        </div>
        <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/product.png" alt="" /> <?=get_catname($catid)?></h1>
      <form action=index.php?pages=product&mode=edit&position_page=<?=$position_page?>&id=<?=$id?>  method=post enctype="multipart/form-data" name="addproduct" id="addproduct">
      <div class="buttons"><input type="submit" value="Update" name="submit" class="submit1" ><input type="reset" value="Làm lại" name="submit2" class="submit1" ></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general">Thông tin chung</a>
      </div>
     <div id="tab-general">
        <div id="language1">
            <table class="form">
               <tr>
                            <td>Mã sản phẩm (Nhập đúng mã của nhà cung cấp) <span class="required">*</span> :</td>
                            <td><input type="text" name="code_pro" size="30" value="<?=$code_pro?>" />
                              </td>
                </tr>
                 <tr>
                    <td>Nhà cung cấp - dịch vụ <span class="required">*</span> :</td>
                    <td>
                            <select name="id_com_cat" id="id_com_cat">
                                    <option value="0" <?=$$id_com_cat==0?"selected":""?>>-- Chọn danh mục nhà cung cấp - dịch vụ --</option>
                                    <?php for($j=1;$j<=count($com_cat);$j++){
                                            if($com_cat[$j]["id"]==$id_com_cat){?>
                                            <option value="<?=$com_cat[$j]["id"]?>" selected><?=  get_cat($com_cat[$j]["id_catalog"])?> - <?=  get_com($com_cat[$j]["id_company"])?></option>
                                    <?php }else{?>
                                            <option value="<?=$com_cat[$j]["id"]?>"><?=  get_cat($com_cat[$j]["id_catalog"])?> - <?=  get_com($com_cat[$j]["id_company"])?></option>
                                    <?}
                                    }?>
                            </select>
                    </td>
              </tr>                
                
              <tr>
                <td>Tên sản phẩm <span class="required">*</span> :</td>
                <td><input type="text" name="ten" name="ten" size="100" value="<?=$ten?>" />
                  </td>
              </tr>
              
              <tr>
                    <td>Giá sản phẩm <span class="required">*</span> :</td>
                    <td>
                        <input type="text" name="gia" name="gia" value="<?=  number_format($gia)?>" />
                    </td>
               </tr>
         
             
              <tr>
                <td>Ảnh cũ:</td>
                <td> 
                        <?=$anhcu?>
                  </td>
              </tr> 
               <tr>
                        <td>Ảnh sản phẩm :<br />(Bạn có thể chọn một hình khác làm hình hiển thị tại trang chủ)<br />(Bạn không chọn mục này nếu không muốn đổi hình)</td>
                        <td> <input name="anh" type="file" id="anh" value="<?=$anh?>" size="32">
                          </td>
              </tr>        
              
           <tr>
              <td>Hiển thị:</td>
                    <td>  <input name="publish" value="1" <?=$publish==1?"checked":""?> type="radio">Có
                          <input name="publish" value="0" <?=$publish==0?"checked":""?> type="radio">Không
                </td>
            </tr>
            </table>
          </div>
     </div>     
        <input name="pages" type="hidden" id="pages" value="product">        
        <input name="mode" type="hidden" id="mode" value="edit">            
        <input name="anhcu" type="hidden" id="mode3" value="<?=$anhcu?>">
        <input name="imgtemp" type="hidden" id="mode3" value="<?=$imgtemp?>">
        <input name="id" type="hidden" id="imgtemp" value="<?=$id?>">
        <input name="position_page" type="hidden" id="sachid_old" value="<?=$position_page?>">
      </form>   
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