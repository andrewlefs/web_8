<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	if($HTTP_POST_VARS["mode"] == "add" && isset($HTTP_POST_VARS["mode"])){
		if(!session_register('countadd')){
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}
                                                     $_SESSION["selected_cd_mnd__newscat"] =  $_POST['cap_do12'];
                                                     $newscat_parent = $_POST['cap_do12'];
		$name = convert_font($_POST["name"]);
		$hienthi = $_POST["hienthi"]==1?$_POST["hienthi"]:0;                                                   
		$thutu = $_POST["thutu"];                                                     			
		$message1 = $name == "" ? "Hãy nhập tên danh mục nhóm tin" : "";
                
                
                
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();		
		$n = $sql->count_rows(DB_PREFIX."newscat")+1;
		if($message1 ==""){
			$name = convert_font($_POST["name"],2);
			$insert_query = "INSERT INTO ".DB_PREFIX."newscat(name,newscat_parent, publish, list_order,lang_id) VALUES('$name','$newscat_parent', $hienthi, $thutu,'$_SESSION[LANGUAGE]')";			
			if($sql->query($insert_query))	{
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;
				$message = "Th&ocirc;ng tin v&#7873; danh mục nhóm tin th&#7913; ".$HTTP_SESSION_VARS['countadd']." &#273;&atilde; &#273;&#432;&#7907;c th&ecirc;m v&agrave;o CSDL";			
			}		
			$n = $sql->count_rows(DB_PREFIX."newscat");										
			$sql->close();	
		}
	}	
	else{
			$sql = new db_sql();
			$sql->db_connect();
			$sql->db_select();
			$n = $sql->count_rows(DB_PREFIX."newscat")+1;
			$sql->close();
	}
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=newscat">Category</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Category</h1>
      
      <FORM action="" method=post enctype="multipart/form-data" name="add" id="add">
      <div class="buttons"><input type="submit" value="Lưu" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
        <div id="tab-general">
          <div id="language1">
            <table class="form">
                 <tr>
                        <td><span class="required">*</span> Danh mục tin tức: </td>
                        <td>                       
                                        <?php 
                                                echo "<select name='cap_do12'>";
                                                        echo "<option value='0'>";
                                                                echo "-- Danh mục tin tức cấp đầu --";
                                                        echo "</option>";
                                                       $sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
                                                      $select_query = "SELECT id_newscat, `name`, `newscat_parent` FROM ".DB_PREFIX."newscat WHERE  `newscat_parent`='0' order by list_order";
                                                      $sql->query($select_query);
                                                      
                                                        while($tv_2=$sql->fetch_array())
                                                        {
                                                                if($_SESSION["selected_cd_mnd__newscat"]==$tv_2['id_newscat'])
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
                                                               $xac_dinh_menu_con__123=  xac_dinh_menu_con__newscat($tv_2[id_newscat]);
                                                                if($xac_dinh_menu_con__123=="co")
                                                                {
                                                                    de_quy_menu__newcat($tv_2['id_newscat']);
                                                                }
                                                        }
                                                echo "</select>";
                                        ?>
                          </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Tên danh mục:</td>
                <td><input type="text" name="name" size="100" id="title" value="<?=$name?>" />
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
        <input name="pages" type="hidden" id="pages" value="newscat">
        <input name="mode" type="hidden" id="mode" value="add">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
