<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
                           session_start();
                          
	if( isset($_POST["mode"]) && $_POST["mode"] == "add" &&  isset($_POST["pages"]) && $_POST["pages"] == "cate"){
                                                    if(!session_register('countadd')){
                                                            session_register('countadd');
                                                            $HTTP_SESSION_VARS['countadd']=0;
                                                    }
                                                    
                                                     $_SESSION["selected_cd_mnd__789"] =  $_POST['cap_do'];
                                                     $catid_parent = $_POST['cap_do'];
		$catname = convert_font($_POST["catname"]);
		$hienthi = $_POST["hienthi"]==1?$_POST["hienthi"]:0;                                                   
		$thutu = $_POST["thutu"];                                                     
		$message1 = $catname == "" ? "Hãy nhập tên danh mục sản phẩm" : "";
                                                     $type = $_POST["type"];
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();		
		$n = $sql->count_rows(DB_PREFIX."catalog") + 1;
                
		if($message1 ==""){
			$catname = convert_font($_POST["catname"],2);
			$insert_query = "INSERT  INTO ".DB_PREFIX."catalog (name ,catalog_parent ,publish ,sort_order , id_lang,type) 
                                                                                                                                            VALUES ('$catname',  '$catid_parent',  '$hienthi',  '$thutu','1','$type')";			
			if($sql->query($insert_query)){	
                                                                                                         unset($catname);
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;
				$message = "Th&ocirc;ng tin v&#7873; danh mục sản phẩm th&#7913; ".$HTTP_SESSION_VARS['countadd']." &#273;&atilde; &#273;&#432;&#7907;c th&ecirc;m v&agrave;o CSDL";			
			}		
			$n = $sql->count_rows(DB_PREFIX."catalog") + 1;										
			$sql->close();	
		}
	}	
	else{
			$sql = new db_sql();
			$sql->db_connect();
			$sql->db_select();
			$n = $sql->count_rows(DB_PREFIX."catalog") + 1;
			$sql->close();
	}
?>
<?php include("lib/header.php")?>
<div id="content">
<div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=cate">Quản lý danh mục </a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='success'>Success: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" /> Danh mục sản phẩm</h1>
      <form action=index.php method=post enctype="multipart/form-data" name="cateadd" id="cateadd">
      <div class="buttons"><input type="submit" value="Thêm" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
       <div id="tab-general">
       <div id="language1">
            <table class="form">
                <tr>
                        <td><span class="required">*</span> Danh mục sản phẩm: </td>
                        <td>                       
                                        <?php 
                                                echo "<select name='cap_do'>";
                                                        echo "<option value='0'>";
                                                                echo "-- Danh mục sản phẩm cấp đầu --";
                                                        echo "</option>";
                                                        $sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
                                                      $select_query = "SELECT id_catalog, name, catalog_parent FROM kien_catalog WHERE  publish = 1 and catalog_parent='0' order by sort_order";
                                                      $sql->query($select_query);
                                                      
                                                        while($tv_2=$sql->fetch_array())
                                                        {
                                                                if($_SESSION["selected_cd_mnd__789"]==$tv_2['id_catalog'])
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
                                                                $xac_dinh_menu_con__123=   xac_dinh_menu_con__123($tv_2[id_catalog]);
                                                                if($xac_dinh_menu_con__123=="co")
                                                                {
                                                                        de_quy_menu__fff($tv_2['id_catalog']);
                                                                }
                                                        }
                                                echo "</select>";
                                        ?>
                          </td>
              </tr>
              <tr>
                <td><span class="required">*</span> Tên danh mục:</td>
                <td><input type="text" name="catname" size="100" id="catname" value="<?=$catname?>" />
                  </td>
              </tr>
              
               <tr>
                <td><span class="required">*</span>Loại thẻ:</td>
                <td>
                        <select name="type" id="type">
                            <option value="">-- Chọn kiểu --</option>
                            <option value="mobile">Mobile</option>
                            <option value="game">Game</option>
                            <option value="software">Phần mềm</option>
                            <option value="both">Thẻ đa năng</option>
                        </select>
                  </td>
              </tr>
              
            <tr>
              <td>Hiển thị:</td>
              <td><input name="hienthi" type="checkbox" id="hienthi" value="1" checked></td>
            </tr>
            <tr>
              <td>Thứ tự hiển thị:</td>
              <td>  <select name="thutu" size="1" id="thutu">
                       
                                <?php  
                                 for($i=1; $i<=$n; $i++){
                                 ?>
                                        <OPTION value="<?=$i?>"><?=$i?></OPTION>
                                 <?php }
                                 ?>    
                        <OPTION value="<?=$n+1?>" selected><?=$n+1?></OPTION>
                    </select></td>
            </tr>
            </table>
          </div>
       </div>
        <input type="hidden" value="Add" name="submit">
        <input name="pages" type="hidden" id="pages" value="cate">
        <input name="mode" type="hidden" id="mode" value="add">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>

