<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
        session_start();
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();

	if($_GET[mode] == "edit" && $_GET["pages"]=="company_catalog")
	{
		$id = $_GET["id"];
		$select_query = "SELECT * FROM ".DB_PREFIX."company_catalog  WHERE `id` = $id";
		$sql->query($select_query);
		$row = $sql->fetch_array();
		$id_catalog = $row["id_catalog"];		
                                                     $id_company = $row["id_company"];
                                                     $_SESSION["tem_cat"] = $id_catalog;
	}
	
	if($_POST[mode] == "edit"  && $_POST["pages"]=="company_catalog")
	{
		$id = $_POST["id"];
                                                     $id_catalog = $_POST["cap_do"];		
                                                     $id_company = $_POST["company_id"];                                                   
		$update_query = "UPDATE  ".DB_PREFIX."company_catalog  SET id_catalog='$id_catalog',id_company='$id_company' WHERE  id = $id";
		$sql->query($update_query);
		$sql->close();
		$message = "Cập nhật thành công !";
                                                     require_once("company_catalog.php");
                                                    exit();
	}	
?>

<?php include("lib/header.php")?>
<div id="content">
<div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=company_catalog">Quản lý danh mục </a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='success'>Success: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" /> Danh mục sản phẩm</h1>
      <form action=index.php method=post enctype="multipart/form-data" name="cateedit" id="cateedit">
      <div class="buttons">
            <input type="submit" value="Update" name="submit" class="submit1" > 
            <a onclick="javascript: window.history.back();" class="button">Cancel</a></div>
    </div>
    <div class="content">
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
                                                        if(  $_SESSION["tem_cat"]==$tv_2['id_catalog'])
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
                                                        if( $_SESSION["tem_cat"]==$tv_2['id_catalog'])
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
                    <td>Chọn danh mục nhà mạng<span class="required">*</span>:</td>
                    <td>
                        <select name="company_id">                          
                            <?php for($i=1;$i<=count($company);$i++){
                                    if($company[$i]["id_company"]==$id_company){?>
                                            <option value="<?=$company[$i]["id_company"]?>" selected><?=$company[$i]["name"]?></option>
                            <?}else{?>
                                        <option value="<?=$company[$i]["id_company"]?>"><?=$company[$i]["name"]?></option>
                                  <?}
                          }
                        ?>
                        </select>
                    </td>
                </tr>     
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="company_catalog">
        <input name="mode" type="hidden" id="mode" value="edit">
        <input name="id" type="hidden" id="id" value="<?=$id?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>

